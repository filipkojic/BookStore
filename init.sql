CREATE DATABASE IF NOT EXISTS Bookstore;

USE Bookstore;

CREATE TABLE Authors (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         firstName VARCHAR(100) NOT NULL,
                         lastName VARCHAR(100) NOT NULL
);

CREATE TABLE Books (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(250) NOT NULL,
                       year INT NOT NULL,
                       authorId INT,
                       FOREIGN KEY (authorId) REFERENCES Authors(id)
);

DELIMITER $$

CREATE PROCEDURE populate_demo_data()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE j INT DEFAULT 1;
    WHILE i <= 20 DO
        INSERT INTO Authors (firstName, lastName) VALUES (CONCAT('FirstName', i), CONCAT('LastName', i));
        SET j = 1;
        WHILE j <= 1000 DO
            INSERT INTO Books (name, year, authorId) VALUES (CONCAT('BookTitle', i, '_', j), 2023, i);
            SET j = j + 1;
END WHILE;
        SET i = i + 1;
END WHILE;
END $$

DELIMITER ;

CALL populate_demo_data();
