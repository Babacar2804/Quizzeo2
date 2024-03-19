<?php

class BDD {
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $BDD = "quizzeo2";
    public $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->BDD", $this->username, $this->password);
            // Configurer PDO pour afficher les erreurs
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Définir le jeu de caractères à utf8mb4
            $this->connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
        } catch (PDOException $e) {
            // En cas d'erreur de connexion, afficher le message d'erreur
            echo "Erreur de connexion: " . $e->getMessage();
            die();
        }
    }

    public function executeQuery($query, $params = []) {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
    }
}

class Users {
    public $db;

    public function __construct(BDD $db) {
        $this->db = $db;
    }
    
    public function AddUsers($pseudo, $email, $password,$role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (pseudo, email, password, statut_compte,id_role) VALUES (:pseudo, :email, :password, 'active',:id_role)";
        $params = array(':pseudo' => $pseudo, ':email' => $email, ':password' => $hashedPassword,':id_role'=>$role);
        $statement = $this->db->executeQuery($query, $params);
        return $statement->execute();
    }
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $this->db->executeQuery($query, array(':email' => $email));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

class AdminSite extends Users {
    
    public function Users() {
        $query = "SELECT * FROM users";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function UsersLogged() {
        $query = "SELECT * FROM users WHERE statut_compte = 'active'";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Quizzes() {
        $query = "SELECT * FROM quizzes";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

class ValCompte extends Users {
}
class AdminQuiz extends Quizzer {
}

class Quizzer extends SimpleUsers {
}

class SimpleUsers extends Users {
}

?>