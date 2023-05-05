-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Maj 05, 2023 at 11:32 AM
-- Wersja serwera: 8.0.33
-- Wersja PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HelpDesk`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Departments`
--

CREATE TABLE `Departments` (
  `Id` int NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Departments`
--

INSERT INTO `Departments` (`Id`, `Name`) VALUES
(1, 'IT');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `TicketResponse`
--

CREATE TABLE `TicketResponse` (
  `Id` int NOT NULL,
  `UniqueTicketId` varchar(255) NOT NULL,
  `ResponseMsg` text NOT NULL,
  `ResponseBy` int NOT NULL,
  `CreatedOn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tickets`
--

CREATE TABLE `Tickets` (
  `Id` int NOT NULL,
  `UniqueId` varchar(255) NOT NULL,
  `UserId` int NOT NULL,
  `Title` varchar(255) NOT NULL,
  `DepartmentId` int NOT NULL,
  `InitialMsg` text NOT NULL,
  `CreatedOn` date NOT NULL,
  `AssignetToUserId` int DEFAULT NULL,
  `IsReadByUser` tinyint(1) NOT NULL,
  `IsReadByHelpDesk` tinyint(1) NOT NULL,
  `Status` enum('Created','InProgress','Resolved','Cancelled') NOT NULL,
  `ExpectedCompletionDate` date DEFAULT NULL,
  `AssignedTechnicalId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `Id` int NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Role` enum('Admin','HelpDesk','User','') NOT NULL,
  `Status` int NOT NULL,
  `DepartmentId` int NOT NULL,
  `CreatedOn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`Id`, `Email`, `Password`, `FirstName`, `LastName`, `Role`, `Status`, `DepartmentId`, `CreatedOn`) VALUES
(1, 'admin@helpdesk.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Adam', 'Mickiewicz', 'Admin', 1, 1, '2023-05-01'),
(2, 'test@test.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Janusz', 'Kowalski', 'HelpDesk', 1, 1, '2023-05-05'),
(3, 'marian.kowalski@helpdesk.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Marian', 'Kowalski', 'User', 1, 1, '2023-05-05');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `Departments`
--
ALTER TABLE `Departments`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `TicketResponse`
--
ALTER TABLE `TicketResponse`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `Tickets`
--
ALTER TABLE `Tickets`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `UniqueId` (`UniqueId`);

--
-- Indeksy dla tabeli `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Departments`
--
ALTER TABLE `Departments`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `TicketResponse`
--
ALTER TABLE `TicketResponse`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tickets`
--
ALTER TABLE `Tickets`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
