<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/Configuration/Init.php');

if(!$users->isLoggedIn()) {
	header('Location: /Pages/Account/Login.php');
}

if(!$users->HaveAdminPermissions()) {
	header('Location: /Pages/Account/Login.php');
}

$errorMessage = $depatments->CreateNewDepartment();

include($_SERVER['DOCUMENT_ROOT'].'/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'].'/Pages/Shared/Menu.php');
?>

<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Create new department</h1>
    </div>
    <div class="card-body">
        <form id="createNewUserForm" class="form-horizontal" role="form" method="POST" action="">
            <div class="text-center">
                <div class="">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="Department" name="Department" placeholder="Department name" required>
                        <label for="Department">Department name</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer pt-4">
            <div class="d-grid col-4 mx-auto pb-3 gap-2">
                <a class="btn btn-outline-secondary" href="/Pages/Departments/DeparmentsList.php">Go back</a>
                <input type="submit" name="CreateNewDepartment" value="Create new department" class="btn btn-outline-primary">
            </div>
            <?php if ($errorMessage != '') { ?>
                <div class="mt-2">
                    <div class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
                </div>
            <?php } ?>
        </div>
    </form>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>