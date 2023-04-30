<?php 
session_start();
include 'config.php';

define("Host" , $host);
define("User" , $user);
define("Password" , $password);
define("Database" , $database);

require 'class/Database.php';

$database = new Database;
?>