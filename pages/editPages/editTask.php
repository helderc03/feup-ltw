<?php
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();
    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../database/objectClasses/ticket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/displayTicket.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/task.class.php');


        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/ticket.tpl.php');
        require_once(__DIR__ . '/../../templates/task.tpl.php');

        $db = getDatabaseConnection();
        $idTask = intval($_GET['idTask']);
        $task = Task::getTask($db, $idTask);
        $agents = User::getAgents($db);

        drawHeader();
        drawTask($task);
        drawEditTaskForms($task, $agents);
        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";
    }else {
        header('Location: ../pages/index.php');

    }


?>