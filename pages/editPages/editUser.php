<?php
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();
    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/user.tpl.php');
        require_once(__DIR__ . '/../../database/objectClasses/department.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/user.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');


        $db = getDatabaseConnection();
        drawHeader();
        $idUser = intval($_GET['idUser']);
        $user = User::getUser($db, $idUser);
        $numberTicketsOpenedClient = Ticket::getNumberTicketsOpenedByClient($db, $idUser);
        $numberTicketsClosedAgent = Ticket::getNumberTicketsClosedByAgent($db, $idUser);
        $departments = Department::getUserDepartments($db, $idUser);  
        $allDepartments = Department::getDepartments($db);
        
        drawUserName($user->getName());
        drawUserInfo($user, $allDepartments, $numberTicketsClosedAgent, $numberTicketsOpenedClient);

        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";
    }else {
        header('Location: ../pages/index.php');
    }
?>