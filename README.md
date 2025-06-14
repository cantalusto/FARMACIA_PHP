# Sistema de Gestão para Farmácia - Pague Mais

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

##  фармацевтическое управление

Um mini-sistema web responsivo desenvolvido em PHP com PDO para a gestão de uma farmácia fictícia. O projeto conta com um sistema de autenticação robusto com diferentes níveis de acesso e três módulos de gerenciamento (CRUDs).

## ✨ Funcionalidades Principais

O sistema foi projetado com uma clara separação de responsabilidades entre os tipos de usuário:

### Para todos os usuários logados:
- **Visualização de Clientes:** Acesso de somente leitura à lista de clientes cadastrados.
- **Visualização de Produtos:** Acesso de somente leitura ao catálogo de produtos, seus preços e estoque.

### Apenas para usuários `Admin`:
- **Login Seguro:** Sistema de autenticação com senhas criptografadas.
- **Gerenciamento Completo de Clientes (CRUD):** Adicionar, editar e remover clientes.
- **Gerenciamento Completo de Produtos (CRUD):** Adicionar, editar e remover produtos do catálogo.
- **Gerenciamento de Usuários (CRUD):** Criar, editar e remover contas de outros usuários (admins e funcionários), com proteção para não se auto-excluir ou modificar.

## 🚀 Tecnologias Utilizadas

* **Backend:** PHP 8+
* **Banco de Dados:** MySQL
* **Conexão com Banco:** PDO (PHP Data Objects) para uma conexão segura e preparada.
* **Frontend:** HTML5, Bootstrap 5 (via CDN) para um design moderno e responsivo.
* **Segurança:**
    * `password_hash()` e `password_verify()` para armazenamento seguro de senhas.
    * Sessões PHP (`$_SESSION`) para controle de autenticação e permissões.
    * Uso de `htmlspecialchars()` para prevenir ataques XSS.
    * Prepared Statements (PDO) para prevenir injeção de SQL.

## 🛠️ Instalação e Configuração

Siga os passos abaixo para rodar o projeto em um ambiente local.

### Pré-requisitos
* Um ambiente de servidor local como [XAMPP](https://www.apachefriends.org/index.html) ou WAMP.
* Um gerenciador de banco de dados como o phpMyAdmin (incluído no XAMPP).

### Passos
1.  **Clone o Repositório:**
    ```bash
    git clone [https://github.com/SEU-USUARIO/SEU-REPOSITORIO.git](https://github.com/SEU-USUARIO/SEU-REPOSITORIO.git)
    ```
    Ou baixe o ZIP e extraia na pasta `htdocs` do seu XAMPP. Renomeie a pasta do projeto para `farma`.

2.  **Configure o Banco de Dados:**
    * Abra o phpMyAdmin (ex: `http://localhost/phpmyadmin`).
    * Crie um novo banco de dados chamado `farmacia_db`.
    * Selecione o banco recém-criado e vá para a aba **"Importar"**.
    * Escolha o arquivo `banco_de_dados.sql` da raiz do projeto e execute a importação.

3.  **Crie o Usuário Administrador Master:**
    * No seu navegador, acesse o script de criação do admin:
        ```
        http://localhost/farma/criar_admin.php
        ```
    * Isso criará o primeiro usuário com as credenciais:
        - **Usuário:** `admin`
        - **Senha:** `admin123`
    * **IMPORTANTE:** Por segurança, **apague o arquivo `criar_admin.php`** da pasta do projeto após executar este passo.

4.  **Acesse o Sistema:**
    * Pronto! Agora acesse a página inicial do sistema:
        ```
        http://localhost/farma/
        ```
    * Você será redirecionado para a tela de login.

## 🎮 Como Usar o Sistema

### Login como Administrador
-   Use as credenciais `admin` / `admin123` (ou a que você criou).
-   Você verá o menu principal com três opções: "Consultar Clientes", "Consultar Produtos" e "Gerenciar Usuários".
-   Em "Gerenciar Usuários", você pode criar uma nova conta com o tipo **"Funcionário"**.

### Login como Funcionário
-   Crie uma conta de funcionário usando sua conta de admin.
-   Faça logout e entre com as novas credenciais do funcionário.
-   Você verá o menu principal com apenas duas opções: "Consultar Clientes" e "Consultar Produtos".
-   Ao acessar essas áreas, você verá as listas, mas não terá os botões para adicionar, editar ou excluir registros.

## 👥 Autor

* [Lucas Cantarelli Lustosa]


---
Feito com ❤️ e PHP.