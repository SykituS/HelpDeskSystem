<?php

if (!file_exists("Configuration/Config.php")) {
    header("Location: Install.php");
} else {
    include 'Configuration/init.php';

    if (!$users->IsLoggedIn()) {
        header("Location: Pages/Account/Login.php");
    } else {
        header("Location: Pages/MainPage/Main.php");
    }
}
