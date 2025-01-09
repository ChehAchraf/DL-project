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
$search = $_GET['search'] ?? '';

switch ($action) {
    case 'search':
        if (empty($search)) {
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
            $stmt->execute(['query' => "%$search%"]);
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<div class="py-1" role="menu">';

            if (empty($tags)) {
                echo '<div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                           hx-post="helpers/tag_handler.php?action=create"
                           hx-swap="none"
                           hx-vals=\'{"name": "' . htmlspecialchars($search) . '"}\'>
                        Create tag: ' . htmlspecialchars($search) . '
                      </div>';
            } else {
                foreach ($tags as $tag) {
                    echo '<div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                             onclick="addTagToForm(\'' . htmlspecialchars($tag['name']) . '\')">' 
                         . htmlspecialchars($tag['name']) . 
                         '</div>';
                }
            }

            echo '</div>';
            
            echo '<script>
                function addTagToForm(tagName) {
                    if (!tagName || typeof tagName !== "string") return;
                    
                    // Clean the tag name
                    const cleanTagName = tagName.trim();
                    if (!cleanTagName) return;

                    // Check if tag already exists
                    const existingTags = document.querySelectorAll("#selected-tags input[type=hidden]");
                    for (let input of existingTags) {
                        if (input.value.toLowerCase() === cleanTagName.toLowerCase()) {
                            return; // Tag already exists (case-insensitive check)
                        }
                    }

                    // Create new tag element
                    const tagDiv = document.createElement("div");
                    tagDiv.className = "group px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 flex items-center gap-1";
                    
                    const tagInput = document.createElement("input");
                    tagInput.type = "hidden";
                    tagInput.name = "tags[]";
                    tagInput.value = cleanTagName;

                    const tagSpan = document.createElement("span");
                    tagSpan.textContent = cleanTagName;

                    const removeButton = document.createElement("button");
                    removeButton.type = "button";
                    removeButton.className = "ml-1 text-blue-600 hover:text-blue-800";
                    removeButton.textContent = "×";
                    removeButton.onclick = function() {
                        tagDiv.remove();
                    };

                    tagDiv.appendChild(tagSpan);
                    tagDiv.appendChild(tagInput);
                    tagDiv.appendChild(removeButton);

                    document.getElementById("selected-tags").appendChild(tagDiv);
                    document.querySelector("[name=\'tag_search\']").value = "";
                    document.getElementById("tag-suggestions").innerHTML = "";
                }
            </script>';
        } catch (PDOException $e) {
            echo '<div class="p-2 text-red-500">Error searching tags</div>';
        }
        break;

    case 'mass_check':
        $input = $_POST['tag_search'] ?? '';
        if (empty($input)) {
            exit;
        }

        // Split input into individual tags
        $inputTags = array_map('trim', explode(',', $input));
        $inputTags = array_filter($inputTags); // Remove empty values

        if (empty($inputTags)) {
            exit;
        }

        try {
            // Prepare placeholders for the IN clause
            $placeholders = str_repeat('?,', count($inputTags) - 1) . '?';
            
            // Find existing tags
            $stmt = $pdo->prepare("
                SELECT name 
                FROM tags 
                WHERE name IN ($placeholders)
            ");
            $stmt->execute($inputTags);
            $existingTags = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Separate new and existing tags
            $newTags = array_diff($inputTags, $existingTags);
            
            echo '<div class="py-1 divide-y divide-gray-100">';
            
            // Show existing tags section if any found
            if (!empty($existingTags)) {
                echo '<div class="px-3 py-2 text-sm text-gray-500">Existing tags:</div>';
                foreach ($existingTags as $tag) {
                    echo '<div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer flex items-center" onclick="addTagToForm(\'' . htmlspecialchars($tag) . '\')">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ' . htmlspecialchars($tag) . '
                          </div>';
                }
            }
            
            // Show new tags section if any found
            if (!empty($newTags)) {
                if (!empty($existingTags)) {
                    echo '<div class="border-t border-gray-100"></div>';
                }
                echo '<div class="px-3 py-2 text-sm text-gray-500">New tags to create:</div>';
                foreach ($newTags as $tag) {
                    echo '<div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer flex items-center" onclick="addTagToForm(\'' . htmlspecialchars($tag) . '\')">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            ' . htmlspecialchars($tag) . '
                          </div>';
                }
            }

            echo '</div>';
            
            // Add Enter key handler
            echo '<script>
                document.querySelector("[name=\'tag_search\']").addEventListener("keydown", async function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        const tagInput = this.value.trim();
                        if (!tagInput) return;

                        // Split by comma and clean each tag
                        const tags = tagInput.split(",")
                            .map(tag => tag.trim())
                            .filter(tag => tag.length > 0);

                        // Process each tag
                        for (const tag of tags) {
                            addTagToForm(tag);
                        }

                        // Clear input and suggestions
                        this.value = "";
                        document.getElementById("tag-suggestions").innerHTML = "";
                    }
                });

                function addTagToForm(tagName) {
                    if (!tagName || typeof tagName !== "string") return;
                    
                    // Clean the tag name
                    const cleanTagName = tagName.trim();
                    if (!cleanTagName) return;

                    // Check if tag already exists in the form
                    const existingTags = document.querySelectorAll("#selected-tags input[type=hidden]");
                    for (let input of existingTags) {
                        if (input.value.toLowerCase() === cleanTagName.toLowerCase()) {
                            return; // Tag already exists (case-insensitive check)
                        }
                    }

                    // Create new tag element
                    const tagDiv = document.createElement("div");
                    tagDiv.className = "group px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 flex items-center gap-1";
                    
                    const tagInput = document.createElement("input");
                    tagInput.type = "hidden";
                    tagInput.name = "tags[]";
                    tagInput.value = cleanTagName;

                    const tagSpan = document.createElement("span");
                    tagSpan.textContent = cleanTagName;

                    const removeButton = document.createElement("button");
                    removeButton.type = "button";
                    removeButton.className = "ml-1 text-blue-600 hover:text-blue-800";
                    removeButton.textContent = "×";
                    removeButton.onclick = function() {
                        tagDiv.remove();
                    };

                    tagDiv.appendChild(tagSpan);
                    tagDiv.appendChild(tagInput);
                    tagDiv.appendChild(removeButton);

                    document.getElementById("selected-tags").appendChild(tagDiv);
                }

                // Add click handlers for tag suggestions
                document.querySelectorAll("#tag-suggestions div[onclick]").forEach(div => {
                    const originalOnClick = div.getAttribute("onclick");
                    if (originalOnClick && originalOnClick.includes("addTagToForm")) {
                        const match = originalOnClick.match(/addTagToForm\\([\'"](.*)[\'"]\)/);
                        if (match) {
                            const tagName = match[1];
                            div.onclick = () => {
                                addTagToForm(tagName);
                                document.getElementById("tag-suggestions").innerHTML = "";
                                document.querySelector("[name=\'tag_search\']").value = "";
                            };
                        }
                    }
                });
            </script>';
        } catch (PDOException $e) {
            echo '<div class="p-2 text-red-500">Error checking tags</div>';
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
