<hr>
<div id="ticket-menu-section" class="text-center">
    <a onclick="goBack()" class="btn btn-outline-secondary fw-bold">Go back</a>
    <?php if ($users->HaveHelpDeskPermissions()) : ?>
        <?php if ($ticketDetails["AssignetToUserId"] != '') : ?>
            <a href="TicketStatus.php?Id=<?php echo $ticketDetails['UniqueId']; ?>" class="btn btn-outline-primary fw-bold">Change ticket status</a>
            <?php if ($ticketDetails["Status"] == "InProgress") : ?>
                <a href="EditTicketData.php?Id=<?php echo $ticketDetails['UniqueId']; ?>" class="btn btn-outline-primary fw-bold">Update ticket data</a>
            <?php else : ?>
                <button class="btn btn-outline-secondary fw-bold" disabled>Ticket closed, you can't edit data</button>
            <?php endif ?>
        <?php else : ?>
            <button class="btn btn-outline-warning fw-bold" onclick="assignTicket('<?php echo $ticketDetails['UniqueId']; ?>')"><span>Assign Ticket</span></button>
        <?php endif ?>
    <?php endif ?>
</div>
<hr>