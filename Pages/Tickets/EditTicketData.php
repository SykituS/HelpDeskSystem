<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: /Pages/Account/Login.php');
}

if (!isset($_GET["Id"])) {
    header('Location: /Pages/Shared/Error.php');
}

$ticketId = $_GET["Id"];
$ticketDetails = $tickets->GetTicketDetailsByUniqueId($ticketId);

$errorMessage = $tickets->EditTicketData();

include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');
?>


<div class="card mt-5">
    <div class="card-header text-center pt-3">
        <h1 class="h3 mb-3 fw-normal">Edit ticket: </h1>
    </div>
    <div class="card-body">
        <form id="editTicketDataForm" class="form-horizontal" role="form" method="POST" action="">
            <input type="hidden" name="UId" value="<?php echo $ticketId; ?>" />
            <div class="text-center">
                <div class="">
                    <div class="form-floating">
                        <input type="Text" value="<?php echo $ticketDetails["Title"] ?>" class="form-control" id="Title" name="Title" placeholder="Title" disabled>
                        <label for="Title">Title</label>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Text" value="<?php echo $ticketDetails["HelpDeskFullName"] ?>" class="form-control" id="AssignedUser" name="AssignedUser" placeholder="Assigned user" value="placeholder" disabled>
                        <label for="AssignedUser">Assigned user</label>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="Department">Department</label>
                    <select class="form-select" id="Department" name="Department" required>
                        <?php
                        $departmentList = $depatments->getAllDepartments();
                        foreach ($departmentList as $value) {
                            $isSelectedDepartment = $value[0] == $ticketDetails["DepartmentId"] ? "Selected" : "";
                            echo '<option value="' . $value[0] . '" ' . $isSelectedDepartment . '>' . $value[1] . '</option>';
                        }

                        ?>
                    </select>
                </div>

                <div class="mt-3">
                    <label for="Technicial">Technicial</label>
                    <select class="form-select" id="Technicial" name="Technicial" required>
                        <option value="0">Select Technicial</option>
                        <?php
                        $userList = $users->GetListOfHelpDeskAdminUsers();

                        foreach ($userList as $value) {
                            $isTechnical = $value[0] == $ticketDetails["AssignedTechnicalId"] ? "Selected" : "";
                            echo '<option value="' . $value[0] . '" ' . $isTechnical . '>' . $value[1] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="ExpectedFinishDate">Expected Finish Date:</label>
                    <div class="input-group">
                        <input type="text" id="ExpectedFinishDate" name="ExpectedFinishDate" class="form-control" value="<?php echo $ticketDetails["ExpectedCompletionDate"] ?>" placeholder="Select date">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="clearDate"><i data-feather="x"></i></button>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    <div class="card-footer pt-4">
        <div class="d-grid col-4 mx-auto pb-3 gap-2">
            <a class="btn btn-outline-secondary" onclick="goBack()">Go back</a>
            <input type="submit" name="EditTicketData" value="Edit ticket" class="btn btn-outline-primary">
        </div>
        <?php if ($errorMessage != '') { ?>
            <div class="mt-2">
                <div class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>
            </div>
        <?php } ?>
    </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var datePicker = flatpickr('#ExpectedFinishDate', {
            enableTime: false,
            dateFormat: 'Y-m-d'
        });

        var clearDateButton = document.getElementById('clearDate');
        clearDateButton.addEventListener('click', function() {
            datePicker.clear();
        });
    });
</script>
<?php include(__DIR__ . '/../../Includes/Footer.php'); ?>