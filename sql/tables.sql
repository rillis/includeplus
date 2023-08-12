CREATE DATABASE IF NOT EXISTS includeplus;

/* USER TABLE */
DROP TABLE IF EXISTS includeplus.users;
CREATE TABLE includeplus.users(
                                id int AUTO_INCREMENT PRIMARY KEY,
                                name varchar(255) NOT NULL,
                                user varchar(255) not null,
                                cpf int NOT NULL,
                                password varchar(255) NOT NULL,
                                role varchar(255) DEFAULT 'user',
                                created_at timestamp not null
                              );

/* PLACES TABLE */
DROP TABLE IF EXISTS includeplus.places;
CREATE TABLE includeplus.places(
                                id int AUTO_INCREMENT PRIMARY KEY,
                                display_name varchar(255) NOT NULL,
                                address varchar(255) NOT NULL,
                                cep varchar(255) NOT NULL,
                                latitude double not null,
                                longitude double not null,
                                created_by int NOT NULL,
                                created_at timestamp not null
                              );

/* PLACE REQUESTS TABLE */
DROP TABLE IF EXISTS includeplus.place_requests;
CREATE TABLE includeplus.place_requests(
                                id int AUTO_INCREMENT PRIMARY KEY,
                                display_name varchar(255) NOT NULL,
                                latitude double not null,
                                longitude double not null,
                                created_by int NOT NULL,
                                created_at timestamp not null,
                                create_post int not null
                              );

/* POSTS TABLE */
DROP TABLE IF EXISTS includeplus.posts;
CREATE TABLE includeplus.posts(
                                id int AUTO_INCREMENT PRIMARY KEY,
                                place_id INT,
                                user_id INT NOT NULL,
                                photo VARCHAR(255) NOT NULL,
                                title VARCHAR(255) NOT NULL,
                                approved_by int,
                                dennied_by int,
                                created_at timestamp not null
                              );

/* REMOVALS TABLE */
DROP TABLE IF EXISTS includeplus.removals;
CREATE TABLE includeplus.removals(
                                id int AUTO_INCREMENT PRIMARY KEY,
                                post_id INT not null,
                                user_id INT NOT NULL,
                                photo VARCHAR(255) NOT NULL,
                                title VARCHAR(255) NOT NULL,
                                approved_by int,
                                dennied_by int,
                                created_at timestamp not null
                              );
