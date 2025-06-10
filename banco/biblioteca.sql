-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS livraria;
USE livraria;

-- Tabela de Autores
CREATE TABLE autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(50)
);

-- Tabela de Editoras
CREATE TABLE editoras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    pais VARCHAR(50)
);

-- Tabela de Categorias (gêneros literários)
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- Tabela de Livros
CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descricao TEXT,
    autor_id INT,
    editora_id INT,
    categoria_id INT,
    ano_publicacao INT,
    imagem VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2),
    estoque INT NOT NULL,
    FOREIGN KEY (autor_id) REFERENCES autores(id),
    FOREIGN KEY (editora_id) REFERENCES editoras(id),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabela de Usuários (Clientes)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    endereco TEXT,
    telefone VARCHAR(20)
);

-- Tabela de Pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Armazena automaticamente a data e hora em que o pedido foi criado
    status ENUM('pendente', 'pago', 'enviado', 'cancelado') DEFAULT 'pendente', -- Define o status atual do pedido. Só aceita os valores especificados.
    -- Se nenhum valor for informado, será definido como 'pendente' por padrão.
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Itens do Pedido
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    livro_id INT,
    quantidade INT,
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (livro_id) REFERENCES livros(id)
);

-- Tabela de Vendas (registro individual de vendas avulsas, opcional)
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT,
    data_venda DATE,
    quantidade INT,
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (livro_id) REFERENCES livros(id)
);

-- Tabela de Administradores
CREATE TABLE usuarios_adm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuarios_adm (nome, senha) VALUES ('admin', 'admin12345');

INSERT INTO categorias (nome) VALUES
('Ficção Científica'),
('Romance'),
('Fantasia'),
('Terror'),
('Aventura'),
('Biografia'),
('Histórico'),
('Autoajuda');