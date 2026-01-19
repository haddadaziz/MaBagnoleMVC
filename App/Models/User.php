<?php
namespace App\Models;
use PDO;

class User
{
    private $id;
    private $nom_complet;
    private $email;
    private $password;
    private $role;

    public function __construct($id, $nom_complet, $email, $password, $role)
    {
        $this->id = $id;
        $this->nom_complet = $nom_complet;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getNomComplet()
    {
        return $this->nom_complet;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getRole()
    {
        return $this->role;
    }

    public static function register($conn, $nom_complet, $email, $password)
    {
        $nom_complet = htmlspecialchars(strip_tags($nom_complet));
        $email = htmlspecialchars(strip_tags($email));
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nom_complet, email, password, role) VALUES (:nom, :email, :password, 'client')";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom_complet,
            ':email' => $email,
            ':password' => $password
        ]);
    }

    public static function login($conn, $email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
