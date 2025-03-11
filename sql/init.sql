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
    `Guide` VARCHAR(255) NOT NULL,
    `FamilyTicketPrice` FLOAT(10, 2) NOT NULL,
    `AvailableTickets` INT(11) NOT NULL
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
	`RegisteredAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	`ResetToken` VARCHAR(255) DEFAULT NULL,
	`ResetTokenExpiration` datetime DEFAULT NULL
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
    (1, 1, 'Bavo Church', 
    'The Grote of Sint-Bavokerk, commonly known as the Bavo Church, is a prominent and historically significant landmark located in the heart of Haarlem\'s city center. This magnificent structure stands as a testament to Haarlem\'s rich history and architectural heritage. Built in the Gothic style, the church\'s towering presence and intricate design make it a focal point of the cityscape, drawing visitors from around the world.

    The church as it stands today was completed in 1479, though its history stretches back much further. The site originally housed a smaller church constructed in 1307, which served as a place of worship for the local community. Tragically, this earlier church was destroyed in a fire during the 14th century, a common hazard in medieval times. Determined to rebuild, the people of Haarlem embarked on a significant reconstruction effort, leading to the creation of the current church, which has since become an iconic symbol of resilience and continuity.

    The Grote Kerk underwent substantial renovations in the 15th century, which solidified its position as Haarlem\'s main church and a central hub for religious and cultural activities. Its Gothic architecture is characterized by soaring vaulted ceilings, intricate stonework, and large stained-glass windows that flood the interior with colorful light. These features not only reflect the artistic and architectural prowess of the time but also convey a sense of awe and reverence to all who enter.

    Beyond its architectural beauty, the church holds immense cultural and historical importance for Haarlem. It has served as a gathering place for centuries, hosting significant religious ceremonies, civic events, and concerts. Its majestic organ, constructed by Christian Müller in 1738, is one of the most famous in the world and has been played by celebrated musicians, including Wolfgang Amadeus Mozart and George Frideric Handel.

    Today, the Bavo Church continues to be a vital part of Haarlem\'s identity, offering a connection to the city\'s past while remaining a vibrant venue for modern events. Visitors can explore its storied halls, admire the detailed craftsmanship, and learn about its pivotal role in Haarlem\'s history. It stands not only as a place of worship but also as a cultural and historical treasure, embodying the spirit and resilience of the city through the ages.',
    'Grote Markt 22, 2011 RD Haarlem', FALSE),
    (2, 2, 'Grote markt', 'Description 2', 'Grote Markt, 2011 RD Haarlem', FALSE),
    (3, 3, 'De Hallen', 'Description 3', 'Grote Markt 16, 2011 RD Haarlem', FALSE),
    (4, 4, 'Proveniershof', 'Description 4', 'Grote Houtstraat 134, 2011 SV Haarlem', FALSE),
    (5, 5, 'Jopenkerk', 'Description 5', 'Gedempte Voldersgracht 2, 2011 WD Haarlem', TRUE),
    (6, 6, 'Waalse kerk Haarlem', 'Description 6', 'Begijnhof 10, 2011 HE Haarlem', FALSE),
    (7, 7, 'Molen de Adriaan', 'Description 7', 'Papentorenvest 1A, 2011 AV Haarlem', FALSE),
    (8, 8, 'Amsterdamse Poort', 'Description 8', 'Amsterdamse Poort, 2011 AV Haarlem', FALSE),
    (9, 9, 'Hof van Bakenes', 'Description 9', 'Warmoesstraat 13, 2011 HN Haarlem', FALSE);


INSERT INTO `Events` (`EventID`, `Name`, `Description`, `Date`, `Time`, `Location`, `Price`, `AvailableTickets`)
VALUES
(1, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-03', '10:00:00', 'Grote Markt, Haarlem', 15.00, 50),
(2, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-03', '14:00:00', 'Grote Markt, Haarlem', 20.00, 40),
(3, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-03', '20:00:00', 'Grote Markt, Haarlem', 18.00, 30),
(4, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-06', '11:00:00', 'Grote Markt, Haarlem', 25.00, 25),
(5, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-05', '13:00:00', 'Grote Markt, Haarlem', 30.00, 20),
(6, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-06', '15:00:00', 'Grote Markt, Haarlem', 35.00, 15),
(7, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-05', '21:00:00', 'Grote Markt, Haarlem', 22.00, 10),
(8, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-03', '12:00:00', 'Grote Markt, Haarlem', 27.00, 5),
(9, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-04-06', '14:00:00', 'Grote Markt, Haarlem', 32.00, 0);



INSERT INTO `Stroll` (`EventID`, `Language`, `Guide`, `FamilyTicketPrice`, `AvailableTickets`)
VALUES
(1, 'English', 'John Doe', 50.00, 50),
(2, 'Dutch', 'Jane Smith', 60.00, 40),
(3, 'English', 'Alice Johnson', 55.00, 30),
(4, 'Dutch', 'Bob Brown', 65.00, 25),
(5, 'English', 'Charlie Davis', 70.00, 20),
(6, 'Chinese', 'Eva White', 75.00, 15),
(7, 'English', 'Frank Wilson', 80.00, 10),
(8, 'Chinese', 'Grace Lee', 85.00, 5),
(9, 'English', 'Henry Clark', 90.00, 0);


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

