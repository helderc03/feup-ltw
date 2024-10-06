<?php
require_once(__DIR__ . '/../../database/connection.db.php');
$db = getDatabaseConnection();
require_once(__DIR__ . '/../../utils/session.php');
$session = new Session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {
        
        $inquiryDescription = $_POST['inquiryDescription'];
        $ticket_id = $_POST['idTicket'];
        $idCreator = $_POST['idCreator'];

        $query = "INSERT INTO Inquiry ( idTicket, idCreator, Description) VALUES (:idTicket, :idCreator, :Description)";
        $statement = $db->prepare($query);
        $statement->bindValue(':Description', $inquiryDescription);
        $statement->bindValue(':idTicket', $ticket_id);
        $statement->bindValue(':idCreator', $idCreator);
        $result = $statement->execute();

        if ($result) {
            $response = array('success' => true);
            echo json_encode($response);
        } else {
            $response = array('success' => false);
            echo json_encode($response);
        }
}}
?>