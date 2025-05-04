# 🕹️ Sistema de Coleta e Validação de Perfis para E-sports

Este sistema foi desenvolvido para centralizar dados e validar identidades de usuários em plataformas de e-sports, com um foco na segurança e na relevância das informações compartilhadas. A solução integra dados pessoais, atividades sociais e validadores de identidade, com o objetivo de fortalecer a conexão entre jogadores e organizações de e-sports.

## 🚀 Proposta

A proposta deste sistema é criar uma plataforma completa para:

- 📝 **Coletar dados pessoais**:
  - Nome, endereço, CPF e outras informações relacionadas aos interesses, atividades, eventos e compras realizadas nos últimos 12 meses.
  
- 📂 **Upload e validação de documentos**:
  - Permitir o envio de documentos de identificação e utilizar **inteligência artificial** para validar esses documentos automaticamente.
  
- 🌐 **Integração com redes sociais**:
  - Conectar perfis de redes sociais dos usuários, capturando interações, páginas seguidas e atividades ligadas a organizações de e-sports, como a **FURIA**.

- 🔗 **Validação de links de perfis**:
  - Validar links de perfis em sites de e-sports e avaliar, com o apoio de **IA**, a relevância do conteúdo de acordo com o perfil do usuário.

## 🛠️ Funcionalidades

- **Cadastro de Usuário**: Formulário para coleta de dados pessoais e informações de interesse.
- **Upload de Documentos**: Suporte ao upload de documentos de identificação (ex.: RG, CNH) e validação com tecnologia **Tesseract OCR**.
- **Integração com Redes Sociais**: Conexão com perfis de redes sociais (Facebook, Instagram, Twitter) para extrair dados relacionados a organizações de e-sports.
- **Validação de Links de Perfis**: Validação de links em sites de e-sports, como o GiantBomb, usando inteligência artificial para avaliar a relevância do conteúdo.
- **Login e Autenticação de Usuários**: Sistema seguro de login, protegendo o acesso às funcionalidades da plataforma.

## 📋 Requisitos Funcionais

1. **Cadastro de Dados Pessoais**:
   - O sistema deve permitir o cadastro de nome, endereço, CPF, interesses, atividades e compras realizadas no último ano.
   - Todos os dados inseridos deverão ser validados para garantir a integridade e a precisão das informações.

2. **Upload de Documentos**:
   - O sistema deve permitir o envio de documentos (como RG, CNH, etc.).
   - A validação dos documentos será feita com o uso de **Tesseract OCR**.

3. **Integração com Redes Sociais**:
   - O sistema permitirá que os usuários vinculem seus perfis de redes sociais.
   - Será possível coletar interações, páginas seguidas e atividades de organizações de e-sports, como a **FURIA**.

4. **Validação de Links de Perfis em E-sports**:
   - O sistema validará links de perfis de e-sports, como os do **GiantBomb**, avaliando a relevância do conteúdo com IA.

5. **Login de Usuários**:
   - Os usuários poderão acessar a plataforma por meio de um login seguro.
   - O sistema usará **JWT (JSON Web Tokens)** para autenticação e proteção das credenciais.

## 📝 Requisitos Não Funcionais

1. **Usabilidade**:
   - A plataforma deverá ser intuitiva, com uma interface simples e fácil de usar, tanto em dispositivos móveis quanto em desktops.

2. **Segurança**:
   - Todos os dados pessoais e documentos carregados serão protegidos com criptografia.
   - O sistema usará **HTTPS** e **JWT** para garantir a segurança no login e nas trocas de dados.

3. **Desempenho**:
   - O sistema deve ser capaz de lidar com até 10.000 usuários simultâneos sem comprometer a performance.
   - A validação de documentos e links de perfis deve ser realizada de forma rápida e eficiente.

4. **Escalabilidade**:
   - A plataforma será desenvolvida para ser escalável, permitindo a expansão de funcionalidades e o suporte a um maior número de usuários e integrações no futuro.

5. **Confiabilidade**:
   - A plataforma deverá garantir um tempo mínimo de inatividade e ter integrações com APIs externas de redes sociais e validação de perfis de e-sports que sejam estáveis e confiáveis.

## 📜 Regras de Negócio

1. **Cadastro de Usuário**:
   - Os dados pessoais, como CPF e nome, devem ser únicos no sistema.
   - A validação do CPF será feita utilizando o algoritmo de dígitos verificadores.

2. **Validação de Documentos**:
   - O sistema aceitará apenas documentos nos formatos **.jpg, .png, .pdf**.
   - A validação dos documentos será realizada através de **Tesseract OCR**. Se a validação falhar, o usuário será notificado e solicitado a enviar um novo documento.

3. **Integração com Redes Sociais**:
   - A vinculação de redes sociais só será permitida mediante a autorização explícita do usuário.
   - O sistema extrairá dados das redes sociais dentro dos limites estabelecidos pelo usuário.

4. **Validação de Links de Perfis**:
   - O sistema verificará a relevância dos links de perfis em sites de e-sports, como o **GiantBomb**, com base nas interações e atividades relacionadas ao e-sports no conteúdo.

## 🔑 Login de Usuário

O login será implementado para garantir que apenas usuários autenticados possam acessar as funcionalidades da plataforma. O fluxo de login será:

### Fluxo de Login

1. **Tela de Login**:
   - O usuário fornecerá seu nome de usuário e senha.
   - O sistema validará as credenciais no banco de dados.

2. **Autenticação**:
   - A autenticação será feita usando **JWT (JSON Web Tokens)**, que garantirá uma experiência de login segura.
   - Se as credenciais forem válidas, o usuário será redirecionado para a página principal.

3. **Senha**:
   - As senhas serão criptografadas usando **bcrypt**.
   - O usuário poderá redefinir sua senha caso a esqueça, com um sistema de validação por e-mail.

4. **Segurança**:
   - Todas as interações do usuário com a plataforma ocorrerão via **HTTPS**.
   - O sistema implementará medidas de proteção contra ataques de força bruta e tentativas de login inválidas.

## ⚙️ Tecnologias

- **Backend**: PHP
- **Frontend**: JavaScript, Bootstrap, CSS, SCSS
- **Banco de Dados**: MySQL
- **Integrações de IA**:
  - **Football-Data.org**: Para integração com dados de futebol.
  - **GiantBomb.com**: Para informações sobre jogos e e-sports.
  - **Tesseract OCR**: Para validação de documentos com OCR (Reconhecimento Óptico de Caracteres).
- **Autenticação**: JWT (JSON Web Tokens) para autenticação segura.

## 🚀 Passo a Passo para Configuração do Ambiente

### 1. Instalar o XAMPP para Apache e MySQL

1. **Baixar o XAMPP**:
   - Acesse o [site oficial do XAMPP](https://www.apachefriends.org/index.html).
   - Clique em "Download" para a versão do seu sistema operacional.

2. **Instalar o XAMPP**:
   - Execute o instalador e siga as instruções, selecionando "Apache" e "MySQL" como componentes.

3. **Iniciar os Serviços**:
   - Abra o painel de controle do XAMPP e inicie os serviços **Apache** e **MySQL**.

4. **Verificar**:
   - Acesse `http://localhost` no navegador para verificar se o Apache está funcionando corretamente.

### 2. Instalar o Tesseract OCR no Windows

1. **Baixar o Tesseract OCR**:
   - Acesse o [GitHub do Tesseract OCR](https://github.com/tesseract-ocr/tesseract) ou baixe o instalador diretamente do [site oficial](https://github.com/UB-Mannheim/tesseract/wiki).

2. **Instalar o Tesseract**:
   - Execute o instalador e marque a opção **"Add Tesseract to the system path"**.

3. **Verificar a Instalação**:
   - Abra o Prompt de Comando (CMD) e digite `tesseract -v` para verificar a instalação.

### 3. Criar o Banco de Dados

1. **Criar o Banco de Dados**:
   - Abra o **phpMyAdmin** no XAMPP e crie um novo banco de dados chamado `esports_profile_validation`.

2. **Importar Estrutura do Banco de Dados**:
   - No arquivo `backend/sql/db.txt` do repositório, você encontrará o script SQL necessário para criar a estrutura do banco de dados.
   - Importe este arquivo no phpMyAdmin ou execute o seguinte comando:

     ```sql
     source C:/xampp/htdocs/esports-profile-validation/backend/sql/db.txt;
     ```

### 4. Estrutura de Pastas do Projeto

- Organize seu projeto no diretório **htdocs** do XAMPP com a seguinte estrutura de pastas:

- C:\xampp\htdocs\esports-profile-validation
- ├── frontend
- └── backend\

- O **frontend** conterá arquivos HTML, CSS, JavaScript e a interface com o usuário.
- O **backend** conterá arquivos PHP, configuração do banco de dados e lógica de negócios.

### 5. Instalar o Visual Studio Code (VS Code)

1. **Baixar o Visual Studio Code**:
   - Acesse o [site oficial do VS Code](https://code.visualstudio.com/).
   - Clique em **Download** para o seu sistema operacional.

2. **Instalar o Visual Studio Code**:
   - Execute o instalador e siga as instruções. Marque a opção **"Add to PATH"** para facilitar o uso do VS Code a partir do terminal.

3. **Instalar Extensões Recomendadas**:
   - Instale as extensões **PHP Intelephense**, **Prettier - Code Formatter**, e **Live Server** para uma melhor experiência de desenvolvimento.

4. **Abrir o Projeto no VS Code**:
   - No VS Code, clique em **File > Open Folder** e selecione a pasta `esports-profile-validation`.

---

## 🚀 Rodando o Sistema

1. **Iniciar o Servidor Apache e MySQL no XAMPP**:
   - No painel de controle do XAMPP, inicie os serviços **Apache** e **MySQL**.

2. **Acessar a Aplicação**:
   - Abra seu navegador e acesse `http://localhost/esports-profile-validation/frontend` para ver a aplicação em funcionamento.

## 📅 Contribuindo

Se você deseja contribuir com o projeto, fique à vontade para criar uma **pull request**. Siga estas etapas:

1. Faça um fork do repositório.
2. Crie uma branch para suas alterações: `git checkout -b minha-alteracao`.
3. Commit suas alterações: `git commit -am 'Adicionando nova funcionalidade'`.
4. Push para a branch: `git push origin minha-alteracao`.
5. Abra uma **pull request**!

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
