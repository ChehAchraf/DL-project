<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../../vendor/autoload.php';

use Helpers\Database;
use Classes\Article;
use Classes\Session;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    if (!$pdo) {
        throw new \Exception('Database connection failed');
    }

    $article = new Article("", $_SESSION['id']);
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'get_post':
            $articles = $article->getpendingArticles($pdo);
            foreach ($articles as $post) {
                $image = $post['image'];
                echo '
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <img src="../../' . $image . '" alt="Post Image" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">' . htmlspecialchars($post['title']) . '</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">Status: ' . htmlspecialchars($post['is_accepted']) . '</p>
                        <div class="flex justify-end">
                            <button onclick="viewPostDetails(' . $post['id'] . ')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>';
            }
            break;

        case 'post_details':
            $postId = $_GET['id'] ?? null;
            if (!$postId) {
                echo '<div class="text-red-500">Post ID is required</div>';
                break;
            }

            $postDetails = $article->getPostDetails($pdo, $postId);
            if (!$postDetails) {
                echo '<div class="text-red-500">Post not found</div>';
                break;
            }

            echo '
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">' . htmlspecialchars($postDetails['title']) . '</h3>
                <button onclick="closePostModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <img src="' . ($postDetails['image'] ? htmlspecialchars($postDetails['image']) : 'path_to_default_image.jpg') . '" 
                 alt="Post Image" class="w-full h-64 object-cover rounded mb-4">
            
            <div class="prose dark:prose-invert max-w-none mb-6">
                <div class="text-gray-700 dark:text-gray-300">' . nl2br(htmlspecialchars($postDetails['content'])) . '</div>
            </div>

            <div class="flex justify-end gap-4">
                <button onclick="approvePost(' . $postDetails['id'] . ')" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Approve
                </button>
                <button onclick="rejectPost(' . $postDetails['id'] . ')" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                    Reject
                </button>
            </div>';
            break;

        case 'approve':
            $postId = $_POST['id'] ?? null;
            if (!$postId) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Post ID is required']);
                break;
            }

            if ($article->acceptArticle($pdo, $postId)) {
                echo json_encode(['success' => true, 'message' => 'Post approved successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to approve post']);
            }
            break;

        case 'reject':
            $postId = $_POST['id'] ?? null;
            if (!$postId) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Post ID is required']);
                break;
            }

            if ($article->rejectArticle($pdo, $postId)) {
                echo json_encode(['success' => true, 'message' => 'Post rejected successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to reject post']);
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
