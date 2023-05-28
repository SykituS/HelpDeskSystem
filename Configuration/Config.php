<?php
                $host="db";
                $user="lamp_docker";
                $password="lamp_docker";
                $database="HelpDesk";
                $prefix="hd_";
                $link = mysqli_connect($host, $user, $password, $database);

# konfiguracja aplikacji

        $baseUrl="localhost";
        $applicationName="help";
        $dateOfCreation="2023-05-28 09:56:40";
        $version="1.1";
        $companyName="HelpDeskSystems";
        $companyStreet="Jana";
        $companyCity="Łódź";
        $companyPhone="123123123";
        