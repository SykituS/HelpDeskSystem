<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/Configuration/Init.php');

if(!$users->isLoggedIn()) {
	header('Location: /Pages/Account/Login.php');
}

if(!$users->HaveAdminPermissions()) {
	header('Location: /Pages/Account/Login.php');
}

include($_SERVER['DOCUMENT_ROOT'].'/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'].'/Pages/Shared/Menu.php');
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
                                    <li class="page-item '.$isOnFirstPage.'">
                                        <a class="page-link" href="?Page='.($pageInfo[3] - 1).'">Previous</a>
                                    </li>
                                    ';

                                    $start = max(1, $pageInfo[3] - 2);
                                    $end = min($start + 4, $pageInfo[1]);

                                    for ($i = $start; $i <= $end; $i++)
                                    {
                                        $isPageActive = ($i == $pageInfo[3]) ? 'disabled' : '';
                                        echo '<li class="page-item"><a class="page-link '.$isPageActive.'" href="?Page='.$i.'">'.$i.'</a></li>';
                                    }
                                    echo '
                                    <li class="page-item">
                                        <a class="page-link '.$isOnLastPage.'" href="?Page='.($pageInfo[3] + 1).'">Next</a>
                                    </li>
                                    ';
                                    ?>
                            </ul>
                            <div class="text-end">
                                <a href="/Pages/Users/CreateNewUser.php" class="btn btn-outline-primary">Add new user</a>
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
                                foreach($userData as $value){
                                    $isActiveBtnClass = $value[5] ? 'btn btn-outline-danger btn-sm' : 'btn btn-outline-success btn-sm';
                                    $isActiveBtnText = $value[5] ? 'Disable user' : 'Enable user';

                                    $statusBadgeClass = $value[5] ? 'badge text-bg-success' : 'badge text-bg-danger';
                                    $statusBadgeText = $value[5] ? 'True' : 'False';
                                    
                                    echo '
                                    <div class="accordion-item">
                                        <tr class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapse'.$numerator.'" aria-expanded="true" aria-controls="collapse'.$numerator.'">
                                        <td>'.$value[1].'</td>
                                        <td>'.$value[2].'</td>
                                        <td class="text-center">'.$value[3].'</td>
                                        <td>'.$value[4].'</td>
                                        <td><span class="'.$statusBadgeClass.'" data-userId="'.$value[0].'">'.$statusBadgeText.'</td>
                                        <td class="text-end pe-3">
                                            <div class="icon-container">
                                                <span ><i class="icon-icon" data-feather="menu"></i></span>
                                                <span class="badge bg-secondary icon-text">Actions</span>
                                            </div>
                                        </td>
                                        <tr id="collapse'.$numerator.'" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                            <td class="accordion-body" colspan="6">
                                                <div class="card text-center">
                                                    <div class="card-body bg-secondary " style="--bs-bg-opacity: .05;">
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-info btn-sm"><span class="fw-bold">Details</span></button>
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-primary btn-sm"><span class="fw-bold">Edit</span></button>
                                                        <button id="BtnChangeStatus" class="'.$isActiveBtnClass.'" data-userId="'.$value[0].'" onclick="changeStatus('.$value[0].')">
                                                            <span class="fw-bold">'.$isActiveBtnText.'</span>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function changeStatus(userId) {
    $.ajax({
      url: 'UsersAction.php',
      type: 'GET',
      data: { UserId: userId },
      dataType: 'json',
      cache: false,
      success: function (response) {
      if (response.status === 'success') {
        console.log(response.isActive);
        // Check the value of isActive
        var button = $('button[data-userId="' + userId + '"]');
        var badge = $('span[data-userId="' + userId + '"]');
        if (response.isActive === "True") {
          button.text("Disable user");
          button.removeClass("btn-outline-success").addClass("btn-outline-danger");

          badge.removeClass("badge text-bg-danger").addClass("badge text-bg-success").text("True");
        } else {
          button.text("Enable user");
          button.removeClass("btn-outline-danger").addClass("btn-outline-success");

          badge.removeClass("badge text-bg-success").addClass("badge text-bg-danger").text("False");
        }
      } else {
        console.log('Error: ' + response.message);
      }
    },
    error: function () {
      console.log('AJAX request failed');
    }
    });
  }
</script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>