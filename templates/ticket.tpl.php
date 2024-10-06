<?php
 declare(strict_types = 1);
 ?>



<?php function drawTicket(object $ticket) {
        $hashtagNames = [];
        foreach ($ticket->getHashtags() as $hashtag) {
            $hashtagNames[] = $hashtag->getId();
        }
    ?>
    <table class="ticket" draggable = "true" data-department="<?= $ticket->getDepartmentName() ?>" data-status="<?= $ticket->getStatus() ?>" data-assignee="<?= $ticket->getAgentName() ?>" data-hashtags="<?= implode(',', $hashtagNames) ?>">
        <tr onclick="location.href = '/../pages/ticket/ticket.php?id=<?php echo $_GET['id'];?>&type=<?php echo $_GET['type'];?>&idTicket=<?=$ticket->getId()?>'">
            <td rowspan ="2" class="ticket-priority">
                <p>Ticket-id: <?= $ticket->getId()?></p>
                <p>Ticket priority: <?= $ticket->getPriority() ?></p>
                <p>Status: <?= $ticket->getStatus() ?></p>
                <p>Similar to: <?= ($ticket->getSimilarTicket() !== null) ? '#' . $ticket->getSimilarTicket() : "None" ?></p>

            </td>
            <td colspan="2" class="ticket-title"><?= $ticket->getTitle() ?></td>
        </tr>
        <tr>
            <td onclick="location.href = '/../pages/ticket/ticket.php?id=<?php echo $_GET['id'];?>&type=<?php echo $_GET['type'];?>&idTicket=<?=$ticket->getId()?>'" class="ticket-hashtags" colspan="3">
                <?php drawHashtags($ticket->getHashtags()); ?>
            </td>
        </tr>
        <tr onclick="location.href = '/../pages/ticket/ticket.php?id=<?php echo $_GET['id'];?>&type=<?php echo $_GET['type'];?>&idTicket=<?=$ticket->getId()?>'">
            <td class="ticket-footer">Department: <?= $ticket->getDepartmentName()?></td>
            <td class="ticket-assigned">Assigned to: <?= $ticket->getAgentName() ?></td>
            <td class="ticket-creator">Created by: <?= $ticket->getClientName() ?></td>
        </tr>
    </table>

<?php } ?>

<?php function drawHashtags(array $hashtags) { ?>
    <?php foreach ($hashtags as $hashtag) { ?>
        <div class="hashtag"><?= $hashtag->getTitle() ?></div>
    <?php } ?>
<?php } ?>

<?php

function drawTickets(?array $tickets) {
    if ($tickets === null || count($tickets) === 0) {
        echo '<div class="no-tickets-container">
                  <img src="/../docs/nothing-found.png" alt="nothing-found-image" width="500" height="500">
                  <span class="no-tickets">No tickets found :(</span>
                  </div>';
        return;
    }
?>
    <div class="container">
        <?php foreach ($tickets as $ticket) { ?>
            <?php drawTicket($ticket); ?>
        <?php } ?>
    </div>
<?php
}
?>


<?php function drawTicketDescription(object $ticket) { ?>
    <div class="description">
        <p><?= $ticket->getDescription() ?></p>
    </div>
<?php } ?>

<?php function drawAddTicketButton(?array $departments) { ?>
    <button class="addTicketButton" type="button" data-modal-target="#test"><i class="fa fa-plus"></i></button>
    <?php drawCreateTicket($departments) ?>
<?php } ?>

<?php function drawCreateTicket(?array $departments) { ?>
    <div class="modal" id="test">
        <form  method="POST">
            
            <div class="modal-header">
                <div class="title">Create your ticket</div>
                <button data-close-button class="close-button">&times;</button>
            </div>

            <div class="new-ticket-title">
                <label for="ftitle">Title</label>
                <input type="text" id="ftitle" name="ftitle">
            </div>

            <div class = "ticketDepartment">
                <label for="ticketDepartment">Department:</label>
                <select name="ticketDepartment" id="ticketDepartment">
                    <?php foreach ($departments as $department): ?>
                        <option value="<?php echo $department->getId() ?>"><?php echo $department->getTitle() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <p id="description-title">Please provide a description:</p>
            <div class="textarea-container">
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
            </div>

            <div class="createTicketButton-container">
                <button id="createTicket-button" onclick="addTicket()">Create Ticket</button>
            </div>

        </form>

    </div>
    <div id="overlay"></div>
<?php } ?>

<?php function drawEditTicketButton() { ?>
    <a href='/../pages/editPages/editTicket.php?id=<?php echo $_GET['id'];?>&type=<?php echo $_GET['type'];?>&idTicket=<?php echo $_GET['idTicket'];?>'>
        <button class="editTicketButton" type="button">
            <i class="fa fa-pencil"></i>
        </button>
    </a>
<?php } ?>


<?php

function drawEditTicketForms(?array $agents, object $ticket, ?array $hashtags, ?array $departments, ?array $tickets)
{
    if (!is_array($agents) || !is_object($ticket) || !is_array($hashtags) || !is_array($departments) || !is_array($tickets)) {
        echo "Error: Invalid input data.";
        return;
    }

    ?>
    <form class="editTicketForms" method="post" data-csrf="<?php echo $_SESSION['csrf']; ?>">
        <label for="priority">Priority:</label>
        <select name="priority" id="priority">
            <?php $priority = $ticket->getPriority(); ?>
            <option value="Low" <?= $priority === 'Low' ? 'selected' : '' ?>>Low</option>
            <option value="Average" <?= $priority === 'Average' ? 'selected' : '' ?>>Average</option>
            <option value="High" <?= $priority === 'High' ? 'selected' : '' ?>>High</option>
        </select>
        <br>
        <label for="status">Status:</label>
        <select name="status" id="status">
            <?php $status = $ticket->getStatus(); ?>
            <option value="Open" <?= $status === 'Open' ? 'selected' : '' ?>>Open</option>
            <option value="Closed" <?= $status === 'Closed' ? 'selected' : '' ?>>Closed</option>
            <option value="In progress" <?= $status === 'In progress' ? 'selected' : '' ?>>In progress</option>
        </select>
        <br>
        <label for="assigned_to">Assigned to:</label>
        <select name="assigned_to" id="assigned_to">
            <?php foreach ($agents as $agent): ?>
                <option value="<?php echo $agent->getId() ?>" <?php echo $agent->getName() === $ticket->getAgentName() ? 'selected' : '' ?>><?php echo $agent->getName() ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="ticketNewDepartment">Assigned to department of:</label>
        <select name="ticketNewDepartment" id="ticketNewDepartment">
            <?php foreach ($departments as $department): ?>
                <?php $selected = $ticket->getDepartmentName() === $department->getTitle() ? 'selected' : ''; ?>
                <option value="<?php echo $department->getId() ?>" <?php echo $selected ?>><?php echo $department->getTitle() ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="ticketNewSimilar">Similar to:</label>
        <select name="ticketNewSimilar" id="ticketNewSimilar">
            <?php $currentSimilar = $ticket->getSimilarTicket(); ?>
            <option value="None" <?php echo ($currentSimilar === null) ? 'selected' : ''; ?>>None</option>
            <?php foreach ($tickets as $ticketOption): ?>
                <?php $selected = ($ticketOption->getId() === $currentSimilar) ? 'selected' : ''; ?>
                <option value="<?php echo $ticketOption->getId(); ?>" <?php echo $selected; ?>><?php echo $ticketOption->getId(); ?></option>
            <?php endforeach; ?>
        </select>
        <br>        
        
        <p>Hashtags:</p>
        <div class="hashtags-container">
            <?php 
            $searchInput = '<input type="text" placeholder="Search hashtags" id="searchInput" style="width: 200px; border-radius: 10px; padding: 10px; margin-top: 10px" />';
            echo $searchInput;
            ?>

            <br>
            <select name="tags[]" id="tags" class="tags multiple-select" multiple data-name="tags">
                <?php foreach ($hashtags as $hashtag): ?>
                    <?php $selected = in_array($hashtag->getId(), $ticket->getHashtags(), true) ? 'selected' : ''; ?>
                    <option value="<?php echo $hashtag->getId() ?>" <?php echo $selected ?>><?php echo $hashtag->getTitle() ?></option>
                <?php endforeach; ?>
            </select>
            <div class="selected-tags-container"></div>
        </div>
        <br>

        <input type="submit" value="Update" class="updateButton">
    </form>
    <?php
}

?>


<?php
function drawTicketChanges(?array $ticketChanges)
{
    if ($ticketChanges === null) {
        return;
    }
    ?>
    <div class="ticket-changes">
        <?php foreach ($ticketChanges as $ticketChange): ?>
            <li class = "changesList">
                <span class="specialElement"><?php echo $ticketChange->getChangedField(); ?></span>
                <?php if($ticketChange->getChangedField() != "Removed hashtag: " && $ticketChange->getChangedField() != "Added hashtag: "): ?>
                    changed from
                <?php endif; ?>

                    <span class="specialElement"><?php echo $ticketChange->getOldValue(); ?></span>
                <?php if($ticketChange->getChangedField() != "Removed hashtag: " && $ticketChange->getChangedField() != "Added hashtag: "): ?>
                    to
                <?php endif; ?>
                    <span class="specialElement"><?php echo $ticketChange->getNewValue(); ?></span>
                    at
                    <span class="specialElement"><?php echo substr($ticketChange->getChangeDate(), 0, 10); ?></span>
            </li>
        <?php endforeach; ?>
    </div>


    <?php
}
?>


<?php function drawTicketFilter(?array $departments, ?array $agents, ?array $hashtags) {?>
    <div class = "filter-sidebar"
    <div class="ticket-filter-container">
        <br>
        <label  for="filterDepartment">Department:  </label>
            <br>
            <select name="filterDepartment" id="filterDepartment">
                <option value=""></option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo $department->getTitle() ?>"><?php echo $department->getTitle() ?></option>
                <?php endforeach; ?>
            </select>
        <br>
        <label  for="filterStatus">Status:  </label>
        <br>

            <select name="filterStatus" id="filterStatus">
                <option value=""></option>
                <option value="<?php echo "Open" ?>">Open</option>
                <option value="<?php echo "In progress" ?>">In progress</option>
                <option value="<?php echo "Closed" ?>">Closed</option>
            </select>
            <br>

        <label for="filterAssignee">Who is it assigned to:  </label>
            <br>
            <select name="filterAssignee" id="filterAssignee">
                <option value=""></option>
                <?php foreach ($agents as $agent) :?>
                    <option value="<?php echo $agent->getName() ?>"><?php echo $agent->getName() ?></option>
                <?php endforeach; ?>    
            </select>    
            <br>

                
        <p>Hashtags:</p>
        <div class="hashtags-container">
            <?php 
            $searchInput = '<input type="text" placeholder="Search hashtags" id="searchInput" style="width: 200px; border-radius: 10px; padding: 10px; margin-top: 10px" />';
            echo $searchInput;
            ?>
            <select name="tags[]" id="tags" class="tags multiple-select" multiple data-name="tags">
                <option value=""></option>
                <?php foreach ($hashtags as $hashtag): ?>
                    <option value="<?php echo $hashtag->getId() ?>"><?php echo $hashtag->getTitle() ?></option>
                <?php endforeach; ?>
            </select>

            <div class="selected-tags-container"></div>
        </div>
        <br>

        <button type="button" class = "filterButton" onclick="applyFilter()">Filter</button><br>
        <button type="button" class = "filterButton" onclick="clearFilters()">Clear Filters</button><br>
        <button type="button" class="filterButton" onclick="closeSidebar()">Close Sidebar</button><br>
    
    </div>
    </div>
<?php } ?>

<?php function drawFilterSidebar() {?>
    <button type="button" onclick="toggleSidebar()" class="showFilterSideBarButton"><i class="fa fa-filter" aria-hidden="true"></i>
</button>
<?php } ?>


<?php function drawInquiryBox(?array $inquiries){?>
    <div class = "inquiryBox">
            <a class = "text"> Inquiry Area </a><br>
    </div>
    <div class = "container">
        <?php foreach ($inquiries as $inquiry): ?>
            <?php drawInquiry($inquiry); ?>
        <?php endforeach; ?>
    </div>

<?php }?>


<?php function drawInquiry(object $inquiry){?>
    <table class="comment-table">
    <tr>
        <td class="comment-description"><?php echo $inquiry->getDescription() ?></td>
    </tr>
    <tr>
        <td class="comment-creator"><?php echo $inquiry->getNameCreator() ?></td>
    </tr>
    </table>

<?php }?>


