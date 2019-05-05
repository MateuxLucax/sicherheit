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

INSERT INTO `Clientes`
VALUE ('124.123.123', '123.123.124-42', 'Carlos', 'Rua Carlos Gomes, 24, Rio do Oeste', '(47) 91234-1234'),
      ('583.432.843', '043.216.756-42', 'Pedro', 'Rua Pedro Albino, 25, Rio do Sul', '(47) 99548-4837');

INSERT INTO `Carros` 
VALUE ('ASD-1234', 'Fiat', 'Uno', 2001, '124.123.123'),
      ('TRE-7590', 'Ford', 'Focus', 2010, '583.432.843');
      
INSERT INTO `Ocorrencias` 
VALUE ( null , 'ASD-1234', '05-08-2018', 'Rio do Sul', 250.00 ,'Furou um pneu'),
      ( null, 'TRE-7590', '05-12-2018', 'Aurora', 650.00 ,'Bateu o carro em um poste por estar embriagado');