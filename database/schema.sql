CREATE DATABASE IF NOT EXISTS logistica
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE logistica;

CREATE TABLE IF NOT EXISTS motoristas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10) NOT NULL UNIQUE,
    modelo VARCHAR(100) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    ano INT NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS veiculo_motorista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    veiculo_id INT NOT NULL,
    motorista_id INT NOT NULL,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NULL,
    CONSTRAINT fk_vm_veiculo
        FOREIGN KEY (veiculo_id) REFERENCES veiculos(id),
    CONSTRAINT fk_vm_motorista
        FOREIGN KEY (motorista_id) REFERENCES motoristas(id),
    INDEX idx_vm_veiculo_ativo (veiculo_id, data_fim),
    INDEX idx_vm_motorista_ativo (motorista_id, data_fim)
);
