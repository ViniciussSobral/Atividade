<?php  
session_start();
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: catalogo.php"); // Redireciona para manter o usuário na mesma página
    exit();
}

require_once "functions.php";

// Verifica se o formulário de login foi submetido
if (isset($_POST['acessar'])) {
    login($connect);
}

// Garantir conexão ao banco de dados
if (!isset($connect)) {
    die("Erro de conexão com o banco de dados.");
}

// Buscar itens do cardápio
$tabela = "cardapio";
$order = "titulo";
$cardapios = buscar($connect, $tabela, 1, $order);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Bolos - VINI BOLOS</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Cabeçalho */
        header {
            background-color: #d2ab72;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            color: white;
        }
        .logo img {
            height: 50px;
        }
        .menu a {
            margin-left: 20px;
            font-weight: bold;
            color: white;
            transition: color 0.3s;
        }
        .menu a:hover {
            color: #ffc107;
        }
        .icons img {
            height: 25px;
            margin-left: 15px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .icons img:hover {
            transform: scale(1.1);
        }

        /* Barra Promocional */
        .promo-bar {
            background-color: #d04a22;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        /* Login */
        .login-form {
        text-align: left; /* Alinha o texto à esquerda */
        margin-bottom: 40px; /* Mantém o espaçamento inferior */
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            display: block; /* Remove o alinhamento inline */
            width: 100%; /* Ajusta para ocupar toda a largura */
            max-width: 400px; /* Define uma largura máxima para o formulário */
            margin: 0; /* Remove o alinhamento ao centro */
        }
        legend {
            font-size: 18px;
            font-weight: bold;
            color: #d2ab72;
        }
        input[type="text"], input[type="password"] {
            width: 250px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Bem-vindo */
        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
        }
        .welcome-message {
            font-size: 18px;
            color: #333;
        }
        .admin-panel-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffc107;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .admin-panel-button:hover {
            background-color: #e0a800;
        }

        /* Catálogo */
        .catalog-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #d2ab72;
        }
        .cardapio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .cardapio-item {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .cardapio-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cardapio-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .cardapio-content {
            padding: 15px;
        }
        .cardapio-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .cardapio-description {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }
        .buy-button {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .buy-button:hover {
            background-color: #218838;
        }

        /* Footer */
        footer {
            background-color: #f9f9f9;
            padding: 20px 0;
            border-top: 1px solid #ddd;
        }
        .footer-container {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .footer-section {
            font-size: 14px;
            color: #555;
        }
        .footer-section h3 {
            margin-bottom: 10px;
            color: #d2ab72;
            font-size: 18px;
        }
        .footer-section ul {
            list-style: none;
            padding: 0;
        }
        .footer-section ul li {
            margin-bottom: 8px;
        }
        .footer-section ul li a {
            color: #555;
        }
        .footer-section ul li a:hover {
            color: #333;
        }
        .logout-button {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}
.logout-button:hover {
    background-color: #b02a37;
}

    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="logo">
            <img src="https://www.mamacida.com.br/image/data/Logo/mamacida-logo-delivery-saopaulo.png" alt="VINI BOLOS">
        </div>
        <nav class="menu">
            <a href="#">Menu</a>
        </nav>
        <div class="icons">
    <?php if (isset($_SESSION['usuario'])): ?>
        <form action="" method="POST" style="display: inline;">
            <button type="submit" name="logout" class="logout-button">Sair</button>
        </form>
    <?php else: ?>
        <!-- Botão para redirecionar ao login -->
        <a href="login.php" class="logout-button">Login</a>
    <?php endif; ?>
</div>

            
        </div>
    </header>

    <!-- Barra Promocional -->
    <div class="promo-bar">
        10% off para o primeiro pedido! Cupom: adorei10
    </div>

    <!-- Login ou Bem-vindo -->
    <?php if (isset($_SESSION['usuario'])): ?>
    <div class="welcome-section">
        <div class="welcome-message">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</div>
        <a href="index.php" class="admin-panel-button">Painel Administrativo</a>
    </div>
<?php endif; ?>


    <!-- Catálogo -->
    <div class="container">
        <h1 class="catalog-title">Catálogo de Bolos</h1>
        <div class="cardapio-grid">
            <?php foreach ($cardapios as $cardapio): ?>
                <div class="cardapio-item">
                    <?php if (!empty($cardapio['imagem'])): ?>
                        <img src="<?php echo getImagePath($cardapio['imagem']); ?>" alt="<?php echo $cardapio['titulo']; ?>">
                    <?php else: ?>
                        <img src="placeholder.jpg" alt="Imagem não disponível">
                    <?php endif; ?>
                    <div class="cardapio-content">
                        <div class="cardapio-title"><?php echo htmlspecialchars($cardapio['titulo']); ?></div>
                        <div class="cardapio-description"><?php echo htmlspecialchars($cardapio['descricao']); ?></div>
                        <a href="#" class="buy-button">Comprar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Sobre VINI BOLOS</h3>
                <p>Desde 2003, VINI BOLOS produz e comercializa bolos caseiros de altíssima qualidade.</p>
            </div>
            <div class="footer-section">
                <h3>Horários</h3>
                <p>Seg. a Sáb. - 8h às 17h</p>
                <p>Domingos - Fechado</p>
            </div>
            <div class="footer-section">
                <h3>Links úteis</h3>
                <ul>
                    <li><a href="#">A Empresa</a></li>
                    <li><a href="#">Políticas</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <ul>
                    <li>Email: contato@vinibolos.com</li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
