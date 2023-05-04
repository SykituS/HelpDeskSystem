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
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#1">1</a></li>
                                <li class="page-item"><a class="page-link" href="#2">2</a></li>
                                <li class="page-item"><a class="page-link" href="#3">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
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
                            <div class="accordion-item">
                                <tr class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <td>Testowy tester</td>
                                    <td>Emailos@email.com</td>
                                    <td>IT Department</td>
                                    <td>Admin</td>
                                    <td>
                                        <span class="badge text-bg-success">True</span>
                                    </td>
                                    <td >
                                        <div class="icon-container">
                                            <span ><i class="icon-icon" data-feather="menu"></i></span>
                                            <span class="badge bg-secondary icon-text">Actions</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <td class="accordion-body" colspan="6">
                                        <div class="card text-center">
                                            <div class="card-body bg-secondary " style="--bs-bg-opacity: .05;">
                                                <button type="button" class="btn btn-outline-primary btn-sm"><span class="fw-bold">Edit</span></button>
                                                <button type="button" class="btn btn-outline-warning btn-sm"><span class="fw-bold">Disable</span></button>
                                                <button type="button" class="btn btn-outline-danger btn-sm"><span class="fw-bold">Remove</span></button>
                                                <button type="button" class="btn btn-outline-info btn-sm"><span class="fw-bold">Details</span></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>
