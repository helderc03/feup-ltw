<?php
    declare(strict_types=1);

    $currentDomain = $_SERVER['HTTP_HOST'];
    session_set_cookie_params(0, '/', $currentDomain, true, true);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/objectClasses/user.class.php');
    require_once(__DIR__ . '/../../database/objectClasses/department.class.php');

    $db = getDatabaseConnection();

    $customer = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
    if ($customer) {
        $session->setId($customer->getId());
        $session->setName($customer->getName());
        $session->setType($customer->getType());
        $session->addMessage('success', 'Login successful!');

        if ($customer->getType() === 'Admin') {
            if (!isset($_SESSION['csrf'])) {
                $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        header("Location: ../../pages/adminPages/adminHomePage.php?id={$customer->getId()}&type={$customer->getType()}");

        } 
        else {
            if (!isset($_SESSION['csrf'])) {
                $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
            header("Location: ../../pages/ticketsDisplay/home.php?id={$customer->getId()}&type={$customer->getType()}");
        }
        
    } else {
        $session->addMessage('error', 'Wrong password!');
        header('Location: ../../pages/index.php');
    }
?>
