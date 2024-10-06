<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();
    
    if($session->isLoggedIn()){
        require_once(__DIR__ . '/../../database/connection.db.php');
        require_once(__DIR__ . '/../../templates/common.tpl.php');
        require_once(__DIR__ . '/../../database/objectClasses/faq.class.php');



        $db = getDatabaseConnection();
        $faqs = Faq::getFAQs($db);
        drawHeader();
        drawFAQ($faqs);
        drawFooter();

    }else {
        header('Location: ../../pages/index.php');
    }
?>