<?php 
session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: catalogo.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="style.css"> <!-- Link para arquivo CSS externo -->
    <style>
        /* Estilos CSS internos */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f0f0;
            color: #333;
        }
        header {
            background-color: #e53935; /* Vermelho forte */
            color: white;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        main {
            padding: 20px;
            margin: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        h3 {
            color: #b71c1c; /* Vermelho mais escuro */
        }
        .menu {
            margin: 20px 0;
        }
        a {
            color: #e53935;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #e53935;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #e53935;
            color: white;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #999;
        }
    </style>
</head>
<body>
    <?php if ($seguranca) { ?>
        <header>
            <h1>Painel Administrativo</h1>
            <h3>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h3>
        </header>
        
        <main>
            <div class="menu">
                <?php include "layout/menu.php"; ?>
            </div>
            <p>Escolha uma das opções no menu para gerenciar o sistema.</p>
        </main>
        
        <footer>
            <p>&copy; 2024 Painel Administrativo. Todos os direitos reservados.</p>
        </footer>
    <?php } ?>
</body>
</html>
