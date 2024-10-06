<?php
    ob_start();
    require_once(__DIR__ . '/../../utils/session.php');
    require_once(__DIR__ . '/../../database/connection.db.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {

        $status = $_POST['status'];
        $assigned_to = $_POST['assigned_to'];
        $task_id = $_POST['idTask'];

        $statement = $db->prepare("UPDATE Task SET Status = :status,  idAgent = :assigned_to WHERE idTask = :idTask");
        $statement->bindValue(':idTask', $task_id);
        $statement->bindValue(':assigned_to', $assigned_to);
        $statement->bindValue(':status',$status);
        $result = $statement->execute();


        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
        }
    }
    ob_end_flush();

?>