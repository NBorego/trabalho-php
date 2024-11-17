# Sistema de Vendas

Um sistema simples de vendas feito com PHP e MySQL, utilizando Bootstrap para a interface. O sistema permite gerenciar clientes, produtos e pedidos, oferecendo funcionalidades básicas para cadastro e visualização de dados.

## Funcionalidades

- `config.php`: Configuração de conexão com o banco de dados.
- `index.php`: Página inicial que lista todos os produtos.
- `cliente.php`: Página para cadastro de novos clientes.
- `produto.php`: Página para cadastro de novos produtos.
- `pedido.php`: Página para criação de novos pedidos.
- `lista_pedidos.php`: Página que lista todos os pedidos realizados.
- `editar_pedido.php`: Página que edita um pedido
- `excluir_pedido.php`: Página que exclui um pedido
- `pedido_itens.php`: Página que exibe os itens de um pedido específico
- `pedido_itens.php`: Página que exibe os itens de um pedido específico
- `pedido_itens.php`: Página que exibe os itens de um pedido específico

## Banco de dados

```sql
CREATE DATABASE sistema_vendas;

USE sistema_vendas;

CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  telefone VARCHAR(15),
  senha VARCHAR(255) NOT NULL
);

CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  preco DECIMAL(10, 2) NOT NULL,
  estoque INT NOT NULL
);

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT,
  data_pedido DATE NOT NULL,
  total DECIMAL(10, 2),
  FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE TABLE pedido_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT,
  produto_id INT,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10, 2),
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
```