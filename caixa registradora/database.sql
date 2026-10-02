CREATE DATABASE caixapro
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE caixapro;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('admin', 'caixa') NOT NULL DEFAULT 'caixa',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    valor_recebido DECIMAL(10,2) NOT NULL,
    troco DECIMAL(10,2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
);

CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (venda_id)
        REFERENCES vendas(id),

    FOREIGN KEY (produto_id)
        REFERENCES produtos(id)
);

INSERT INTO produtos
(nome, codigo, preco, estoque)
VALUES
('Coca-Cola', '1001', 2.00, 50),
('Água', '1002', 1.00, 100),
('Café', '1003', 1.50, 80),
('Sanduíche', '1004', 4.50, 30);