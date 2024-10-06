<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    
    if($session->isLoggedIn()){

        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/displayTicket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticketChange.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/inquiry.class.php');

        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/ticket.tpl.php');

        $db = getDatabaseConnection();
        $type_user = $_GET['type'];
        $ticket = displayTicket::getDisplayTicket($db, intval($_GET['idTicket']));
        $ticketChanges = TicketChange::getTicketChanges($db,  intval($_GET['idTicket']));
        $ticketInquiries = Inquiry::getTicketInquiries($db, intval($_GET['idTicket']));

        drawHeader();
        drawTicket($ticket);
        drawTicketDescription($ticket);
        drawTicketChanges($ticketChanges);
        drawInquiryBox($ticketInquiries);

        if($type_user == 'Agent' || $type_user == 'Admin'){
            drawEditTicketButton();
        }
        
        drawFooter();

        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";

    }else {
        header('Location: ../../pages/index.php');
    }
?>
