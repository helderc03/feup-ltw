<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/displayTicket.class.php');


        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/ticket.tpl.php');

        $db = getDatabaseConnection();
        $tickets = displayTicket::getDisplayUnassignedTickets($db);

        drawHeader();
        drawTickets($tickets);
        drawFooter();

    }else {
        header('Location: ../pages/index.php');
    }
    
?>