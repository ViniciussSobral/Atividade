<?php 
require_once "db_connect.php";
require_once "functions.php";

if (isset($_POST['acessar'])) {
    login($connect); // Função para realizar o login
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acessar</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background-color: #8B0000; /* Vermelho escuro */
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }
        header nav {
            display: flex;
            gap: 15px;
        }
        header nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        header nav a:hover {
            text-decoration: underline;
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin: auto;
            text-align: center;
        }
        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            width: 100%;
            text-align: left;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%; /* Define largura igual */
            font-size: 14px;
            box-sizing: border-box; /* Garante que padding e border não afetem o tamanho total */
        }

        .password-container {
            position: relative;
            width: 100%; /* Igual ao campo de texto */
        }

        .password-container input {
            width: calc(100% - 40px);
        }
        .password-container .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #666;
        }
        .password-container .toggle-password:hover {
            color: #000;
        }
        .login-container a {
            font-size: 14px;
            color: #d4b26c; /* Dourado */
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .login-container .submit-btn {
            padding: 10px;
            background-color: #28a745; /* Verde */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            transition: background-color 0.2s ease;
        }
        .login-container .submit-btn:hover {
            background-color: #218838;
        }

        /* Footer */
        footer {
            background-color: #8B0000; /* Vermelho escuro */
            color: white;
            padding: 20px;
            margin-top: auto;
        }
        footer .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        footer .footer-section {
            flex: 1;
            margin: 10px;
        }
        footer .footer-section h3 {
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        footer .footer-section ul {
            list-style: none;
            padding: 0;
        }
        footer .footer-section ul li {
            margin-bottom: 5px;
        }
        footer .footer-section ul li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }
        footer .footer-section ul li a:hover {
            text-decoration: underline;
        }
        footer .social-icons {
            display: flex;
            gap: 10px;
        }
        footer .social-icons a {
            color: white;
            font-size: 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">VINI BOLOS</div>
        <nav>
            <a href="#">Natal</a>
            <a href="#">Presentes</a>
            <a href="#">Tortas</a>
            <a href="#">Congelados</a>
            <a href="#">Comidinhas</a>
        </nav>
    </header>

    <div class="login-container">
        <h1>Acessar</h1>
        <form action="" method="POST">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" required>

            <label for="senha">Senha:</label>
            <div class="password-container">
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                <span class="toggle-password" id="toggleSenha">&#128065;</span>
            </div>

            <a href="#">Esqueceu sua senha?</a>

            <input type="submit" name="acessar" value="ENTRAR" class="submit-btn">
        </form>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Métodos de Pagamento</h3>
                <ul>
                    <li>MasterCard</li>
                    <li>Visa</li>
                    <li>American Express</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Lojas</h3>
                <ul>
                    <li>Shopping Salvador</li>
                    <li>Shopping Barra</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Pedidos e Devoluções</h3>
                <ul>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Fale Conosco</a></li>
                </ul>
            </div>
            <div class="footer-section social-icons">
                <a href="#">&#xf09a;</a> <!-- Facebook -->
                <a href="#">&#xf099;</a> <!-- Twitter -->
            </div>
        </div>
    </footer>

    <script>
        const senhaInput = document.getElementById('senha');
        const toggleSenha = document.getElementById('toggleSenha');

        toggleSenha.addEventListener('click', () => {
            const isPassword = senhaInput.type === 'password';
            senhaInput.type = isPassword ? 'text' : 'password';
            toggleSenha.textContent = isPassword ? '👁️' : '🔒';
        });
    </script>
</body>
</html>
