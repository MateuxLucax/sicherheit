CREATE DATABASE IF NOT EXISTS `Sicherheit`;

CREATE TABLE IF NOT EXISTS `Clientes` (
    `RG` VARCHAR(15) PRIMARY KEY,
    `CPF` VARCHAR(15) NOT NULL,
    `Nome` VARCHAR(150) NOT NULL,
    `Endereço` VARCHAR(200),
    `Telefone` VARCHAR(25)
);

CREATE TABLE IF NOT EXISTS `Carros` (
    `Placa` VARCHAR(7) PRIMARY KEY,
    `Fabricante` VARCHAR(120),
    `Modelo` VARCHAR(120),
    `Ano` DATE,
    `RG_Cliente` VARCHAR(15),
    FOREIGN KEY (`RG_Cliente`) REFERENCES `Clientes`(`RG`)
);

CREATE TABLE IF NOT EXISTS `Ocorrencias` (
    `Placa_Carro` VARCHAR(7) PRIMARY KEY,
    `Data` DATE,
    `Local` VARCHAR(120),
    `Descricao` VARCHAR(120)
);

CREATE TABLE IF NOT EXISTS `Ocorrencia_Carro` (
    `Carro_Placa` PRIMARY KEY,
    `Ocorrencia_Carro` PRIMARY KEY,
    FOREIGN KEY (`Carro_Placa`) REFERENCES `Carros`(`Placa`),
    FOREIGN KEY (`Ocorrencia_Carro`) REFERENCES `Ocorrencias`(`Placa_Carro`)
);