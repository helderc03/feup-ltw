<?php
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();
    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/displayTicket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/department.class.php');


        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/ticket.tpl.php');

        $db = getDatabaseConnection();
        $idTicket = intval($_GET['idTicket']);

        drawHeader();
        $ticket = displayTicket::getDisplayTicket($db, $idTicket);
        $hashtags = Hashtag::getAllHashtags($db);
        $departments = Department::getDepartments($db);
        $agents = User::getAgents($db);
        $tickets = Ticket::getAllTickets($db);
        drawTicket($ticket);
        drawEditTicketForms($agents, $ticket, $hashtags, $departments, $tickets);
    }else {
        header('Location: ../pages/index.php');
    }


?>