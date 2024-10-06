<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();


    if($session->isLoggedIn() && ($session->getType() === 'Admin')){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/user.class.php');
        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/admin.tpl.php');
        
        $db = getDatabaseConnection();
        $users = User::getUsers($db);
        drawHeader();
        drawUserInformationBar();
        $userId = intval($_GET['id']);
        drawUsers($users, $userId);
    }else{
        header('Location: ../../pages/index.php');
    }


?>