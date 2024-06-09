-- Create message logs table
CREATE TABLE message_logs (
    messageID VARCHAR(255),
    guestID VARCHAR(255),
    createdAt DATETIME,
    FOREIGN KEY (messageID) REFERENCES messages(messageID)
);