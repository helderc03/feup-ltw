<?php
    declare(strict_types=1);
    require_once('../utils/session.php');
    $session = new Session();
    
    require_once('../database/connection.db.php');

    require_once('../templates/common.tpl.php');
    require_once('../templates/login.tpl.php');

    $db = getDatabaseConnection();

    drawLogin();
?>