<?php
session_start();
include 'Config.php';



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