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
            $stmt = $pdo->prepare("DELETE FROM `users` WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            echo "User with ID $userId has been deleted successfully.";
        } catch (PDOException $e) {
            throw new Exception("Failed to delete user: " . $e->getMessage());
        }
    }

    public function listUsers($pdo) {
        try {
            $stmt = $pdo->query("SELECT id, name, s_name, email, role FROM `users`");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch users: " . $e->getMessage());
        }
    }

    public function updateUserRole($pdo, $userId, $newRole) {
        try {
            $stmt = $pdo->prepare("UPDATE `users` SET role = :role WHERE id = :id");
            $stmt->execute([
                'role' => $newRole,
                'id' => $userId
            ]);
            echo "User with ID $userId has been updated to role $newRole.";
        } catch (PDOException $e) {
            throw new Exception("Failed to update user role: " . $e->getMessage());
        }
    }
}
