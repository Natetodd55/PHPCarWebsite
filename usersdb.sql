CREATE DATABASE IF NOT EXISTS cs_350;
CREATE TABLE IF NOT EXISTS cs_350.users(
    id int NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) UNIQUE NOT NULL,
    password VARCHAR(72),
    PRIMARY KEY(id)
);
CREATE TABLE IF NOT EXISTS cs_350.cars(
    id int NOT NULL AUTO_INCREMENT,
    make VARCHAR(30) NOT NULL,
    model VARCHAR(30) NOT NULL,
    year int NOT NULL,
    price int NOT NULL,
    description VARCHAR(250),
    ownerId int,
    PRIMARY KEY(id),
    FOREIGN KEY(ownerId) REFERENCES users(id)
);