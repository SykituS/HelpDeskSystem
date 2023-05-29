<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

$errorMessage = $tickets->CreateNewTicket();

include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');
?>


<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Create new ticket: </h1>
    </div>
    <div class="card-body">
        <form id="createNewTicketForm" class="form-horizontal" role="form" method="POST" action="">
            <div class="text-center">
                <div class="">
                    <div class="form-floating">
                        <input type="Text" class="form-control" id="Title" name="Title" placeholder="Title" required>
                        <label for="Title">Title</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <textarea class="form-control" id="Message" name="Message" rows="3" placeholder="Message" required></textarea>
                        <label for="Message">Message</label>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="Department">Department</label>
                    <select class="form-select" id="Department" name="Department" required>
                        <?php
                        $departmentList = $depatments->getAllDepartments();
                        foreach ($departmentList as $value) {
                            $isInRole = $value[0] == $userDetails["Role"] ? "Selected" : "";
                            echo '<option value="' . $value[0] . '" ' . $isInRole . '>' . $value[1] . '</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>

    </div>
    <div class="card-footer pt-4">
        <div class="d-grid col-4 mx-auto pb-3 gap-2">
            <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
            <input type="submit" name="CreateNewTicket" value="Create ticket" class="btn btn-outline-primary">
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