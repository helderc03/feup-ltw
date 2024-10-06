<?php

    declare(strict_types=1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();
    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../templates/entities.tpl.php');
        require_once(__DIR__ . '/../../database/objectClasses/department.class.php');
        require_once(__DIR__ . '/../../database/objectClasses/hashtag.class.php');


        $db = getDatabaseConnection();
        $departments = Department::getDepartments($db);
        $hashtags = Hashtag::getAllHashtags($db);

        drawHeader();
        drawDepartmentsList($departments);
        drawHashtagsList($hashtags, $departments);
        drawAddEntityButton($departments);

        echo "<script>var csrfToken = '" . $_SESSION['csrf'] . "';</script>";
    }else {
        header('Location: ../../pages/index.php');
    }

?>