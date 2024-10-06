<?php function drawUserInformationBar() { ?>

    <table class = "userInfoBar">
        <tr>
            <td class="userInfoParamTitle">Name</td>
            <td class="userInfoParamTitle">Email</td>
            <td class="userInfoParamTitle">Type</td>
            <td class="userInfoParamTitle">Department</td>
        </tr>
    </table>

<?php } ?>

<?php
function drawUsers(?array $users, int $userId)
{
    foreach ($users as $user) {
        if ($user->getId() !== $userId) {
            drawUser($user);
        }
    }
}
?>


<?php function drawUser(object $user) { ?>
    <table class="userInfo">
            <tr>
                <td class="userInfoParam" ><?php echo $user->getName() ?></td>
                <td class="userInfoParam" ><?php echo $user->getEmail() ?></td>
                <td class="userInfoParam" ><?php echo $user->getType() ?></td>
                <td class="userInfoParam">
                    <?php foreach ($user->getDepartments() as $index => $department): ?>
                        <?php echo $department->getTitle(); ?>
                        <?php if ($index !== count($user->getDepartments()) - 1): ?>
                            ;
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
                <td class="edit">
                    <a onclick="location.href = '/../pages/editPages/editUser.php?id=<?php echo $_GET['id'];?>&type=<?php echo $_GET['type'];?>&idUser=<?= $user->getId()?>'">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>

            </tr>
        </table>
<?php }?>



