Este é um sistema de login básico desenvolvido em PHP e MySQL. O sistema permite que os usuários façam login utilizando suas credenciais e tenham acesso a diferentes áreas com base em seu cargo.

Requisitos

Servidor web (como Apache) com suporte a PHP
Servidor de banco de dados MySQL
Extensão MySQLi habilitada no PHP
Configuração do Banco de Dados
Crie um banco de dados no seu servidor MySQL.
Importe o arquivo database.sql para criar a tabela usuarios no banco de dados.

Configuração do Projeto

Copie todos os arquivos para o diretório raiz do seu servidor web.
Abra o arquivo connect.php e ajuste as informações de conexão com o banco de dados ($servername, $username, $password, $dbname) de acordo com a sua configuração.

Funcionalidades do Sistema
Login: Os usuários podem fazer login fornecendo seu e-mail e senha. O sistema verifica as credenciais no banco de dados e redireciona o usuário para a área correspondente com base em seu cargo.
Cadastro: Os usuários podem se cadastrar fornecendo seu e-mail e senha. O sistema verifica se o e-mail já está cadastrado e insere o novo usuário no banco de dados com base no domínio do e-mail.
Sessão de Usuário: O sistema utiliza sessões para manter o usuário autenticado durante a sessão. As informações do usuário são armazenadas na sessão, permitindo o acesso ao banco de dados específico do usuário durante a sessão.
Logout: Os usuários podem encerrar a sessão e fazer logout a qualquer momento.

Arquivos Principais

index.php: Página de login do sistema.
login.php: Script que trata o processo de login.
cadastro.php: Página de cadastro de novos usuários.
quiz.php: Página para criar um novo quiz.
connect.php: Arquivo de conexão com o banco de dados.
logout.php: Script para encerrar a sessão do usuário.

Instalação:

1° - Baixe o wampserver por esse link, e instale-o em sua máquina.
https://www.wampserver.com/en/download-wampserver-64bits/

2° - coloque essa pasta no diretorio wamp64\www. (Que se localiza onde o wampserver foi instalado)

3° - Crie um banco de dados com o nome 'login',que pode ser acessado atravez do PhpMyAdmin. (que ja vem instalado no wampserver)

4° - importe o banco de dados disponivel na pasta "bd" do projeto no mysql.

5° - Por ultimo, no seu guia do navegador , escreva "http://localhost/xastre_final/".

6° - Aproveite.
