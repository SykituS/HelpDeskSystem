<?php

$server = "db";
$user = "lamp_docker";
$password = "lamp_docker";
$DbName = "HelpDesk";

$context = new mysqli($server, $user, $password, $DbName);

if ($context -> connect_error) 
    die("Connection Problem: ".$context -> connect_error); 

?>