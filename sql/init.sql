CREATE DATABASE IF NOT EXISTS thefestivaldb;

USE thefestivaldb;

CREATE TABLE `Artists` (
	`ArtistID` INT(11) NOT NULL,
	`Name` VARCHAR(128) NOT NULL,
	`About` VARCHAR(4096) NOT NULL,
	`KnownFor` VARCHAR(4096) NOT NULL,
	`Song1Link` VARCHAR(1024) NOT NULL,
	`Song2Link` VARCHAR(1024) NOT NULL,
	`Song3Link` VARCHAR(1024) NOT NULL,
	`ImageName` VARCHAR(128) NOT NULL,
	`Category` VARCHAR(32) NOT NULL
);

CREATE TABLE `Dance` (
	`ArtistID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL
);

CREATE TABLE `Events` (
	`EventID` INT(11) NOT NULL,
	`Name` VARCHAR(255) NOT NULL,
	`Description` text NOT NULL,
	`Date` DATE NOT NULL,
	`Time` TIME NOT NULL,
	`Location` VARCHAR(255) NOT NULL,
	`Price` FLOAT(10, 2) NOT NULL,
	`AvailableTickets` INT(11) NOT NULL
);

CREATE TABLE `Invoices` (
	`InvoiceID` INT(11) NOT NULL,
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`TotalAmount` FLOAT(10, 2) NOT NULL,
	`VAT` FLOAT(10, 2) NOT NULL,
	`InvoiceDate` datetime NOT NULL
);

CREATE TABLE `Jazz` (
	`ArtistID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL
);

CREATE TABLE `Orders` (
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`Status` enum('Pending', 'Paid', 'Cancelled') NOT NULL,
	`CreatedAt` datetime NOT NULL,
	`PaymentMethod` enum('iDEAL', 'CreditCard', 'PayPal') NOT NULL
);

CREATE TABLE `Payments` (
	`PaymentID` INT(11) NOT NULL,
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`Status` enum('Success', 'Failed', 'Pending') NOT NULL,
	`PaymentDate` datetime NOT NULL,
	`Amount` FLOAT(10, 2) NOT NULL,
	`PaymentMethod` enum('iDEAL', 'CreditCard', 'PayPal') NOT NULL
);

CREATE TABLE `ShoppingCart` (
	`CartID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`CreatedAt` datetime NOT NULL
);

CREATE TABLE `ShoppingCartItems` (
	`ItemID` INT(11) NOT NULL,
	`CartID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL,
	`Quantity` INT(11) NOT NULL,
	`AddedAt` datetime NOT NULL
);

CREATE TABLE `Stroll` (
	`EventID` INT(11) NOT NULL,
	`Language` enum('English', 'Dutch', 'Chinese') NOT NULL,
	`Guide` VARCHAR(255) NOT NULL
);

CREATE TABLE `StrollDetail` (
    `EventID` INT(11) NOT NULL,
    `StopNumber` INT(11) NOT NULL,
    `StopName` VARCHAR(255) NOT NULL,
    `Description` text NOT NULL,
	`Adress` VARCHAR(255) NOT NULL,
	`BreakLocation` BOOLEAN NOT NULL
);

CREATE TABLE `Tickets` (
	`TicketID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`QRCode` VARCHAR(255) NOT NULL,
	`Status` enum('Valid', 'Scanned', 'Cancelled') NOT NULL,
	`PurchasedAt` datetime NOT NULL
);

CREATE TABLE `Users` (
	`UserID` INT(11) NOT NULL,
	`Role` enum('Customer', 'Administrator', 'Employee') DEFAULT NULL,
	`Name` VARCHAR(255) NOT NULL,
	`Email` VARCHAR(255) NOT NULL,
	`Password` VARCHAR(255) NOT NULL,
	`Phone` VARCHAR(255) NOT NULL,
	`Country` VARCHAR(255) NOT NULL,
	`RegisteredAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

INSERT INTO
	`Users` (
		`UserID`,
		`Role`,
		`Name`,
		`Email`,
		`Password`,
		`Phone`,
		`Country`,
		`RegisteredAt`
	)
VALUES
	(
		1,
		'Customer',
		'Daniel Zwart',
		'dtzwart@gmail.com',
		'$2y$12$AtD6c5mvh6R1//0TWiAk3uhix4geuIPjWVJiGIuXTwMNm179fQ4HW',
		'0612345678',
		'Netherlands',
		'2025-03-06 12:04:16'
	);

INSERT INTO
	`StrollDetail` (
		`EventID`,
		`StopNumber`,
		`StopName`,
		`Description`,
		`Adress`,
		`BreakLocation`
	)
VALUES
	(1, 1, 'Bavo Church', 'Description 1', 'Grote Markt 22, 2011 RD Haarlem', FALSE),
	(2, 2, 'Grote markt', 'Description 2', 'Grote Markt, 2011 RD Haarlem', FALSE),
	(3, 3, 'De Hallen', 'Description 3', 'Grote Markt 16, 2011 RD Haarlem', FALSE),
	(4, 4, 'Proveniershof', 'Description 4', 'Grote Houtstraat 134, 2011 SV Haarlem', FALSE),
	(5, 5, 'Jopenkerk', 'Description 5', 'Gedempte Voldersgracht 2, 2011 WD Haarlem', TRUE),
	(6, 6, 'Waalse kerk Haarlem', 'Description 6', 'Begijnhof 10, 2011 HE Haarlem', FALSE),
	(7, 7, 'Molen de Adriaan', 'Description 7', 'Papentorenvest 1A, 2011 AV Haarlem', FALSE),
	(8, 8, 'Amsterdamse Poort', 'Description 8' , 'Amsterdamse Poort, 2011 AV Haarlem', FALSE),
	(9, 9, 'Hof van Bakenes', 'Description 9' , 'Warmoesstraat 13, 2011 HN Haarlem', FALSE);


CREATE TABLE `Yummie` (
	`EventID` INT(11) NOT NULL,
	`StarRating` INT(11) NOT NULL,
	`Cuisine` VARCHAR(255) NOT NULL
);



ALTER TABLE `Artists` ADD PRIMARY KEY (`ArtistID`);

ALTER TABLE `Events` ADD PRIMARY KEY (`EventID`);

ALTER TABLE `Invoices` ADD PRIMARY KEY (`InvoiceID`);

ALTER TABLE `Orders` ADD PRIMARY KEY (`OrderID`);

ALTER TABLE `Payments` ADD PRIMARY KEY (`PaymentID`);

ALTER TABLE `ShoppingCart` ADD PRIMARY KEY (`CartID`);

ALTER TABLE `ShoppingCartItems` ADD PRIMARY KEY (`ItemID`);

ALTER TABLE `Tickets` ADD PRIMARY KEY (`TicketID`);

ALTER TABLE `Users` ADD PRIMARY KEY (`UserID`), ADD UNIQUE KEY `Email` (`Email`);

ALTER TABLE `StrollDetail` ADD PRIMARY KEY (`EventID`);



ALTER TABLE `Artists` MODIFY `ArtistID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Events` MODIFY `EventID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Invoices` MODIFY `InvoiceID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Orders` MODIFY `OrderID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Payments` MODIFY `PaymentID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ShoppingCart` MODIFY `CartID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ShoppingCartItems` MODIFY `ItemID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Tickets` MODIFY `TicketID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Users` MODIFY `UserID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 2;

ALTER TABLE `StrollDetail` MODIFY `EventID` INT(11) NOT NULL AUTO_INCREMENT;



ALTER TABLE `Dance` ADD FOREIGN KEY (`ArtistID`) REFERENCES `Artists`(`ArtistID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Dance` ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Invoices` ADD FOREIGN KEY (`OrderID`) REFERENCES `Orders`(`OrderID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Invoices` ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Jazz` ADD FOREIGN KEY (`ArtistID`) REFERENCES `Artists`(`ArtistID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Jazz` ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Orders` ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Payments` ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Payments` ADD FOREIGN KEY (`OrderID`) REFERENCES `Orders`(`OrderID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `ShoppingCart` ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `ShoppingCartItems` ADD FOREIGN KEY (`CartID`) REFERENCES `ShoppingCart`(`CartID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `ShoppingCartItems` ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Stroll` ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Tickets` ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Tickets` ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Yummie` ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`) ON DELETE RESTRICT ON UPDATE RESTRICT;