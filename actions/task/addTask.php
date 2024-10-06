<?php
require_once(__DIR__ . '/../../utils/session.php');
require_once(__DIR__ . '/../../database/connection.db.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {

    $ticket_id = $_POST['idTicket'];
    $ticketDescription = $_POST["description"];
    $agentID = $_POST['taskAssigned'];

    $query = "INSERT INTO Task (Description, idTicket, idAgent) VALUES (:description, :idTicket, :idAgent)";
    $statement = $db->prepare($query);
    $statement->bindValue(':description', $ticketDescription);
    $statement->bindValue(':idTicket', $ticket_id);
    $statement->bindValue(':idAgent', $agentID);
    $result = $statement->execute();

    if ($result) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
}

}
?>
