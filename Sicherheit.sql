CREATE DATABASE IF NOT EXISTS `Sicherheit`;

USE `Sicherheit`;

CREATE TABLE IF NOT EXISTS `Clientes` (
    `RG` VARCHAR(15) PRIMARY KEY,
    `CPF` VARCHAR(15) NOT NULL,
    `Nome` VARCHAR(150) NOT NULL,
    `Endereço` VARCHAR(200) NOT NULL,
    `Telefone` VARCHAR(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS `Carros` (
    `Placa` VARCHAR(7) PRIMARY KEY,
    `Fabricante` VARCHAR(120) NOT NULL,
    `Modelo` VARCHAR(120) NOT NULL,
    `Ano` DATE NOT NULL,
    `RG_Cliente` VARCHAR(15) NOT NULL,
    FOREIGN KEY (`RG_Cliente`) REFERENCES `Clientes`(`RG`)
);

CREATE TABLE IF NOT EXISTS `Ocorrencias` (
    `Codigo` INT PRIMARY KEY AUTO_INCREMENT,
    `Placa_Carro` VARCHAR(7) NOT NULL,
    `Data` DATE NOT NULL,
    `Local` VARCHAR(120) NOT NULL,
    `Descricao` VARCHAR(120) NOT NULL
);