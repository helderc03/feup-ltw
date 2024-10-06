PRAGMA foreign_keys=ON;

DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Document;
DROP TABLE IF EXISTS Faq;
DROP TABLE IF EXISTS Inquiry;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS assUserDepartment;
DROP TABLE IF EXISTS assTicketHashtag;
DROP TABLE IF EXISTS TicketChange;

/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE Department(
	idDepartment INTEGER NOT NULL UNIQUE,
	Title NVARCHAR(50) NOT NULL,
	Description NVARCHAR(160) NOT NULL,
	PRIMARY KEY(idDepartment)	
);

CREATE TABLE User(
	idUser INTEGER UNIQUE, 
	Name NVARCHAR(50) NOT NULL, 
	Email NVARCHAR(100) NOT NULL,
	Password NVARCHAR(50) NOT NULL, 
	type TEXT CHECK(type IN ('Agent', 'Admin', 'Client')),
	PRIMARY KEY(idUser)	
);

CREATE TABLE Hashtag (
	idHashtag INTEGER NOT NULL UNIQUE,
	Title NVARCHAR(50) NOT NULL,
	idDepartment INTEGER NOT NULL,
	PRIMARY KEY(idHashtag),
	FOREIGN KEY(idDepartment) REFERENCES Department(idDepartment)
);
CREATE TABLE Ticket(
    idTicket INTEGER NOT NULL UNIQUE,
    Title NVARCHAR(160) NOT NULL,
    Status NVARCHAR(160) NOT NULL DEFAULT 'Not defined',
    Priority NVARCHAR(160) NOT NULL DEFAULT 'Not defined',
    Description NVARCHAR(160) NOT NULL,
    idClient INTEGER NOT NULL,
    idDepartment INTEGER NOT NULL,
    idAgent INTEGER,
	similarTicket INTEGER,
    PRIMARY KEY(idTicket),
    FOREIGN KEY(idAgent) REFERENCES User(idUser),
    FOREIGN KEY(idClient) REFERENCES User(idUser),
    FOREIGN KEY(idDepartment) REFERENCES Department(idDepartment)
);

CREATE TABLE TicketChange (
    idChange INTEGER PRIMARY KEY,
    idTicket INTEGER NOT NULL,
    ChangedField NVARCHAR(160) NOT NULL,
    OldValue NVARCHAR(160),
    NewValue NVARCHAR(160),
    ChangeDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idTicket) REFERENCES Ticket (idTicket)
);


CREATE TABLE assUserDepartment(
	user_id INTEGER NOT NULL,
	department_id INTEGER NOT NULL,
	PRIMARY KEY (user_id, department_id),
	FOREIGN KEY (user_id) REFERENCES User(idUser),
	FOREIGN KEY (department_id) REFERENCES Department(idDepartment)
);


CREATE TABLE assTicketHashtag(
	ticket_id INTEGER NOT NULL,
	hashtag_id INTEGER NOT NULL,
	PRIMARY KEY (ticket_id, hashtag_id),
	FOREIGN KEY (ticket_id) REFERENCES Ticket(idTicket),
	FOREIGN KEY (hashtag_id) REFERENCES Hashtag(idHashtag)
);

CREATE TABLE Task (
	idTask INTEGER NOT NULL UNIQUE, 
	Description NVARCHAR(160) NOT NULL,
	Status NVARCHAR(160) NOT NULL DEFAULT 'Open',
	idTicket INTEGER NOT NULL,
	idAgent INTEGER NOT NULL,
	PRIMARY KEY(idTask),
	FOREIGN KEY(idTicket) REFERENCES Ticket(idTicket),
	FOREIGN KEY(idAgent) REFERENCES User(idUser)
);

CREATE TABLE Inquiry (
    idInquiry INTEGER NOT NULL UNIQUE,
    idTicket INTEGER NOT NULL,
    idCreator INTEGER NOT NULL,
    Description NVARCHAR(160) NOT NULL,
    PRIMARY KEY (idInquiry),
    FOREIGN KEY (idTicket) REFERENCES Ticket(idTicket),
    FOREIGN KEY (idCreator) REFERENCES User(idUser)
);


CREATE TABLE Document (
    idDocument INTEGER PRIMARY KEY,
    documentPath NVARCHAR(100) NOT NULL,
    idTicket INTEGER NOT NULL ,
    FOREIGN KEY(idTicket) REFERENCES Ticket(idTicket)
);


CREATE TABLE Faq (
	idFaq INTEGER NOT NULL UNIQUE,
	Question NVARCHAR(160) NOT NULL,
	Answer NVARCHAR(200) NOT NULL,
	PRIMARY KEY(idFaq)	
);

INSERT INTO Department (idDepartment, Title, Description) VALUES (0, 'Mecanica', 'Parafusos e tal');
INSERT INTO Department (idDepartment, Title, Description) VALUES (1, 'Informatica', 'Melhor curso');
INSERT INTO Department (idDepartment, Title, Description) VALUES (2, 'Química', 'Tubos de ensaio');
INSERT INTO Department (idDepartment, Title, Description) VALUES (3, 'Biologia', 'Pior disciplina');
INSERT INTO Department (idDepartment, Title, Description) VALUES (4, 'Eletrónica', 'Lei das malhas');
INSERT INTO User (idUser, Name, Email, Password, type) VALUES (0, 'John Doe', 'johndoe@example.com', 'mypassword', 'Client');
INSERT INTO User (idUser, Name, Email, Password, type) VALUES (1, 'Batman', 'batman@example.com', 'mypassword', 'Agent');
INSERT INTO User (idUser, Name, Email, Password, type) VALUES (2, 'Spider-man', 'spider-man@example.com', 'mypassword', 'Agent');
INSERT INTO User (idUser, Name, Email, Password, type) VALUES (3, 'John Wick', 'john-wick@example.com', 'mypassword', 'Admin');
INSERT INTO Ticket (idTicket, Title, Status, Priority, Description, idClient, idAgent, idDepartment, similarTicket) VALUES (0, 'Please work', 'Open', 'High', 'Seriously please work', 0, 1, 1, NULL);
INSERT INTO Ticket (idTicket, Title, Status, Priority, Description, idClient, idAgent, idDepartment, similarTicket) VALUES (1, 'My pc is not working', 'In progress', 'Low', 'It doesnt work anymore', 0, 1, 2, NULL);
INSERT INTO Ticket (idTicket, Title, Status, Priority, Description, idClient, idAgent, idDepartment, similarTicket) VALUES (2, 'My internet is not working', 'Closed', 'Average', 'It just stopped', 0, 1, 4, NULL);
INSERT INTO Task (idTask, Description, Status, idTicket, idAgent) VALUES (0, 'Fix the graphics card', 'Open', 1, 1);
INSERT INTO Task (idTask, Description, Status, idTicket, idAgent) VALUES (1, 'Fix the monitor', 'Open', 1, 2);
INSERT INTO Hashtag (idHashtag, Title, idDepartment) VALUES (0, 'bug', 0);
INSERT INTO Hashtag (idHashtag, Title, idDepartment) VALUES (1, 'feature', 0);
INSERT INTO assUserDepartment (user_id, department_id) VALUES (1, 0);
INSERT INTO assUserDepartment (user_id, department_id) VALUES (2, 1);
INSERT INTO assUserDepartment (user_id, department_id) VALUES (3, 2);
INSERT INTO assUserDepartment (user_id, department_id) VALUES (2, 3);
INSERT INTO assUserDepartment (user_id, department_id) VALUES (1, 4);
INSERT INTO assUserDepartment (user_id, department_id) VALUES (3, 0);
INSERT INTO assTicketHashtag (ticket_id, hashtag_id) VALUES (0, 0);
INSERT INTO assTicketHashtag (ticket_id, hashtag_id) VALUES (0, 1);
INSERT INTO Inquiry (idInquiry, idTicket, idCreator, Description) VALUES (0, 0, 1, 'Can you please provide more information');
INSERT INTO Inquiry (idInquiry, idTicket, idCreator, Description) VALUES (1, 0, 0, 'I think i already gave you more than enough information');
INSERT INTO Faq (idFaq, Question, Answer) VALUES (0, 'What is this?', 'This is a FAQ.');
