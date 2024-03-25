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

class Quizzer extends Users {
    public function Quizzes() {
        $query = "SELECT * FROM quizzes";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function insert_quizz($id_user, $titre, $date_creation, $type, $description, $statut_quizz) {
        $params = [
            ':titre' => htmlspecialchars($titre),
            ':date_creation' => htmlspecialchars($date_creation),
            ':type' => htmlspecialchars($type),
            ':description' => htmlspecialchars($description),
            ':statut_quizz' => htmlspecialchars($statut_quizz),
            ':id_user' => (int) $id_user
        ];
    
        $result = $this->executeInsertQuery("INSERT INTO Quizzes (id_user,titre, date_creation,  type, Description, statut_quizz) VALUES (:id_user,:titre, :date_creation, :type, :description, :statut_quizz)", $params);
        return $result ? $this->db->connection->lastInsertId() : false;
    }
    
    public function insert_question($question, $id_quizz) {
        $params = [
            ':question' => htmlspecialchars($question),
            ':id_quizz' => (int) $id_quizz
        ];
    
       $result= $this->executeInsertQuery("INSERT INTO Questions (question, id_quizz) VALUES (:question, :id_quizz)", $params);
        return $result ? $this->db->connection->lastInsertId() : false;
    }
    
    public function insert_reponse($reponses, $id_question) {
        $params = [
            ':reponses' => htmlspecialchars($reponses),
            ':id_question' => (int) $id_question
        ];
    
        $result= $this->executeInsertQuery("INSERT INTO Reponses (reponses, id_question) VALUES (:reponses, :id_question)", $params);
        return $result ? $this->db->connection->lastInsertId() : false;
    }
    
    public function insert_reponse_user($id_user, $id_question, $id_reponse, $statut_rep) {
        $params = [
            ':id_user' => (int) $id_user,
            ':id_question' => (int) $id_question,
            ':id_reponse' => (int) $id_reponse,
            ':statut_rep' => htmlspecialchars($statut_rep)
        ];
    
        return $this->executeInsertQuery("INSERT INTO Reponse_user (id_user, id_question, id_reponse, statut_rep) VALUES (:id_user, :id_question, :id_reponse, :statut_rep)", $params);
    }
    
    public function executeInsertQuery($query, $params) {
        $stmt = $this->db->connection->prepare($query);
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value, PDO::PARAM_STR);
        }
        return $stmt->execute();
    }
    
    
}

class AdminQuiz extends Quizzer {
}

class ValCompte extends AdminQuiz {


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
