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
        $type_user = $_GET['type'];


        $tickets = displayTicket::getOpenTickets($db);
        drawHeader();
        drawTickets($tickets);
        if($type_user == 'Agent'){
            drawEditTicketButton();
        }
        drawFooter();

    }else {
        header('Location: ../pages/index.php');
    }

?> 