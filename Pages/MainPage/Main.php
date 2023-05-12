<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

$fullName = $_SESSION["UserFirstName"] . " " . $_SESSION["UserLastName"];

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
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
                            <a href="/Pages/Tickets/CreateNewTicket.php" class="btn btn-primary">
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
                            <p>Number of opened tickets: <span class="badge text-bg-danger">0</span></p>
                            <p>Number of closed tickets: <span class="badge text-bg-success">0</span></p>
                            <a href="/Pages/Tickets/TicketsList.php" class="btn btn-primary">
                                List of tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-body mt-3">
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-2">
                    <div class="col d-flex align-items-start">
                        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <span><i data-feather="activity"></i></span>
                        </div>
                        <div>
                            <h3 class="fs-2">Your newest ticket:</h3>
                            <p>Title: Computer crashing on starting excel</p>
                            <a href="/Pages/Tickets/CreateNewTicket.php" class="btn btn-primary">
                                Check it out!
                            </a>

                        </div>
                    </div>
                    <div class="col d-flex align-items-start">
                        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <span><i data-feather="repeat"></i></span>
                        </div>
                        <div>
                            <h3 class="fs-2">Latest replay</h3>
                            <p>There is no replay yet!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Footer.php'); ?>