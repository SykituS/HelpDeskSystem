<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

if (!$users->HaveAdminPermissions()) {
    header('Location: /Pages/Account/Login.php');
}

if (!isset($_GET["Id"])) {
    header('Location: /Pages/Shared/Error.php');
}

$userId = $_GET["Id"];
$userDetails = $users->GetUserInfoById($userId);

$errorMessage = $users->EditUser();

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');
?>

<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Edit user: </h1>
    </div>
    <div class="card-body">
        <form id="editUserForm" class="form-horizontal" role="form" method="POST" action="">
            <input type="hidden" name="Id" value="<?php echo $userDetails["Id"]; ?>" />

            <div class="text-center">
                <div class="">
                    <div class="form-floating">
                        <input type="Email" value="<? echo $userDetails["Email"]; ?>" class="form-control" id="Email" name="Email" placeholder="name@example.com" required>
                        <label for="Email">Email address</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="text" value="<? echo $userDetails["FirstName"]; ?>" class="form-control" id="FirstName" name="FirstName" placeholder="First name" required>
                        <label for="FirstName">First name</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="text" value="<? echo $userDetails["LastName"]; ?>" class="form-control" id="LastName" name="LastName" placeholder="Last name" required>
                        <label for="LastName">Last name</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Password" value="" class="form-control" id="Password" name="Password" placeholder="Password">
                        <label for="Password">Password</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Password" value="" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm password">
                        <label for="ConfirmPassword">Confirm password</label>
                    </div>
                </div>
                <div class="mt-3">
                    <select class="form-select" id="Department" name="Department" required>

                        <?php
                        $departmentList = $depatments->getAllDepartments();
                        foreach ($departmentList as $value) {
                            $isInDepartment = $value[0] == $userDetails["DepartmentId"] ? "Selected" : "";
                            echo '<option value="' . $value[0] . '" ' . $isInDepartment . '>' . $value[1] . '</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="my-3">
                    <select class="form-select" id="Role" name="Role" required>
                        <option value="Admin" <?php if ($userDetails["Role"] == "Admin") echo 'Selected'; ?>>Admin</option>
                        <option value="HelpDesk" <?php if ($userDetails["Role"] == "HelpDesk") echo 'Selected'; ?>>Help Desk</option>
                        <option value="User" <?php if ($userDetails["Role"] == "User") echo 'Selected'; ?>>User</option>
                    </select>
                </div>
            </div>

    </div>
    <div class="card-footer pt-4">
        <div class="d-grid col-4 mx-auto pb-3 gap-2">
            <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
            <input type="submit" name="EditUser" value="Edit user" class="btn btn-outline-primary">
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