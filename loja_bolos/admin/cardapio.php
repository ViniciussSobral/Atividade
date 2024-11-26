<?php 
session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: catalogo.php");
require_once "db_connect.php";
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Admin - Cardápio</title>
    <style>
        /* Estilo Geral */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        header h1, header h3 {
            margin: 0;
        }
        main {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        .menu {
            margin-bottom: 20px;
        }
        a {
            color: #007BFF;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border: 1px solid #007BFF;
            border-radius: 5px;
            transition: all 0.3s;
        }
        a:hover {
            background-color: #007BFF;
            color: white;
        }
        .container {
            margin-top: 20px;
        }
        .container a {
            display: inline-block;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        td img {
            border-radius: 8px;
            max-width: 150px;
            height: auto;
        }
        .confirm-delete h2 {
            color: red;
        }
        .confirm-delete form {
            display: inline-block;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #dc3545;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #a71d2a;
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
            <h2>Gerenciador do Cardápio</h2>
            <div class="menu">
                <?php include "layout/menu.php"; ?>
            </div>
            
            <?php 
                $tabela = "cardapio";
                $order = "titulo";
                $cardapios = buscar($connect, $tabela, 1, $order);

                if (isset($_GET['id'])) { ?>
                    <div class="confirm-delete">
                        <h2>Tem certeza que deseja deletar o item do cardápio: <?php echo htmlspecialchars($_GET['titulo']); ?>?</h2>
                        <form action="cardapio.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                            <input type="submit" name="deletar" value="Deletar">
                        </form>
                    </div>
                <?php }

                if (isset($_POST['deletar']) && !empty($_POST['id'])) {
                    deletar($connect, $tabela, $_POST['id']);
                }
            ?>
            
            <div class="container">
                <a href="form_cardapio.php">Inserir novo item</a>
                <table>
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Título</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cardapios as $cardapio) { ?>
                            <tr>
                                <td>
                                    <?php if (!empty($cardapio['imagem'])) { ?>
                                        <img src="<?php echo htmlspecialchars(getImagePath($cardapio['imagem'])); ?>" alt="<?php echo htmlspecialchars($cardapio['titulo']); ?>">
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($cardapio['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($cardapio['data_registro']); ?></td>
                                <td>
                                    <a href="cardapio.php?id=<?php echo htmlspecialchars($cardapio['id']); ?>&titulo=<?php echo htmlspecialchars($cardapio['titulo']); ?>">Excluir</a>
                                    <a href="form_cardapio.php?id=<?php echo htmlspecialchars($cardapio['id']); ?>&titulo=<?php echo htmlspecialchars($cardapio['titulo']); ?>">Atualizar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    <?php } ?>
</body>
</html>
