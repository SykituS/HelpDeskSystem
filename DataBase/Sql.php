<?php

$create[] = "CREATE TABLE `" . $prefix . "Departments` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] .= "CREATE TABLE `" . $prefix . "TicketResponse` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `UniqueTicketId` varchar(255) NOT NULL,
  `ResponseMsg` text NOT NULL,
  `ResponseBy` int NOT NULL,
  `CreatedOn` datetime NOT NULL,
  PRIMARY KEY (`Id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] .= "CREATE TABLE `" . $prefix . "Tickets` (
 `Id` int NOT NULL AUTO_INCREMENT,
 `UniqueId` varchar(255) NOT NULL,
 `UserId` int NOT NULL,
 `Title` varchar(255) NOT NULL,
 `DepartmentId` int NOT NULL,
 `InitialMsg` text NOT NULL,
 `CreatedOn` datetime NOT NULL,
 `AssignetToUserId` int DEFAULT NULL,
 `IsReadByUser` tinyint(1) NOT NULL,
 `IsReadByHelpDesk` tinyint(1) NOT NULL,
 `Status` enum('Created','InProgress','Resolved','Cancelled') NOT NULL,
 `ExpectedCompletionDate` date DEFAULT NULL,
 `AssignedTechnicalId` int DEFAULT NULL,
 PRIMARY KEY (`Id`),
 UNIQUE KEY `UniqueId` (`UniqueId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] .= "CREATE TABLE `" . $prefix . "Users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Role` enum('Admin','HelpDesk','User','') NOT NULL,
  `Status` int NOT NULL,
  `DepartmentId` int NOT NULL,
  `CreatedOn` date NOT NULL,
  PRIMARY KEY (`Id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";
