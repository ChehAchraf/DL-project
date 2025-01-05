<?php
namespace Classes;
use Classes\User;
use PDO;
use PDOException;
use Exception;

class Admin extends User {
    protected $role = "admin";
    

    public function __construct($name, $secname, $email, $password) {
        parent::__construct($name, $secname, $email, $password);
    }

    public function register($pdo) {
        try {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO `users` (name, s_name, email, password, role) VALUES (:name, :s_name, :email, :password, :role)");
            $stmt->execute([
                'name' => $this->name,
                's_name' => $this->secname,
                'email' => $this->email,
                'password' => $hashedPassword,
                'role' => $this->role
            ]);
            $_SESSION['registered'] = true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function deleteUser($pdo, $userId) {
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            throw new Exception("Failed to delete user: " . $e->getMessage());
        }
    }

    public function listUsers($pdo) {
        try {
            $stmt = $pdo->query("
                SELECT id, name, s_name, email, role, created_at 
                FROM `users` 
                ORDER BY created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch users: " . $e->getMessage());
        }
    }
    
    public function updateUserRole($pdo, $userId, $newRole) {
        try {
            if (!in_array($newRole, ['client', 'admin'])) {
                throw new Exception("Invalid role specified");
            }
            
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            return $stmt->execute([$newRole, $userId]);
        } catch (PDOException $e) {
            throw new Exception("Failed to update user role: " . $e->getMessage());
        }
    }

    public static function ReservationHandling($pdo){
        
        try {
            $stmt = $pdo->prepare("SELECT 	
                                    reservations.id,
                                    reservations.user_id,
                                    reservations.car_id,
                                    reservations.start_date,
                                    reservations.end_date,
                                    reservations.pickup_location,
                                    reservations.return_location,
                                    reservations.created_at,
                                    reservations.status,
                                    users.name,
                                    cars.model,
                                    cars.price
                                FROM 
                                    reservations
                                INNER JOIN 
                                    users ON users.id = reservations.user_id
                                INNER JOIN 
                                    cars ON cars.id = reservations.car_id");
    
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);   
    
            return $reservations;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    public function EditStatus($pdo, $res_id, $res_status) {
        if (isset($res_id) && isset($res_status)) {
            // تحقق من أن القيمة التي تم إرسالها هي واحدة من الحالات المعتمدة
            $validStatuses = ['pending', 'approved', 'rejected'];
            
            if (in_array($res_status, $validStatuses)) {
                // إعداد الاستعلام لتحديث حالة الحجز بناءً على id الحجز والحالة المطلوبة
                $stmt = $pdo->prepare("UPDATE `reservations` SET `status` = :status WHERE `id` = :id");
    
                // إضافة تسجيل للحالة
                echo "Executing query to update status: " . $stmt->queryString;
                // تنفيذ الاستعلام مع ربط القيم
                $stmt->execute([
                    'status' => $res_status,  // تحديث الحالة باستخدام المتغير
                    'id' => $res_id           // تحديث الحجز باستخدام id
                ]);
    
                echo "Rows affected: " . $stmt->rowCount();  // تحقق من عدد الأسطر المتأثرة
            } else {
                echo "Invalid status value.";
            }
        }
    }
    
    public function createcategory($pdo, $name) {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute(['name' => $name]);
            return "Category created successfully.";
        } catch (PDOException $e) {
            throw new Exception("Failed to create category: " . $e->getMessage());
        }
    }
    public function listCategories($pdo) {
        try {
            $stmt = $pdo->query("SELECT id, name FROM categories");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch categories: " . $e->getMessage());
        }
    }
    public function deleteCategory($pdo, $categoryId) {
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            return $stmt->execute([$categoryId]);
        } catch (PDOException $e) {
            throw new Exception("Failed to delete category: " . $e->getMessage());
        }
    }

    public function updateCategory($pdo, $categoryId, $categoryName) {
        try {
            $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
            return $stmt->execute([
                ':name' => $categoryName,
                ':id' => $categoryId
            ]);
        } catch (PDOException $e) {
            error_log("Error updating category: " . $e->getMessage());
            return false;
        }
    }
}
