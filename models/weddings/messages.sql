-- Create messages table
CREATE TABLE messages (
    messageID VARCHAR(255) PRIMARY KEY NOT NULL,
    weddingID VARCHAR(255),
    lang VARCHAR(50),
    type ENUM('web', 'ar','rsvp', 'update','custom'), 
    text_ TEXT,
    status ENUM('pending', 'accepted','rejected', 'deleted'),
    createdAt DATETIME,
    updatedAt DATETIME
);