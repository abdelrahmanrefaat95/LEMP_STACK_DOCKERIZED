-- init.sql

CREATE DATABASE IF NOT EXISTS demo;
USE demo;

CREATE TABLE IF NOT EXISTS users (
  username VARCHAR(50),
  password VARCHAR(100),
  category VARCHAR(50)
);

CREATE USER IF NOT EXISTS 'abdelrahman'@'%' IDENTIFIED BY '123456789';
GRANT ALL PRIVILEGES ON demo.* TO 'abdelrahman'@'%';
FLUSH PRIVILEGES;

