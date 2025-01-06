<?php 
namespace Classes;
require __DIR__ . '/../../vendor/autoload.php'; 
use Helpers\Database;
use PDO;
use PDOException;
use Exception;

class BlogCategory {
    public $id;
    public $name;
    public $description;
    public $created_at;

    public function __construct($id, $name, $description, $created_at) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;        
    }

    public static function listCategories($pdo) {
        try {
            // Check if the table exists
            $stmt = $pdo->query("SHOW TABLES LIKE 'category_blog'");
            if (!$stmt->fetch()) {
                throw new Exception("Categories table does not exist");
            }

            $stmt = $pdo->prepare("
                SELECT id, name, description, created_at 
                FROM category_blog 
                ORDER BY created_at DESC
            ");
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query");
            }

            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($categories)) {
                // If no categories exist, create a default one
                $stmt = $pdo->prepare("
                    INSERT INTO category_blog (name, description) 
                    VALUES ('General', 'General category for articles')
                ");
                $stmt->execute();
                
                // Fetch categories again
                $stmt = $pdo->prepare("
                    SELECT id, name, description, created_at 
                    FROM category_blog 
                    ORDER BY created_at DESC
                ");
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $categories;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
    
    public static function getCategory($pdo, $id) {
        try {
            $stmt = $pdo->prepare("
                SELECT id, name, description, created_at 
                FROM category_blog 
                WHERE id = :id
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch category: " . $e->getMessage());
        }    
    }
}