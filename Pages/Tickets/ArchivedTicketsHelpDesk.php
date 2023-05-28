<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

if (!$users->HaveHelpDeskPermissions()) {
    header('Location: /Pages/Account/Login.php');
}

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="h5 text-center">Assigned to you</h3>
                </div>
                <div class="card-body">
                    <div>
                        <nav>
                            <div class="text-center">
                                <a href="TicketsListHelpDesk.php" class="btn btn-outline-info fw-bold">See Created/In Progress Tickets</a>
                            </div>
                        </nav>
                    </div>
                    <table class="table table-hover" id="accordion">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th class="text-center">Department</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Created on</th>
                                <th>Expected Completion Date</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $ticketsData = $tickets->GetOnlyTicketsAssignedToUserId(true);

                            include("TicketListBody.php");

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function redirectToPage(url) {
        window.location.href = url;
    }
</script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Footer.php'); ?>