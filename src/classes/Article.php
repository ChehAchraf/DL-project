<?php 
namespace Classes;
require __DIR__ . '/../../vendor/autoload.php'; 

class Article {
    protected $id;
    protected $user_id;

    public function __construct($id, $user_id) {
        $this->id = $id;
        $this->user_id = $user_id;
    }

    public function CreatePost($pdo, $title, $content, $imageFile, $category_id = null, $tags = []) {
        try {
            $pdo->beginTransaction();

            if (empty($title) || empty($content)) {
                throw new \Exception("Title and content are required.");
            }

            if (empty($this->user_id)) {
                throw new \Exception("User ID is required.");
            }

            if ($category_id) {
                $stmt = $pdo->prepare("SELECT id FROM category_blog WHERE id = :id");
                $stmt->execute(['id' => $category_id]);
                if (!$stmt->fetch()) {
                    throw new \Exception("Invalid category selected");
                }
            }

            $imagePath = null;
            if (isset($imageFile) && $imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
                $imagePath = $this->uploadImage($imageFile);
            }

            $stmt = $pdo->prepare("
                INSERT INTO articles (title, content, image, user_id, category_id) 
                VALUES (:title, :content, :image, :user_id, :category_id)
            ");
            
            $params = [
                'title' => $title,
                'content' => $content,
                'image' => $imagePath,
                'user_id' => $this->user_id,
                'category_id' => $category_id
            ];

            if (!$stmt->execute($params)) {
                throw new \Exception("Failed to create article");
            }

            $articleId = $pdo->lastInsertId();

            if (!empty($tags)) {
                foreach ($tags as $tagName) {
                    if (empty(trim($tagName))) continue;
                    
                    try {
                        $stmt = $pdo->prepare("SELECT id FROM tags WHERE name = :name");
                        $stmt->execute(['name' => trim($tagName)]);
                        $tag = $stmt->fetch(\PDO::FETCH_ASSOC);

                        if (!$tag) {
                            $stmt = $pdo->prepare("INSERT INTO tags (name) VALUES (:name)");
                            $stmt->execute(['name' => trim($tagName)]);
                            $tagId = $pdo->lastInsertId();
                        } else {
                            $tagId = $tag['id'];
                        }

                        $stmt = $pdo->prepare("
                            INSERT INTO article_tags (article_id, tag_id) 
                            VALUES (:article_id, :tag_id)
                        ");
                        $stmt->execute([
                            'article_id' => $articleId,
                            'tag_id' => $tagId
                        ]);
                    } catch (\PDOException $e) {
                        continue;
                    }
                }
            }

            $pdo->commit();
            return "Article created successfully";
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw new \Exception("Failed to create article: " . $e->getMessage());
        }
    }

    public function getPostDetails($pdo, $articleId) {
        try {
            $stmt = $pdo->prepare("
                SELECT a.id AS article_id, a.title, a.content, a.image, a.created_at AS article_created_at, u.name AS author_name, GROUP_CONCAT(DISTINCT t.name) AS tags, COUNT(co.id) AS comment_count FROM articles a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN article_tags at ON a.id = at.article_id LEFT JOIN tags t ON at.tag_id = t.id LEFT JOIN comments co ON a.id = co.article_id WHERE a.id = :id  GROUP BY a.id;
            ");
            $stmt->execute(['id' => $articleId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Failed to fetch article details: " . $e->getMessage());
        }
    }

    protected function uploadImage($imageFile) {
        try {
            if (!isset($imageFile) || !is_array($imageFile)) {
                throw new \Exception("Invalid image file");
            }

            if ($imageFile['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception("Image upload failed");
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageFile['type'], $allowedTypes)) {
                throw new \Exception("Invalid image type");
            }

            $maxSize = 5 * 1024 * 1024;
            if ($imageFile['size'] > $maxSize) {
                throw new \Exception("Image size too large");
            }

            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($imageFile['name']);
            $targetPath = $uploadDir . $fileName;

            if (!move_uploaded_file($imageFile['tmp_name'], $targetPath)) {
                throw new \Exception("Failed to move uploaded file");
            }

            return 'uploads/' . $fileName;
        } catch (\Exception $e) {
            throw new \Exception("Image upload error: " . $e->getMessage());
        }
    }

    public function DeletePost($pdo, $articleId) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("SELECT user_id, image FROM articles WHERE id = :id");
            $stmt->execute(['id' => $articleId]);
            $article = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$article) {
                throw new \Exception("Article not found");
            }

            if ($article['user_id'] != $this->user_id) {
                throw new \Exception("Unauthorized to delete this article");
            }

            $stmt = $pdo->prepare("DELETE FROM article_tags WHERE article_id = :id");
            $stmt->execute(['id' => $articleId]);

            $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
            if (!$stmt->execute(['id' => $articleId])) {
                throw new \Exception("Failed to delete article");
            }

            if ($article['image']) {
                $imagePath = __DIR__ . '/../../public/' . $article['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $pdo->commit();
            return "Article deleted successfully";
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw new \Exception("Failed to delete article: " . $e->getMessage());
        }
    }

    public function getAllArticles($pdo) {
        try {
            $stmt = $pdo->prepare("
                SELECT
    a.*,
    u.name AS author_name,
    GROUP_CONCAT(DISTINCT t.name) AS tags,
    c.name AS category_name
FROM articles a
LEFT JOIN users u ON a.user_id = u.id
LEFT JOIN article_tags at ON a.id = at.article_id
LEFT JOIN tags t ON at.tag_id = t.id
LEFT JOIN category_blog c ON a.category_id = c.id
WHERE a.is_accepted = 'accepted'
GROUP BY a.id;
            ");
            
            $stmt->execute(['user_id' => $this->user_id]);    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Failed to fetch articles: " . $e->getMessage());
        }
    }

    public function listArticles($pdo) {
        try {
            $stmt = $pdo->prepare("
                SELECT 
                    a.id, 
                    a.title, 
                    a.content, 
                    a.image,
                    a.user_id, 
                    c.name as category_name,
                    u.name as author_name,
                    GROUP_CONCAT(t.name) as tags
                FROM articles a
                LEFT JOIN category_blog c ON c.id = a.category_id
                LEFT JOIN users u ON u.id = a.user_id
                LEFT JOIN article_tags at ON at.article_id = a.id
                LEFT JOIN tags t ON t.id = at.tag_id
                GROUP BY a.id
                ORDER BY a.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Failed to fetch articles: " . $e->getMessage());
        }
    }

    public function getFilteredArticles($pdo, $search = '', $category = '', $sort = 'newest', $tags = []) {
        try {
            $sql = "
                SELECT
                    a.*,
                    u.name AS author_name,
                    GROUP_CONCAT(DISTINCT t.name) AS tags,
                    c.name AS category_name
                FROM articles a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN article_tags at ON a.id = at.article_id
                LEFT JOIN tags t ON at.tag_id = t.id
                LEFT JOIN category_blog c ON a.category_id = c.id
                WHERE a.is_accepted = 'accepted'
            ";
            
            $params = [];

            if (!empty($search)) {
                $sql .= " AND (a.title LIKE ? OR a.content LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            if (!empty($category)) {
                $sql .= " AND a.category_id = ?";
                $params[] = $category;
            }

            if (!empty($tags)) {
                $placeholders = str_repeat('?,', count($tags) - 1) . '?';
                $sql .= " AND a.id IN (
                    SELECT article_id 
                    FROM article_tags at2 
                    JOIN tags t2 ON at2.tag_id = t2.id 
                    WHERE t2.name IN ($placeholders)
                    GROUP BY article_id 
                    HAVING COUNT(DISTINCT t2.name) = ?
                )";
                $params = array_merge($params, $tags);
                $params[] = count($tags);
            }

            $sql .= " GROUP BY a.id";

            switch ($sort) {
                case 'oldest':
                    $sql .= " ORDER BY a.created_at ASC";
                    break;
                case 'popular':
                    $sql .= " ORDER BY (SELECT COUNT(*) FROM reviews r WHERE r.article_id = a.id) DESC, a.created_at DESC";
                    break;
                default: // newest
                    $sql .= " ORDER BY a.created_at DESC";
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error filtering articles: " . $e->getMessage());
        }
    }

    public function getpendingArticles($pdo) {
        try{
            $stmt = $pdo->query("SELECT * FROM articles WHERE is_accepted = 'pending'");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\Exception $e){ 
            throw new \Exception("Failed to fetch articles: " . $e->getMessage());
        }
    }

    public function acceptArticle($pdo, $articleId) {
        try {
            $stmt = $pdo->prepare("UPDATE articles SET is_accepted = 'accepted' WHERE id = :id");
            return $stmt->execute(['id' => $articleId]);
        } catch (\Exception $e) {
            throw new \Exception("Failed to accept article: " . $e->getMessage());
        }
    }

    public function rejectArticle($pdo, $articleId) {
        try {
            $stmt = $pdo->prepare("UPDATE articles SET is_accepted = 'rejected' WHERE id = :id");
            return $stmt->execute(['id' => $articleId]);
        } catch (\Exception $e) {
            throw new \Exception("Failed to reject article: " . $e->getMessage());
        }
    }
}