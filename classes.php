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
    protected $db;

    public function __construct(BDD $db) {
        $this->db = $db;
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $this->db->executeQuery($query, array(':email' => $email));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

class SimpleUsers extends Users {
        

    
}

class Quizzer extends SimpleUsers {
    public function Quizzes() {
        $query = "SELECT * FROM quizzes";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

class AdminQuiz extends Quizzer {
}

class ValCompte extends Quizzer {


}

class AdminSite extends ValCompte {
    public function Users() {
        $query = "SELECT * FROM users";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUsersByStatus($status) {
        $query = "SELECT id_user, pseudo, email FROM users WHERE status = :status";
        $statement = $this->db->connection->prepare($query);
        $statement->execute(array(':status' => $status));
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function updateStatus($user_id, $status) {
        $status_value = ($status === "active") ? 1 : 0;
        $query = "UPDATE users SET status = :status WHERE id_user = :user_id";
        $params = array(':status' => $status_value, ':user_id' => $user_id);
        $statement = $this->db->executeQuery($query, $params);
        if ($statement) {
            echo "Statut de connexion de l'utilisateur mis à jour avec succès.";
        } else {
            echo "Une erreur s'est produite lors de la mise à jour du statut de connexion de l'utilisateur.";
        }
    }

    public function updateUserStatus($user_id, $status) {
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

?>
