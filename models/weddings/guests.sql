-- wedding guests Table
CREATE TABLE guests(
    guestID VARCHAR(255) PRIMARY KEY NOT NULL,
    weddingID VARCHAR(255),
    lang ENUM('as', 'bn', 'gu', 'hi', 'kn', 'ml', 'mr', 'ne', 'or', 'pa', 'ta', 'te', 'ur', 'en') DEFAULT 'en',
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(255) NOT NULL,
    gender VARCHAR(255),
    age INT,
    city VARCHAR(255),
    relation ENUM ('friend', 'closeFriend', 'relative', 'closeRelative', 'brother', 'sister', 'mother', 'father', 'vip', 'colleague', 'boss', 'student', 'teacher'),
    RSVP ENUM('yes', 'no') DEFAULT 'no',
    arrivalTime DATETIME,
    travelMode ENUM ('car', 'train', 'bus', 'flight'),
    transportName VARCHAR(255),
    pickup ENUM('yes', 'no') DEFAULT 'no',
    status ENUM('pending', 'invited', 'deleted'),
    createdAt DATETIME,
    createdBy ENUM ('guest', 'host'),
    additionalGuests INT,
    guestMessage TEXT,
    FOREIGN KEY (weddingID) REFERENCES weddings(weddingID)
);