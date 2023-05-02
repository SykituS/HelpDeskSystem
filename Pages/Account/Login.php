<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/Configuration/Init.php');

if($users->isLoggedIn()) {
	header('Location: /Pages/Tickets/TicketsList.php');
}

$errorMessage = $users->Login();

include($_SERVER['DOCUMENT_ROOT'].'/Includes/Header.php');
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Container.php');?>
<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Login to Help Desk</h1>
    </div>
    <form id="loginForm" class="form-horizontal" role="form" method="POST" action="">
    <div class="card-body">
        <div class="text-center">
            <div class="">
                <div class="form-floating">
                    <input type="Email" class="form-control" id="Email" name="Email" placeholder="name@example.com" required>
                    <label for="Email">Email address</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-floating">
                    <input type="Password" class="form-control" id="Password" name="Password" placeholder="Password" required>
                    <label for="Password">Password</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer pt-4">
            <div class="d-grid col-4 mx-auto pb-3">
                    <input type="submit" name="Login" value="Login" class="btn btn-outline-primary">
            </div>
            <?php if ($errorMessage != '') { ?>
                <div class="mt-5">
                    <div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
                </div>
            <?php } ?>
        </div>
    </form>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>