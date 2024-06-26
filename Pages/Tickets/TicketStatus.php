<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: '.BaseUrl.'/Pages/Account/Login.php');
}

if (!isset($_GET["Id"])) {
    header('Location: '.BaseUrl.'/Pages/Shared/Error.php');
}

$ticketId = $_GET["Id"];
$ticketDetails = $tickets->GetTicketDetailsByUniqueId($ticketId);

$errorMessage = $tickets->UpdateTicketStatus();

include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');
?>


<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Change status: </h1>
    </div>
    <div class="card-body">
        <form id="updateTicketStatusFrom" class="form-horizontal" role="form" method="POST" action="">
            <input type="hidden" name="UId" value="<?php echo $ticketId; ?>" />
            <div class="text-center">
                <div class="">
                    <select class="form-select" id="Status" name="Status" required>
                        <option value="Created" <?php echo $ticketDetails['Status'] == 'Created' ? 'selected' : '' ?>>Created</option>
                        <option value="InProgress" <?php echo $ticketDetails['Status'] == 'InProgress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Resolved" <?php echo $ticketDetails['Status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                        <option value="Cancelled" <?php echo $ticketDetails['Status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
            </div>

    </div>
    <div class="card-footer pt-4">
        <div class="d-grid col-4 mx-auto pb-3 gap-2">
            <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
            <input type="submit" name="UpdateTicketStatus" value="Edit status" class="btn btn-outline-primary">
        </div>
        <?php if ($errorMessage != '') { ?>
            <div class="mt-2">
                <div class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>
            </div>
        <?php } ?>
    </div>
    </form>
</div>

<?php include(__DIR__ . '/../../Includes/Footer.php'); ?>