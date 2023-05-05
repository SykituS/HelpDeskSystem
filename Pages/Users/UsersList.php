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
                                    $pageInfo = $users->retrivePageInformations();
                                    $isOnFirstPage = ($pageInfo[3] == 1) ? 'disabled' : '';
                                    $isOnLastPage = ($pageInfo[3] == $pageInfo[1]) ? 'disabled' : '';
                                    echo '
                                    <li class="page-item '.$isOnFirstPage.'">
                                        <a class="page-link" href="?Page='.($pageInfo[3] - 1).'">Previous</a>
                                    </li>
                                    ';
                                    for ($i = 1; $i <= $pageInfo[1]; $i++)
                                    {
                                        $isPageActive = ($i == $pageInfo[3]) ? 'active' : '';
                                        echo '<li class="page-item"><a class="page-link" href="?Page='.$i.'">'.$i.'</a></li>';
                                    }
                                    echo '
                                    <li class="page-item">
                                        <a class="page-link '.$isOnLastPage.'" href="?Page='.($pageInfo[3] + 1).'">Next</a>
                                    </li>
                                    ';
                                    ?>
                            </ul>
                        </nav>
                    </div>
                    <table class="table table-hover" id="accordion">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
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
                                    echo '
                                    <div class="accordion-item">
                                        <tr class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapse'.$numerator.'" aria-expanded="true" aria-controls="collapse'.$numerator.'">
                                        <td>'.$value[1].'</td>
                                        <td>'.$value[2].'</td>
                                        <td>'.$value[3].'</td>
                                        <td>'.$value[4].'</td>
                                        <td>'.$value[5].'</td>
                                        <td >
                                            <div class="icon-container">
                                                <span ><i class="icon-icon" data-feather="menu"></i></span>
                                                <span class="badge bg-secondary icon-text">Actions</span>
                                            </div>
                                        </td>
                                        <tr id="collapse'.$numerator.'" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                            <td class="accordion-body" colspan="6">
                                                <div class="card text-center">
                                                    <div class="card-body bg-secondary " style="--bs-bg-opacity: .05;">
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-primary btn-sm"><span class="fw-bold">Edit</span></button>
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-warning btn-sm"><span class="fw-bold">Disable</span></button>
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-danger btn-sm"><span class="fw-bold">Remove</span></button>
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-info btn-sm"><span class="fw-bold">Details</span></button>
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
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>
