<?php
ob_start();
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();
    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
    require_once(__DIR__ . '/../../database/objectClasses/user.class.php');
    require_once(__DIR__ . '/../../database/objectClasses/hashtag.class.php');
    require_once(__DIR__ . '/../../database/objectClasses/department.class.php');


    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {

        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $assigned_to = $_POST['assigned_to'];
        $ticket_id = $_POST['idTicket'];
        $ticketNewDep = $_POST["ticketNewDepartment"];
        $user_id = $_POST['id'];
        $type = $_POST['type'];
        $selected_hashtags = $_POST['tags'] ?? [];
        $newTicketSim = $_POST['ticketNewSimilar'];
        $ticketObject = Ticket::getTicket($db, $ticket_id);

        if ($priority !== $ticketObject->getPriority()) {
            $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
            $statement = $db->prepare($query);
            $statement->bindValue(':idTicket', $ticket_id);
            $statement->bindValue(':ChangeField', "Priority");
            $statement->bindValue(':OldValue', $ticketObject->getPriority());
            $statement->bindValue(':NewValue', $priority);
            $result = $statement->execute();
        }
        if($status !== $ticketObject->getStatus()) {
            $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
            $statement = $db->prepare($query);
            $statement->bindValue(':idTicket', $ticket_id);
            $statement->bindValue(':ChangeField', "Status");
            $statement->bindValue(':OldValue', $ticketObject->getStatus());
            $statement->bindValue(':NewValue', $status);
            $result = $statement->execute();
        }
        if($assigned_to != $ticketObject->getIdAgent()){
            $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
            $statement = $db->prepare($query);
            $statement->bindValue(':idTicket', $ticket_id);
            $statement->bindValue(':ChangeField', "This ticket assignee");
            $statement->bindValue(':OldValue', User::getUser($db, $ticketObject->getIdAgent())->getName());
            $statement->bindValue(':NewValue', User::getUser($db, $assigned_to)->getName());
            $result = $statement->execute();
        }
        if($ticketNewDep != $ticketObject->getIdDepartment()){
            $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
            $statement = $db->prepare($query);
            $statement->bindValue(':idTicket', $ticket_id);
            $statement->bindValue(':ChangeField', "Department");
            $statement->bindValue(':OldValue', Department::getDepartment($db, $ticketObject->getIdDepartment())->getTitle());
            $statement->bindValue(':NewValue', Department::getDepartment($db, $ticketNewDep)->getTitle());
            $result = $statement->execute();
        }
        if($newTicketSim != $ticketObject->getSimilarTicket()){
            if ($newTicketSim == "None" && $ticketObject->getSimilarTicket() == null) {
                
            }
            else{
            $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
            $statement = $db->prepare($query);
            $statement->bindValue(':idTicket', $ticket_id);
            $statement->bindValue(':ChangeField', "Similar ticket");
            $similarTicket = $ticketObject->getSimilarTicket();
            $oldValue = ($similarTicket !== null) ? $similarTicket : 'None';
            $statement->bindValue(':OldValue', $oldValue);
            $statement->bindValue(':NewValue', $newTicketSim);
            $result = $statement->execute();
            }
        }
        
        $query = "SELECT hashtag_id FROM assTicketHashtag WHERE ticket_id = :idTicket";
        $statement = $db->prepare($query);
        $statement->bindValue(':idTicket', $ticket_id);
        $statement->execute();
        $existing_hashtags = $statement->fetchAll(PDO::FETCH_COLUMN);

        $hashtags_to_remove = array_diff($existing_hashtags, $selected_hashtags);

        if (!empty($hashtags_to_remove)) {
            $query = "DELETE FROM assTicketHashtag WHERE ticket_id = :idTicket AND hashtag_id IN (".implode(',', $hashtags_to_remove).")";
            $statement = $db->prepare($query);
            $statement->bindValue(':idTicket', $ticket_id);
            $statement->execute();

            foreach ($hashtags_to_remove as $removed_hashtag) {
                $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
                $statement = $db->prepare($query);
                $statement->bindValue(':idTicket', $ticket_id);
                $statement->bindValue(':ChangeField', "Removed hashtag: ");
                $statement->bindValue(':OldValue', (Hashtag::getHashtag($db, $removed_hashtag))->getTitle());
                $statement->bindValue(':NewValue', ""); 
                $statement->execute();
            }
        }

        foreach ($selected_hashtags as $hashtag) {
            $queryCheckExists = "SELECT COUNT(*) FROM assTicketHashtag WHERE ticket_id = :idTicket AND hashtag_id = :idHashtag";
            $statementCheckExists = $db->prepare($queryCheckExists);
            $statementCheckExists->bindValue(':idTicket', $ticket_id);
            $statementCheckExists->bindValue(':idHashtag', $hashtag);
            $statementCheckExists->execute();
            $countExists = $statementCheckExists->fetchColumn();
        
            if ($countExists == 0) {
                $query = "INSERT INTO assTicketHashtag (ticket_id, hashtag_id) VALUES (:idTicket, :idHashtag)";
                $statement = $db->prepare($query);
                $statement->bindValue(':idTicket', $ticket_id);
                $statement->bindValue(':idHashtag', $hashtag);
                $result = $statement->execute();
        
                if ($result) {
                    $query = "INSERT INTO TicketChange (idTicket, ChangedField, OldValue, NewValue) VALUES (:idTicket, :ChangeField, :OldValue, :NewValue)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':idTicket', $ticket_id);
                    $statement->bindValue(':ChangeField', "Added hashtag: ");
                    $statement->bindValue(':OldValue', ""); 
                    $statement->bindValue(':NewValue', (Hashtag::getHashtag($db, $hashtag))->getTitle());
                    $statement->execute();
                }
            }
        }
        
    
        $stmt = $db->prepare("UPDATE Ticket SET Priority = :priority, Status = :status, idAgent = :assigned_to, idDepartment = :idDepartment, similarTicket = :newTicketSim WHERE idTicket = :id");
        $stmt->bindValue(':priority', $priority);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':assigned_to', $assigned_to);
        $stmt->bindValue(':id', $ticket_id);
        $stmt->bindValue(':idDepartment', $ticketNewDep);
        if ($newTicketSim === "None") {
            $stmt->bindValue(':newTicketSim', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':newTicketSim', $newTicketSim);
        }
        $stmt->execute();
        

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] !== PDO::ERR_NONE) {
            echo $errorInfo[2];
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }
}
    ob_end_flush();

?>
