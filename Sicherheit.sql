USE `u629327027_sich`;

CREATE TABLE IF NOT EXISTS `Clientes` (
    `RG` VARCHAR(15) PRIMARY KEY,
    `CPF` VARCHAR(15) NOT NULL,
    `Nome` VARCHAR(150) NOT NULL,
    `Endereco` VARCHAR(200) NOT NULL,
    `Telefone` VARCHAR(25) NOT NULL
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
