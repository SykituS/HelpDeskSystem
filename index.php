<?php 
include 'init.php';

if(!$users->IsLoggedIn()) {
    header("Location: Login.php");
} else {
    header("Location: Ticket.php");
}
include('Includes/Header.php');
//$user = $users->getUserInfo();
?>

