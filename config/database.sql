create database cabinet;

CREATE TABLE CONNEXION (
  login VARCHAR(10) NOT NULL,
  pwd varchar(10) NOT NULL,
  PRIMARY KEY (login,pwd)
) ENGINE = InnoDB;


CREATE TABLE DOCTOR (
  idDoctor INT(11) NOT NULL AUTO_INCREMENT,
  gender TINYINT NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  firstName VARCHAR(50) NOT NULL,
  picture VARCHAR(50) DEFAULT 'doctor.png',
  PRIMARY KEY (idDoctor)
) ENGINE = InnoDB;


CREATE TABLE USER (
  idUser INT(11) NOT NULL AUTO_INCREMENT,
  gender TINYINT DEFAULT NULL,
  lastName VARCHAR(50) DEFAULT NULL,
  firstName VARCHAR(50) DEFAULT NULL,
  birthDay DATE DEFAULT NULL,
  adress VARCHAR(50) DEFAULT NULL,
  city VARCHAR(50) DEFAULT NULL,
  postalCode VARCHAR(5) DEFAULT NULL,
  birthPlace VARCHAR(50) DEFAULT NULL,
  secuNum BIGINT(11) DEFAULT NULL,
  idDoctor INT(11) DEFAULT NULL,
  picture VARCHAR(50) DEFAULT 'user.png',
  PRIMARY KEY (idUser),
  FOREIGN KEY(idDoctor) REFERENCES DOCTOR(idDoctor)
) ENGINE = InnoDB;


CREATE TABLE APPOINTMENT (
  appointmentDate DATE NOT NULL,
  hour TIME NOT NULL,
  idUser INT(11) NOT NULL,
  idDoctor INT(11) NOT NULL,
  duration TIME NOT NULL,
  PRIMARY KEY (appointmentDate,hour,idUser,idDoctor),
  FOREIGN KEY(idUser) REFERENCES USER(idUser),
  FOREIGN KEY(idDoctor) REFERENCES DOCTOR(idDoctor)
) ENGINE = InnoDB;



-- REMPLISSAGE DES TABLES

INSERT INTO DOCTOR (idDoctor, gender, lastName, firstName) VALUES
(1, 1, 'Burze', 'Patrick'),
(2, 2, 'Poirier', 'Isabelle'),
(3, 1, 'Fabre', 'Pascal'),
(4, 2, 'Dutoit', 'Corine'),
(5, 1, 'Voine', 'Michel');

INSERT INTO USER (idUser, gender, lastName, firstName, birthDay, adress, city, postalCode, birthPlace, secuNum, idDoctor) VALUES
(1, 1, 'Benz', 'Alexandre', '1991-09-08', 'Dans un bel appartement', 'Paris', '75000', 'Evreux', 45887587895, 1),
(2, 2, 'Dupont', 'Marine', '1968-08-05', 'EnFrance', 'Toulouse', '75003', 'Neuilly-sur-Seine', 55555555555, 1),
(3, 1, 'Dufour', 'Emmanuel', '2020-01-06', 'EnFrance', 'Lille', '31320', 'sdfg', 11111111111, 2),
(4, 1, 'Aron', 'Gabriel', '1991-09-08', 'Dans un bel appartement', 'Paris', '75000', 'Evreux', 45887587895, 2),
(5, 2, 'Vuste', 'Léa', '1968-08-05', 'EnFrance', 'Paris', '75003', 'Neuilly-sur-Seine', 55555555555, 3),
(6, 1, 'Chevalier', 'Tom', '2020-01-06', 'EnFrance', 'Paris', '31320', 'sdfg', 11111111111, 4),
(7, 1, 'Parte', 'Théo', '1991-09-08', 'Dans un bel appartement', 'Toulouse', '75000', 'Evreux', 45887587895, 5),
(8, 2, 'Suite', 'Jeanne', '1968-08-05', 'EnFrance', 'Toulouse', '75003', 'Neuilly-sur-Seine', 55555555555, 4),
(9, 1, 'Madre', 'Daniel', '2020-01-06', 'EnFrance', 'Marseille', '31320', 'sdfg', 11111111111, 3),
(10, 1, 'Poude', 'Roméo', '1977-12-21', 'LaBanque', 'Toulouse', '75006', 'Amienssdfgsdfg', 45875687584, 5);

INSERT INTO CONNEXION (login, pwd) VALUES
('admin', 'motDePasse');

INSERT INTO APPOINTMENT (appointmentDate, hour, idUser, idDoctor, duration) VALUES
('2024-02-01', '08:30:00', 1, 1, '01:00:00'), -- Consultation pour Alexandre Benz avec le Dr. Patrick Burze (1 heure)
('2024-02-03', '14:00:00', 2, 2, '00:45:00'), -- Consultation pour Marine Dupont avec le Dr. Isabelle Poirier (45 minutes)
('2024-02-05', '10:15:00', 3, 2, '00:30:00'), -- Consultation pour Emmanuel Dufour avec le Dr. Isabelle Poirier (30 minutes)
('2024-02-07', '09:45:00', 4, 3, '01:00:00'); -- Consultation pour Gabriel Aron avec le Dr. Pascal Fabre (1 heure)





--CREATION DES DECLENCHEURS
DELIMITER //
CREATE TRIGGER before_delete_user
BEFORE DELETE ON USER
FOR EACH ROW
BEGIN
    DELETE FROM appointment WHERE idUser = OLD.idUser;
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_delete_doctor
BEFORE DELETE ON DOCTOR
FOR EACH ROW
BEGIN
    DELETE FROM appointment WHERE idDoctor = OLD.idDoctor;
    UPDATE user SET idDoctor = NULL WHERE idDoctor = OLD.idDoctor;
END;
//
DELIMITER ;