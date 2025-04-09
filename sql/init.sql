START TRANSACTION;

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
	`StartTime` DATETIME NULL,
	`EndTime` DATETIME NULL,
	`Location` VARCHAR(255) NOT NULL,
	`Price` DECIMAL(10, 2) NOT NULL,
	`AvailableTickets` INT(11) NOT NULL,
	`ImageName` VARCHAR(128) NOT NULL,
	`Category` enum(
		'Jazz',
		'Yummy',
		'Dance',
		'A Stroll through History',
		'Magic@Teylers',
		'Stories in Haarlem'
	) DEFAULT NULL
);

CREATE TABLE `Invoices` (
	`InvoiceID` INT(11) NOT NULL,
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`TotalAmount` DECIMAL(10, 2) NOT NULL,
	`VAT` DECIMAL(10, 2) NOT NULL,
	`InvoiceDate` datetime NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `Jazz` (
	`ArtistID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL
);

CREATE TABLE `Orders` (
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`Status` enum('Pending', 'Paid', 'Cancelled') NOT NULL,
	`CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
	`PaymentMethod` enum('iDEAL', 'CreditCard', 'PayPal') NOT NULL
);

CREATE TABLE `Payments` (
	`PaymentID` INT(11) NOT NULL,
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`Status` enum('Success', 'Failed', 'Pending') NOT NULL,
	`PaymentDate` datetime NOT NULL,
	`Amount` DECIMAL(10, 2) NOT NULL,
	`PaymentMethod` enum('iDEAL', 'CreditCard', 'PayPal') NOT NULL
);

CREATE TABLE `ShoppingCart` (
	`CartID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`CreatedAt` datetime NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `ShoppingCartItems` (
	`ItemID` INT(11) NOT NULL,
	`CartID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL,
	`Quantity` INT(11) NOT NULL,
	`Selected` TINYINT(1) NOT NULL DEFAULT 0,
	`isFamilyTicket` TINYINT(1) NOT NULL DEFAULT 0,
	`AddedAt` datetime NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `Stroll` (
	`EventID` INT(11) NOT NULL,
	`Language` enum('English', 'Dutch', 'Chinese') NOT NULL,
	`Guide` VARCHAR(255) NOT NULL,
	`FamilyTicketPrice` DECIMAL(10, 2) NOT NULL
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

Create Table `PurchasedTickets` (
	`id` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL,
	`UserId` INT(11) NOT NULL,
	`Quantity` INT(11) NOT NULL,
	`PurchasedAt` datetime NOT NULL DEFAULT current_timestamp()
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

CREATE TABLE `menu_items` (
	`id` INT(11) NOT NULL,
	`restaurant_id` INT(11) NOT NULL,
	`category` VARCHAR(225) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`description` text NOT NULL
);

CREATE TABLE `restaurants` (
	`id` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`rating` INT(11) NOT NULL,
	`seats` INT(11) NOT NULL,
	`cuisine` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
	`open_time` VARCHAR(255) NOT NULL,
	`close_time` VARCHAR(255) NOT NULL,
	`cost` DECIMAL(10,2) NOT NULL,
	`image` VARCHAR(255) NOT NULL,
	`duration` DECIMAL NOT NULL,
	`sessions` INT(11) NOT NULL,
	`address` VARCHAR(255) DEFAULT NULL,
	`city` VARCHAR(255) DEFAULT NULL,
	`zipcode` VARCHAR(255) DEFAULT NULL,
	`map_link` text DEFAULT NULL,
	`extra_info_menu` text NOT NULL
);

CREATE TABLE `restaurant_images` (
	`id` INT(11) NOT NULL,
	`restaurant_id` INT(11) NOT NULL,
	`image_path` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE `restaurant_reservations` (
	`id` INT(11) NOT NULL,
	`restaurant_id` INT(11) NOT NULL,
	`adults` INT(11) NOT NULL,
	`children` INT(11) NOT NULL,
	`day` VARCHAR(255) NOT NULL,
	`start_time` VARCHAR(255) NOT NULL,
	`extra_information` text NOT NULL,
	`total_price` DECIMAL(10,2) NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `Yummie` (
	`RestaurantID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL
);




ALTER TABLE `Events`
	ADD PRIMARY KEY (`EventID`),
	MODIFY `EventID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Artists`
	ADD PRIMARY KEY (`ArtistID`),
	MODIFY `ArtistID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `StrollDetail`
	ADD PRIMARY KEY (`EventID`),
	MODIFY `EventID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `restaurants`
	ADD PRIMARY KEY (`id`),
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Users`
	ADD PRIMARY KEY (`UserID`),
	MODIFY `UserID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD UNIQUE KEY `Email` (`Email`);

ALTER TABLE `Tickets`
	ADD PRIMARY KEY (`TicketID`),
	MODIFY `TicketID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`),
	ADD FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

ALTER TABLE `PurchasedTickets`
	ADD PRIMARY KEY (`id`),
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`),
  	ADD FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserID`);

ALTER TABLE `Orders`
	ADD PRIMARY KEY (`OrderID`),
	MODIFY `OrderID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`);

ALTER TABLE `Invoices`
	ADD PRIMARY KEY (`InvoiceID`),
	MODIFY `InvoiceID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`OrderID`) REFERENCES `Orders`(`OrderID`),
	ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`);

ALTER TABLE `Payments`
	ADD PRIMARY KEY (`PaymentID`),
	MODIFY `PaymentID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`),
	ADD FOREIGN KEY (`OrderID`) REFERENCES `Orders`(`OrderID`);

ALTER TABLE `menu_items`
	ADD PRIMARY KEY (`id`),
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	ADD KEY `FOREIGN KEY` (`restaurant_id`),
	ADD FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

ALTER TABLE `restaurant_images`
	ADD PRIMARY KEY (`id`),
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	ADD KEY `restaurant_id` (`restaurant_id`),
	ADD FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

ALTER TABLE `restaurant_reservations`
	ADD PRIMARY KEY (`id`),
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	ADD KEY `FOREIGHN kEY` (`restaurant_id`),
	ADD FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

ALTER TABLE `ShoppingCart`
	ADD PRIMARY KEY (`CartID`),
	MODIFY `CartID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`);

ALTER TABLE `ShoppingCartItems`
	ADD PRIMARY KEY (`ItemID`),
	MODIFY `ItemID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`CartID`) REFERENCES `ShoppingCart`(`CartID`),
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`);

ALTER TABLE `Yummie`
	ADD FOREIGN KEY (`RestaurantID`) REFERENCES `restaurants`(`id`),
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`);

ALTER TABLE `Dance`
	ADD FOREIGN KEY (`ArtistID`) REFERENCES `Artists`(`ArtistID`),
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`);

ALTER TABLE `Jazz`
	ADD FOREIGN KEY (`ArtistID`) REFERENCES `Artists`(`ArtistID`),
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`);

ALTER TABLE `Stroll`
	ADD FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventID`);




INSERT INTO `Users` 
	(`UserID`, `Role`, `Name`, `Email`, `Password`, `Phone`, `Country`, `RegisteredAt`)
VALUES
	(1, 'Administrator', 'Daniel Zwart', 'dtzwart@gmail.com', '$2y$12$AtD6c5mvh6R1//0TWiAk3uhix4geuIPjWVJiGIuXTwMNm179fQ4HW', '0612345678', 'Netherlands', '2025-03-06 12:04:16');

INSERT INTO `StrollDetail`
	(`EventID`, `StopNumber`, `StopName`, `Description`, `Adress`, `BreakLocation`, `mapName`)
VALUES
	(
		1,
		1,
		'Bavo Church',
		'The <strong>Grote of Sint-Bavokerk</strong>, commonly known as the <strong>Bavo Church</strong>, is a <strong>prominent and historically significant landmark</strong> located in the heart of Haarlem''s city center. This magnificent structure stands as a testament to Haarlem''s <strong>rich history and architectural heritage</strong>. Built in the <strong>Gothic style</strong>, the church''s towering presence and intricate design make it a <strong>focal point</strong> of the cityscape, drawing visitors from around the world.<br><br>

   		 The church as it stands today was <strong>completed in 1479</strong>, though its history stretches back much further. The site originally housed a <strong>smaller church constructed in 1307</strong>, which served as a place of worship for the local community. Tragically, this earlier church was <strong>destroyed in a fire during the 14th century</strong>, a common hazard in medieval times. Determined to rebuild, the people of Haarlem embarked on a <strong>significant reconstruction effort</strong>, leading to the creation of the current church, which has since become an <strong>iconic symbol of resilience and continuity</strong>.<br><br>

   		 The Grote Kerk underwent <strong>substantial renovations in the 15th century</strong>, which solidified its position as Haarlem''s <strong>main church</strong> and a <strong>central hub for religious and cultural activities</strong>. Its <strong>Gothic</strong> architecture is characterized by <strong>soaring vaulted ceilings</strong>, <strong>intricate stonework</strong>, and <strong>large stained-glass windows</strong> that flood the interior with colorful light. These features not only reflect the <strong>artistic and architectural prowess of the time</strong> but also convey a <strong>sense of awe and reverence</strong> to all who enter.<br><br>

   		 Beyond its architectural beauty, the church holds immense <strong>cultural and historical importance</strong> for Haarlem. It has served as a <strong>gathering place for centuries</strong>, hosting significant <strong>religious ceremonies</strong>, <strong>civic events</strong>, and <strong>concerts</strong>. Its <strong>majestic organ</strong>, constructed by <strong>Christian Müller in 1738</strong>, is one of the most famous in the world and has been played by celebrated musicians, including <strong>Wolfgang Amadeus Mozart</strong> and <strong>George Frideric Handel</strong>. <br><br>

   		 Today, the Bavo Church continues to be a <strong>vital part</strong> of Haarlem''s identity, offering a <strong>connection to the city''s past</strong> while remaining a <strong>vibrant venue for modern events</strong>. Visitors can explore its <strong>storied halls</strong>, admire the <strong>detailed craftsmanship</strong>, and learn about its <strong>pivotal role in Haarlem''s history</strong>. It stands not only as a place of worship but also as a <strong>cultural and historical treasure</strong>, embodying the <strong>spirit and resilience</strong> of the city through the ages.',
		'Grote Markt 22, 2011 RD Haarlem',
		FALSE,
		'map.png'
	),
	(
		2,
		2,
		'Grote markt',
		'The <strong>Grote Markt</strong>, Haarlem''s <strong>central square</strong>, is a <strong>vibrant and historically rich location</strong> that has served as the <strong>beating heart of the city</strong> for centuries. Surrounded by <strong>stunning architecture</strong> and steeped in history, the Grote Markt is not only a <strong>bustling hub of activity</strong> but also a key symbol of Haarlem''s <strong>cultural and economic significance</strong>.

        Dating back to the <strong>Middle Ages</strong>, the square emerged as a <strong>central marketplace</strong> where merchants and residents gathered to <strong>trade goods</strong>, <strong>share news</strong>, and <strong>celebrate communal events</strong>. Its <strong>strategic position</strong> made it an essential meeting point in Haarlem, fostering the city''s growth as a <strong>regional trading and cultural center</strong>. Over time, the Grote Markt became surrounded by <strong>iconic buildings</strong> that reflect Haarlem''s <strong>rich history and architectural evolution</strong>. <br><br>

        One of the square''s most notable features is the <strong>Grote or Sint-Bavokerk</strong>, which <strong>dominates its skyline</strong> with its <strong>Gothic spire</strong>. The church stands as a <strong>stunning backdrop</strong> to the market, enhancing the square''s historic charm. Another significant building is the <strong>Stadhuis (City Hall)</strong>, an elegant structure that originated as a <strong>medieval count''s residence</strong> before being repurposed as Haarlem''s <strong>administrative center</strong>. Its mix of <strong>Gothic and Renaissance elements</strong> showcases the <strong>architectural diversity</strong> surrounding the square. <br><br>

        The Vleeshal, a striking example of Dutch Renaissance architecture, is another highlight of the Grote Markt. Once a guild hall for butchers, it now serves as an art museum, reflecting the square''s ability to adapt to modern cultural needs while preserving its historical significance. Together, these buildings create a harmonious blend of history and artistry, making the Grote Markt a visual feast for visitors. <br><br>

        Throughout its history, the Grote Markt has been a <strong>stage for significant events</strong>. From <strong>medieval festivals</strong> and <strong>public gatherings</strong> to markets that <strong>continue to this day</strong>, the square has always been a <strong>lively center of Haarlem''s community life</strong>. It remains a popular venue for <strong>seasonal events</strong>, including the <strong>weekly market</strong>, the <strong>annual Christmas market</strong>, and <strong>cultural festivals</strong>, which attract both locals and tourists. <br><br>

        Today, the Grote Markt is a <strong>lively space</strong> where <strong>history and modernity meet</strong>. Cafés and restaurants with outdoor terraces line its edges, offering visitors a chance to <strong>relax while soaking in the atmosphere</strong> of this historic square. Whether it’s the <strong>sounds of street performers</strong>, the <strong>sights of its majestic buildings</strong>, or the <strong>flavors of its vibrant market stalls</strong>, the Grote Markt encapsulates the essence of Haarlem''s <strong>charm and vitality</strong>, making it a <strong>must-visit destination</strong> in the city.',
		'Grote Markt, 2011 RD Haarlem',
		FALSE,
		'map.png'
	),
	(
		3,
		3,
		'De Hallen',
		'Description 3',
		'Grote Markt 16, 2011 RD Haarlem',
		FALSE,
		'map.png'
	),
	(
		4,
		4,
		'Proveniershof',
		'Description 4',
		'Grote Houtstraat 134, 2011 SV Haarlem',
		FALSE,
		'map.png'
	),
	(
		5,
		5,
		'Jopenkerk',
		'Description 5',
		'Gedempte Voldersgracht 2, 2011 WD Haarlem',
		TRUE,
		'map.png'
	),
	(
		6,
		6,
		'Waalse kerk Haarlem',
		'Description 6',
		'Begijnhof 10, 2011 HE Haarlem',
		FALSE,
		'map.png'
	),
	(
		7,
		7,
		'Molen de Adriaan',
		'Description 7',
		'Papentorenvest 1A, 2011 AV Haarlem',
		FALSE,
		'map.png'
	),
	(
		8,
		8,
		'Amsterdamse Poort',
		'Description 8',
		'Amsterdamse Poort, 2011 AV Haarlem',
		FALSE,
		'map.png'
	),
	(
		9,
		9,
		'Hof van Bakenes',
		'Description 9',
		'Warmoesstraat 13, 2011 HN Haarlem',
		FALSE,
		'map.png'
	);

INSERT INTO `Artists`
	(`ArtistID`, `Name`, `About`, `KnownFor`, `Song1Link`, `Song2Link`, `Song3Link`, `ImageName`, `Category`, `BannerImage`)
VALUES
	(
		1,
		'Hardwell',
		'Hardwell, real name Robert van de Corbo, is a world-famous DJ and music producer from the Netherlands. Known for his energetic performances and music hits like \"Spaceman\" and \"Apollo\", he has dominated the DJ Mag Top 100 charts for years. Hardwell also founded his own label, Revealed Recordings, and after a short break he is back stronger than ever, ready to conquer the electronic music world.',
		'Hardwell is most recognized for his big room house anthems and electrifying festival sets. Tracks like \"Spaceman\" and \"Apollo\" have become dance music classics, solidifying his place as one of the genre’s greatest performers.',
		'6jmTQwFzejCurofZDz7x9k',
		'4cYrCTMjUzdFvMT9XcMXYu',
		'3Nnq6YSHQ5LwRKkioGIjhb',
		'dance/hardwell.png',
		'Dance',
		'dance/Hardwell dj.png'
	);

INSERT INTO `Events`
	(`EventID`, `Name`, `Description`, `StartTime`, `EndTime`, `Location`, `Price`, `AvailableTickets`, `ImageName`, `Category`)
VALUES
	(
		1,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-24 10:00:00',
		'2025-07-24 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		2,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-24 13:00:00',
		'2025-07-24 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		3,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-24 16:00:00',
		'2025-07-24 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		4,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-24 10:00:00',
		'2025-07-24 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		5,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-24 13:00:00',
		'2025-07-24 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		6,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-24 16:00:00',
		'2025-07-24 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		7,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 10:00:00',
		'2025-07-25 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		8,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 13:00:00',
		'2025-07-25 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		9,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 16:00:00',
		'2025-07-25 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		10,
		'Caprera Openluchttheater',
		'Harwell\r\nMartin Garrix\r\nArmin van Buuren',
		'2025-03-15 14:00:00',
		'2025-03-15 23:00:00',
		'Caprera Openluchttheater',
		110.00,
		2000,
		'dance/Caprera_Openluchttheater.png',
		'Dance'
	),
	(
		11,
		'Jopenkerk',
		'Harwell\r\nMartin Garrix\r\nArmin van Buuren',
		'2025-03-14 23:00:00',
		'2025-03-15 00:30:00',
		'Jopenkerk',
		60.00,
		300,
		'dance/Jopenkerk.png',
		'Dance'
	),
	(
		12,
		'Test',
		'Test',
		'2025-03-14 23:00:00',
		'2025-03-15 00:30:00',
		'Test',
		60.00,
		300,
		'dance/Jopenkerk.png',
		'Dance'
	),
	(
		13,
		'All Access Pass',
		'Grants entry to all events on Friday, Saturday, and Sunday',
		'2025-07-04 00:00:00',
		'2025-07-04 00:00:00',
		'Festival Grounds',
		120.00,
		300,
		'dance/dance-festival.png',
		'Dance'
	),
	(
		14,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 10:00:00',
		'2025-07-25 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		15,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 13:00:00',
		'2025-07-25 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		16,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 16:00:00',
		'2025-07-25 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		17,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-25 13:00:00',
		'2025-07-25 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		18,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 10:00:00',
		'2025-07-26 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		19,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 10:00:00',
		'2025-07-26 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		20,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 13:00:00',
		'2025-07-26 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		21,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 13:00:00',
		'2025-07-26 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		22,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 16:00:00',
		'2025-07-26 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		23,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 10:00:00',
		'2025-07-26 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		24,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 10:00:00',
		'2025-07-26 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		25,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 13:00:00',
		'2025-07-26 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		26,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 13:00:00',
		'2025-07-26 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		27,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 16:00:00',
		'2025-07-26 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		28,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 13:00:00',
		'2025-07-26 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		29,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-26 16:00:00',
		'2025-07-26 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		30,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 10:00:00',
		'2025-07-27 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		31,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 10:00:00',
		'2025-07-27 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		32,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		33,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		34,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		35,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 16:00:00',
		'2025-07-27 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		36,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 10:00:00',
		'2025-07-27 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		37,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 10:00:00',
		'2025-07-27 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		38,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		39,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		40,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		41,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 16:00:00',
		'2025-07-27 16:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		42,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 10:00:00',
		'2025-07-27 10:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		43,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	),
	(
		44,
		'Stroll through history',
		'Explore the beautiful city of Haarlem with a guided walk.',
		'2025-07-27 13:00:00',
		'2025-07-27 13:00:00',
		'Grote Markt, Haarlem',
		17.50,
		12,
		'Stroll_through_history.png',
		'A Stroll through History'
	);

INSERT INTO `Dance`
	(`ArtistID`, `EventID`)
VALUES
	(1, 10),
	(1, 11);

INSERT INTO `Stroll`
	(`EventID`, `Language`, `Guide`, `FamilyTicketPrice`)
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

INSERT INTO `restaurants` (
		`id`,
		`name`,
		`rating`,
		`seats`,
		`cuisine`,
		`open_time`,
		`close_time`,
		`cost`,
		`image`,
		`duration`,
		`sessions`,
		`address`,
		`city`,
		`zipcode`,
		`map_link`,
		`extra_info_menu`
	)
VALUES
	(1, 'Café de Roemer', 4, 35, '[\"Dutch\", \"Fish and seafood\", \"European\"]', '18:30', '23:00', 35, 'cafe-roemer.jpg', 1.5, 3, 'Botermarkt 17', 'Haarlem', '2011 XL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4870.956489095403!2d4.629297576183683!3d52.37988014659486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6ad50d053b%3A0x9f83720b021b43f2!2sCaf%C3%A9%20de%20Roemer!5e0!3m2!1snl!2snl!4v1741031476025!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €35,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €17,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!'),
	(2, 'Ratatouille', 4, 52, '[\"French\", \"Fish and seafood\", \"European\"]', '17:00', '23:00', 45, 'ratatouille.jpg', 2, 3, 'Spaarne 96', 'Haarlem', '2011 CL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4871.087550997948!2d4.634927276183602!3d52.37869204668252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6bd9e573fb%3A0x8c3546c16902f0f2!2sRatatouille%20Food%20%26%20Wine!5e0!3m2!1snl!2snl!4v1741031660132!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €45,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €22,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!'),
	(3, 'Restaurant ML', 4, 60, '[\"Dutch\", \"Fish and seafood\", \"European\"]', '17:00', '21:00', 45, 'restaurant-ml.jpg', 2, 2, 'Kleine Houtstraat 70', 'Haarlem', '2011 DR', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.594816219705!2d4.633010476183523!3d52.377766646750985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6a7004c319%3A0x76af8a5ed45166c3!2sKleine%20Houtstraat%2070%2C%202011%20DR%20Haarlem!5e0!3m2!1snl!2snl!4v1741031777659!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €35,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €17,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!'),
	(4, 'Restaurant Fris', 4, 45, '[\"Dutch\", \"French\", \"European\"]', '17:30', '22:00', 45, 'restaurant-fris.jpg', 1.5, 3, 'Twijnderslaan 7', 'Haarlem', '2012 BG', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4871.797836756019!2d4.63162227618318!3d52.3722528471585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef41296bd029%3A0xcd09d3d53371340a!2sRestaurant%20Fris%20-%20Haarlem!5e0!3m2!1snl!2snl!4v1741031838062!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €35,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €17,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!'),
	(5, 'New Vegas', 3, 36, '[\"Vegan\"]', '17:00', '21:30', 35, 'new-vegas.jpg', 1.5, 3, 'Koningstraat 5', 'Haarlem', '2011 TB', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.410241496371!2d4.632345676183739!3d52.38111304650362!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef5598e3c30f%3A0x8b30f647d6a5bb41!2sNew%20Vegas!5e0!3m2!1snl!2snl!4v1741031907282!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €35,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €17,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!'),
	(6, 'Grand Cafe Brinkman', 3, 100, '[\"Dutch\", \"European\", \"Modern\"]', '16:30', '21:00', 35, 'grand-cafe-brinkman.jpg', 1.5, 3, 'Grote Markt 13', 'Haarlem', '2011 RC', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.3804177568672!2d4.633574776183788!3d52.38165374646373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6b85897acd%3A0x31d97d67297dc088!2sBrinkmann!5e0!3m2!1snl!2snl!4v1741031969115!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €35,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €17,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!'),
	(7, 'Urban Frenchy Bistro Toujours', 3, 48, '[\"Dutch\", \"Fish and seafood\", \"European\"]', '17:30', '22:00', 35, 'urban-frenchy-bistro-toujours.jpg', 1.5, 3, 'Oude Groenmarkt 10-12', 'Haarlem', '2011 HL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.4346541093037!2d4.634481976183756!3d52.3806704465364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6bc6dddc2d%3A0xc869373de43980c8!2sOude%20Groenmarkt%2010%2C%202011%20HL%20Haarlem!5e0!3m2!1snl!2snl!4v1741032037813!5m2!1snl!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'Be delighted by the culinary masterpieces of our chefs with this carefully crafted three-course menu. Each dish is prepared with passion and expertise, offering you a unique dining experience.\r\n\r\nThis exclusive menu is available for the special price of just €35,-. \r\n\r\nFor children under the age of 12, we offer a reduced price of only €17,50. \r\n\r\nA perfect opportunity for the whole family to enjoy our cuisine and ambiance.\r\n\r\nBook your table today and let us spoil you!');

INSERT INTO  `menu_items`
	(`id`, `restaurant_id`, `category`, `name`, `description`)
VALUES
	(1, 1, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(2, 1, 'Main Course', 'Flank steak (approx. 200 GR) ', 'served with mashed potatoes, roasted cherry tomatoes, parsnip & pickled onions, mushroom sauce & Boursin bacon sauce'),
	(5, 1, 'Dessert', 'Brownie', 'Homemade with mocha cream and caramel sauce'),
	(6, 2, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(7, 2, 'Main Course', 'Tubot', 'Sauerkraut · Kale · Smoked Eel'),
	(9, 2, 'Dessert', 'Chestnut Soufflé', 'Hazelnut · Praline · Citrus'),
	(11, 3, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(12, 3, 'Main Course', 'Tubot', 'Sauerkraut · Kale · Smoked Eel'),
	(13, 3, 'Dessert', 'Chestnut Soufflé', 'Hazelnut · Praline · Citrus'),
	(14, 4, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(15, 4, 'Main Course', 'Tubot', 'Sauerkraut · Kale · Smoked Eel'),
	(16, 4, 'Dessert', 'Chestnut Soufflé', 'Hazelnut · Praline · Citrus'),
	(17, 5, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(18, 5, 'Main Course', 'Tubot', 'Sauerkraut · Kale · Smoked Eel'),
	(19, 5, 'Dessert', 'Chestnut Soufflé', 'Hazelnut · Praline · Citrus'),
	(20, 6, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(21, 6, 'Main Course', 'Tubot', 'Sauerkraut · Kale · Smoked Eel'),
	(22, 6, 'Dessert', 'Chestnut Soufflé', 'Hazelnut · Praline · Citrus'),
	(23, 7, 'Starter', 'Carpaccio', 'Truffle mayo, seed mix, parmesan, and capers'),
	(24, 7, 'Main Course', 'Tubot', 'Sauerkraut · Kale · Smoked Eel'),
	(25, 7, 'Dessert', 'Chestnut Soufflé', 'Hazelnut · Praline · Citrus');

INSERT INTO `restaurant_images`
	(`id`, `restaurant_id`, `image_path`)
VALUES
	(2, 1, '/images/yummie/album-roemer/cafe-roemer-2.jpg'),
	(3, 1, '/images/yummie/album-roemer/cafe-roemer-3.jpg'),
	(4, 1, '/images/yummie/album-roemer/cafe-roemer-4.jpg'),
	(6, 1, '/images/yummie/album-roemer/cafe-roemer-6.jpg'),
	(7, 2, '/images/yummie/album-ratatouille/ratatouille-1.jpg'),
	(8, 2, '/images/yummie/album-ratatouille/ratatouille-2.jpg'),
	(9, 2, '/images/yummie/album-ratatouille/ratatouille-3.jpg'),
	(10, 2, '/images/yummie/album-ratatouille/ratatouille-4.jpg'),
	(11, 3, '/images/yummie/album-fris/fris-1.jpg'),
	(12, 3, '/images/yummie/album-fris/fris-2.jpg'),
	(13, 3, '/images/yummie/album-fris/fris-3.jpg'),
	(14, 3, '/images/yummie/album-fris/fris-4.jpg'),
	(15, 4, NULL),
	(16, 4, NULL),
	(17, 4, NULL),
	(18, 4, NULL),
	(19, 5, NULL),
	(20, 5, NULL),
	(21, 5, NULL),
	(22, 5, NULL),
	(23, 6, NULL),
	(24, 6, NULL),
	(25, 6, NULL),
	(26, 6, NULL),
	(27, 7, NULL),
	(28, 7, '/images/yummie/ratatouille-2.jpg'),
	(29, 7, '/images/yummie/ratatouille-3.jpg'),
	(30, 7, '/images/yummie/ratatouille-4.jpg'),
	(31, 4, '/images/yummie/album-fris/fris-4.jpg');

INSERT INTO `restaurant_reservations` (
		`id`,
		`restaurant_id`,
		`adults`,
		`children`,
		`day`,
		`start_time`,
		`extra_information`,
		`total_price`,
		`created_at`
	)
VALUES
	(1, 1, 0, 0, 'Friday', '20:00', '', 0, '2025-03-20 11:20:26'),
	(2, 1, 0, 0, 'Friday', '18:30', '', 0, '2025-03-20 11:22:20'),
	(3, 1, 0, 0, 'Saturday', '18:30', '', 0, '2025-03-20 11:23:05'),
	(4, 1, 2, 2, 'Sunday', '21:30', '', 0, '2025-03-23 17:24:40');

commit;