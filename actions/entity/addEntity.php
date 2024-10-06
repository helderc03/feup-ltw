<?php
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../utils/session.php');

$db = getDatabaseConnection();
$session = new Session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {

    $typeEntity = $_POST['typeEntity']; 

    if($typeEntity === "Department"){
        $title = $_POST['depTitle']; 
        $description = $_POST['description'];

        $query = "INSERT INTO Department (Title, Description) VALUES (:title, :description)";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $result = $statement->execute();

    } else if ($typeEntity === "Hashtag"){
        $title = $_POST['hashTitle']; 
        $tag = $_POST['depTag']; 

        $query = "INSERT INTO Hashtag (Title, idDepartment) VALUES (:title, :idDepartment)";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':idDepartment', $tag);
        $result = $statement->execute();
    } else if ($typeEntity === "Faq"){
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        $query = "INSERT INTO Faq (Question, Answer) VALUES (:question, :answer)";
        $statement = $db->prepare($query);
        $statement->bindValue('question', $question);
        $statement->bindValue('answer', $answer);
        $result = $statement->execute();
    }


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