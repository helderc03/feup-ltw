<?php 
    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/objectClasses/user.class.php');
    require_once(__DIR__ . '/../../utils/session.php');

    $db = getDatabaseConnection();

    $currentDomain = $_SERVER['HTTP_HOST'];
    session_set_cookie_params(0, '/', $currentDomain, true, true);
    $session = new Session();


    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO User (Name, Email, Password, type) VALUES (:name, :email, :password, :type)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hashedPassword);
    $statement->bindValue(':type', 'Client');
    $result = $statement->execute();
    $customer = User::getUserWithPassword($db, $email, $password);
    $session->setId($customer->getId());
    $session->setName($customer->getName());
    $session->setType($customer->getType());

    if($result){
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
        header("Location: ../../pages/ticketsDisplay/home.php?id={$customer->getId()}&type={$customer->getType()}");
    }

?>