<?php
namespace App\models;

use App\Utils;
use PDO;

class User
{
    protected $password;
    protected $email;
    protected $isAdmin = 0;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function validateEmail()
    {
        if(strlen($this->email)>255 || strlen($this->email)<5) {
            $_SESSION['registerMessage'] = "Email must be between 5 and 255 characters long!";
            return false;
        }
        $user = Utils::getDb()->prepare("SELECT * FROM users WHERE email=:email");
        $user->execute(['email' =>$this->email]);
        $user = $user->fetch(PDO::FETCH_OBJ);
        if($user) {
            $_SESSION['registerMessage'] = "Email already exists";
            return false;
        }
        unset($_SESSION['registerMessage']);
        return true;
    }

    public function validatePassword()
    {
        if(strlen($this->password)<8) {
            $_SESSION['registerMessage'] = "Password must be at least 8 characters long!";
            return false;
        }
        if(strcmp($this->password, $_POST["repeat"])) {
            $_SESSION['registerMessage'] = "Passwords are not equal!";
            return false;
        }
        unset($_SESSION['registerMessage']);
        return true;
    }

    public function register()
    {
        $user = Utils::getDb()->prepare("INSERT INTO users (email, password, isAdmin) VALUES (:email, :password, :isAdmin)");
        $user->execute([
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'isAdmin' => $this->isAdmin
        ]);
    }

    public function login()
    {
        $user = Utils::getDb()->prepare("SELECT * FROM users WHERE email = :email");
        $user->execute(['email' => $this->email]);
        $user = $user->fetch();
        if(password_verify($this->password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            unset($_SESSION['loginMessage']);
            if($user['isAdmin']) {
                $_SESSION['isAdmin'] = true;
            }
            return true;
        }
        return false;
    }
}
