<?php function drawProfileInfo(object $user, ?array $userDepartments, ?int $numberTicketsOpenedClient, ?int $numberTicketClosedAgent) { ?>


    <div class="profilePageInfo">

        <div class = "userParam">
            <label class="userLabel">Email:</label>
                <?php echo $user->getEmail() ?>
        </div>

        <div class ="userParam">
            <label class="userLabel">Type:</label>
            <?php echo $user->getType() ?>
        </div>

        <div class="userParam">
            <label class="userLabel">Departments:</label>
            <?php if (empty($userDepartments)) { ?>
                <?php echo "No departments available :(" ?>
            <?php } else { ?>
                <?php foreach ($userDepartments as $index => $department): ?>
                <?php echo $department->getTitle(); ?>
                <?php if ($index !== count($userDepartments) - 1): ?>
                    ;
                <?php endif; ?>
            <?php endforeach; ?>
            <?php } ?>
        </div>

        <?php if($user->getType() == "Client") {?>
            <label class = "userLabel"> Number of tickets opened: </label>
            <?php echo $numberTicketsOpenedClient ?>
        <?php } ?>

        <?php if($user->getType() == "Agent") {?>
            <label class = "userLabel"> Number of tickets closed: </label>
            <?php echo $numberTicketClosedAgent ?>
        <?php } ?>

        <form action="../../actions/session/action_logout.php" method="post">
            <button type="submit" class="logoutButton">Logout</button>
        </form>

    </div>

<?php } ?>


<?php function drawEditTicketButton(object $user) { ?>
        <button class="editTicketButton" type="button" data-modal-target="#editProfile">
            <i class="fa fa-pencil"></i>
        </button>
        <?php drawEditProfile($user) ?>

<?php } ?>


<?php function drawEditProfile(object $user) { ?>
    <div class="modal" id="editProfile">
        <form class="editProfileForms" method="POST">
            <div class="userParamEdit">
                <label class="userLabel">Username:</label>
                <input type="text" name="username" placeholder="<?php echo $user->getName() ?>">
            </div>

            <div class="userParamEdit">
                <label class="userLabel">Email:</label>
                <input type="email" name="email" placeholder="<?php echo $user->getEmail() ?>">
            </div>

            <div class="userParamEdit">
                <label class="userLabel">Password:</label>
                <div class="password-field">
                    <input type="password" id="password-input" name="password" placeholder="<?php echo $user->getPassword() ?>">
                </div>
            </div>

            <div class="EditProfileContainer">
                <button class="EditProfile" type="submit" onclick="editProfile()">Edit Profile</button>
            </div>
        </form>

    </div>
    <div id="overlay"></div>
<?php } ?>
