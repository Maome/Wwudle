# Create table scripts for Western List website

CREATE TABLE WesternList.HyperLink (
	HyperlinkID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	URL VARCHAR(200),
	Text VARCHAR(100),
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL
);

CREATE TABLE WesternList.User (
	UserID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Email VARCHAR(50) NOT NULL,
	FirstLoginDate DATETIME,
	LastLoginDate DATETIME,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL
);

CREATE TABLE WesternList.BookCategory (
	BookCategoryID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Description VARCHAR(100) NOT NULL,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL
);

-- Book Conditions
	-- New
	-- Like New
	-- Very Good
	-- Good
	-- Acceptable
CREATE TABLE WesternList.BookCondition (
	BookConditionID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Description VARCHAR(20) NOT NULL,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL
);

CREATE TABLE WesternList.Book (
	BookID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ISBN DECIMAL(13,0) NOT NULL,
	Authors VARCHAR(150),
	Title VARCHAR(150),
	Edition VARCHAR(5),
	BookCategoryID INT UNSIGNED,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL,
	FOREIGN KEY (BookCategoryID) REFERENCES BookCategory(BookCategoryID)
);

-- How should posts be handled where the user wants to post multiple books?
-- It may be useful to break the book listing table into header and detail tables
CREATE TABLE WesternList.BookListing (
	PostID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	PostDate DATETIME NOT NULL,
	UserID INT UNSIGNED NOT NULL,
	BookID INT UNSIGNED NOT NULL,
	BookConditionID INT UNSIGNED,
	Price DECIMAL(6,2),
	ViewCount INT UNSIGNED NOT NULL DEFAULT 0,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL,
	FOREIGN KEY (UserID) REFERENCES User(UserID),
	FOREIGN KEY (BookID) REFERENCES Book(BookID),
	FOREIGN KEY (BookConditionID) REFERENCES BookCondition(BookConditionID)
);

CREATE TABLE WesternList.BookReview (
	PostID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	PostDate DATETIME NOT NULL,
	UserID INT UNSIGNED NOT NULL,
	BookID INT UNSIGNED NOT NULL,
	-- Rating Types should go here
	ViewCount INT UNSIGNED NOT NULL DEFAULT 0,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL,
	FOREIGN KEY (UserID) REFERENCES User(UserID),
	FOREIGN KEY (BookID) REFERENCES Book(BookID)
);

CREATE TABLE WesternList.RideShare (
	PostID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	PostDate DATETIME NOT NULL,
	UserID INT UNSIGNED NOT NULL,
	DepartureDate DATETIME NOT NULL,
	ReturnDate DATETIME NOT NULL,
	SourceLatitude DECIMAL(8,5) NOT NULL,
	SourceLongitude DECIMAL(8,5) NOT NULL,
	DestLatitude DECIMAL(8,5) NOT NULL,
	DestLongitude DECIMAL(8,5) NOT NULL,
	SourceThresholdMiles SMALLINT UNSIGNED,
	DestThreshholdMiles SMALLINT UNSIGNED,
	SeatsRemaining TINYINT UNSIGNED,
	MaxSeats TINYINT UNSIGNED,
	Price DECIMAL(6,2),
	ViewCount INT UNSIGNED NOT NULL DEFAULT 0,
	ChangeSource VARCHAR(50),
	RecordStatus TINYINT UNSIGNED NOT NULL,
	RecordStatusDate DATETIME NOT NULL,
	FOREIGN KEY (UserID) REFERENCES User(UserID)
);

-- TODO: Create professor reviews table. This may require both a reviews table
-- and professors table. Need to research where professor information can be
-- automatically extracted from

-- TODO: Add GPA Calculator to Home Page?
-- TODO: Add Tuition Calculator to Home Page?
