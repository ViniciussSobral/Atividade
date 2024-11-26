<?php 
session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: login.php");
require_once "db_connect.php";
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Admin - Usuários</title>
    <link rel="stylesheet" href="style.css"> <!-- Link para arquivo CSS externo -->
    <style>
        /* Estilos internos */
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
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            margin: 10px 0;
            color: #007BFF;
        }
        .menu {
            margin: 20px 0;
        }
        form {
            margin: 20px 0;
        }
        fieldset {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        legend {
            color: #007BFF;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"] {
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
        .container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
        /* Estilo específico para exclusão */
        .confirm-delete {
            color: red;
            font-weight: bold;
        }
        input[type="submit"].btn-danger {
            background-color: red;
            color: white;
            border: none;
        }
        input[type="submit"].btn-danger:hover {
            background-color: darkred;
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
            <h2>Gerenciador de Usuários</h2>
            <div class="menu">
                <?php include "layout/menu.php"; ?>
            </div>
            
            <?php 
            $tabela = "funcionarios";
            $funcionarios = buscar($connect, $tabela); 
            inserirUsuarios($connect);

            if (isset($_GET['id'])) { ?>
                <h2 class="confirm-delete">Tem certeza que deseja deletar o funcionário <?php echo htmlspecialchars($_GET['usuario']); ?>?</h2>
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                    <input type="submit" name="deletar" value="Deletar" class="btn-danger">
                </form>
            <?php } ?>

            <?php 
            if (isset($_POST['deletar'])) {
                if ($_SESSION['id'] != $_POST['id']) {
                    deletar($connect, $tabela, $_POST['id']);
                } else {
                    echo "<p style='color: red;'>Você não pode deletar seu próprio usuário!</p>";
                }
            }
            ?>

            <form action="" method="post">
                <fieldset>
                    <legend>Inserir Usuários</legend>
                    <input type="text" name="usuario" placeholder="Usuário" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="password" name="senha" placeholder="Senha"required>
                    <input type="password" name="repetesenha" placeholder="Confirme sua senha"required>
                    <input type="submit" name="cadastrar" value="Cadastrar">
                </fieldset>
            </form>

            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($funcionarios as $usuario) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['data_cadastro']); ?></td>
                                <td>
                                    <a href="users.php?id=<?php echo $usuario['id']; ?>&usuario=<?php echo htmlspecialchars($usuario['usuario']); ?>">Excluir</a>
                                    <a href="edit_user.php?id=<?php echo $usuario['id']; ?>&usuario=<?php echo htmlspecialchars($usuario['usuario']); ?>">Atualizar</a>
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
