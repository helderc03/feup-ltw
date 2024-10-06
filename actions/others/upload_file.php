<?php
    require_once(__DIR__ . '/../../database/connection.db.php');
    $db = getDatabaseConnection();
    
    $ticket_id = $_POST['idTicket'];
    $directory_path = "../../documents/" . $ticket_id . "/";


    if (!file_exists($directory_path)) {
        mkdir($directory_path, 0777, true);
    }

    $filename = $_FILES['file']['name'];
    $location = $directory_path . $filename;

    if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
        echo "Success";
        
        $query = "INSERT INTO Document (documentPath, idTicket) VALUES (:documentPath, :idTicket)";
        $statement = $db->prepare($query);
        $statement->bindValue(':documentPath', $location);
        $statement->bindValue(':idTicket', $ticket_id);
        $result = $statement->execute();
        
        if ($result) {
            echo "Document inserted successfully into the database.";
        } else {
            echo "Error inserting document into the database.";
        }
        
    } else {
        echo "Failure";
    }
?>
