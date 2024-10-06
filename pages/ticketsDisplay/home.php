<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();


    if($session->isLoggedIn() && ($session->getType() !== 'Admin')){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/displayTicket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/department.class.php');
    

        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/ticket.tpl.php');
    
        $db = getDatabaseConnection();
        
        $type_user = $_GET['type'];
        $id_user = isset($_GET['id']) ? intval($_GET['id']) : -1;
        $tickets = displayTicket::getDisplayTickets($db, $id_user, $type_user);
        $departments =  Department::getDepartments($db);
    
        drawHeader();
        drawTickets($tickets);
        if($type_user == "Client"){
            drawAddTicketButton($departments); 
        }
        drawFooter();
        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";
    }else{
        header('Location: ../../pages/index.php');
    }


?>