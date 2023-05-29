<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: '.BaseUrl.'/Pages/Account/Login.php');
}

$fullName = $_SESSION["UserFirstName"] . " " . $_SESSION["UserLastName"];
$loggedUserData = $users->GetLoggedUserInfo();

include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');
?>
<div class="container mt-2 px-4 py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="pb-2 border-bottom">Welcome, <?php echo $fullName; ?></h2>
            <div class="card card-body">
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-2">
                    <div class="col d-flex align-items-start">
                        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <span><i data-feather="file-plus"></i></span>
                        </div>
                        <div>
                            <h3 class="fs-2">Create new ticket</h3>
                            <p></p>
                            <a href="<?php echo BaseUrl; ?>/Pages/Tickets/CreateNewTicket.php" class="btn btn-primary">
                                Create new ticket
                            </a>

                        </div>
                    </div>
                    <div class="col d-flex align-items-start">
                        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <span><i data-feather="list"></i></span>
                        </div>
                        <div>
                            <h3 class="fs-2">See list of tickets</h3>
                            <p>Number of opened tickets: <span class="badge text-bg-success"><?php echo $loggedUserData["OpenedTickets"]; ?></span></p>
                            <p>Number of closed tickets: <span class="badge text-bg-danger"><?php echo $loggedUserData["ClosedTickets"]; ?></span></p>
                            <a href="<?php echo BaseUrl; ?>/Pages/Tickets/TicketsList.php" class="btn btn-primary">
                                List of tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/../../Includes/Footer.php'); ?>