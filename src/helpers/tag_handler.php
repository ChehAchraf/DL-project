<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use Helpers\Database;
use Classes\Session;



Session::validateSession();

function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function handleError($message) {
    sendJsonResponse([
        'success' => false,
        'message' => $message
    ]);
}

$db = new Database();
$pdo = $db->getConnection();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'search':
        $query = $_GET['query'] ?? '';
        if (empty($query)) {
            echo '<div class="p-2">Type to search tags...</div>';
            exit;
        }

        try {
            $stmt = $pdo->prepare("
                SELECT id, name 
                FROM tags 
                WHERE name LIKE :query 
                ORDER BY name ASC 
                LIMIT 5
            ");
            $stmt->execute(['query' => "%$query%"]);
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($tags)) {
                echo '<div class="p-2 cursor-pointer hover:bg-gray-100" onclick="createTag(\'' . htmlspecialchars($query) . '\')">
                        Create tag: ' . htmlspecialchars($query) . '
                      </div>';
            } else {
                foreach ($tags as $tag) {
                    echo '<div class="p-2 cursor-pointer hover:bg-gray-100" 
                             onclick="selectTag(' . $tag['id'] . ', \'' . htmlspecialchars($tag['name']) . '\')">' 
                         . htmlspecialchars($tag['name']) . 
                         '</div>';
                }
            }
        } catch (PDOException $e) {
            echo '<div class="p-2 text-red-500">Error searching tags</div>';
        }
        break;

    case 'create':
        $name = $_POST['name'] ?? '';
        if (empty($name)) {
            handleError('Tag name is required');
        }

        try {
            // Check if tag already exists
            $stmt = $pdo->prepare("SELECT id, name FROM tags WHERE name = :name");
            $stmt->execute(['name' => $name]);
            $existingTag = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingTag) {
                sendJsonResponse([
                    'success' => true,
                    'tag' => $existingTag,
                    'message' => 'Tag already exists'
                ]);
            } else {
                // Create new tag
                $stmt = $pdo->prepare("INSERT INTO tags (name) VALUES (:name)");
                $stmt->execute(['name' => $name]);
                
                sendJsonResponse([
                    'success' => true,
                    'tag' => [
                        'id' => $pdo->lastInsertId(),
                        'name' => $name
                    ],
                    'message' => 'Tag created successfully'
                ]);
            }
        } catch (PDOException $e) {
            handleError('Failed to create tag: ' . $e->getMessage());
        }
        break;

    default:
        handleError('Invalid action');
}
