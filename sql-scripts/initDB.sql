create database Chat;
use Chat;
create table messages
(
    id       int AUTO_INCREMENT,
    username varchar(32),
    text     varchar(255),
    datetime datetime,
    PRIMARY KEY (id)
);
create table users
(
    id       int AUTO_INCREMENT,
    login    varchar(32),
    password varchar(50),
    logo     varchar(255),
    PRIMARY KEY (id)
);
show tables;

create user 'ChatUser'@'%' IDENTIFIED BY 'ChatPassword';
grant SELECT, INSERT, UPDATE, DELETE on `Chat`.* TO `ChatUser`@`%`;