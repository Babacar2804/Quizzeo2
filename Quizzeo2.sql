DROP DATABASE IF EXISTS Quizzeo2;
CREATE DATABASE IF NOT EXISTS Quizzeo2;
USE Quizzeo2;

CREATE TABLE Roles (
   id_role INT PRIMARY KEY AUTO_INCREMENT,
   nom_role VARCHAR(50) NOT NULL
);

CREATE TABLE Users (
   id_user INT PRIMARY KEY AUTO_INCREMENT,
   pseudo VARCHAR(50),
   email VARCHAR(50),
   password VARCHAR(50),
   statut_compte boolean NOT NULL,
   id_role INT NOT NULL,
   FOREIGN KEY (id_role) REFERENCES Roles(id_role)
);

CREATE TABLE Quizzes (
   id_quizz INT PRIMARY KEY AUTO_INCREMENT,
   titre VARCHAR(50),
   date_creation DATE,
   nbre_questions INT,
   type ENUM('QCM', 'Sondage') NOT NULL,
   Description VARCHAR(120),
   statut_quizz ENUM('creation', 'lance', 'termine') NOT NULL,
   visi_res ENUM('public', 'prive') NOT NULL,
   id_user INT NOT NULL,
   FOREIGN KEY (id_user) REFERENCES Users(id_user)
);

CREATE TABLE Questions (
   id_question INT PRIMARY KEY AUTO_INCREMENT,
   text VARCHAR(150),
   intitule VARCHAR(50),
   id_quizz INT NOT NULL,
   FOREIGN KEY (id_quizz) REFERENCES Quizzes(id_quizz)
);

CREATE TABLE Reponses (
   id_reponse INT PRIMARY KEY AUTO_INCREMENT,
   text_reponse VARCHAR(50),
   statut_reponse ENUM('correct', 'incorrect') NOT NULL,
   id_question INT NOT NULL,
   FOREIGN KEY (id_question) REFERENCES Questions(id_question)
);

CREATE TABLE Reponse_user (
   id_repuser INT PRIMARY KEY AUTO_INCREMENT,
   id_user INT,
   id_question INT,
   id_reponse INT,
   statut_rep ENUM('correct', 'incorrect') NOT NULL,
   FOREIGN KEY (id_user) REFERENCES Users(id_user),
   FOREIGN KEY (id_question) REFERENCES Questions(id_question),
   FOREIGN KEY (id_reponse) REFERENCES Reponses(id_reponse)
);
CREATE TABLE API(
id_api INT PRIMARY KEY AUTO_INCREMENT,
id_user INT,
API_KEY VARCHAR(100),
FOREIGN KEY (id_user) REFERENCES Users(id_user)
);
INSERT INTO roles (id_role, nom_role) VALUES
(1, 'Admin'),
(2, 'Validateur'),
(3, 'Quizz_admin'),
(4, 'Quizzer'),
(5, 'Utilisateur');


INSERT INTO users (id_user, pseudo, email, password, statut_compte, id_role) VALUES
(1, 'admin', 'admin@example.com', 'admin', true, 1),
(2, 'validateur', 'validateur@example.com', 'validateur', true, 2),
(3, 'adminquiz', 'adminquiz@example.com', 'adminquiz', true, 3),
(4, 'quizzer', 'quizzer@example.com', 'quizzer', true, 4);
