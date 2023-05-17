-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Maj 16, 2023 at 05:19 PM
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
(1, 'IT'),
(2, 'HR'),
(3, 'Finances');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `TicketResponse`
--

CREATE TABLE `TicketResponse` (
  `Id` int NOT NULL,
  `UniqueTicketId` varchar(255) NOT NULL,
  `ResponseMsg` text NOT NULL,
  `ResponseBy` int NOT NULL,
  `CreatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `TicketResponse`
--

INSERT INTO `TicketResponse` (`Id`, `UniqueTicketId`, `ResponseMsg`, `ResponseBy`, `CreatedOn`) VALUES
(1, '5951317d-ece7-46cc-9aaf-907ecafdac96', 'Lorem Ipsum Test', 2, '2023-05-16 17:00:45'),
(2, '5951317d-ece7-46cc-9aaf-907ecafdac96', 'Lorem Ipsum da latina Howerowe Sup De Lotius', 1, '2023-05-16 17:01:06');

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
  `CreatedOn` datetime NOT NULL,
  `AssignetToUserId` int DEFAULT NULL,
  `IsReadByUser` tinyint(1) NOT NULL,
  `IsReadByHelpDesk` tinyint(1) NOT NULL,
  `Status` enum('Created','InProgress','Resolved','Cancelled') NOT NULL,
  `ExpectedCompletionDate` date DEFAULT NULL,
  `AssignedTechnicalId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Tickets`
--

INSERT INTO `Tickets` (`Id`, `UniqueId`, `UserId`, `Title`, `DepartmentId`, `InitialMsg`, `CreatedOn`, `AssignetToUserId`, `IsReadByUser`, `IsReadByHelpDesk`, `Status`, `ExpectedCompletionDate`, `AssignedTechnicalId`) VALUES
(1, '5951317d-ece7-46cc-9aaf-907ecafdac96', 1, 'Test', 1, 'Test', '2023-05-16 00:00:00', 1, 0, 0, 'Created', NULL, NULL),
(2, '646381a282bc5', 1, 'CreateTest', 1, 'Testing message for ticket creation', '2023-05-16 00:00:00', NULL, 0, 0, 'Resolved', NULL, NULL),
(3, '64638293ec409', 1, 'CreateTest', 1, 'Testing message for ticket creation', '2023-05-16 00:00:00', NULL, 0, 0, 'Created', NULL, NULL);

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
(2, 'test@test.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Janusz', 'Kowalski', 'HelpDesk', 0, 2, '2023-05-05'),
(3, 'marian.Janigloda@helpdesk.com', '0cbc6611f5540bd0809a388dc95a615b', 'Marian', 'Janigloda', 'Admin', 1, 1, '2023-05-05'),
(4, 'test@helpdesk.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Testoron', 'Tost', 'User', 1, 3, '2023-05-05'),
(5, 'Helosor.Koric@helpdesk.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Helosor', 'Koric', 'Admin', 1, 3, '2023-05-05'),
(6, 'matxx29@gmail.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Mateusz', 'Jaruga', 'HelpDesk', 1, 1, '2023-05-05'),
(7, 'dasd@asd.vom', '7815696ecbf1c96e6894b779456d330e', 'asd', 'asd', 'HelpDesk', 1, 1, '2023-05-05'),
(8, 'Joanna.Mariki@company.com', '9e38e8d688743e0d07d669a1fcbcd35b', 'Joanna', 'Mariki', 'User', 1, 3, '2023-05-07');

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
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `TicketResponse`
--
ALTER TABLE `TicketResponse`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Tickets`
--
ALTER TABLE `Tickets`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
