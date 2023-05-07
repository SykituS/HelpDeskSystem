<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/Configuration/Init.php');

if(!$users->isLoggedIn()) {
	header('Location: /Pages/Account/Login.php');
}

if(!$users->HaveAdminPermissions()) {
	header('Location: /Pages/Account/Login.php');
}

include($_SERVER['DOCUMENT_ROOT'].'/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'].'/Pages/Shared/Menu.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/Container.php');
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="h5 text-center">Departments List</h3>
                </div>
                <div class="card-body">
                    <div>
                        <nav>
                        <ul class="pagination justify-content-center">
                                <?php 
                                    $pageInfo = $depatments->retrivePageInformations($depatments->departmentTable);
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
                                <a href="/Pages/Departments/CreateNewDepartment.php" class="btn btn-outline-primary">Create new department</a>
                            </div>
                        </nav>
                    </div>
                    <table class="table table-hover" id="accordion">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Users in department</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $depatmentData = $depatments->getListOfDepartments();
                                $numerator = 0;
                                foreach($depatmentData as $value){
                                    echo '
                                    <div class="accordion-item">
                                        <tr class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapse'.$numerator.'" aria-expanded="true" aria-controls="collapse'.$numerator.'">
                                        <td>'.$value[1].'</td>
                                        <td><span class="badge bg-secondary">'.$value[2].'</span></td>
                                        <td class="text-end pe-3">
                                            <div class="icon-container">
                                                <span ><i class="icon-icon" data-feather="menu"></i></span>
                                                <span class="badge bg-secondary icon-text">Actions</span>
                                            </div>
                                        </td>
                                        <tr id="collapse'.$numerator.'" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                            <td class="accordion-body" colspan="3">
                                                <div class="card text-center">
                                                    <div class="card-body bg-secondary " style="--bs-bg-opacity: .05;">
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-info btn-sm"><span class="fw-bold">Details</span></button>
                                                        <button id='.$value[0].' type="button" class="btn btn-outline-primary btn-sm"><span class="fw-bold">Edit</span></button>
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

