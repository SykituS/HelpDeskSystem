<?php
include(__DIR__ . '/../../Configuration/Init.php');

if (!$users->isLoggedIn()) {
    header('Location: '.BaseUrl.'/Pages/Account/Login.php');
}

if (!$users->HaveAdminPermissions()) {
    header('Location: '.BaseUrl.'/Pages/Account/Login.php');
}

include(__DIR__ . '/../../Includes/Header.php');
include(__DIR__ . '/../../Includes/Container.php');
include(__DIR__ . '/../../Pages/Shared/Menu.php');

if (isset($_SESSION["SuccessMessage"])) {
    // Display the toast message
    echo '
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">    
            <div class="toast-header">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ' . $_SESSION["SuccessMessage"] . '
            </div>
        </div>
    </div>';

    // Clear the success message session variable
    unset($_SESSION["SuccessMessage"]);

    // Show the toast using JavaScript
    echo '
    <script>
        var toastEl = document.querySelector(".toast");
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    </script>';
}
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="h5 text-center">User List</h3>
                </div>
                <div class="card-body">
                    <div>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php
                                $pageInfo = $users->retrivePageInformations($users->userTable);
                                $isOnFirstPage = ($pageInfo[3] == 1) ? 'disabled' : '';
                                $isOnLastPage = ($pageInfo[3] == $pageInfo[1]) ? 'disabled' : '';
                                echo '
                                    <li class="page-item ' . $isOnFirstPage . '">
                                        <a class="page-link" href="?Page=' . ($pageInfo[3] - 1) . '">Previous</a>
                                    </li>
                                    ';

                                $start = max(1, $pageInfo[3] - 2);
                                $end = min($start + 4, $pageInfo[1]);

                                for ($i = $start; $i <= $end; $i++) {
                                    $isPageActive = ($i == $pageInfo[3]) ? 'disabled' : '';
                                    echo '<li class="page-item"><a class="page-link ' . $isPageActive . '" href="?Page=' . $i . '">' . $i . '</a></li>';
                                }
                                echo '
                                    <li class="page-item">
                                        <a class="page-link ' . $isOnLastPage . '" href="?Page=' . ($pageInfo[3] + 1) . '">Next</a>
                                    </li>
                                    ';
                                ?>
                            </ul>
                            <div class="text-end">
                                <a href="<?php echo BaseUrl; ?>/Pages/Users/CreateNewUser.php" class="btn btn-outline-primary">Add new user</a>
                            </div>
                        </nav>
                    </div>
                    <table class="table table-hover" id="accordion">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-center">Department</th>
                                <th>Role</th>
                                <th>IsActive</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $userData = $users->getListOfUsers();
                            $numerator = 0;
                            foreach ($userData as $value) {
                                $isActiveBtnClass = $value[5] ? 'btn btn-outline-danger btn-sm' : 'btn btn-outline-success btn-sm';
                                $isActiveBtnText = $value[5] ? 'Disable user' : 'Enable user';

                                $statusBadgeClass = $value[5] ? 'badge text-bg-success' : 'badge text-bg-danger';
                                $statusBadgeText = $value[5] ? 'True' : 'False';
                                $rowStyleClass = $value[5] ? '' : 'text-decoration-line-through fst-italic';
                                echo '
                                    <div class="accordion-item">
                                        <tr class="accordion-header ' . $rowStyleClass . '" data-bs-toggle="collapse" data-bs-target="#collapse' . $numerator . '" aria-expanded="true" aria-controls="collapse' . $numerator . '" data-userId="' . $value[0] . '">
                                            <td>' . $value[1] . '</td>
                                            <td>' . $value[2] . '</td>
                                            <td class="text-center">' . $value[3] . '</td>
                                            <td>' . $value[4] . '</td>
                                            <td><span class="' . $statusBadgeClass . '" data-userId="' . $value[0] . '">' . $statusBadgeText . '</td>
                                            <td class="text-end pe-3">
                                                <div class="icon-container">
                                                    <span ><i class="icon-icon" data-feather="menu"></i></span>
                                                    <span class="badge bg-secondary icon-text">Actions</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="collapse' . $numerator . '" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                            <td class="accordion-body" colspan="6">
                                                <div class="card text-center">
                                                    <div class="card-body bg-secondary " style="--bs-bg-opacity: .05;">
                                                        <a href="UserDetails.php?Id=' . $value[0] . '" type="button" class="btn btn-outline-info btn-sm"><span class="fw-bold">Details</span></a>
                                                        <a href="EditUser.php?Id=' . $value[0] . '" type="button" class="btn btn-outline-primary btn-sm"><span class="fw-bold">Edit</span></a>
                                                        <button id="BtnChangeStatus" class="' . $isActiveBtnClass . '" data-userId="' . $value[0] . '" onclick="changeStatus(' . $value[0] . ')">
                                                            <span class="fw-bold">' . $isActiveBtnText . '</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </div>
                                    ';
                                $numerator++;
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
    function changeStatus(userId) {
        $.ajax({
            url: 'UsersAction.php',
            type: 'GET',
            data: {
                UserId: userId
            },
            dataType: 'json',
            cache: false,
            success: function(response) {
                if (response.status === 'success') {
                    console.log(response.isActive);
                    // Check the value of isActive
                    var button = $('button[data-userId="' + userId + '"]');
                    var badge = $('span[data-userId="' + userId + '"]');
                    var tr = $('tr[data-userId="' + userId + '"]');
                    if (response.isActive === "True") {
                        button.text("Disable user");
                        button.removeClass("btn-outline-success").addClass("btn-outline-danger");

                        badge.removeClass("badge text-bg-danger").addClass("badge text-bg-success").text("True");
                        tr.removeClass("text-decoration-line-through fst-italic");
                    } else {
                        button.text("Enable user");
                        button.removeClass("btn-outline-danger").addClass("btn-outline-success");

                        badge.removeClass("badge text-bg-success").addClass("badge text-bg-danger").text("False");
                        tr.addClass("text-decoration-line-through fst-italic");
                    }
                } else {
                    console.log('Error: ' + response.message);
                }
            },
            error: function() {
                console.log('AJAX request failed');
            }
        });
    }
</script>
<?php include(__DIR__ . '/../../Includes/Footer.php'); ?>