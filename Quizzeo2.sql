DROP DATABASE IF EXISTS Quizzeo2;
CREATE DATABASE Quizzeo2;
USE Quizzeo2;

DROP TABLE IF EXISTS Users;
CREATE TABLE IF NOT EXISTS Users (
   id_user INT PRIMARY KEY AUTO_INCREMENT,
   pseudo VARCHAR(50),
   email VARCHAR(50),
   password VARCHAR(50),
   role enum('admin','validateur','quizz_admin','quizzer','utilisateur') NOT NULL,
   statut_compte enum('active','desactive')  NOT NULL
);

DROP TABLE IF EXISTS Quizzes;
CREATE TABLE IF NOT EXISTS Quizzes (
   id_quizz INT PRIMARY KEY AUTO_INCREMENT,
   titre VARCHAR(50),
   date_creation DATE,
   nbre_questions INT,
   type enum('QCM','Feedback') NOT NULL,
   Description VARCHAR(120),
   statut_quizz enum('creation','lance','termine') NOT NULL,
   visi_resu enum('public','prive')  NOT NULL,
   id_user INT NOT NULL,
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

DROP TABLE IF EXISTS Questions;
CREATE TABLE IF NOT EXISTS Questions (
   id_question INT PRIMARY KEY AUTO_INCREMENT,
   text VARCHAR(150),
   intitule VARCHAR(50),
   id_quizz INT NOT NULL,
   FOREIGN KEY(id_quizz) REFERENCES Quizzes(id_quizz)
);

DROP TABLE IF EXISTS Reponses;
CREATE TABLE IF NOT EXISTS Reponses (
   id_reponse INT PRIMARY KEY AUTO_INCREMENT,
   text_reponse VARCHAR(50),
   statut_reponse enum('correcte','incorrecte') NOT NULL,
   id_question INT NOT NULL,
   FOREIGN KEY(id_question) REFERENCES Questions(id_question)
);

DROP TABLE IF EXISTS Reponse_user;
CREATE TABLE IF NOT EXISTS Reponse_user (
   id_repuser INT PRIMARY KEY AUTO_INCREMENT,
   id_user INT,
   id_question INT,
   id_reponse INT,
   statut_rep enum('correcte','incorrecte') NOT NULL,
   FOREIGN KEY(id_user) REFERENCES Users(id_user),
   FOREIGN KEY(id_question) REFERENCES Questions(id_question),
   FOREIGN KEY(id_reponse) REFERENCES Reponses(id_reponse)
);


