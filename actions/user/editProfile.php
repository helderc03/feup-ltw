<?php
    ob_start();
    require_once(__DIR__ . '/../../utils/session.php');
    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/user.class.php');
    
    $session = new Session();
    $db = getDatabaseConnection();
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {

        $id = $_POST['id'];
        $user = User::getUser($db, $id);
        $username = ($_POST['username'] === "") ? $user->getName() : $_POST['username'];
        $email = ($_POST['email'] === "") ? $user->getEmail() : $_POST['email'] ;
        $password = ($_POST['password'] === "") ?  $user->getPassword() : $_POST['password']  ;
        

        $statement = $db->prepare("UPDATE User SET Name = :name,  Email = :email, Password = :password WHERE idUser = :idUser");
        $statement->bindValue(':idUser', $id);
        $statement->bindValue(':name', $username);
        $statement->bindValue(':email',$email);
        $statement->bindValue(':password',$password);
        $result = $statement->execute();


        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }
}
    ob_end_flush();


?>