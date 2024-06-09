CREATE TABLE verification(
    verificationID VARCHAR(255) PRIMARY KEY NOT NULL, 
    userID VARCHAR(255) NOT NULL,
    otp VARCHAR(6),
    createdAt DATETIME,
    expiresAt DATETIME,
    FOREIGN KEY (userID) REFERENCES users(userID)
)