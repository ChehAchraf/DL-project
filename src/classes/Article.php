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

    public function CreatePost($pdo, $title, $content, $imageFile, $category_id = null) {
        try {
            // Validate inputs
            if (empty($title) || empty($content)) {
                throw new \Exception("Title and content are required.");
            }

            if (empty($this->user_id)) {
                throw new \Exception("User ID is required.");
            }

            // Validate category if provided
            if ($category_id) {
                $stmt = $pdo->prepare("SELECT id FROM category_blog WHERE id = :id");
                $stmt->execute(['id' => $category_id]);
                if (!$stmt->fetch()) {
                    throw new \Exception("Invalid category selected");
                }
            }

            // Validate and upload the image if provided
            $imagePath = null;
            if (isset($imageFile) && $imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
                $imagePath = $this->uploadImage($imageFile);
            }

            // Insert the article into the database
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
                $error = $stmt->errorInfo();
                throw new \Exception("Database error: " . ($error[2] ?? 'Unknown error'));
            }

            return "Article created successfully";
        } catch (\Exception $e) {
            throw new \Exception("Failed to create article: " . $e->getMessage());
        }
    }

    protected function uploadImage($imageFile) {
        try {
            if (!isset($imageFile) || !is_array($imageFile)) {
                throw new \Exception("Invalid image file data");
            }

            if ($imageFile['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception("File upload error: " . $imageFile['error']);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageFile['type'], $allowedTypes)) {
                throw new \Exception("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
            }

            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($imageFile['size'] > $maxSize) {
                throw new \Exception("File size exceeds the maximum limit of 5MB.");
            }

            // Create uploads directory if it doesn't exist
            $uploadDir = __DIR__ . '/../../uploads/';
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new \Exception("Failed to create uploads directory");
                }
            }

            $fileName = uniqid() . '_' . basename($imageFile['name']);
            $uploadPath = $uploadDir . $fileName;

            if (!move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
                throw new \Exception("Failed to move uploaded file.");
            }

            return 'uploads/' . $fileName;
        } catch (\Exception $e) {
            throw new \Exception("Image upload failed: " . $e->getMessage());
        }
    }
    
    public function getAllArticles($pdo) {
        try {
            $stmt = $pdo->prepare("
                SELECT 
                    a.id, 
                    a.title, 
                    a.content, 
                    a.image,
                    a.user_id, 
                    c.name as category_name,
                    u.name as author_name
                FROM articles a
                LEFT JOIN category_blog c ON c.id = a.category_id
                LEFT JOIN users u ON u.id = a.user_id
                WHERE a.user_id = :user_id
                ORDER BY a.created_at DESC
            ");
            
            $stmt->execute(['user_id' => $this->user_id]);    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Failed to fetch articles: " . $e->getMessage());
        }
    }
    public function DeleteArticle($pdo, $ArticleId) {
        try {
            // Validate article ownership
            $stmt = $pdo->prepare('SELECT user_id FROM articles WHERE id = :id');
            $stmt->execute(['id' => $ArticleId]);
            $article = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$article) {
                throw new \Exception("Article not found");
            }

            if ($article['user_id'] != $this->user_id) {
                throw new \Exception("You don't have permission to delete this article");
            }

            // Delete the article
            $stmt = $pdo->prepare('DELETE FROM articles WHERE id = :id AND user_id = :user_id');
            $result = $stmt->execute([
                'id' => $ArticleId,
                'user_id' => $this->user_id
            ]);

            if (!$result) {
                throw new \Exception("Failed to delete article");
            }

            return "Article deleted successfully";
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
}