<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: '.BaseUrl.'/Pages/Account/Login.php');
}

if (!$users->HaveAdminPermissions()) {
    header('Location: '.BaseUrl.'/Pages/Account/Login.php');
}

$errorMessage = $users->CreateNewUser();

include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');
?>

<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Create new user</h1>
    </div>
    <div class="card-body">
        <form id="createNewUserForm" class="form-horizontal" role="form" method="POST" action="">
            <div class="text-center">
                <div class="">
                    <div class="form-floating">
                        <input type="Email" class="form-control" id="Email" name="Email" placeholder="name@example.com" required>
                        <label for="Email">Email address</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="First name" required>
                        <label for="FirstName">First name</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Last name" required>
                        <label for="LastName">Last name</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Password" class="form-control" id="Password" name="Password" placeholder="Password" required>
                        <label for="Password">Password</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm password" required>
                        <label for="ConfirmPassword">Confirm password</label>
                    </div>
                </div>
                <div class="mt-3">
                    <select class="form-select" id="Department" name="Department" required>
                        <option value="0" selected>Select department</option>

                        <?php
                        $departmentList = $depatments->getAllDepartments();
                        foreach ($departmentList as $value) {
                            echo '<option value="' . $value[0] . '">' . $value[1] . '</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="my-3">
                    <select class="form-select" id="Role" name="Role" required>
                        <option value="" selected>Select user role</option>
                        <option value="Admin">Admin</option>
                        <option value="HelpDesk">Help Desk</option>
                        <option value="User">User</option>
                    </select>
                </div>
            </div>

    </div>
    <div class="card-footer pt-4">
        <div class="d-grid col-4 mx-auto pb-3 gap-2">
            <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
            <input type="submit" name="CreateNewUser" value="Create new user" class="btn btn-outline-primary">
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