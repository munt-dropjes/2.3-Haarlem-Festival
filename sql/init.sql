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
	`Category` VARCHAR(32) NOT NULL,
	`BannerImage` VARCHAR(128) NOT NULL
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

	`StartTime` TIME  NULL,
	`EndTime` TIME  NULL,
	`Time` TIME  NULL,

	`Time` TIME DEFAULT NULL,
	`Duration` INT(11) DEFAULT NULL,

	`Location` VARCHAR(255) NOT NULL,
	`Price` FLOAT(10, 2) NOT NULL,
	`AvailableTickets` INT(11) NOT NULL,
	`ImageName` VARCHAR(128) NOT NULL,
	`Category` enum('Jazz','Yummy','Dance','A Stroll through History','Magic@Teylers','Stories in Haarlem') DEFAULT NULL
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
    `FamilyTicketPrice` FLOAT(10, 2) NOT NULL
);

CREATE TABLE `StrollDetail` (
    `EventID` INT(11) NOT NULL,
    `StopNumber` INT(11) NOT NULL,
    `StopName` VARCHAR(255) NOT NULL,
    `Description` text NOT NULL,
	`Adress` VARCHAR(255) NOT NULL,
	`BreakLocation` BOOLEAN NOT NULL,
	`mapName` VARCHAR(255) NOT NULL
);

CREATE TABLE `Tickets` (
	`TicketID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`QRCode` VARCHAR(255) NOT NULL,
	`Status` enum('Valid', 'Scanned', 'Cancelled') NOT NULL,
	`PurchasedAt` datetime NOT NULL,
	`PaymentStatus'` enum('Completed', 'Failed', 'Pending') NOT NULL
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
		'Administrator',
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
        `BreakLocation`,
		`mapName`
    )
VALUES
    (1, 1, 'Bavo Church', 
    'The Grote of Sint-Bavokerk, commonly known as the Bavo Church, is a prominent and historically significant landmark located in the heart of Haarlem\'s city center. This magnificent structure stands as a testament to Haarlem\'s rich history and architectural heritage. Built in the Gothic style, the church\'s towering presence and intricate design make it a focal point of the cityscape, drawing visitors from around the world.

    The church as it stands today was completed in 1479, though its history stretches back much further. The site originally housed a smaller church constructed in 1307, which served as a place of worship for the local community. Tragically, this earlier church was destroyed in a fire during the 14th century, a common hazard in medieval times. Determined to rebuild, the people of Haarlem embarked on a significant reconstruction effort, leading to the creation of the current church, which has since become an iconic symbol of resilience and continuity.

    The Grote Kerk underwent substantial renovations in the 15th century, which solidified its position as Haarlem\'s main church and a central hub for religious and cultural activities. Its Gothic architecture is characterized by soaring vaulted ceilings, intricate stonework, and large stained-glass windows that flood the interior with colorful light. These features not only reflect the artistic and architectural prowess of the time but also convey a sense of awe and reverence to all who enter.

    Beyond its architectural beauty, the church holds immense cultural and historical importance for Haarlem. It has served as a gathering place for centuries, hosting significant religious ceremonies, civic events, and concerts. Its majestic organ, constructed by Christian Müller in 1738, is one of the most famous in the world and has been played by celebrated musicians, including Wolfgang Amadeus Mozart and George Frideric Handel.

    Today, the Bavo Church continues to be a vital part of Haarlem\'s identity, offering a connection to the city\'s past while remaining a vibrant venue for modern events. Visitors can explore its storied halls, admire the detailed craftsmanship, and learn about its pivotal role in Haarlem\'s history. It stands not only as a place of worship but also as a cultural and historical treasure, embodying the spirit and resilience of the city through the ages.',
    'Grote Markt 22, 2011 RD Haarlem', FALSE, 'map.png'),
    (2, 2, 'Grote markt', 'Description 2', 'Grote Markt, 2011 RD Haarlem', FALSE, 'map.png'),
    (3, 3, 'De Hallen', 'Description 3', 'Grote Markt 16, 2011 RD Haarlem', FALSE, 'map.png'),
    (4, 4, 'Proveniershof', 'Description 4', 'Grote Houtstraat 134, 2011 SV Haarlem', FALSE, 'map.png'),
    (5, 5, 'Jopenkerk', 'Description 5', 'Gedempte Voldersgracht 2, 2011 WD Haarlem', TRUE, 'map.png'),
    (6, 6, 'Waalse kerk Haarlem', 'Description 6', 'Begijnhof 10, 2011 HE Haarlem', FALSE,'map.png'),
    (7, 7, 'Molen de Adriaan', 'Description 7', 'Papentorenvest 1A, 2011 AV Haarlem', FALSE, 'map.png'),
    (8, 8, 'Amsterdamse Poort', 'Description 8', 'Amsterdamse Poort, 2011 AV Haarlem', FALSE, 'map.png'),
    (9, 9, 'Hof van Bakenes', 'Description 9', 'Warmoesstraat 13, 2011 HN Haarlem', FALSE, 'map.png');

INSERT INTO `Artists` (`ArtistID`, `Name`, `About`, `KnownFor`, `Song1Link`, `Song2Link`, `Song3Link`, `ImageName`, `Category`, `BannerImage`)
VALUES
(1, 'Hardwell', 'Hardwell, real name Robert van de Corbo, is a world-famous DJ and music producer from the Netherlands. Known for his energetic performances and music hits like \"Spaceman\" and \"Apollo\", he has dominated the DJ Mag Top 100 charts for years. Hardwell also founded his own label, Revealed Recordings, and after a short break he is back stronger than ever, ready to conquer the electronic music world.', 'Hardwell is most recognized for his big room house anthems and electrifying festival sets. Tracks like \"Spaceman\" and \"Apollo\" have become dance music classics, solidifying his place as one of the genre’s greatest performers.', '6jmTQwFzejCurofZDz7x9k', '4cYrCTMjUzdFvMT9XcMXYu', '3Nnq6YSHQ5LwRKkioGIjhb', 'hardwell.png', 'Dance', '0');

INSERT INTO `Dance` (`ArtistID`, `EventID`)
VALUES
(1, 10),
(1, 11);

INSERT INTO `Events` (`EventID`, `Name`, `Description`, `Date`, `Time`, `Duration`, `Location`, `Price`, `AvailableTickets`, `ImageName`, `Category`)
VALUES
(1, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-24', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(2, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-24', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(3, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-24', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(4, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-24', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(5, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-24', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(6, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-24', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(7, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(8, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(9, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(10, 'Caprera Openluchttheater', 'Harwell\r\nMartin Garrix\r\nArmin van Buuren', '2025-03-15', '14:00:00', 540, 'Caprera Openluchttheater', 110.00, 2000, 'Caprera_Openluchttheater.png', 'Dance'),
(11, 'Jopenkerk', 'Harwell\r\nMartin Garrix\r\nArmin van Buuren', '2025-03-14', '23:00:00', 90, 'Jopenkerk', 60.00, 300, 'Jopenkerk.png', 'Dance'),
(12, 'Test', 'Test', '2025-03-14', '23:00:00', 90, 'Test', 60.00, 300, 'Jopenkerk.png', NULL),
(13, 'All Access Pass', 'Grants entry to all events on Friday, Saturday, and Sunday', '2025-07-04', '00:00:00', 0, 'Festival Grounds', 120.00, 300, 'dance-festival.png', 'Dance'),
(14, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(15, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(16, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(17, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-25', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(18, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(19, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(20, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(21, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(22, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(23, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(24, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(25, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(26, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(27, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(28, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(29, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-26', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(30, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(31, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(32, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(33, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(34, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(35, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(36, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(37, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(38, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(39, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(40, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(41, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '16:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(42, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '10:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(43, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History'),
(44, 'Stroll through history', 'Explore the beautiful city of Haarlem with a guided walk.', '2025-07-27', '13:00:00', 0, 'Grote Markt, Haarlem', 17.50, 12, 'Stroll_through_history.png', 'A Stroll through History');




INSERT INTO `Stroll` (`EventID`, `Language`, `Guide`, `FamilyTicketPrice`)
VALUES
(1, 'English', 'Frederick', 60.00),
(2, 'English', 'Frederick', 60.00),
(3, 'English', 'Frederick', 60.00),
(4, 'Dutch', 'Jan-Willem', 60.00),
(5, 'Dutch', 'Jan-Willem', 60.00),
(6, 'Dutch', 'Jan-Willem', 60.00),
(7, 'English', 'William', 60.00),
(8, 'English', 'William', 60.00),
(9, 'English', 'William', 60.00),
(14, 'Dutch', 'Annet', 60.00),
(15, 'Dutch', 'Annet', 60.00),
(16, 'Dutch', 'Annet', 60.00),
(17, 'Chinese', 'Kim', 60.00),
(18, 'English', 'Frederick', 60.00),
(19, 'English', 'William', 60.00),
(20, 'English', 'Frederick', 60.00),
(21, 'English', 'William', 60.00),
(22, 'English', 'William', 60.00),
(23, 'Dutch', 'Jan-Willem', 60.00),
(24, 'Dutch', 'Annet', 60.00),
(25, 'Dutch', 'Jan-Willem', 60.00),
(26, 'Dutch', 'Annet', 60.00),
(27, 'Dutch', 'Annet', 60.00),
(28, 'Chinese', 'Kim', 60.00),
(29, 'Chinese', 'Kim', 60.00),
(30, 'English', 'Frederick', 60.00),
(31, 'English', 'William', 60.00),
(32, 'English', 'Frederick', 60.00),
(33, 'English', 'William', 60.00),
(34, 'English', 'Deirdre', 60.00),
(35, 'English', 'Frederick', 60.00),
(36, 'Dutch', 'Jan-Willem', 60.00),
(37, 'Dutch', 'Annet', 60.00),
(38, 'Dutch', 'Jan-Willem', 60.00),
(39, 'Dutch', 'Annet', 60.00),
(40, 'Dutch', 'Lisa', 60.00),
(41, 'Dutch', 'Jan-Willem', 60.00),
(42, 'Chinese', 'Kim', 60.00),
(43, 'Chinese', 'Kim', 60.00),
(44, 'Chinese', 'Susan', 60.00);


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

