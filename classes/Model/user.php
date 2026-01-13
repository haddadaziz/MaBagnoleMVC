<?php
namespace App\Model;
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
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'client';
        $query = "INSERT INTO users (nom_complet, email, password, role) VALUES (:nom, :email, :pass, :role)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            ':nom' => $nom_complet,
            ':email' => $email,
            ':pass' => $password_hash,
            ':role' => $role
        ]);
    }
    public static function findByEmail($conn, $email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function verifier_login($conn, $email, $password)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($password, $row['password'])) {
            return new User(
                $row['id'],
                $row['nom_complet'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        }

        return null;
    }
    public static function getById($conn, $id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User(
                $row['id'],
                $row['nom_complet'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        }
        return null;
    }
    public static function getAll($conn)
    {
        $query = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}