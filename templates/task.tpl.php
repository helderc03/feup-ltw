<?php
declare(strict_types = 1);
?>

<?php function drawTask(object $task) { ?>
    <table class="ticket" draggable="true">
        <tr>
        <td rowspan ="1" class="ticket-priority">
            <p>Task-id: <?= $task->getId()?></p>
            <p>Task status: <?= $task->getStatus() ?></p>
        </td>
        <td colspan="2" class="ticket-title"><?= $task->getDescription() ?></td>
            <td colspan="2" class="edit">
                <a onclick="location.href = '/../pages/editPages/editTask.php?id=<?php echo $_GET['id'];?>&type=<?php echo $_GET['type'];?>&idTicket=<?php echo $_GET['idTicket'];?>&idTask=<?= $task->getId()?>'">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="task-assigned">Task assigned to: <?= $task->getAgentName()?></td>
        </tr>
    </table>
<?php } ?>


<?php function drawTasks(?array $tasks) { ?>
    <div class="container">
        <?php foreach ($tasks as $task) { ?>
            <?php drawTask($task) ?>
        <?php } ?>
    </div>

<?php } ?>


<?php function drawAddTaskButton(?array $agents) { ?>
    <button class="addTaskButton" type="button" data-modal-target="#addTask"><i class="fa fa-plus"></i></button>
    <?php drawCreateTask($agents) ?>
<?php } ?>


<?php function drawCreateTask(?array $agents) { ?>
    <div class="modal" id="addTask">
        <form class="addTaskForms" method="POST">
            <div class="modal-header">
                <div class="title">Create your task</div>
                <button data-close-button class="close-button" type="button">&times;</button>
            </div>

            <p id="description-title">Please provide a description:</p>
            <div class="textarea-container">
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
            </div>

            <br>
            <p id="taskAssignedTitle">This task should be assigned to: </p>
            <select name="taskAssigned" id="taskAssigned">
                <?php foreach ($agents as $agent): ?>
                    <option value="<?php echo $agent->getId() ?>"?><?php echo $agent->getName() ?></option>
                <?php endforeach; ?>
            </select>
            <div class="createTicketButton-container">
                <button id="createTicket-button" onclick="addTask()">Create Task</button>
            </div>
        </form>
    </div>
    <div id="overlay"></div>
<?php } ?>


<?php function drawEditTaskForms(object $task, ?array $agents) { ?>
    <form class="editTaskForms" method="post">
        <label for="status">Status:  </label>
                <select name="status" id="status">
                    <?php $status = $task->getStatus(); ?>
                    <option value="Open" <?= $status === 'Open' ? 'selected' : '' ?>>Open</option>
                    <option value="Closed" <?= $status === 'Closed' ? 'selected' : '' ?>>Closed</option>
                </select>
            <br>

        <label for="assigned_to">Assigned to:</label>
        <select name="assigned_to" id="assigned_to">
            <?php foreach ($agents as $agent): ?>
                <option value="<?php echo $agent->getId() ?>" <?php echo $agent->getName() === $task->getAgentName() ? 'selected' : '' ?>><?php echo $agent->getName() ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <div class = "createTicketButton-container">
            <button id="createTicket-button" onclick="editTask()">Create Task</button>
        </div>
    </form>
<?php } ?>
