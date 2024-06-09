-- wedding images Table
CREATE TABLE wedding_images(
    imageID VARCHAR(255) PRIMARY KEY,
    imageName VARCHAR(255),
    weddingID VARCHAR(255),
    imageURL VARCHAR(255),
    uploadedAt DATETIME,
    type ENUM('separate', 'gallery'),
    FOREIGN KEY (weddingID) REFERENCES weddings(weddingID)
);