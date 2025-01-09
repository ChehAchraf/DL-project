<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');

require __DIR__ . '/../../vendor/autoload.php';

use Helpers\Database;
use Classes\Admin;
use Classes\Article;
use Classes\Session;

function sendJsonResponse($data, $code = 200) {
    ob_clean();
    http_response_code($code);
    echo json_encode($data, JSON_THROW_ON_ERROR);
    ob_end_flush();
    exit;
}

function handleError($message, $code = 400) {
    sendJsonResponse([
        'success' => false,
        'message' => $message
    ], $code);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$debug = [
    'post' => $_POST,
    'files' => $_FILES,
    'session' => isset($_SESSION) ? array_keys($_SESSION) : []
];

try {
    if (!isset($_SESSION['id'])) {
        handleError('User not authenticated', 401);
    }

    $db = new Database();
    $pdo = $db->getConnection();
    
    if (!$pdo) {
        handleError('Database connection failed');
    }

    $article = new Article("", $_SESSION['id']);
    $action = $_POST['action'] ?? 'add';

    switch ($action) {
        case 'add':
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $rawTags = $_POST['tags'] ?? [];
            $tags = [];
            if (is_array($rawTags)) {
                $tags = $rawTags;
            } elseif (is_string($rawTags)) {
                $tags = array_filter(array_map('trim', explode(',', $rawTags)));
            }
            
            if (empty($title) || empty($content)) {
                handleError('Title and content are required');
            }
            
            try {
                $response = $article->CreatePost(
                    $pdo, 
                    $title, 
                    $content, 
                    $_FILES['image'] ?? null,
                    $category_id,
                    $tags
                );
                sendJsonResponse([
                    'success' => true,
                    'message' => $response
                ]);
            } catch (\Exception $e) {
                handleError('Create post error: ' . $e->getMessage());
            }
            break;
        
        case 'delete':
            $articleId = $_POST['article_id'] ?? '';
            
            if (empty($articleId)) {
                handleError('Article ID is required');
            }
            
            try {
                $response = $article->DeletePost($pdo, $articleId);
                sendJsonResponse([
                    'success' => true,
                    'message' => $response
                ]);
            } catch (\Exception $e) {
                handleError('Delete article error: ' . $e->getMessage());
            }
            break;
        default:
            handleError('Invalid action');
    }
} catch (\Throwable $e) {
    handleError('Server error: ' . $e->getMessage(), 500);
}
