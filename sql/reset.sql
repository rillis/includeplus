CREATE DATABASE IF NOT EXISTS includeplus;

/* USER TABLE */
DROP TABLE IF EXISTS includeplus.users;
CREATE TABLE includeplus.users(
                                ID int AUTO_INCREMENT PRIMARY KEY,
                                NAME varchar(255) NOT NULL,
                                CPF int NOT NULL,
                                PASSWORD varchar(255) NOT NULL,
                                LEVEL int
                              );

/* LOCATIONS TABLE */
DROP TABLE IF EXISTS includeplus.locations;
CREATE TABLE includeplus.locations(
                                ID int AUTO_INCREMENT PRIMARY KEY,
                                NAME varchar(255) NOT NULL,
                                LATITUDE double NOT NULL,
                                LONGITUDE double NOT NULL
                              );

/* POSTS TABLE */
DROP TABLE IF EXISTS includeplus.posts;
CREATE TABLE includeplus.posts(
                                ID int AUTO_INCREMENT PRIMARY KEY,
                                LOCATION_ID INT NOT NULL,
                                USER_ID INT NOT NULL,
                                PHOTO VARCHAR(255) NOT NULL,
                                TYPE VARCHAR(255) NOT NULL,
                                FILTER VARCHAR(255),
                                RESPONSE_POST_ID INT,
                                DISABLED BOOLEAN DEFAULT FALSE,
                                APPROVED BOOLEAN DEFAULT FALSE,
                                APPROVED_USER_ID INT
                              );
