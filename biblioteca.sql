CREATE TABLE Livros (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL
);

CREATE TABLE Autores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    nacionalidade VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    biografia TEXT
);

CREATE TABLE Clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_cadastro DATETIME NOT NULL
);

CREATE TABLE Pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    data_pedido DATETIME NOT NULL,
    status VARCHAR(50) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES Clientes(id)
);

CREATE TABLE Itens_Pedido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT NOT NULL,
    livro_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedidos(id),
    FOREIGN KEY (livro_id) REFERENCES Livros(id)
);

CREATE TABLE Categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    data_criacao DATETIME NOT NULL,
    status VARCHAR(50) NOT NULL
);

CREATE TABLE Livros_Categorias (
    livro_id INT NOT NULL,
    categoria_id INT NOT NULL,
    PRIMARY KEY (livro_id, categoria_id),
    FOREIGN KEY (livro_id) REFERENCES Livros(id),
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

CREATE TABLE Fornecedores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    contato VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL
);

CREATE TABLE Livros_Fornecedores (
    livro_id INT NOT NULL,
    fornecedor_id INT NOT NULL,
    PRIMARY KEY (livro_id, fornecedor_id),
    FOREIGN KEY (livro_id) REFERENCES Livros(id),
    FOREIGN KEY (fornecedor_id) REFERENCES Fornecedores(id)
);

CREATE TABLE Usuarios_ADM(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) UNIQUE NOT NULL,
    FOREIGN KEY (livro_id) REFERENCES Livros(id),
    FOREIGN KEY (fornecedor_id) REFERENCES Fornecedores(id)
    FOREIGN KEY (cliente_id) REFERENCES Clientes(id)
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);


