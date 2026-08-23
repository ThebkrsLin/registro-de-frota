CREATE DATABASE IF NOT EXISTS registro_de_frota;

USE registro_de_frota;

CREATE TABLE IF NOT EXISTS motoristas(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    ativo BOOLEAN NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME,
    PRIMARY KEY(id)
) DEFAULT CHARSET =  utf8mb4;

CREATE TABLE IF NOT EXISTS veiculos(
    id INT NOT NULL AUTO_INCREMENT,
    placa VARCHAR(10) NOT NULL UNIQUE,
    modelo VARCHAR(100) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    ano INT NOT NULL,
    ativo BOOLEAN NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME,
    motorista_id INT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(motorista_id) 
        REFERENCES motoristas(id)
        ON DELETE SET NULL
) DEFAULT CHARSET = utf8mb4;
