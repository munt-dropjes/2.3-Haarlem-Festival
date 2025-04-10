START TRANSACTION;

CREATE DATABASE IF NOT EXISTS thefestivaldb;

USE thefestivaldb;

CREATE TABLE `HomePage`(
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `data` LONGTEXT NOT NULL
);

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
	`TotalTickets` INT(11) NOT NULL,
	`SoldTickets` INT(11) NOT NULL DEFAULT 0,
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
    `InvoiceDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `Subtotal` DECIMAL(10, 2) NOT NULL,
    `Vat21` DECIMAL(10, 2) NOT NULL,
    `Vat9` DECIMAL(10, 2) NOT NULL,
    `PaymentDate` DATETIME NOT NULL
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
	`PaymentMethod` enum('iDEAL', 'CreditCard', 'PayPal') NULL
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
	`IsScanned` BOOLEAN NOT NULL DEFAULT 0,
	`Status` enum('Valid', 'Scanned', 'Cancelled') NOT NULL,
	`PurchasedAt` datetime NOT NULL,
	`PaymentStatus'` enum('Completed', 'Failed', 'Pending') NOT NULL
);

Create Table `PurchasedTickets` (
	`id` INT(11) NOT NULL,
	`OrderID` INT(11) NOT NULL,
	`UserID` INT(11) NOT NULL,
	`EventID` INT(11) NOT NULL,
	`Quantity` INT(11) NOT NULL,
	`isFamilyTicket` TINYINT(1) NOT NULL DEFAULT 0,
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

ALTER TABLE `Orders`
	ADD PRIMARY KEY (`OrderID`),
	MODIFY `OrderID` INT(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`UserID`) REFERENCES `Users`(`UserID`);

ALTER TABLE `PurchasedTickets`
	ADD PRIMARY KEY (`id`),
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
	ADD FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`),
  	ADD FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  	ADD FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`);

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


INSERT INTO `HomePage` (`id`, `data`) VALUES
(1, '<main>\r\n	<div class=\"container-fluid p-0\">\r\n		<img src=\"images/homepage1.png\" class=\"img-fluid w-100\" alt=\"plaatje kerk haarlem\">\r\n	</div>\r\n	<div class=\"container mt-4 text-center\" style=\"max-width: 713px; margin: 0 auto;\">\r\n		<h1 style=\"font-family: \'Monoton\', cursive;\">What is the festival?</h1>\r\n		<p>The Haarlem Festival in the Netherlands is a lively celebration that brings the city to life with an exciting\r\n			mix of music, food, and family-friendly fun. Jazz enthusiasts can revel in soulful performances, while dance\r\n			lovers groove to electrifying beats.\r\n			Foodies will delight in Yummy, the festival\'s culinary hub, offering a diverse array of delicious flavors.\r\n			Families can explore the enchanting Magic@Teylers, a special program for kids hosted at the historic Teylers\r\n			Museum. With its diverse lineup, the Haarlem Festival promises an unforgettable experience for all ages, set\r\n			against the charming backdrop of Haarlem\'s historic streets.\r\n	</div>\r\n	<div class=\"container mt-4 d-flex justify-content-between align-items-center\">\r\n		<div class=\"col-md-6\"style=\"padding: 20px;\">\r\n			<img src=\"images/homepage2.png\" class=\"img-fluid\" alt=\"festival image\" style=\"height: 400px; width: 726px;\">\r\n		</div>\r\n		<div class=\"col-md-6 text-center\"style=\"padding: 20px;\">\r\n			<h2>Feel the Beat at \"The Festival\"</h2>\r\n			<p>At Haarlem Dance, we bring you the best in dance, house, techno, and trance, set against the backdrop of\r\n				Haarlem\'s most iconic locations and its charming surroundings.\r\n				Prepare for an extraordinary experience as six of the world\'s top DJs take the stage in unforgettable\r\n				Back2Back sessions. These larger performances feature multiple acts, extended sets, and breathtaking\r\n				energy. For a more intimate vibe, explore our smaller, experimental club sessions, where creativity and\r\n				innovation take center stage.\r\n				Dive into the rhythm of Haarlem Dance and let the music move you. Check out the full lineup and event\r\n				details now!</p>\r\n		</div>\r\n	</div>\r\n	<div class=\"container mt-4 d-flex justify-content-between align-items-center\">\r\n		<div class=\"col-md-6 text-center\"style=\"padding: 20px;\">\r\n			<h2>Discover the Flavors of Haarlem</h2>\r\n			<p>While Haarlem might not be world-famous for its culinary traditions, it’s a hidden gem for food lovers!\r\n				On our Yummie page, you’ll find a selection of the city’s best restaurants offering exclusive Festival\r\n				menus at special discounted prices.\r\n				It’s the perfect opportunity to explore Haarlem’s vibrant food scene and indulge in unique dishes\r\n				crafted just for The Festival. Whether you\'re a foodie or simply love great cuisine, there\'s something\r\n				delicious waiting for you.</p>\r\n		</div>\r\n		<div class=\"col-md-6\"style=\"padding: 20px;\">\r\n			<img src=\"images/Homepage3.png\" class=\"img-fluid\" alt=\"culinary image\" style=\"height: 400px; width: 726px;\">\r\n		</div>\r\n	</div>\r\n	<div class=\"container mt-4 d-flex justify-content-between align-items-center\">\r\n		<div class=\"col-md-6\"style=\"padding: 20px;\">\r\n			<img src=\"images/homepage4.png\" class=\"img-fluid\" alt=\"festival image\" style=\"height: 400px; width: 726px;\">\r\n		</div>\r\n		<div class=\"col-md-6 text-center\"style=\"padding: 20px;\">\r\n			<h2>Experience the Soul of Haarlem Jazz</h2>\r\n			<p>Haarlem Jazz is a cornerstone of the city’s vibrant music scene, and during The Festival, we’re bringing\r\n				its spirit back to life!\r\n				Join us at Het Patronaat, where some of the most iconic bands from previous editions of Haarlem Jazz\r\n				will take the stage once more. On Sunday, the celebration continues at the Grote Markt, where select\r\n				bands will perform on the big stage, offering a spectacular free concert for all visitors to enjoy.\r\n				Don’t miss this chance to immerse yourself in the rich sounds of jazz while soaking up the lively\r\n				atmosphere of Haarlem. Check out the program and join us for an unforgettable musical experience!</p>\r\n		</div>\r\n	</div>\r\n	<div class=\"container mt-4 d-flex justify-content-between align-items-center\">\r\n		<div class=\"col-md-6 text-center\" style=\"padding: 20px;\">\r\n			<h2>Discover Haarlem’s Fascinating History</h2>\r\n			<p>Step into the past and uncover the rich history of Haarlem with our guided walking tours. Wander through\r\n				the city’s historic streets, admire its centuries-old architecture, and hear the captivating stories\r\n				that have shaped Haarlem into the cultural gem it is today.\r\n				Whether you’re a history enthusiast or simply looking for a unique way to experience Haarlem, this tour\r\n				offers something for everyone.\r\n				To ensure this experience is accessible to all, the tour is available in English, Dutch, and Chinese.\r\n				Our expert guides will bring Haarlem’s history to life, making it engaging and enjoyable for visitors\r\n				from around the world.</p>\r\n		</div>\r\n		<div class=\"col-md-6\" style=\"padding: 20px;\">\r\n			<img src=\"images/homepage5.png\" class=\"img-fluid\" alt=\"jazz image\" style=\"height: 400px; width: 726px;\">\r\n		</div>\r\n	</div>\r\n	<div class=\"container mt-4 d-flex justify-content-between align-items-center\">\r\n		<div class=\"col-md-6\"style=\"padding: 20px;\">\r\n			<img src=\"images/homepage6.png\" class=\"img-fluid\" alt=\"family fun image\"\r\n				style=\"height: 400px; width: 726px; \">\r\n		</div>\r\n		<div class=\"col-md-6 text-center\"  style=\"padding: 20px;\">\r\n			<h2>The Secret of Professor Teyler</h2>\r\n			<p>\r\n				Embark on an unforgettable adventure at Teyler’s Museum with a special interactive experience designed\r\n				just for kids. During The Festival, young explorers are invited to step into the world of science and\r\n				mystery, where they’ll solve puzzles, conduct hands-on experiments, and gather clues to unlock the\r\n				hidden secret of Professor Teyler.\r\n				This unique experience combines fun and learning in a way that sparks curiosity and creativity. Kids\r\n				will meet intriguing characters, explore fascinating science facts, and work together to unravel the\r\n				professor’s greatest mystery. It’s an exciting journey that will challenge their problem-solving skills\r\n				and leave them with a sense of accomplishment.</p>\r\n		</div>\r\n	</div>\r\n	<div class=\"container mt-4 d-flex justify-content-between align-items-center\">\r\n		<div class=\"col-md-6\">\r\n			<iframe src=\"https://www.google.com/maps/d/embed?mid=1FYl1K84-DwA0wW6LkFzpX3yUolaKvm8&ehbc=2E312F&noprof=1\"\r\n				width=\"646\" height=\"620\"></iframe>\r\n		</div>\r\n		<div class=\"col-md-6 offset-md-1\">\r\n			<img src=\"images/homepage7.png\" class=\"img-fluid\" alt=\"map image\">\r\n		</div>\r\n	</div>\r\n</main>');

INSERT INTO `Users` 
	(`UserID`, `Role`, `Name`, `Email`, `Password`, `Phone`, `Country`, `RegisteredAt`)
VALUES
	(1, 'Administrator', 'Daniel Zwart', 'dtzwart@gmail.com', '$2y$12$AtD6c5mvh6R1//0TWiAk3uhix4geuIPjWVJiGIuXTwMNm179fQ4HW', '0612345678', 'Netherlands', '2025-03-06 12:04:16'),
	(2, 'Customer', 'Customer Test', 'customer@testmail.com', '$2y$12$ZD4gbCVRRPtxROkN44iMMeBhmQgmOO4BuRVr.flrrNIqmrJDo3AkK', '0612345678', 'Netherlands', '2025-04-09 22:28:06'),
	(3, 'Administrator', 'Admin Test', 'admin@testmail.com', '$2y$12$5DP89FRGtloS2e1wCEt6.uK1SmoxWN/wboWlFe3KxXKqMT3DPqwly', '0612345678', 'Netherlands', '2025-04-09 22:29:14'),
	(4, 'Employee', 'Employee Test', 'employee@testmail.com', '$2y$12$GerAwBwcN9tcM89MY0RWhuvFTY6duamEBCh9WrdmQuSWFcgrif1oG', '0612345678', 'Netherlands', '2025-04-09 22:29:45');


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
	),
(2, 'Gumbo Kings', 'De Gumbo Kings zijn een vijfkoppige band die de groove van New Orleans combineren met ruige deltablues en de melodie van soul uit het oude Memphis. Ze staan bekend om hun energieke live shows.', 'Roots Blues', 'https://open.spotify.com/track/example1', 'https://soundcloud.com/example1', 'https://open.spotify.com/track/example3', 0, 'Jazz', 0),
(3, 'Evolve', 'Informatie over Evolve.', 'Genre of bekendheid', 'https://open.spotify.com/track/example4', 'https://soundcloud.com/example4', 'https://open.spotify.com/track/example6', 0, 'Jazz', 0),
(4, 'Ntjam Rosie', 'Informatie over Ntjam Rosie.', 'Genre of bekendheid', 'https://open.spotify.com/track/example7', 'https://soundcloud.com/example7', 'https://open.spotify.com/track/example9', 0, 'Jazz', 0),
(5, 'Wicked Jazz Sounds', 'Wicked Jazz Sounds is een wekelijkse clubavond waar jazz en dans samenkomen. DJs en muzikanten spelen samen een mix van funk, soul, hiphop, house en meer.', 'Funk, Soul, Hiphop, House', 'https://open.spotify.com/track/example10', 'https://soundcloud.com/example10', 'https://open.spotify.com/track/example12', 0, 'Jazz', 0),
(6, 'Wouter Hamel', 'Informatie over Wouter Hamel.', 'Genre of bekendheid', 'https://open.spotify.com/track/example13', 'https://soundcloud.com/example13', 'https://open.spotify.com/track/example15', 0, 'Jazz', 0),
(7, 'Jonna Frazer', 'Informatie over Jonna Frazer.', 'Genre of bekendheid', 'https://open.spotify.com/track/example16', 'https://soundcloud.com/example16', 'https://open.spotify.com/track/example18', 0, 'Jazz', 0),

-- Vrijdag 25 juli 2025
(8, 'Karsu', 'Informatie over Karsu.', 'Genre of bekendheid', 'https://open.spotify.com/track/example19', 'https://soundcloud.com/example19', 'https://open.spotify.com/track/example21', 0, 'Jazz', 0),
(9, 'Uncle Sue', 'Informatie over Uncle Sue.', 'Genre of bekendheid', 'https://open.spotify.com/track/example22', 'https://soundcloud.com/example22', 'https://open.spotify.com/track/example24', 0, 'Jazz', 0),
(10, 'Chris Allen', 'Informatie over Chris Allen.', 'Genre of bekendheid', 'https://open.spotify.com/track/example25', 'https://soundcloud.com/example25', 'https://open.spotify.com/track/example27', 0, 'Jazz', 0),
(11, 'Myles Sanko', 'Myles Sanko is een Britse soulzanger die bekendstaat om zijn funky, jazzy en vintage soul sound. Zijn vierde album, "Memories of Love", werd in 2021 uitgebracht.', 'Britse Soulzanger', 'https://open.spotify.com/track/example28', 'https://soundcloud.com/example28', 'https://open.spotify.com/track/example30', 0, 'Jazz', 0),
(12, 'Ilse Huizinga', 'Informatie over Ilse Huizinga.', 'Genre of bekendheid', 'https://open.spotify.com/track/example31', 'https://soundcloud.com/example31', 'https://open.spotify.com/track/example33', 0, 'Jazz', 0),
(13, 'Eric Vloeimans and Hotspot!', 'Eric Vloeimans is een Nederlandse trompettist die bekendstaat om zijn virtuositeit en expressieve speelstijl. Zijn project "Hotspot!" combineert jazz met andere genres.', 'Nederlandse Trompettist', 'https://open.spotify.com/track/example34', 'https://soundcloud.com/example34', 'https://open.spotify.com/track/example36', 0, 'Jazz', 0),

-- Zaterdag 26 juli 2025
(14, 'Gare du Nord', 'Gare du Nord is een Nederlandse band die jazz, blues en swing combineert met moderne invloeden. Ze staan bekend om hun energieke optredens.', 'Jazz, Blues, Swing Band', 'https://open.spotify.com/track/example37', 'https://soundcloud.com/example37', 'https://open.spotify.com/track/example39', 0, 'Jazz', 0),
(15, 'Rilan & The Bombadiers', 'Informatie over Rilan & The Bombadiers.', 'Genre of bekendheid', 'https://open.spotify.com/track/example40', 'https://soundcloud.com/example40', 'https://open.spotify.com/track/example42', 0, 'Jazz', 0),
(16, 'Soul Six', 'Informatie over Soul Six.', 'Genre of bekendheid', 'https://open.spotify.com/track/example43', 'https://soundcloud.com/example43', 'https://open.spotify.com/track/example45', 0, 'Jazz', 0),
(17, 'Han Bennink', 'Han Bennink is een Nederlandse jazzdrummer die bekendstaat om zijn innovatieve en energieke speelstijl. Hij is een pionier in de Europese jazzscene.', 'Nederlandse Jazzdrummer', 'https://open.spotify.com/track/example46', 'https://soundcloud.com/example46', 'https://open.spotify.com/track/example48', 0, 'Jazz', 0),
(18, 'The Nordanians', 'Informatie over The Nordanians.', 'Genre of bekendheid', 'https://open.spotify.com/track/example49', 'https://soundcloud.com/example49', 'https://open.spotify.com/track/example51', 0, 'Jazz', 0),
(19, 'Lilith Merlot', 'Informatie over Lilith Merlot.', 'Genre of bekendheid', 'https://open.spotify.com/track/example52', 'https://soundcloud.com/example52', 'https://open.spotify.com/track/example54', 0, 'Jazz', 0),

(20, 'Nicky Romero', 'Nicky Romero, geboren als Nick Rotteveel, is een Nederlandse DJ en muziekproducent uit Amerongen. Hij staat bekend om zijn energieke optredens en samenwerkingen met artiesten als Avicii en David Guetta.', 'Bekend van hits als "Toulouse" en "I Could Be The One".', 'https://open.spotify.com/track/1l6G6h6g6l6G6l6G6l6G6G', 'https://open.spotify.com/track/2m6M6m6m6M6m6M6m6M6m6M', 'https://open.spotify.com/track/3n6N6n6n6N6n6N6n6N6n6N', 'dance/nicky-artist.png', 'Dance', 'dance/nicky-banner.png'),
(21, 'Afrojack', 'Afrojack, geboren als Nick van de Wall, is een Nederlandse DJ en muziekproducent uit Spijkenisse. Hij staat bekend om zijn dynamische performances en diverse muziekstijl.', 'Bekend van tracks als "Take Over Control" en "Ten Feet Tall".', 'https://open.spotify.com/track/4o6O6o6o6O6o6O6o6O6o6O', 'https://open.spotify.com/track/5p6P6p6p6P6p6P6p6P6p6P', 'https://open.spotify.com/track/6q6Q6q6q6Q6q6Q6q6Q6q6Q', 'dance/afro-artist.png', 'Dance', 'dance/afro-banner.png'),
(22, 'Tiësto', 'Tiësto, geboren als Tijs Michiel Verwest, is een legendarische Nederlandse DJ en muziekproducent uit Breda. Hij wordt beschouwd als een pionier in de elektronische dansmuziek.', 'Hits zoals "Red Lights" en "Wasted" hebben zijn status als top DJ bevestigd.', 'https://open.spotify.com/track/7r6R6r6r6R6r6R6r6R6r6R', 'https://open.spotify.com/track/8s6S6s6s6S6s6S6s6S6s6S', 'https://open.spotify.com/track/9t6T6t6t6T6t6T6t6T6t6T', 'dance/tiesto-artist.png', 'Dance', 'dance/tiesto-banner.png'),
(23, 'Hardwell', 'Hardwell, geboren als Robbert van de Corput, is een Nederlandse DJ en muziekproducent uit Breda. Hij staat bekend om zijn energieke mainstage-optredens en big room house geluid.', 'Bekend van nummers als "Spaceman" en "Apollo".', 'https://open.spotify.com/track/1u6U6u6u6U6u6U6u6U6u6U', 'https://open.spotify.com/track/2v6V6v6v6V6v6V6v6V6v6V', 'https://open.spotify.com/track/3w6W6w6w6W6w6W6w6W6w6W', 'dance/hardwell-artist.png', 'Dance', 'dance/hardwell-banner.png'),
(24, 'Armin van Buuren', 'Armin van Buuren is een invloedrijke Nederlandse DJ en muziekproducent uit Leiden, bekend om zijn wekelijkse radioshow "A State of Trance" en zijn bijdragen aan de trance muziek.', 'Hits zoals "This Is What It Feels Like" en "Blah Blah Blah" hebben zijn populariteit vergroot.', 'https://open.spotify.com/track/4x6X6x6x6X6x6X6x6X6x6X', 'https://open.spotify.com/track/5y6Y6y6y6Y6y6Y6y6Y6y6Y', 'https://open.spotify.com/track/6z6Z6z6z6Z6z6Z6z6Z6z6Z', 'dance/armin-artist.png', 'Dance', 'dance/armin-banner.png'),
(25, 'Martin Garrix', 'Martin Garrix, geboren als Martijn Gerard Garritsen, is een Nederlandse DJ en muziekproducent uit Amstelveen. Hij staat bekend om zijn progressive house en big room house tracks.', 'Bekend van hits als "Animals" en "In the Name of Love".', 'https://open.spotify.com/track/7a6A6a6a6A6a6A6a6A6a6A', 'https://open.spotify.com/track/8b6B6b6b6B6b6B6b6B6b6B', 'https://open.spotify.com/track/9c6C6c6c6C6c6C6c6C6c6C', 'dance/martin-artist.png', 'Dance', 'dance/martin-banner.png');


INSERT INTO `Events`
	(`EventID`, `Name`, `Description`, `StartTime`, `EndTime`, `Location`, `Price`, `TotalTickets`, `ImageName`, `Category`)
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
		'dance/event-caprera.png',
		'Dance'
	),
	(
		12,
		'Jopenkerk',
		'Harwell\r\nMartin Garrix\r\nArmin van Buuren',
		'2025-03-14 23:00:00',
		'2025-03-15 00:30:00',
		'Jopenkerk',
		60.00,
		300,
		'dance/event-jopenkerk.png',
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
	),
	(45, 'Gumbo Kings', '', '2025-07-24 18:00:00', '2025-07-24 19:00:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(46, 'Evolve', '', '2025-07-24 19:30:00', '2025-07-24 20:30:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(47, 'Ntjam Rosie', '', '2025-07-24 21:00:00', '2025-07-24 22:00:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(48, 'Wicked Jazz Sounds', '', '2025-07-24 18:00:00', '2025-07-24 19:00:00', 'Patronaat - Second Hall', 10.00, 200, '', 'Jazz'),
	(49, 'Wouter Hamel', '', '2025-07-24 19:30:00', '2025-07-24 20:30:00', 'Patronaat - Second Hall', 10.00, 200, '', 'Jazz'),
	(50, 'Jonna Frazer', '', '2025-07-24 21:00:00', '2025-07-24 22:00:00', 'Patronaat - Second Hall', 10.00, 200, '', 'Jazz'),

	-- Vrijdag 25 juli 2025
	(51, 'Karsu', '', '2025-07-25 18:00:00', '2025-07-25 19:00:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(52, 'Uncle Sue', '', '2025-07-25 19:30:00', '2025-07-25 20:30:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(53, 'Chris Allen', '', '2025-07-25 21:00:00', '2025-07-25 22:00:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(54, 'Myles Sanko', '', '2025-07-25 18:00:00', '2025-07-25 19:00:00', 'Patronaat - Second Hall', 10.00, 200, '', 'Jazz'),
	(55, 'Ilse Huizinga', '', '2025-07-25 19:30:00', '2025-07-25 20:30:00', 'Patronaat - Second Hall', 10.00, 200, '', 'Jazz'),
	(56, 'Eric Vloeimans and Hotspot!', '', '2025-07-25 21:00:00', '2025-07-25 22:00:00', 'Patronaat - Second Hall', 10.00, 200, '', 'Jazz'),

	-- Zaterdag 26 juli 2025
	(57, 'Gare du Nord', '', '2025-07-26 18:00:00', '2025-07-26 19:00:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(58, 'Rilan & The Bombadiers', '', '2025-07-26 19:30:00', '2025-07-26 20:30:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(59, 'Soul Six', '', '2025-07-26 21:00:00', '2025-07-26 22:00:00', 'Patronaat - Main Hall', 15.00, 300, '', 'Jazz'),
	(60, 'Han Bennink', '', '2025-07-26 18:00:00', '2025-07-26 19:00:00', 'Patronaat - Third Hall', 10.00, 150, '', 'Jazz'),
	(61, 'The Nordanians', '', '2025-07-26 19:30:00', '2025-07-26 20:30:00', 'Patronaat - Third Hall', 10.00, 150, '', 'Jazz'),
	(62, 'Lilith Merlot', '', '2025-07-26 21:00:00', '2025-07-26 22:00:00', 'Patronaat - Third Hall', 10.00, 150, '', 'Jazz'),

	-- Zondag 27 juli 2025 (gratis events)
	(63, 'Ruis Soundsystem', '', '2025-07-27 15:00:00', '2025-07-27 16:00:00', 'Grote Markt', 0.00, 0, '', 'Jazz'),
	(64, 'Wicked Jazz Sounds', '', '2025-07-27 16:00:00', '2025-07-27 17:00:00', 'Grote Markt', 0.00, 0, '', 'Jazz'),
	(65, 'Evolve', '', '2025-07-27 17:00:00', '2025-07-27 18:00:00', 'Grote Markt', 0.00, 0, '', 'Jazz'),
	(66, 'The Nordanians', '', '2025-07-27 18:00:00', '2025-07-27 19:00:00', 'Grote Markt', 0.00, 0, '', 'Jazz'),
	(67, 'Gumbo Kings', '', '2025-07-27 19:00:00', '2025-07-27 20:00:00', 'Grote Markt', 0.00, 0, '', 'Jazz'),
	(68, 'Gare du Nord', '', '2025-07-27 20:00:00', '2025-07-27 21:00:00', 'Grote Markt', 0.00, 0, '', 'Jazz'),

	-- Dance
	(69, 'Nicky Romero / Afrojack', 'Back2Back show', '2025-07-25 20:00:00', '2025-07-25 02:00:00', 'Lichtfabriek', 75.00, 1500, 'dance/event-licht.png', 'Dance'),
	(70, 'Tiësto', 'Club night', '2025-07-25 22:00:00', '2025-07-26 00:30:00', 'Slachthuis', 60.00, 200, 'dance/event-slachthuis.png', 'Dance'),
	(71, 'Hardwell', 'Club night', '2025-07-25 23:00:00', '2025-07-26 00:30:00', 'Jopenkerk', 60.00, 300, 'dance/event-jopenkerk.png', 'Dance'),
	(72, 'Armin van Buuren', 'Club night', '2025-07-25 22:00:00', '2025-07-26 00:30:00', 'XO the Club', 60.00, 200, 'dance/event-xo.png', 'Dance'),
	(73, 'Martin Garrix', 'Club night', '2025-07-25 22:00:00', '2025-07-26 00:30:00', 'Puncher comedy club', 60.00, 200, 'dance/event-puncher.png', 'Dance'),

	(74, 'Harwell / Martin Garrix / Armin van Buuren', 'Back2Back outdoor show', '2025-07-26 14:00:00', '2025-07-26 23:00:00', 'Caprera Openluchttheater', 110.00, 2000, 'dance/event-caprera.png', 'Dance'),
	(75, 'Afrojack', 'Club night', '2025-07-26 22:00:00', '2025-07-27 00:30:00', 'Jopenkerk', 60.00, 300, 'dance/event-jopenkerk.png', 'Dance'),
	(76, 'Tiësto', 'TiëstoWorld**', '2025-07-26 21:00:00', '2025-07-27 01:00:00', 'Lichtfabriek', 75.00, 1500, 'dance/event-licht.png', 'Dance'),
	(77, 'Nicky Romero', 'Club night', '2025-07-26 23:00:00', '2025-07-27 00:30:00', 'Slachthuis', 60.00, 200, 'dance/event-slachthuis.png', 'Dance'),

	(78, 'Afrojack / Tiësto / Nicky Romero', 'Back2Back outdoor show', '2025-07-27 14:00:00', '2025-07-27 23:00:00', 'Caprera Openluchttheater', 110.00, 2000, 'dance/event-caprera.png', 'Dance'),
	(79, 'Armin van Buuren', 'Club night', '2025-07-27 19:00:00', '2025-07-27 20:30:00', 'Jopenkerk', 60.00, 300, 'dance/event-jopenkerk.png', 'Dance'),
	(80, 'Hardwell', 'Club night', '2025-07-27 21:00:00', '2025-07-27 22:30:00', 'XO the Club', 90.00, 1500, 'dance/event-xo.png', 'Dance'),
	(81, 'Martin Garrix', 'Club night', '2025-07-27 18:00:00', '2025-07-27 19:30:00', 'Slachthuis', 60.00, 200, 'dance/event-slachthuis.png', 'Dance'),

	(
		82,
		'All Access Pass Dance',
		'Grants entry to all dance events on Friday, Saturday, and Sunday',
		'2025-07-25 00:00:01',
		'2025-07-27 23:59:59',
		'Festival Grounds',
		250.00,
		300,
		'dance/dance-festival.png',
		'Dance'
	),
		(
		83,
		'Day Pass Friday Dance',
		'Grants entry to all dance events on Friday, Saturday, and Sunday',
		'2025-07-25 00:00:01',
		'2025-07-25 23:59:59',
		'Festival Grounds',
		250.00,
		300,
		'dance/dance-festival.png',
		'Dance'
	),
		(
		84,
		'Day Pass Saturday Dance',
		'Grants entry to all dance events on Friday, Saturday, and Sunday',
		'2025-07-26 00:00:01',
		'2025-07-26 23:59:59',
		'Festival Grounds',
		250.00,
		300,
		'dance/dance-festival.png',
		'Dance'
	),
		(
		85,
		'Day Pass Sunday Dance',
		'Grants entry to all dance events on Friday, Saturday, and Sunday',
		'2025-07-27 00:00:01',
		'2025-07-27 23:59:59',
		'Festival Grounds',
		250.00,
		300,
		'dance/dance-festival.png',
		'Dance'
	),
	-- Jazz
	(
		86,
		'All Access Pass Jazz',
		'Grants entry to all jazz events on Friday, Saturday, and Sunday',
		'2025-07-25 00:00:01',
		'2025-07-27 23:59:59',
		'Patronaat',
		80.00,
		300,
		'jazz/image1.jpg',
		'Jazz'
	),
		(
		87,
		'Day Pass Friday Jazz',
		'Grants entry to all jazz events on Friday, Saturday, and Sunday',
		'2025-07-25 00:00:01',
		'2025-07-25 23:59:59',
		'Patronaat',
		35.00,
		300,
		'jazz/image1.jpg',
		'Jazz'
	),
		(
		88,
		'Day Pass Saturday Jazz',
		'Grants entry to all jazz events on Friday, Saturday, and Sunday',
		'2025-07-26 00:00:01',
		'2025-07-26 23:59:59',
		'Patronaat',
		35.00,
		300,
		'jazz/image1.jpg',
		'Jazz'
	),
		(
		89, 
		'Day Pass Sunday Jazz',
		'Grants entry to all jazz events on Friday, Saturday, and Sunday',
		'2025-07-27 00:00:01',
		'2025-07-27 23:59:59',
		'Patronaat',
		35.00,
		300,
		'jazz/image1.jpg',
		'Jazz'
	);

INSERT INTO `Dance`
	(`ArtistID`, `EventID`)
VALUES
	(1, 10);

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

INSERT INTO `Jazz` (`ArtistID`, `EventID`)
VALUES(2, 45),   -- Gumbo Kings
(3, 46),   -- Evolve
(4, 47),   -- Ntjam Rosie
(5, 48),   -- Wicked Jazz Sounds (donderdag)
(6, 49),   -- Wouter Hamel
(7, 50),   -- Jonna Frazer
(8, 51),   -- Karsu
(9, 52),   -- Uncle Sue
(10, 53),  -- Chris Allen
(11, 54),  -- Myles Sanko
(12, 55),  -- Ilse Huizinga
(13, 56),  -- Eric Vloeimans and Hotspot!
(14, 57),  -- Gare du Nord (zaterdag)
(15, 58),  -- Rilan & The Bombadiers
(16, 59),  -- Soul Six
(17, 60),  -- Han Bennink
(18, 61),  -- The Nordanians (zaterdag)
(19, 62),  -- Lilith Merlot

-- Zondag (gratis evenementen, al eerder genoemde artiesten)
(5, 64),   -- Wicked Jazz Sounds (zondag)
(3, 65),   -- Evolve (zondag)
(18, 66),  -- The Nordanians (zondag)
(2, 67),   -- Gumbo Kings (zondag)
(14, 68);

INSERT INTO `Dance` (`ArtistID`, `EventID`)
VALUES (20, 69),
(21, 69),
(22, 70),
(23, 71),
(24, 72),
(25, 73),
(23, 74),
(25, 74),
(24, 74),
(21, 75),
(22, 76),
(20, 77),
(21, 78),
(22, 78),
(20, 78),
(24, 79),
(23, 80),
(25, 81);

commit;