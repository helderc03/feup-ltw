<?php

    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if($session->isLoggedIn()){

        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/user.tpl.php');
        require_once(__DIR__ . '/../../templates/profile.tpl.php');
        require_once(__DIR__ . '/../../database/objectClasses/user.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/department.class.php');


        $db = getDatabaseConnection();
        $idUser = intval($_GET['id']);
        $user = User::getUser($db, $idUser);
        $numberTicketsOpenedClient = Ticket::getNumberTicketsOpenedByClient($db, $idUser);
        $numberTicketsClosedAgent = Ticket::getNumberTicketsClosedByAgent($db, $idUser);
        $departments = Department::getUserDepartments($db, $idUser);  
        drawHeader();
        drawUserName($user->getName());
        drawProfileInfo($user, $departments, $numberTicketsOpenedClient, $numberTicketsClosedAgent);
        drawEditTicketButton($user);

        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";

    }else {
        header('Location: ../pages/index.php');
    }

?>