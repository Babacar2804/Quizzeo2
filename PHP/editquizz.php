<?php 
session_start();

require 'classes.php';
$db = new BDD();
$user_id = $_SESSION['user_id'];
$id_quizz=31;
$query = "SELECT * FROM quizzes WHERE id_quizz =$id_quizz ";
$statement = $db->connection->prepare($query);
$statement->execute(array(':id_quizz' => $id_quizz));
$user = $statement->fetch(PDO::FETCH_ASSOC);
?>