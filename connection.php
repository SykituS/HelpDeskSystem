<?php

$server = "localhost";
$user = "admin";
$password = "admin";
$DbName = "lamp_docker";

$context = new mysqli($server, $user, $password, $DbName);

if ($context -> connect_error) die("Connection Problem: ".$context -> connect_error); 

?>