<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/displayTicket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/task.class.php');

        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/task.tpl.php');

        $db = getDatabaseConnection();
        $idTicket = intval($_GET['idTicket']);
        $tasks = Task::getTicketTasks($db, $idTicket);
        $agents = User::getAgents($db);

        drawHeader();
        drawTasks($tasks);
        drawAddTaskButton($agents);

        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";
        
    }else {
        header('Location: ../pages/index.php');
    }
?>