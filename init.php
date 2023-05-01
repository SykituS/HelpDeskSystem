<?php 
session_start();
include 'Config.php';

define("Host" , $host);
define("User" , $user);
define("Password" , $password);
define("Database" , $database);

require 'Class/Database.php';
require 'Class/Users.php';

$database = new Database;
$users = new Users;
?>