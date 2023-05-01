<?php 
include 'Configuration/init.php';

if(!$users->IsLoggedIn()) {
    header("Location: Pages/Account/Login.php");
} else {
    header("Location: Pages/Tickets/Ticket.php");
}
include('Includes/Header.php');
//$user = $users->getUserInfo();
?>

