<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/Configuration/Init.php');

if(!$users->isLoggedIn()) {
	header('Location: /Pages/Account/Login.php');
}

include($_SERVER['DOCUMENT_ROOT'].'/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/Container.php');
?>

<div class="container">
<?php include($_SERVER['DOCUMENT_ROOT'].'/Pages/Shared/Menu.php'); ?>	
    <div class="row">
        <div class="col-md-12"></div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Includes/Footer.php');?>
