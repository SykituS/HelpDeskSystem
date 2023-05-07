<?php 
include 'Configuration/init.php';

if(!$users->IsLoggedIn()) {
    header("Location: Pages/Account/Login.php");
} else {
    header("Location: Pages/MainPage/Main.php");
}
?>

