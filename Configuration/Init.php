<?php
session_start();
include 'Config.php';

define("Host", $host);
define("User", $user);
define("Password", $password);
define("Database", $database);

require($_SERVER['DOCUMENT_ROOT'] . '/Class/Database.php');
require($_SERVER['DOCUMENT_ROOT'] . '/Class/Users.php');
require($_SERVER['DOCUMENT_ROOT'] . '/Class/Departments.php');
require($_SERVER['DOCUMENT_ROOT'] . '/Class/Tickets.php');

$database = new Database;
$users = new Users;
$depatments = new Departments;
$tickets = new Tickets;
