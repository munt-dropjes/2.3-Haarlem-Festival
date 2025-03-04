CREATE DATABASE IF NOT EXISTS thefestivaldb;
USE thefestivaldb;

-- create the tables and their contents
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Role ENUM('Customer', 'Administrator', 'Employee'),
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Phone VARCHAR(255) NOT NULL,
    Country VARCHAR(255) NOT NULL,
    RegisteredAt DATETIME NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE Visitors (
    UserID INT PRIMARY KEY,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Customers (
    UserID INT PRIMARY KEY,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Employees (
    UserID INT PRIMARY KEY,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Administrators (
    UserID INT PRIMARY KEY,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Events (
    EventID UUID PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    Location VARCHAR(255) NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    AvailableTickets INT NOT NULL
);

CREATE TABLE Yummie (
    EventID UUID PRIMARY KEY,
    StarRating INT NOT NULL,
    Cuisine VARCHAR(255) NOT NULL,
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);

CREATE TABLE Dance (
    EventID UUID PRIMARY KEY,
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);

CREATE TABLE Jazz (
    EventID UUID PRIMARY KEY,
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);

--Think of way to add pictures to the events
--for reference can add 1 to each event, makes updating it per event more easy
--can add 1 picture to be used by all events of the same type, makes it take up less space in the db but do need to add another table for that.
CREATE TABLE Stroll (
    EventID UUID PRIMARY KEY,
    Language VARCHAR(255) NOT NULL,
    Guide VARCHAR(255) NOT NULL,
    FamilyTicketPrice DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);

CREATE TABLE Tickets (
    TicketID UUID PRIMARY KEY,
    EventID UUID NOT NULL,
    UserID INT NOT NULL,
    QRCode VARCHAR(255) NOT NULL,
    Status ENUM('Valid', 'Scanned', 'Cancelled') NOT NULL,
    PurchasedAt DATETIME NOT NULL,
    FOREIGN KEY (EventID) REFERENCES Events(EventID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Orders (
    OrderID UUID PRIMARY KEY,
    CustomerID INT NOT NULL,
    Status ENUM('Pending', 'Paid', 'Cancelled') NOT NULL,
    CreatedAt DATETIME NOT NULL,
    PaymentMethod ENUM('iDEAL', 'CreditCard', 'PayPal') NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(UserID)
);

CREATE TABLE ShoppingCart (
    CartID UUID PRIMARY KEY,
    CustomerID INT NOT NULL,
    CreatedAt DATETIME NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(UserID)
);

CREATE TABLE ShoppingCartItems (
    ItemID UUID PRIMARY KEY,
    CartID UUID NOT NULL,
    EventID UUID NOT NULL,
    Quantity INT NOT NULL,
    AddedAt DATETIME NOT NULL,
    FOREIGN KEY (CartID) REFERENCES ShoppingCart(CartID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);

CREATE TABLE Payments (
    PaymentID UUID PRIMARY KEY,
    OrderID UUID NOT NULL,
    CustomerID INT NOT NULL,
    Status ENUM('Success', 'Failed', 'Pending') NOT NULL,
    PaymentDate DATETIME NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    PaymentMethod ENUM('iDEAL', 'CreditCard', 'PayPal') NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customers(UserID)
);

CREATE TABLE Invoices (
    InvoiceID UUID PRIMARY KEY,
    OrderID UUID NOT NULL,
    CustomerID INT NOT NULL,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    VAT DECIMAL(10, 2) NOT NULL,
    InvoiceDate DATETIME NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customers(UserID)
);


-- add the relationships
ALTER TABLE Customers ADD CONSTRAINT FK_Customers_Orders FOREIGN KEY (UserID) REFERENCES Users(UserID);
ALTER TABLE Customers ADD CONSTRAINT FK_Customers_ShoppingCart FOREIGN KEY (UserID) REFERENCES Users(UserID);
ALTER TABLE Customers ADD CONSTRAINT FK_Customers_Tickets FOREIGN KEY (UserID) REFERENCES Users(UserID);

ALTER TABLE Orders ADD CONSTRAINT FK_Orders_Tickets FOREIGN KEY (OrderID) REFERENCES Tickets(TicketID);
ALTER TABLE Orders ADD CONSTRAINT FK_Orders_Payments FOREIGN KEY (OrderID) REFERENCES Payments(OrderID);
ALTER TABLE Orders ADD CONSTRAINT FK_Orders_Invoices FOREIGN KEY (OrderID) REFERENCES Invoices(OrderID);

ALTER TABLE ShoppingCart ADD CONSTRAINT FK_ShoppingCart_ShoppingCartItems FOREIGN KEY (CartID) REFERENCES ShoppingCartItems(CartID);
ALTER TABLE ShoppingCartItems ADD CONSTRAINT FK_ShoppingCartItems_Events FOREIGN KEY (EventID) REFERENCES Events(EventID);

ALTER TABLE Events ADD CONSTRAINT FK_Events_Tickets FOREIGN KEY (EventID) REFERENCES Tickets(TicketID);

ALTER TABLE Employees ADD CONSTRAINT FK_Employees_Tickets FOREIGN KEY (UserID) REFERENCES Users(UserID);

ALTER TABLE Administrators ADD CONSTRAINT FK_Administrators_Events FOREIGN KEY (UserID) REFERENCES Users(UserID);
ALTER TABLE Administrators ADD CONSTRAINT FK_Administrators_Orders FOREIGN KEY (UserID) REFERENCES Users(UserID);

-- insert some data
INSERT INTO Users (Role, Name, Email, Password, Phone, Country) 
    VALUES ('Customer', 'Daniel Zwart', 'dtzwart@gmail.com', '$2y$12$AtD6c5mvh6R1//0TWiAk3uhix4geuIPjWVJiGIuXTwMNm179fQ4HW', '0612345678', 'Netherlands');