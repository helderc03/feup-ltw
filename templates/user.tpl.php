<?php function drawUserName(string $name) { ?>
    <div class="userName"><?php echo $name ?></div>
<?php }?>


<?php function drawUserInfo(object $user, ?array $departments, ?int $numberTicketClosedAgent, ?int $numberTicketsOpenedClient) { ?>

        <form class = "userEditForms" method ="POST">
            <div class ="email">
            <label >Email: </label>
                <?php echo $user->getEmail() ?>   
            </div>  
            <br>
            <div class = "user_type">
                <label for="user_type">User type:</label>
                <select name="user_type" id="user_type">
                    <?php $user_type = $user->getType(); ?>
                    <option value="Client" <?= $user_type === 'Client' ? 'selected' : '' ?>>Client</option>
                    <option value="Agent" <?= $user_type === 'Agent' ? 'selected' : '' ?>>Agent</option>
                    <option value="Admin" <?= $user_type === 'Admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <br>


            <?php if ($user->getType() !== 'Client'): ?>
                <p>Departments:</p>
                <div class="deps-container">
                    <select name="tags[]" id="tags" class="tags" multiple data-name="tags">
                        <?php foreach ($departments as $department): ?>
                            <?php $selected = ''; ?>
                            <?php foreach ($user->getDepartments() as $userDepartment): ?>
                                <?php if ($userDepartment->getId() === $department->getId()): ?>
                                    <?php $selected = 'selected'; ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <option value="<?php echo $department->getId() ?>" <?php echo $selected ?>><?php echo $department->getTitle() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="selected-tags-container"></div>

            <?php endif; ?>

            <br>
            <?php if($user->getType() == "Client") {?>
                <label> Number of tickets opened: </label>
                <?php echo $numberTicketsOpenedClient ?>
            <?php } ?>

            <?php if($user->getType() == "Agent") {?>
                <label > Number of tickets closed: </label>
                <?php echo $numberTicketClosedAgent ?>
            <?php } ?>
            <br>
            <button id="editTask-button" onclick="editUser()">Edit user</button>

        </div>
        


    </form>

<?php }?>
