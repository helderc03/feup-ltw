<?php
    require_once(__DIR__ . '/../../utils/session.php');
    require_once(__DIR__ . '/../../database/connection.db.php');

    $session = new Session();
    $db = getDatabaseConnection();
    
    if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {
        $ticketTitle = $_POST["title"];
        $ticketDescription = $_POST["description"];
        $creatorID = $_POST["creatorId"];
        $ticketDepartment = $_POST["ticketDepartment"];
        
        $query = "INSERT INTO Ticket (Title, Description, idClient, idAgent, idDepartment) VALUES (:ticketTitle, :ticketDescription, :creatorId, -1, :idDepartment)";
        $statement = $db->prepare($query);
        $statement->bindValue(':ticketTitle', $ticketTitle);
        $statement->bindValue(':ticketDescription', $ticketDescription);
        $statement->bindValue(':creatorId', $creatorID);
        $statement->bindValue(':idDepartment', $ticketDepartment);
        $result = $statement->execute();
    }

?>