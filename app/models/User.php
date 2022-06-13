<?php
namespace app\models;

use PDO;

class User extends Model
{
    protected $password;
    protected $username;
    protected $isAdmin = 0;

    public function __construct(PDO $db, $username, $password)
    {
        parent::__construct($db);
        $this->username=$username;
        $this->password = $password;
    }

    public function validateUsername()
    {
        if(strlen($this->username)>30 || strlen($this->username)<3)
        {
            echo "Username must be between 3 and 30 characters long!";
            return false;
        }
        $user = $this->db->prepare("SELECT * FROM users WHERE username= :username");
        $user->execute(['username' =>$this->username]);
        $user = $user->fetch(PDO::FETCH_OBJ);
        if($user)
        {
            echo "Username already exists";
            return false;
        }
        return true;
    }

    public function validatePassword()
    {
        if(strlen($this->password)>30 || strlen($this->password)<8)
        {
            echo "Password must be between 8 and 30 characters long!";
            return false;
        }
        if(isset($_POST['repeat']) && strcmp($this->password, $_POST["repeat"]))
        {
            echo "Passwords are not equal!";
            return false;
        }
        return true;
    }

    public function register()
    {
        //do registering
        $user = $this->db->prepare("INSERT INTO users (username, password, isAdmin) VALUES (:username, :password, :isAdmin)");
        $user->execute([
            'username' => $this->username,
            'password' => $this->password,
            'isAdmin' => $this->isAdmin
        ]);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }
}