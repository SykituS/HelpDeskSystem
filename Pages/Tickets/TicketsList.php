<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/Configuration/Init.php');

if(!$users->isLoggedIn()) {
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
                    <h3 class="h5 text-center">Your tickets</h3>
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
                            <div class="text-center">
                                <a href="#NewTicket" class="btn btn-outline-primary fw-bold">Create new Ticket</a>
                                <a href="#History" class="btn btn-outline-info fw-bold">See archived Tickets</a>
                            </div>
                        </nav>
                    </div>
                    <table class="table table-hover" id="accordion">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th class="text-center">To department</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Created on</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="accordion-item">
                                <tr onclick="redirectToPage('Ticket.php')">
                                    <td>System not working</td>
                                    <td class="text-center">IT</td>
                                    <td>Mariusz Kowalski</td>
                                    <td><span class="badge text-bg-success">Created</td>
                                    <td>2023-05-10</td>
                                    <td class="text-end pe-3">
                                        <div class="icon-container">
                                            <span ><i class="icon-icon" data-feather="align-right"></i></span>
                                            <span class="badge bg-secondary icon-text">Details</span>
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

<script>
    function redirectToPage(url) {
      window.location.href = url;
    }
</script>

<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>
