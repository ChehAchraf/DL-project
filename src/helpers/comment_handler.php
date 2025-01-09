<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Helpers\Database;
use Classes\Session;
use Classes\Comment;    

Session::validateSession();

$db = new Database();
$pdo = $db->getConnection();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $article_id = $_POST['article_id'] ?? '';
        $content = $_POST['content'] ?? '';
        $user_id = $_SESSION['id'];

        if (empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Comment content is required']);
            exit;
        }

        if (empty($article_id)) {
            echo json_encode(['success' => false, 'message' => 'Article ID is required']);
            exit;
        }

        $comment = new Comment($content, $user_id, $article_id);
        if ($comment->addComment($pdo)) {
            // Return the new comment HTML
            ?>
            <div class="mb-8 pb-8 border-b border-gray-200">
                <div class="flex items-start">
                    <img src="https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png" alt="Commenter" class="w-10 h-10 rounded-full mr-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <h4 class="font-semibold text-gray-900 mr-2"><?php echo $comment['user_name'] ?></h4>
                            <span class="text-sm text-gray-600">Just now</span>
                        </div>
                        <p class="text-gray-700"><?php echo htmlspecialchars($content); ?></p>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
        }
        break;

    case 'remove':
        $comment_id = $_POST['comment_id'] ?? '';
        if (empty($comment_id)) {
            echo json_encode(['success' => false, 'message' => 'Comment ID is required']);
            exit;
        }

        $comment = new Comment("", $_SESSION['id'], "");
        if ($comment->removeComment($pdo, $comment_id, $_SESSION['id'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove comment']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}