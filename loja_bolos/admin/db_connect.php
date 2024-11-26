<?php
$host = "localhost";
$db_user = "root";
$db_pass = "3221";
$db_name = "loja_bolos";

// Conexão com o banco de dados
$connect = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Verifica se a conexão foi estabelecida com sucesso
if (!$connect) {
    die("Erro de conexão com o banco de dados: " . mysqli_connect_error());
}
?>
