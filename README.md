# Site Leyo+ - Sistema de venda de livros online

Projeto como atividade de final de semestre do 2° módulo de DS - ETEC GRU.
O sistema é um site de venda de livros, baseado no tema biblioteca, desenvolvido em PHP com front-end em HTML e CSS, além de um banco de dados em MySQL.

## Estrutura do projeto

- **banco/**: Contém scripts relacionados ao banco de dados.
- **htmls/**: Páginas HTML do sistema.
- **php/**: Scripts PHP que implementam a lógica da aplicação (conexão ao banco, inserção, exclusão, etc).
- **styles/**: Arquivos CSS para o estilo das páginas.
- **img/**: Imagens utilizadas na aplicação.
- **uploads/**: Diretório para armazenar arquivos enviados.

## Funcionalidades principais

- Cadastro de livros.
- Listagem dos livros cadastrados.
- Operações básicas de CRUD (Criar, Ler, Atualizar, Deletar).
- Interface web simples para interação.

## Tecnologias utilizadas

- PHP
- HTML
- CSS
- MySQL

## Como usar

1. Configure um servidor local com suporte a PHP e MySQL (ex: XAMPP, WAMP).
2. Importe o banco de dados usando o script localizado na pasta `banco/`.
3. Coloque os arquivos do projeto no diretório raiz do servidor local.
4. Acesse a aplicação via navegador, abrindo as páginas em `htmls/`.

## Observações

- Certifique-se de configurar corretamente as credenciais de banco de dados no arquivo `php/banco.php`.
- O sistema é básico e pode ser estendido para incluir autenticação, melhorias na interface, entre outros.
