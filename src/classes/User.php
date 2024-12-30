<?php
namespace Classes;
session_start();
class User{
    protected $id;
    protected $name;
    protected $secname;
    protected $email;
    protected $password;
    protected $role;

    public function __construct($name, $secname,$email,$password){
        $this->name      = $name ;
        $this->secname   = $secname;
        $this->email     = $email;
        $this->password  =$password;
    }

    public function register($pdo){
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO `users` (name,s_name,email,password) VALUES(:name,:s_name,:email,:password) ");
        $stmt->execute([
            'name' => $this->name,
            's_name' => $this->secname,
            'email' => $this->email,
            'password' => $hashedPassword
        ]);
        $_SESSION['registred'] ;
    }

    public function login($pdo){
        $stmt = $pdo->prepare("SELECT  * FROM `users` WHERE email = :email");
        $stmt->execute(['email' => $this->email]);
        $user = $stmt->fetch();
        if ($user && password_verify($this->password, $user['mot_de_passe'])) {
            if($user['banned'] == true)
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
            }
      
        }
    }
}