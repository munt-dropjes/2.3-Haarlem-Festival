-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Gegenereerd op: 12 mrt 2025 om 18:59
-- Serverversie: 11.7.2-MariaDB-ubu2404
-- PHP-versie: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thefestivaldb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Artists`
--

CREATE TABLE `Artists` (
  `ArtistID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL,
  `About` varchar(4096) NOT NULL,
  `KnownFor` varchar(4096) NOT NULL,
  `Song1Link` varchar(1024) NOT NULL,
  `Song2Link` varchar(1024) NOT NULL,
  `Song3Link` varchar(1024) NOT NULL,
  `ImageName` varchar(128) NOT NULL,
  `Category` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Artists`
--

INSERT INTO `Artists` (`ArtistID`, `Name`, `About`, `KnownFor`, `Song1Link`, `Song2Link`, `Song3Link`, `ImageName`, `Category`) VALUES
(1, 'Jazz Band One', 'Famous jazz band from the 90s.', 'Smooth jazz hits', 'link1', 'link2', 'link3', 'jazzartiest1.png', 'Jazz'),
(2, 'Smooth Jazz Duo', 'A calming jazz duo.', 'Acoustic jazz', 'link4', 'link5', 'link6', 'jazzartiest2.png', 'Jazz'),
(3, 'Swing Kings', 'Energetic swing band.', 'Swing music', 'link7', 'link8', 'link9', 'jazzartiest3.png', 'Jazz');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Dance`
--

CREATE TABLE `Dance` (
  `ArtistID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Events`
--

CREATE TABLE `Events` (
  `EventID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Price` float(10,2) NOT NULL,
  `AvailableTickets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Events`
--

INSERT INTO `Events` (`EventID`, `Name`, `Description`, `Date`, `StartTime`, `EndTime`, `Location`, `Price`, `AvailableTickets`) VALUES
(1, 'Jazz Night', 'An evening full of jazz.', '2025-08-20', '18:00:00', '23:00:00', 'Patronaat, Haarlem', 25.00, 100),
(2, 'Swing Extravaganza', 'A night of swing and rhythm.', '2025-08-21', '19:00:00', '22:30:00', 'Patronaat, Haarlem', 30.00, 150),
(3, 'Smooth Jazz Evening', 'Relax with smooth jazz vibes.', '2025-08-22', '20:00:00', '23:00:00', 'Patronaat, Haarlem', 20.00, 200);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Invoices`
--

CREATE TABLE `Invoices` (
  `InvoiceID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TotalAmount` float(10,2) NOT NULL,
  `VAT` float(10,2) NOT NULL,
  `InvoiceDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Jazz`
--

CREATE TABLE `Jazz` (
  `ArtistID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Jazz`
--

INSERT INTO `Jazz` (`ArtistID`, `EventID`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Orders`
--

CREATE TABLE `Orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Status` enum('Pending','Paid','Cancelled') NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `PaymentMethod` enum('iDEAL','CreditCard','PayPal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Payments`
--

CREATE TABLE `Payments` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Status` enum('Success','Failed','Pending') NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `Amount` float(10,2) NOT NULL,
  `PaymentMethod` enum('iDEAL','CreditCard','PayPal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ShoppingCart`
--

CREATE TABLE `ShoppingCart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ShoppingCartItems`
--

CREATE TABLE `ShoppingCartItems` (
  `ItemID` int(11) NOT NULL,
  `CartID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `AddedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Stroll`
--

CREATE TABLE `Stroll` (
  `EventID` int(11) NOT NULL,
  `Language` enum('English','Dutch','Chinese') NOT NULL,
  `Guide` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Tickets`
--

CREATE TABLE `Tickets` (
  `TicketID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `QRCode` varchar(255) NOT NULL,
  `Status` enum('Valid','Scanned','Cancelled') NOT NULL,
  `PurchasedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Role` enum('Customer','Administrator','Employee') DEFAULT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `RegisteredAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Users`
--

INSERT INTO `Users` (`UserID`, `Role`, `Name`, `Email`, `Password`, `Phone`, `Country`, `RegisteredAt`) VALUES
(1, 'Customer', 'Daniel Zwart', 'dtzwart@gmail.com', '$2y$12$AtD6c5mvh6R1//0TWiAk3uhix4geuIPjWVJiGIuXTwMNm179fQ4HW', '0612345678', 'Netherlands', '2025-03-06 12:04:16');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Yummie`
--

CREATE TABLE `Yummie` (
  `EventID` int(11) NOT NULL,
  `StarRating` int(11) NOT NULL,
  `Cuisine` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Artists`
--
ALTER TABLE `Artists`
  ADD PRIMARY KEY (`ArtistID`);

--
-- Indexen voor tabel `Dance`
--
ALTER TABLE `Dance`
  ADD KEY `ArtistID` (`ArtistID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexen voor tabel `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexen voor tabel `Invoices`
--
ALTER TABLE `Invoices`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `Jazz`
--
ALTER TABLE `Jazz`
  ADD KEY `ArtistID` (`ArtistID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexen voor tabel `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexen voor tabel `ShoppingCart`
--
ALTER TABLE `ShoppingCart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `ShoppingCartItems`
--
ALTER TABLE `ShoppingCartItems`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `CartID` (`CartID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexen voor tabel `Stroll`
--
ALTER TABLE `Stroll`
  ADD KEY `EventID` (`EventID`);

--
-- Indexen voor tabel `Tickets`
--
ALTER TABLE `Tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `EventID` (`EventID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexen voor tabel `Yummie`
--
ALTER TABLE `Yummie`
  ADD KEY `EventID` (`EventID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Artists`
--
ALTER TABLE `Artists`
  MODIFY `ArtistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `Events`
--
ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `Invoices`
--
ALTER TABLE `Invoices`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `Orders`
--
ALTER TABLE `Orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `Payments`
--
ALTER TABLE `Payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ShoppingCart`
--
ALTER TABLE `ShoppingCart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ShoppingCartItems`
--
ALTER TABLE `ShoppingCartItems`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `Tickets`
--
ALTER TABLE `Tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `Dance`
--
ALTER TABLE `Dance`
  ADD CONSTRAINT `Dance_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `Artists` (`ArtistID`),
  ADD CONSTRAINT `Dance_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`);

--
-- Beperkingen voor tabel `Invoices`
--
ALTER TABLE `Invoices`
  ADD CONSTRAINT `Invoices_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`),
  ADD CONSTRAINT `Invoices_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Beperkingen voor tabel `Jazz`
--
ALTER TABLE `Jazz`
  ADD CONSTRAINT `Jazz_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `Artists` (`ArtistID`),
  ADD CONSTRAINT `Jazz_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`);

--
-- Beperkingen voor tabel `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Beperkingen voor tabel `Payments`
--
ALTER TABLE `Payments`
  ADD CONSTRAINT `Payments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `Payments_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`);

--
-- Beperkingen voor tabel `ShoppingCart`
--
ALTER TABLE `ShoppingCart`
  ADD CONSTRAINT `ShoppingCart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Beperkingen voor tabel `ShoppingCartItems`
--
ALTER TABLE `ShoppingCartItems`
  ADD CONSTRAINT `ShoppingCartItems_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `ShoppingCart` (`CartID`),
  ADD CONSTRAINT `ShoppingCartItems_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`);

--
-- Beperkingen voor tabel `Stroll`
--
ALTER TABLE `Stroll`
  ADD CONSTRAINT `Stroll_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`);

--
-- Beperkingen voor tabel `Tickets`
--
ALTER TABLE `Tickets`
  ADD CONSTRAINT `Tickets_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`),
  ADD CONSTRAINT `Tickets_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Beperkingen voor tabel `Yummie`
--
ALTER TABLE `Yummie`
  ADD CONSTRAINT `Yummie_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
