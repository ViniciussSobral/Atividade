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
    <title>Painel Admin - Editar Usuário</title>
    <style>
        /* Estilo Geral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
    background-color: #007BFF; /* Fundo azul */
    color: white; /* Cor da fonte branca */
    text-align: center;
    padding: 30px 0;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 1px;
}
header h1 {
    margin: 0;
    font-size: 32px;
    color: white; /* Cor da fonte branca */
}
header h3 {
    margin: 5px 0 0;
    font-size: 18px;
    font-weight: normal;
    color: white; /* Cor da fonte branca */
}

        main {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #007BFF;
            margin: 10px 0;
        }
        form {
            margin: 20px 0;
        }
        fieldset {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        legend {
            font-weight: bold;
            color: #007BFF;
        }
        input[type="text"], 
        input[type="email"], 
        input[type="password"], 
        input[type="date"], 
        input[type="hidden"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .menu {
            margin: 20px 0;
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
            background-color: #0056b3;
            color: white;
        }
        
    </style>
</head>
<body>
    <?php if ($seguranca) { ?>
        <header>
            <h1>Painel Administrativo</h1>
            <h2>Gerenciador de Usuários</h2>
        </header>
        
        <main>
            
            <div class="menu">
                <?php include "layout/menu.php"; ?>
            </div>

            <?php 
            $tabela = "funcionarios";
            $funcionarios = buscar($connect, $tabela); 
            
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $usuario = buscaUnica($connect, "funcionarios", $id);
                updateUser($connect);
            ?>
                <h2>Editando o usuário: <?php echo htmlspecialchars($_GET['usuario']); ?></h2>
                
                <form action="" method="post">
                    <fieldset>
                        <legend>Editar Usuário</legend>
                        <!-- Inputs pré-preenchidos -->
                        <input value="<?php echo htmlspecialchars($usuario['id']); ?>" type="hidden" name="id" required>
                        <label for="usuario">Usuário:</label>
                        <input value="<?php echo htmlspecialchars($usuario['usuario']); ?>" type="text" name="usuario" id="usuario" placeholder="Usuário" required>

                        <label for="email">E-mail:</label>
                        <input value="<?php echo htmlspecialchars($usuario['email']); ?>" type="email" name="email" id="email" placeholder="E-mail" required>

                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha">

                        <label for="repetesenha">Confirme sua senha:</label>
                        <input type="password" name="repetesenha" id="repetesenha" placeholder="Confirme sua senha">

                        <label for="data_cadastro">Data de Cadastro:</label>
                        <input value="<?php echo htmlspecialchars($usuario['data_cadastro']); ?>" type="date" name="data_cadastro" id="data_cadastro" required>

                        <input type="submit" name="atualizar" value="Atualizar">
                    </fieldset>
                </form>
            <?php } ?>
        </main>
    <?php } ?>
</body>
</html>
