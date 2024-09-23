CREATE DATABASE testtasks;

USE testtasks;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    date DATETIME,
    author VARCHAR(255),
    status VARCHAR(50),
    description TEXT
);

-- Генерация 1000 записей
DELIMITER //
CREATE PROCEDURE generate_tasks()
BEGIN
  DECLARE i INT DEFAULT 1;
  WHILE i <= 1000 DO
    INSERT INTO tasks (title, date, author, status, description)
    VALUES (
        CONCAT('Задача ', i),
        NOW() + INTERVAL i HOUR,
        CONCAT('Автор ', i),
        CONCAT('Статус ', i),
        CONCAT('Описание ', i)
    );
    SET i = i + 1;
  END WHILE;
END //
DELIMITER ;

CALL generate_tasks();
