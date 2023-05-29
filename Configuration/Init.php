<?php
session_start();
include 'Config.php';

if (!$link) {
    if(file_exists(BaseUrl.'/Install.php')) {
        header('Location: '.BaseUrl.'/Install.php');
    } else {
        http_response_code(503);
        die("Service unavailable");
    }
    die("Failed to connect");
}

define("Host", $host);
define("User", $user);
define("Password", $password);
define("Database", $database);
define("Prefix", $prefix);
define("BaseUrl", $baseUrl);

require(__DIR__ . '/../Class/Database.php');
require(__DIR__ . '/../Class/Users.php');
require(__DIR__ . '/../Class/Departments.php');
require(__DIR__ . '/../Class/Tickets.php');

$database = new Database;
$users = new Users;
$depatments = new Departments;
$tickets = new Tickets;