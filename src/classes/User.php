<?php
session_start();
class User {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $password;
    protected $email;
    protected $role;
    protected $bannir;
    
    public function setBan($bannir)
    {
      
        $this->bannir = $bannir;
    }

    public function __construct($id=null,$nom, $prenom, $password,$email, $role = 'client') {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }
    function __tostring(){
        return 'mon id est '.$this->id. ' mon email est '.$this->bannir;
    }
    public function login($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email ");
        $stmt->execute(['email' => $this->email]);
        $user = $stmt->fetch();

        if ($user && password_verify($this->password, $user['mot_de_passe'])) {
            if($user['banned'] == true)
            {
                return 404;
            }else {
                $_SESSION['id'] = $user['id_utilisateur'];
                $_SESSION['user_role'] = $user['role'];
                
                return 202;
            }
      
        }
        return null;
    }

    public function register($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email ");
        $stmt->execute(['email' => $this->email]);
        $user = $stmt->fetch();
        
        if ($user) {
            return false;
        }

        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, mot_de_passe,email, role) VALUES (:nom, :prenom, :password, :email , :role)");
        $stmt->execute([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'password' => $hashedPassword,
            'email' => $this->email,
            'role' => $this->role
        ]);

        return "User registered successfully";
    }
    // public function makeReservation($pdo, $activityId, $userId, $date) {
    //     $stmt = $pdo->prepare("INSERT INTO reservations (user_id, activity_id, date) VALUES (:user_id, :activity_id, :date)");
    //     $stmt->execute(['user_id' => $userId, 'activity_id' => $activityId, 'date' => $date]);

    //     return "Reservation made successfully";
    // }
   
    public static function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['user_role']);
        session_destroy();
       
        return true;
    }
    // public static function getUserById($pdo,$id)
    // {
    //     try {
    //         $stmt = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE `id_utilisateur` = :idd");
    //         $stmt->execute(['idd' => $id]);
    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     } catch (Exception $e) {
    //         return "Couldn't Fetch Users: " . $e->getMessage();
    //     }
    // }
    // public static function getAllUsers($pdo)
    // {
    //     try {
    //         $stmt = $pdo->prepare("SELECT * FROM `utilisateurs`");
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (Exception $e) {
    //         return "Couldn't Fetch Users: " . $e->getMessage();
    //     }
    // }


}
?>
