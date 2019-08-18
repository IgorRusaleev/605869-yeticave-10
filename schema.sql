CREATE DATABASE yetcave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeticave;
CREATE TABLE category (
                          category_id INT AUTO_INCREMENT PRIMARY KEY,
                          name_cat CHAR(128),
                          character_code CHAR(64)
);
CREATE TABLE lot (
                     lot_id INT AUTO_INCREMENT PRIMARY KEY,
                     creation_date DATETIME,
                     name_lot CHAR(128),
                     description CHAR(128),
                     image CHAR(128),
                     initial_price DECIMAL(10,2),
                     completion_date DATETIME,
                     step_rate DECIMAL(6,2),
                     user_created_lot CHAR(128),
                     user_winner CHAR (128),
                     character_code CHAR(64)
);
CREATE TABLE rate (
                      rate_id INT AUTO_INCREMENT PRIMARY KEY,
                      date DATETIME,
                      rate DECIMAL(10,2),
                      name_user CHAR(128),
                      name_lot CHAR(128)
);
CREATE TABLE user (
                      user_id INT AUTO_INCREMENT PRIMARY KEY,
                      registration_date DATETIME,
                      email CHAR(128),
                      name_user CHAR(128) ,
                      password CHAR(64),
                      avatar CHAR (128),
                      contact_information CHAR(128),
                      name_lot CHAR(128),
                      rate DECIMAL(10,2)
);