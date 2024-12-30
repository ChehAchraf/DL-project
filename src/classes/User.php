<?php
namespace Classes;

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
        return "User registered successfully";
    }

}