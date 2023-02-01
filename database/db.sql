SHOW DATABASES;

-- create database
CREATE DATABASE php_app_33_1;
USE php_app_33_1;

SHOW TABLES;

-- create users table (with error in password)
CREATE TABLE users
(
    id       serial PRIMARY KEY,
    name     VARCHAR(256),
    email    VARCHAR(256) NOT NULL,
    password VARCHAR(30)  NOT NULL,
    date     DATE         NOT NULL
);

-- fix password error (use hash)
ALTER TABLE users
    MODIFY COLUMN password
    VARCHAR (256) NOT NULL
;

-- add new column for users roles
ALTER TABLE users
    ADD COLUMN role VARCHAR(30)
--     DROP COLUMN role
;

-- set default role
ALTER TABLE users
    ALTER role
        SET DEFAULT 'user'
;

-- INSERT INTO users (email, password, date) VALUES ('', '', '');

-- add a role if there is a previously created user
UPDATE users
    SET role = 'user'
        WHERE id = 1;

-- show table
SELECT * FROM users;

-- -------------------------------------------------------------------------------
DELETE FROM users;
ALTER TABLE users AUTO_INCREMENT = 1;
DROP TABLE users;
-- -------------------------------------------------------------------------------


-- create images table with FOREIGN KEY
CREATE TABLE images
(
    id       serial PRIMARY KEY,
    path     VARCHAR(256) NOT NULL,
    user_id  INT
-- 	FOREIGN KEY users_images_fk(user_id) REFERENCES users(id)
--     user_id  INT REFERENCES users (id)
);

-- select img by id
SELECT * FROM images
    RIGHT JOIN users
        ON images.user_id = users.id
;

-- set default path
ALTER TABLE images
    ALTER path
        SET DEFAULT '/../src/avatars/default.png'
;

-- DELETE FROM users WHERE id = 3;

SELECT * FROM images;

--
CREATE INDEX email_name_index ON users (email, name);
CREATE UNIQUE INDEX user_image_index ON images (user_id, path);

ALTER TABLE php_app_33_1.images
    DROP INDEX user_image_index
;

--
SHOW INDEXES FROM users; -- users/images

-- -------------------------------------------------------------------------------
DELETE FROM images;
ALTER TABLE images AUTO_INCREMENT = 1;
DROP TABLE images;
-- -------------------------------------------------------------------------------


-- create messages table
CREATE TABLE messages
(
    msg_id      	SERIAL 		 	PRIMARY KEY,
    incoming_msg_id INT 			NOT NULL,
    outgoing_msg_id INT			 	NOT NULL,
    msg		 		VARCHAR(1001) 	NOT NULL,
    date     		DATE         	NOT NULL
);

-- -------------------------------------------------------------------------------
DELETE FROM messages;
ALTER TABLE messages AUTO_INCREMENT = 1;
DROP TABLE messages;
-- -------------------------------------------------------------------------------
