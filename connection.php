<?php

$server = "localhost";
$user = "lamp_docker";
$password = "password";
$DbName = "lamp_docker";

$context = new mysqli($server, $user, $password, $DbName);

if ($context -> connect_error) die("Connection Problem: ".$context -> connect_error); 

?>