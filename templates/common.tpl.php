<?php declare(strict_types = 1); ?>

<?php
    function is_page($page_name){
        return strpos($_SERVER['REQUEST_URI'], $page_name) !== false;
    }
?>

<?php function drawHeader() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Trouble ticket website</title>
        <meta charset="utf-8">
        
        <link href="/../css/nav_bar.css" rel="stylesheet">
        <link href="/../css/ticket.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/ddfecc64fb.js" crossorigin="anonymous"></script>
        <link href="/../css/faq.css" rel="stylesheet">
        <link href="/../css/popUp.css" rel="stylesheet">
        <link href="/../css/tags.css" rel="stylesheet">
        <link href="/../css/user.css" rel="stylesheet">
        <link href="/../css/task.css" rel="stylesheet">
        <link href="/../css/entities.css" rel="stylesheet">
        <link href="/../css/adminPage.css" rel="stylesheet">
        <script src="/../javascript/entity.js" defer></script>
        <script src="/../javascript/userExperience/script.js" defer></script>
        <script src="/../javascript/userExperience/applyFilter.js" defer></script>
        <script src="/../javascript/userExperience/pop_up.js" defer></script>      
        <script src="/../javascript/tags.js" defer></script>
        <script src="/../javascript/ajax/edit/editTicket.js" defer></script>
        <script src="/../javascript/ajax/edit/editUser.js" defer></script>
        <script src="/../javascript/ajax/add/addTask.js" defer></script>
        <script src="/../javascript/ajax/add/addInquiry.js" defer></script>
        <script src="/../javascript/ajax/edit/editProfile.js" defer></script>
        <script src="/../javascript/ajax/edit/editTask.js" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <div class = "wrapper">
        <?php drawSidebar() ?>
    <main class="ticket-area">

<?php } ?>

<?php function drawSidebar() { ?>

    <aside class = "sidenav">
        <div class="menu-toggle">
            <button class="menu-btn" aria-label="Toggle menu">
                <span class="fas fa-bars"></span>
            </button>
        </div>

        <div class = "sidenav-menu">
            <?php
                $type = $_GET['type'] ?? '';
                if ($type === 'Admin') {
                    $url = '/../pages/adminPages/adminHomePage.php?id=' . $_GET['id'] . '&type=' . $type;
                } else {
                    $url = '/../pages/ticketsDisplay/home.php?id=' . $_GET['id'] . '&type=' . $type;
                }
            ?>
            <h1 onclick="location.href = '<?php echo $url; ?>'">Tickets Information</h1>
            <div class = "ticket-information">
                <ul>
                        <?php if($type === 'Admin') { ?>
                            <li onclick="location.href ='/../pages/adminPages/adminHomePage.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                            <?php if(is_page('adminHomePage.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>Users</li>
                            <li onclick="location.href = '/../pages/adminPages/entities.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                            <?php if(is_page('entities.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>Entities</li>
                        <?php }?>

                        <?php if($type !== 'Admin') { ?>
                        <li onclick="location.href = '/../pages/ticketsDisplay/home.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                            <?php if(is_page('home.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>My tickets</li>
                        <?php }?>       
                        <li onclick="location.href = '/../pages/ticketsDisplay/unassigned.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                            <?php if(is_page('unassigned.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>Unassigned Tickets</li>
                        <li onclick="location.href = '/../pages/ticketsDisplay/allTickets.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                            <?php if(is_page('allTickets.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>All tickets</li>
                        <li onclick="location.href = '/../pages/ticketsDisplay/openTickets.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                            <?php if(is_page('openTickets.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>Open Tickets</li>

                    <?php if (is_page('ticket.php')) { ?>
                        <li data-modal-target="#document_pop_up">Documents</li>
                        <?php drawPopup() ?>
                        <li class="active" data-modal-target="#inquiryPopup">Inquiries</li>
                        <?php addInquiryPopup() ?>

                        <?php
                        if ($type === 'Agent' || $type === 'Admin') {
                            echo "<li onclick=\"location.href='/../pages/task/tasks.php?id=" . $_GET['id'] . "&type=" . $_GET['type'] . "&idTicket=" . $_GET['idTicket'] ."'\">Tasks</li>";
                        }
                    }?>
                </ul>
            </div>
            <div class = "non-ticket-information">
                <ul>
                    <li onclick="location.href = '/../pages/others/faq.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                    <?php if(is_page('faq.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>FAQs</li>
                    <li onclick="location.href = '/../pages/others/profile.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>'"
                    <?php if(is_page('profile.php')) { ?> style="background-color: #1B9F90;" <?php } ?>>My account</li>
                </ul>
            </div>
        </div>
    </aside>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    <footer style='display: none;'>
        Trouble Ticket system website
    </footer>
    
</div>
</body>

</html>
<?php } ?>

<?php function drawFAQ(array $faqs) { ?>
    <p class="titulo-faq">Frequently Asked Questions</p>
    <?php foreach ($faqs as $faq) { ?>
        <div class = "Question">
            <?= $faq->getQuestion() ?>
        </div>
        <div class = "Answer">
            <?= $faq->getAnswer() ?>
        </div>
    <?php } ?>
<?php } ?>

<?php function drawPopup() { ?>
  <div class="modal" id="document_pop_up">
    <div class="modal-header">
      <div class="title">Save your file here</div>
      <button data-close-button class="close-button">&times;</button>
    </div>
    <div class="modal-body">
        <input id = "fileupload" type="file" name="fileupload"></input>
        <button id="uppload-button" onclick="saveFile()">Upload</button>
    </div>
  </div>
  <div id="overlay"></div>
<?php } ?>


<?php function addInquiryPopup() {?>
    <form class="addInquiryForms" method="POST">

        <div class="modal" id="inquiryPopup">
                <div class="modal-header">
                    <div class="title">Add your inquiry</div>
                    <button data-close-button class="close-button">&times;</button>
                </div>

                <p id="inquiryDescriptionTitle">Please provide a description:</p>
                    <div class="textarea-container">
                    <textarea id="inquiryDescription" name="inquiryDescription" rows="4" cols="50"></textarea>
                </div>

                <div class="createInquiry-container">
                    <button id="createInquiry-button" onclick="addInquiry()">Create Inquiry</button>
                </div>
        </div>
    </form>
    <div id="overlay"></div>

<?php }?>
