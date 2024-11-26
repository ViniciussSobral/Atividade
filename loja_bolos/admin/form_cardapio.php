<?php 
session_start(); 
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: catalogo.php");
require_once "db_connect.php";
require_once "functions.php";
// Inserir ou atualizar item no cardápio
insertCardapio($connect);
if (isset($_POST['update'])) {
    updateCardapio($connect);
}
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
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        header h1, header h3 {
            margin: 0;
        }
        main {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        fieldset {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }
        legend {
            font-weight: bold;
            color: #007BFF;
        }
        input[type="text"], 
        input[type="date"], 
        input[type="file"], 
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
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
            padding: 5px 10px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
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
            <h3>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h3>
        </header>
        
        <main>
            <h2>Gerenciador do Cardápio</h2>
            <div class="menu">
                <?php include "layout/menu.php"; ?>
            </div>
            
            <?php 
                $id = "";
                $titulo = "";
                $descricao = "";
                $data = date('Y-m-d');
                $action = "insert";

                if (isset($_GET['id'])) {
                    $idGet = $_GET['id'];
                    $itemCardapio = buscaUnica($connect, "cardapio", $idGet);

                    if (!empty($itemCardapio['titulo'])) {
                        $id = $itemCardapio['id'];
                        $titulo = $itemCardapio['titulo'];
                        $descricao = $itemCardapio['descricao'];
                        $data = $itemCardapio['data_registro'];
                        $action = "update";
                    }
                }
            ?>
            
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Inserir / Editar Item no Cardápio</legend>
                    
                    <input value="<?php echo $id; ?>" type="hidden" name="id">

                    <?php if (!empty($itemCardapio['imagem'])) { ?>
                        <div>
                            <img src="/loja_bolos/admin/uploads/<?php echo $itemCardapio['imagem']; ?>" alt="Imagem do Cardápio">
                        </div>
                    <?php } ?>

                    <label for="imagem">Imagem (somente JPG, PNG, JPEG):</label>
                    <input type="file" name="imagem" id="imagem" accept=".jpg, .jpeg, .png">
                    
                    <label for="titulo">Título:</label>
                    <input value="<?php echo htmlspecialchars($titulo); ?>" type="text" name="titulo" id="titulo" placeholder="Título" required>
                    
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" placeholder="Descrição do item..." required><?php echo htmlspecialchars($descricao); ?></textarea>
                    
                    <label for="data_registro">Data de Registro:</label>
                    <input value="<?php echo htmlspecialchars($data); ?>" type="date" name="data_registro" id="data_registro" required>
                    
                    <input type="submit" name="<?php echo $action; ?>" value="Salvar">
                </fieldset>
            </form>
        </main>
    <?php } ?>
</body>
</html>
