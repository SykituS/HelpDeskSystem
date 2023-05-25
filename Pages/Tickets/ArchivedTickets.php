<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
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
                    <h3 class="h5 text-center">Your tickets</h3>
                </div>
                <div class="card-body">
                    <div>
                        <nav>
                            <div class="text-center">
                                <a href="TicketsList.php" class="btn btn-outline-info fw-bold">See Created/In Progress Tickets</a>
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

                            $ticketsData = $tickets->GetListOfTicketsForGivenUser(true);

                            foreach ($ticketsData as $value) {
                                $statusStyle = "";
                                switch ($value[4]) {
                                    case "Created":
                                        $statusStyle = "badge text-bg-secondary";
                                        break;
                                    case "InProgress":
                                        $statusStyle = "badge text-bg-primary";
                                        break;
                                    case "Resolved":
                                        $statusStyle = "badge text-bg-success";
                                        break;
                                    case "Cancelled":
                                        $statusStyle = "badge text-bg-warning";
                                        break;
                                }
                                echo '
                                    <tr onclick="redirectToPage(\'Ticket.php?Id=' . $value[0] . '\')">
                                <td>' . $value[1] . '</td>
                                <td class="text-center">' . $value[2] . '</td>
                                <td>' . $value[3] . '</td>
                                <td><span class="' . $statusStyle . '">' . $value[4] . '</td>
                                <td>' . $value[5] . '</td>
                                <td>' . $value[6] . '</td>
                                <td><span class="badge text-bg-warning">New message</td>
                                <td class="text-end pe-3">
                                    <div class="icon-container">
                                        <span><i class="icon-icon" data-feather="align-right"></i></span>
                                        <span class="badge bg-secondary icon-text">Details</span>
                                    </div>
                                </td>
                            </tr>
                                    ';
                            }

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