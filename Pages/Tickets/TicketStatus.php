<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

$errorMessage = $tickets->CreateNewTicket();

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');
?>


<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Change status: </h1>
    </div>
    <div class="card-body">
        <form id="createNewTicketForm" class="form-horizontal" role="form" method="POST" action="">
            <div class="text-center">
                <div class="">
                    <select class="form-select" id="Status" name="Status" required>
                        <option value="Created">Created</option>
                        <option value="InProgress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

    </div>
    <div class="card-footer pt-4">
        <div class="d-grid col-4 mx-auto pb-3 gap-2">
            <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
            <input type="submit" name="CreateNewTicket" value="Create ticket" class="btn btn-outline-primary">
        </div>
        <?php if ($errorMessage != '') { ?>
            <div class="mt-2">
                <div class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>
            </div>
        <?php } ?>
    </div>
    </form>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Footer.php'); ?>