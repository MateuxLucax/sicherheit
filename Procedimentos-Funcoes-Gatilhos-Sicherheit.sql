DROP DATABASE `Sicherheit`;

CREATE DATABASE `Sicherheit`;

USE `Sicherheit`;

CREATE TABLE IF NOT EXISTS `Clientes` (
    `RG` VARCHAR(15) PRIMARY KEY,
    `CPF` VARCHAR(15) NOT NULL,
    `Nome` VARCHAR(150) NOT NULL,
    `Endereco` VARCHAR(200) NOT NULL,
    `Telefone` VARCHAR(25) NOT NULL,
    `Quantidade_Carros` INT NULL
);

CREATE TABLE IF NOT EXISTS `Carros` (
    `Placa` VARCHAR(8) PRIMARY KEY,
    `Fabricante` VARCHAR(40) NOT NULL,
    `Modelo` VARCHAR(120) NOT NULL,
    `Ano` INT(4) NOT NULL,
    `RG_Cliente` VARCHAR(15) NOT NULL,
    FOREIGN KEY (`RG_Cliente`) REFERENCES `Clientes`(`RG`)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Ocorrencias` (
    `Codigo` INT PRIMARY KEY AUTO_INCREMENT,
    `Placa_Carro` VARCHAR(8) NOT NULL,
    `Data` DATE NOT NULL,
    `Local` VARCHAR(120) NOT NULL,
    `Valor_Multa` DECIMAL(6, 2) NOT NULL,
    `Descricao` VARCHAR(240) NOT NULL,
    FOREIGN KEY (`Placa_Carro`) REFERENCES `Carros`(`Placa`)
    ON DELETE CASCADE
);

-- Função

CREATE FUNCTION Multa_Dolar (multa DECIMAL(6, 2), dolar DECIMAL(6, 2))
RETURNS DECIMAL(6, 2)
RETURN multa * dolar;

SELECT Multa_Dolar((
SELECT `Valor_Multa`
FROM `Ocorrencias`
WHERE `Codigo` = 1), 4.15) AS 'Multa em dólar';

-- 1 Gatilho

DELIMITER $$
CREATE TRIGGER Quantidade_Carro_Cliente_Insert AFTER INSERT
ON `Carros`
FOR EACH ROW
BEGIN
    UPDATE `Clientes` SET `Quantidade_Carros` = `Quantidade_Carros` + 1
    WHERE `RG` = NEW.`RG_Cliente`;
END $$
DELIMITER ;

-- 2 Gatilho

DELIMITER $$
CREATE TRIGGER Quantidade_Carro_Cliente_Delete AFTER DELETE
ON `Carros`
FOR EACH ROW
BEGIN
    UPDATE `Clientes` SET `Quantidade_Carros` = `Quantidade_Carros` - 1
    WHERE `RG` = OLD.`RG_Cliente`;
END $$
DELIMITER ;

INSERT INTO `Clientes` VALUES ('124.123.123', '123.123.124-42', 'Carlos', 'Rua Carlos Gomes, 24, Rio do Oeste', '(47) 91234-1234', 0);
INSERT INTO `Clientes` VALUES ('583.432.843', '043.216.756-42', 'Pedro', 'Rua Pedro Albino, 25, Rio do Sul', '(47) 99548-4837', 0);

INSERT INTO `Carros` VALUES ('ASD-1234', 'Fiat', 'Uno', 2001, '124.123.123');
INSERT INTO `Carros` VALUES ('TRE-7590', 'Ford', 'Focus', 2010, '583.432.843');

INSERT INTO `Ocorrencias` VALUES (null ,'ASD-1234', '2018-05-05', 'Rio do Sul', 250.00 ,'Furou um pneu');

-- DELETE FROM `Carros` WHERE Placa = 'ASD-1234';
-- SELECT `RG`, `Quantidade_Carros` FROM `Clientes`;

-- 1 Procedimento

DELIMITER $$
CREATE PROCEDURE Atualiza_Ano_Carro (IN Novo_Ano INT(4), IN Carro VARCHAR(8))
BEGIN
	UPDATE `Carros`
    SET `Ano` = Novo_Ano
    WHERE `Placa` = Carro;
END $$
DELIMITER ;

CALL Atualiza_Ano_Carro(2004, 'ASD-1234');

SELECT * FROM `Carros` WHERE `Placa` = 'ASD-1234';

-- 2 Procedimento

DELIMITER $$
CREATE PROCEDURE Quantidade_Carros_Fabricante (IN Fabricante_Carro VARCHAR(40))
BEGIN
	SELECT COUNT(ca.`Placa`) AS 'Quantidade de carros' FROM Carros ca, Clientes cl
    WHERE cl.`RG` = ca.`RG_Cliente` AND ca.`Fabricante` = Fabricante_Carro;
END $$
DELIMITER ;

CALL Quantidade_Carros_Fabricante('Ford');
