#  Sistema de Compra de Ingressos ou Produtos

Este é um sistema web simples e funcional para venda de produtos, 
com controle de clientes, produtos compras desenvolvido em PHP orientado a objetos com SQLite.

# Como Rodar o Projeto

###  Pré-requisitos

- PHP 7.4 ou superior instalado
- Composer (para o autoload)

### Passo a Passo

1. ##Instale as dependências com o Composer

   composer install

2. Inicie o servidor embutido do PHP

   php -S localhost:8000


 ### Diagrama Simples de Funcionamento

[Usuário] --> (Login.php) --> [Autenticação via sessão]

↓

[Painel Principal]

↓

│ Clientes   │ Produtos   │ Compras    │


CRUD   Completo         

Estoque   Registro  e Preço   de Compras
↓               ↓              ↓

[SQLite]  ←→  (Banco Único Local)

Relatórios




### Checklist de Funcionalidades

Login com sessão

Logout

Cadastro de clientes 

Cadastro de produtos 

Controle de estoque	 

Registro de compras	 

Relatório de compras 

Layout com Bootstrap 

Banco SQLite local	 

Composer autoload	 


### Estruturas de pastas

/DevEvolution2025
│

├── banco.sqlite              # Banco de dados SQLite

├── index.php                 # Página inicial / dashboard

├── login.php                 # Tela de login

├── logout.php                # Logout e fim de sessão

├── produtos.php              # CRUD de produtos

├── clientes.php              # CRUD de clientes

├── compras.php               # Registro de compras

├── usuarios.php              # Gerenciamento de usuários

├── /classes                  # Classes (Produto, Cliente, Usuario, etc.)

├── /templates                # Cabeçalho, rodapé, layout comum

├── /assets                   # CSS, JS, imagens

├── composer.json             # Autoload e dependências

└── README.md                 # Este arquivo



### detalhes

para testes na parte do admin use o usuário

admin@email.com

senha: admin


caso ainda nao estiver registrado, registre desta forma para acessar a aba do admin.