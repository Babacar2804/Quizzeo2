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
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
        } catch (PDOException $e) {
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
    if (isset($_SESSION['logged_users'])) {
        return $_SESSION['logged_users'];
    } else {
        return [];
    }
}
    
    public function Quizzes() {
        $query = "SELECT * FROM quizzes";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
        public function updateUserStatus($user_id, $status) {
            // Vérifier si le statut est "active" ou "inactive"
            $statut_compte = ($status === "active") ? 1 : 0;
            $query = "UPDATE Users SET statut_compte = :statut_compte WHERE id_user = :user_id";
            $params = array(':statut_compte' => $statut_compte, ':user_id' => $user_id);
            $statement = $this->db->executeQuery($query, $params);
            if ($statement) {
                echo "Statut du compte utilisateur mis à jour avec succès.";
            } else {
                echo "Une erreur s'est produite lors de la mise à jour du statut du compte utilisateur.";
            }
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