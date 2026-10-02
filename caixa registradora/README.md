# CaixaPro

Sistema de caixa desenvolvido para praticar e integrar conhecimentos de desenvolvimento Web Front-end e Back-end.

O CaixaPro simula um sistema de ponto de venda, permitindo realizar vendas, controlar produtos e estoque e diferenciar permissões entre operadores de caixa e administradores.

## Funcionalidades

* Login e autenticação de usuários
* Cadastro de usuários
* Diferenciação entre Administrador e Operador de Caixa
* Controle de acesso através de sessões
* Cadastro de produtos
* Gerenciamento de produtos
* Controle de estoque
* Carrinho de compras
* Registro de vendas
* Cálculo automático do total
* Cálculo de troco
* Área administrativa protegida
* Armazenamento das vendas no banco de dados

## Tecnologias

* HTML5
* CSS3
* JavaScript
* PHP
* MySQL
* XAMPP

## Estrutura do projeto

```text
caixa-registradora/
│
├── admin.php
├── cadastro.html
├── caixa.php
├── index.html
├── database.sql
├── .gitignore
├── README.md
│
├── css/
│   └── style.css
│
├── js/
│   └── script.js
│
└── php/
    ├── admin_produtos.php
    ├── cadastro.php
    ├── conexao.php
    ├── login.php
    ├── produtos.php
    ├── proteger.php
    ├── proteger_admin.php
    └── vendas.php
```

## Banco de dados

O projeto utiliza MySQL para armazenar:

* Usuários
* Produtos
* Vendas
* Itens das vendas

O arquivo `database.sql` contém a estrutura necessária para criar o banco de dados e alguns produtos de teste.

## Como executar

### 1. Instalar o XAMPP

O projeto utiliza Apache, PHP e MySQL através do XAMPP.

### 2. Colocar o projeto no htdocs

Copie a pasta do projeto para:

```text
C:\xampp\htdocs\
```

### 3. Iniciar o XAMPP

Inicie:

* Apache
* MySQL

### 4. Criar o banco de dados

Abra o phpMyAdmin e execute o conteúdo do arquivo:

```text
database.sql
```

### 5. Acessar o sistema

No navegador:

```text
http://localhost/caixapro/
```

## Controle de acesso

O sistema possui dois tipos de usuários:

### Administrador

Possui acesso à área administrativa para gerenciamento de produtos e estoque.

### Operador de Caixa

Possui acesso às funções relacionadas ao atendimento e realização de vendas.

O controle de acesso é realizado através de sessões PHP.

## Objetivo do projeto

O CaixaPro foi desenvolvido como projeto de estudo e portfólio, com o objetivo de praticar a integração entre Front-end, Back-end e banco de dados.

Durante o desenvolvimento foram trabalhados conceitos como:

* PHP
* SQL
* CRUD
* Autenticação
* Sessões
* Relacionamento entre tabelas
* Requisições com JavaScript
* Integração entre Front-end e Back-end
* Controle de permissões

## Status

Em desenvolvimento.

Novas funcionalidades e melhorias poderão ser adicionadas ao projeto posteriormente.
