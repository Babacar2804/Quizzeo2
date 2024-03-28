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
    public function getLastInsertedId() {
        return $this->connection->lastInsertId();
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
   
    public function insert_quizz($id_user, $titre, $date_creation, $type,$status) {
        $query="INSERT INTO Quizzes (id_user,titre, date_creation,  type, statut_quizz,status) VALUES (:id_user,:titre, :date_creation, :type, :statut_quizz,:status)";
        $params = [
            ':titre' => htmlspecialchars($titre),
            ':date_creation' => htmlspecialchars($date_creation),
            ':type' => htmlspecialchars($type),
            ':id_user' => (int) $id_user,
            ':statut_quizz'=>'creation',
            ':status'=>(int)$status,
        ];
        $statement = $this->db->connection->prepare($query);
        $statement->execute($params);
        return $statement ? $this->db->connection->lastInsertId() : false;
    }
    
    public function insert_question($question, $id_quizz) {
        $query="INSERT INTO Questions (question, id_quizz) VALUES (:question, :id_quizz)";
        $params = [
            ':question' => htmlspecialchars($question),
            ':id_quizz' => (int) $id_quizz
        ];
    
        $statement = $this->db->connection->prepare($query);
        $statement->execute($params);
        return $statement ? $this->db->connection->lastInsertId() : false;
    }
    public function updateQuizz($titre, $date_creation, $type, $id_quizz) {
        $query = "UPDATE quizzes SET titre = :titre, date_creation = :date_creation, type = :type WHERE id_quizz = :id_quizz";
        $params = [
            ':titre' => $titre,
            ':date_creation' => $date_creation,
            ':type' => $type,
            ':id_quizz' => $id_quizz
        ];
        $statement = $this->db->connection->prepare($query);
        return $statement->execute($params);
    }
    
    public function insert_reponse($reponses, $id_question) {
        $query="INSERT INTO Reponses (reponses, id_question) VALUES (:reponses, :id_question)";
        $params = [
            ':reponses' => htmlspecialchars($reponses),
            ':id_question' => (int) $id_question
        ];
        $statement = $this->db->connection->prepare($query);
        $statement->execute($params);
        return $statement ? $this->db->connection->lastInsertId() : false;
    }
    public function affichquizz($user_id) {
        $query = "SELECT * FROM quizzes WHERE id_user= :user_id";
        $statement = $this->db->connection->prepare($query);
        $statement->execute(array(':user_id' => $user_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saveQuizLink($id_quizz, $lien) {
        $query="UPDATE Quizzes SET lien = :lien WHERE id_quizz = :id_quizz";
        $params = [
            ':id_quizz' => (int) $id_quizz,
            ':lien' => htmlspecialchars($lien)
        ];

        $statement = $this->db->connection->prepare($query);
        $statement->execute($params);
        return $statement ? $this->db->connection->lastInsertId() : false;
    }
    public function deleteQuizLink($quiz_id) {
        $query = "UPDATE quizzes SET lien = NULL WHERE id_quizz = :id_quizz";
        $params = array(':id_quizz' => $quiz_id);
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    public function insert_reponse_user($id_user, $id_question, $id_reponse) {
        // Vérifiez si la réponse est correcte
        $query = "SELECT * FROM reponses WHERE id_question = :id_question AND id_reponse = :id_reponse";
        $statement = $this->db->connection->prepare($query);
        $statement->execute(array(':id_question' => $id_question, ':id_reponse' => $id_reponse));
        $reponse = $statement->fetch(PDO::FETCH_ASSOC);
    
        $is_correct = ($reponse !== false) ? true : false;
    
        // Insérez la réponse de l'utilisateur
        $query = "INSERT INTO reponse_user (id_user, id_question, id_reponse, is_correct) VALUES (:id_user, :id_question, :id_reponse, :is_correct)";
        $statement = $this->db->connection->prepare($query);
        $statement->execute(array(':id_user' => $id_user, ':id_question' => $id_question, ':id_reponse' => $id_reponse, ':is_correct' => $is_correct));
    
        return $is_correct;
    }
    
    
    
    
    
    public function updateQuizzStatus($quiz_id, $status) {
        $query = "UPDATE quizzes SET statut_quizz = :status WHERE id_quizz = :quiz_id";
        $params = array(':status' => $status, ':quiz_id' => $quiz_id);
        $statement = $this->db->executeQuery($query, $params);
        if ($statement) {
            echo '<script>alert("Statut du quizz mis à jour avec succès.");</script>';
        } else {
            echo "<script>alert('Une erreur s\'est produite lors de la mise à jour du statut du quizz.');</script>";
        }
    }
    public function getQuizzData($id_quizz) {
        $query = "SELECT * FROM quizzes WHERE id_quizz = :idQuizz";
        $params = [':idQuizz' => $id_quizz];
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuestions($id_quizz) {
        $query = "SELECT * FROM questions WHERE id_quizz = :idQuizz";
        $params = [':idQuizz' => $id_quizz];
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteQuestions($id_quizz) {
        $query = "DELETE FROM questions WHERE id_quizz = :idQuizz";
        $params = [':idQuizz' => $id_quizz];
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute($params);
    }

    public function insertQuestion($question, $id_quizz) {
        $query = "INSERT INTO questions (question, id_quizz) VALUES (:question, :idQuizz)";
        $params = [':question' => $question, ':idQuizz' => $id_quizz];
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute($params);
        return $this->db->connection->lastInsertId();
    }

    public function insertReponse($reponse, $id_question) {
        $query = "INSERT INTO reponses (reponses, id_question) VALUES (:reponse, :idQuestion)";
        $params = [':reponse' => $reponse, ':idQuestion' => $id_question];
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute($params);
    }
    
    
}

class AdminQuiz extends Quizzer {

public function updateQuizStatus($quiz_id, $status) {
    $statut_quizz = ($status === "active") ? 1 : 0;
    $query = "UPDATE quizzes SET status = :status WHERE id_quizz = :quiz_id";
    $params = array(':status' => $statut_quizz, ':quiz_id' => $quiz_id);
    $statement = $this->db->executeQuery($query, $params);
    if ($statement) {
        echo '<script>alert("Statut du quizz mis à jour avec succès.");</script>';
    } else {
        echo "Une erreur s'est produite lors de la mise à jour du statut du quiz.";
    }
}

}

class ValCompte extends AdminQuiz {
    public function InactiveAccounts() {
        $query = "SELECT id_user, pseudo FROM users WHERE statut_compte = 0";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function activateAccount($user_id) {
        $query = "UPDATE users SET statut_compte = 1 WHERE id_user = :user_id";
        $params = array(':user_id' => $user_id);
        $statement = $this->db->executeQuery($query, $params);
        return $statement !== false;
    }
    public function UsersAccounts() {
        $query = "SELECT id_user, pseudo FROM users WHERE id_role = 5";
        $statement = $this->db->executeQuery($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateUserRole($userId, $newRoleId) {
        $query = "UPDATE Users SET id_role = :newRoleId WHERE id_user = :userId";
        $params = array(':newRoleId' => $newRoleId, ':userId' => $userId);
        $statement = $this->db->executeQuery($query, $params);
        return $statement !== false;
    }

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
            echo '<script>alert("Statut du user mis à jour avec succès.");</script>';
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
            echo '<script>alert("Statut du quizz mis à jour avec succès.");</script>';
        } else {
            echo "Une erreur s'est produite lors de la mise à jour du statut du compte utilisateur.";
        }
    }
}

?>
