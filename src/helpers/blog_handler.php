<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Helpers\Database;
use Classes\Session;
use Classes\Article;

Session::validateSession();

$db = new Database();
$pdo = $db->getConnection();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        include('add.php');
        break;
    case 'edit':
        include('edit.php');
        break;
    case 'delete':
        include('delete.php');
        break;
    case 'search':
        // Get filter parameters
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        try {
            // Base query
            $sql = "
                SELECT DISTINCT
                    a.*,
                    u.name AS author_name,
                    c.name AS category_name
                FROM articles a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN category_blog c ON a.category_id = c.id
                WHERE a.is_accepted = 'accepted'
            ";
            
            $params = [];

            // Add search condition
            if (!empty($search)) {
                $sql .= " AND (a.title LIKE ? OR a.content LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            // Add category condition
            if (!empty($category)) {
                $sql .= " AND a.category_id = ?";
                $params[] = $category;
            }

            // Add sorting
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
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($articles)) {
                echo '<div class="col-span-full text-center py-8 text-gray-600">No articles found matching your criteria.</div>';
                exit;
            }

            foreach ($articles as $article) {
                echo '<div class="bg-white rounded-lg shadow-lg overflow-hidden">';
                
                // Article image
                if (!empty($article['image'])) {
                    echo '<img src="../' . htmlspecialchars($article['image']) . '" 
                              alt="' . htmlspecialchars($article['title']) . '" 
                              class="w-full h-48 object-cover">';
                }
                
                echo '<div class="p-6">';
                
                // Title
                echo '<h3 class="text-xl font-bold mb-2">' . htmlspecialchars($article['title']) . '</h3>';
                
                // Category
                if (!empty($article['category_name'])) {
                    echo '<div class="text-sm text-blue-600 mb-2">' . htmlspecialchars($article['category_name']) . '</div>';
                }
                
                // Content preview
                echo '<p class="text-gray-600 mb-4">' . substr(htmlspecialchars($article['content']), 0, 150) . '...</p>';
                
                // Author and date
                echo '<div class="flex justify-between items-center mt-4">';
                echo '<span class="text-sm text-gray-600">By ' . htmlspecialchars($article['author_name'] ?? 'Anonymous') . '</span>';
                echo '<span class="text-sm text-gray-600">' . date('M d, Y', strtotime($article['created_at'])) . '</span>';
                echo '</div>';
                
                echo '</div></div>';
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo '<div class="col-span-full text-center py-8 text-red-600">An error occurred while loading articles.</div>';
        }
        break;

    default:
        include('list.php');
        break;
}