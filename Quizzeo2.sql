Drop Database if exists Quizzeo2;
CREATE Database if not exists Quizzeo2;
use Quizzeo2;
CREATE TABLE Rôles(
   id_role INT PRIMARY KEY AUTO_INCREMENT,
   admin VARCHAR(50),
   validateur VARCHAR(50),
   quizz_admin VARCHAR(50),
   quizzer VARCHAR(50),
   utilisateur VARCHAR(50)
);

CREATE TABLE Users(
   id_user INT PRIMARY KEY AUTO_INCREMENT,
   pseudo VARCHAR(50),
   email VARCHAR(50),
   password VARCHAR(50),
   statut_compte enum('active','desactive') NOT NULL,
   id_role INT NOT NULL,
   FOREIGN KEY(id_role) REFERENCES Rôles(id_role)
);

CREATE TABLE Quizzes(
   id_quizz INT PRIMARY KEY AUTO_INCREMENT,
   titre VARCHAR(50),
   date_creation DATE,
   nbre_questions INT,
   type enum('QCM','Sondage') NOT NULL,
   Description VARCHAR(120),
   statut_quizz enum('creation','lance','termine') NOT NULL,
   visi_res('public','prive') NOT NULL,
   id_user INT NOT NULL,
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

CREATE TABLE questions(
   id_question INT PRIMARY KEY AUTO_INCREMENT,
   text VARCHAR(150),
   intitule VARCHAR(50),
   id_quizz INT NOT NULL,
   FOREIGN KEY(id_quizz) REFERENCES Quizzes(id_quizz)
);

CREATE TABLE reponses(
   id_reponse INT PRIMARY KEY AUTO_INCREMENT,
   text_reponse VARCHAR(50),
   statut_reponse enum('correct','incorrect') NOT NULL,
   id_question INT NOT NULL,
   FOREIGN KEY(id_question) REFERENCES questions(id_question)
);

CREATE TABLE reponse_user(
   id_repuser INT PRIMARY KEY AUTO_INCREMENT,
   id_user INT,
   id_question INT,
   id_reponse INT,
   statut_rep enum('correct','incorrect') INT NOT NULL,
   FOREIGN KEY(id_user) REFERENCES Users(id_user),
   FOREIGN KEY(id_question) REFERENCES questions(id_question),
   FOREIGN KEY(id_reponse) REFERENCES reponses(id_reponse)
)
