<?php 
namespace Classes;
require __DIR__ . '/../../vendor/autoload.php'; 
use Helpers\Database;
use PDO;
use PDOException;
use Exception;

class BlogCategory{
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
            $stmt = $pdo->query("
                SELECT id, name, description, created_at 
                FROM blog_categories 
                ORDER BY created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch categories: " . $e->getMessage());
        }
    }
    
    public static function getCategory($pdo, $id) {
        try {
            $stmt = $pdo->prepare("
                SELECT id, name, description, created_at 
                FROM blog_categories 
                WHERE id = :id
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch category: " . $e->getMessage());
        }    
    }
}