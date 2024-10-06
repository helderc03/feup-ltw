<?php function drawDepartmentsList(?array $departments) {?>
        <div class = "listEntities">
            <div class="listTitle">Departments</div>
                <?php foreach ($departments as $department): ?>
                    <?php drawDepartment($department); ?>
                <?php endforeach; ?>

        </div>
<?php }?>

<?php function drawDepartment(object $department) {?>
    <div class = "entityDisplay">
        <?php echo $department->getTitle()?>
        <p></p>
        <?php echo $department->getDescription()?>
    </div>
<?php }?>


<?php function drawHashtagsList(?array $hashtags, ?array $departments) {?>
    <div class = "listEntities">
        <div class = "listTitle">Hashtags</div>
            <?php foreach($hashtags as $hashtag): ?>
                <?php drawHashtag($hashtag, $departments); ?>
            <?php endforeach; ?>    
    </div>
<?php }?>

<?php function drawHashtag(object $hashtag, ?array $departments) {?>
    <div class = "entityDisplay">
        <?php echo $hashtag->getTitle() ?>
        <p></p>
        <?php foreach($departments as $department): ?>
            <?php if ($hashtag->getIdDepartment() === $department->getId()): ?>
                <?php echo "This hashtag belongs to the department of: " . $department->getTitle(); ?>
                <?php break; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php }?>


<?php function drawAddEntityButton(?array $departments) {?>
    <button class="addEntityButton" type="button" data-modal-target="#addEntity"><i class="fa fa-plus"></i></button>
    <?php addEntityForms($departments) ?>
<?php }?>

<?php function addEntityForms(?array $departments) { ?>
    <div class="modal" id="addEntity">
        <form  class="addEntityForms" method="POST">
            
            <div class="modal-header">
                <div class="title">Add your entity</div>
                <button data-close-button class="close-button">&times;</button>
            </div>

            <label for="typeEntity">What do you want to add: </label>
                <select name="typeEntity" id="typeEntity" onchange="showAddionalOptions()">
                    <option selected></option>
                    <option value="Department" >Department</option>
                    <option value="Hashtag">Hashtag</option>
                    <option value="Faq">Faq</option>
                </select>


            <div id="departmentOptions" style="display: none;">
                <div class="new-ticket-title">
                    <label for="depTitle">Title</label>
                    <input type="text" id="ftitle" name="depTitle">
                </div>

                <div class="textarea-container">
                    <p id="descriptionTitle">Please provide a description:</p>
                    <br>
                    <textarea id="descriptionEntity" name="description" rows="4" cols="50"></textarea>
                </div>
            </div>

            <div id="hashtagOptions" style="display: none;">
                <div class="new-ticket-title">
                    <label for="hashTitle">Title</label>
                    <input type="text" id="ftitle" name="hashTitle">
                </div>
                <div class="deps-container">
                    <p>Departments:</p>
                    <select name="depTag" id="depTag" class="depTag"  data-name="depTag">
                        <?php foreach ($departments as $department): ?>
                            <option value="<?php echo $department->getId() ?>"><?php echo $department->getTitle() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="faqOptions" style="display: none;">
                <div class="textarea-container">
                    <p id="question">What is the question:</p>
                    <br>
                    <textarea id="question" name="question" rows="4" cols="50"></textarea>
                </div>
                <div class="textarea-container">
                    <p id="answer">What is the answer:</p>
                    <br>
                    <textarea id="answer" name="answer" rows="4" cols="50"></textarea>
                </div>
            </div>

            <div class="createTicketButton-container">
                <button id="createTicket-button" onclick="addEntity()">Add</button>
            </div>

        </form>

    </div>
    <div id="overlay"></div>
<?php }?>