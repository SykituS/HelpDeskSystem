<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

if (!$users->HaveAdminPermissions()) {
    header('Location: /Pages/Account/Login.php');
}

if (!isset($_GET["Id"]))
    header('Location: /Pages/Shared/Error.php');


$userDetails = $users->GetUserInfoById($_GET["Id"]);
$styleForBorder = $userDetails["Status"] == 1 ? "border-primary" : "border-danger";
include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-header">
                    <h3>User information</h3>
                </div>
                <div class="card-body ms-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="border-start border-3 pe-2 <?php echo $styleForBorder ?>"></div>
                                <div class="ms-3">
                                    <h4>Email</h4>
                                    <p><?php echo $userDetails["Email"]; ?></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="border-start border-3 pe-2 <?php echo $styleForBorder ?>"></div>
                                <div class="ms-3">
                                    <h4>Fullname</h4>
                                    <p><?php echo $userDetails["FirstName"] . " " . $userDetails["LastName"]; ?></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="border-start border-3 pe-2 <?php echo $styleForBorder ?>"></div>
                                <div class="ms-3">
                                    <h4>Role</h4>
                                    <p><?php echo $userDetails["Role"]; ?></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="border-start border-3 pe-2 <?php echo $styleForBorder ?>"></div>
                                <div class="ms-3">
                                    <h4>Department</h4>
                                    <p><?php echo $userDetails["DepartmentName"]; ?></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="border-start border-3 pe-2 <?php echo $styleForBorder ?>"></div>
                                <div class="ms-3">
                                    <h4>Status</h4>
                                    <p><?php echo $userDetails["Status"] == 1 ? "Active" : "Inactive"; ?></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="border-start border-3 pe-2 <?php echo $styleForBorder ?>"></div>
                                <div class="ms-3">
                                    <h4>Created on:</h4>
                                    <p><?php echo $userDetails["CreatedOn"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card-footer"></div>
            <div class="card mt-3 text-center">
                <div class="card-header">
                    <h3>Actions</h3>
                </div>
                <div class="card-body">
                    <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
                    <a href="EditUser.php?Id=<?php echo $_GET["Id"]; ?>" type="button" class="btn btn-outline-primary"><span class="fw-bold">Edit</span></a>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/../../Includes/Footer.php'); ?>