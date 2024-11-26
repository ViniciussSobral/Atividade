<?php
require_once 'db_connect.php';

function login($connect){
    if(isset($_POST['acessar']) AND !empty($_POST['usuario']) AND !empty($_POST['senha'])){
        $usuario = filter_input(INPUT_POST, "usuario", FILTER_VALIDATE_REGEXP, [
            "options" => ["regexp" => "/^[a-zA-Z0-9_]{3,20}$/"]
        ]);
        $senha = sha1($_POST['senha']);
        $query = "SELECT * FROM funcionarios where usuario = '$usuario' AND senha = '$senha' ";
        $executar = mysqli_query($connect, $query);
        $return = mysqli_fetch_assoc($executar);
        if(!empty($return["usuario"])){
        session_start();
        $_SESSION['usuario'] = $return['usuario'];
        $_SESSION['id'] = $return['id'];
        $_SESSION['ativa'] = TRUE;
        header("location: index.php");

        echo "Bem vindo ". $return['usuario'];
}else{
    echo "Usuario ou não encontrado!";
}

}

}

function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("location: catalogo.php");
}

/* Seleciona no bd apenas um resultado com base no ID */
function buscaUnica($connect, $tabela, $id) {

    $query = "SELECT * FROM $tabela WHERE id =" .(int) $id;
    $execute = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($execute);
    return $result;
}

/* Seleciona(busca) no BD todos os resultados com base no WHERE */
function buscar($connect, $tabela, $where = 1, $order = "") {
    if(!empty($order)){
        $order = "ORDER BY $order";
    }

    $query = "SELECT * FROM $tabela WHERE $where $order";
    $execute = mysqli_query($connect, $query);
    $results = mysqli_fetch_all($execute, MYSQLI_ASSOC);
    return $results;
}

/*Inserir novos usuarios */
function inserirUsuarios($connect){

    if((isset($_POST['cadastrar']) AND !empty($_POST['email']) AND !empty($_POST['senha']))){
        $erros = array();
        $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
        $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
        $senha = sha1($_POST['senha']);

        if($_POST['senha'] != $_POST['repetesenha']){
            $erros[] = "Senhas estão diferentes";
        
        }
        $queryEmail = "SELECT email FROM funcionarios where email = '$email'";
        $buscaEmail = mysqli_query($connect, $queryEmail);
        $verifica = mysqli_num_rows($buscaEmail);
        if (!empty ($verifica) ){
            $erros[] = "E-mail ja cadastrado!";
        }
        if (empty($erros)){
            //inserir o usuario no BD
            $query = "INSERT INTO funcionarios (usuario, email, senha, data_cadastro) VALUES('$usuario','$email','$senha',NOW())";
            $executar = mysqli_query($connect, $query);
            if($executar){
                echo "Usuário inserido com sucesso!";

            }else{
                echo "Erro ao inserir Usuário!";
            }

        }else{
            foreach($erros as $erro){
                echo "<p>$erro</p>";
            }
        }
    }   
}
    
    function deletar($connect, $tabela, $id){
        if(!empty($id)){
            $query = "DELETE FROM $tabela WHERE id = ".(int) $id;
            $execute = mysqli_query($connect, $query);
            if($execute){
                echo "dado removido com sucesso!";

            }else{
                echo "Erro ao deletar!";
            }
        }
    }

    function updateUser($connect){
        if(isset($_POST['atualizar']) AND !empty($_POST['email'])){
            $erros = array();
            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);
            $email = filter_input(INPUT_POST,"email", FILTER_VALIDATE_EMAIL);
            $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
            $senha = "";
            $data = mysqli_real_escape_string($connect, $_POST['data_cadastro']);

            if(empty($data)){
                $erros[] = "Preencha a data de cadastro";
            }
            if(empty($email)){
                $erros[] = "Preencha seu e-mail corretamente";
            }

            if(strLen($usuario)< 4 ){
                $erros[] = "Preencha com mais caracteres";
            }

            if(!empty($_POST['senha'])){
                if($_POST['senha'] == $_POST['repetesenha']){
                    $senha = sha1($_POST['senha']);
                }else{
                    $erros[]= "Senhas não conferem!";

                }
            }

            if($_POST['senha'] != $_POST['repetesenha']){
                $erros[] = "Senhas estão diferentes";
            
            }
            $queryEmailAtual = "SELECT email FROM funcionarios WHERE id = $id";
            $buscaEmailAtual = mysqli_query($connect, $queryEmailAtual);
            $returnEmail = mysqli_fetch_assoc($buscaEmailAtual);
 
            $queryEmail = "SELECT email FROM funcionarios WHERE email = '$email' AND  email <> '".$returnEmail['email']."'";
            $buscaEmail = mysqli_query($connect, $queryEmail);
            $verifica = mysqli_num_rows($buscaEmail);
            if (!empty ($verifica)){
                $erros[] = "E-mail ja cadastrado!";}
    

    if(empty($erros)){
        //update usuário
        if(!empty($senha)){
            $query = "UPDATE funcionarios SET usuario = '$usuario', email = '$email', senha = '$senha', data_cadastro = '$data' WHERE id = ".(int) $id;

        }else{
            $query = "UPDATE funcionarios SET usuario = '$usuario', email = '$email',  data_cadastro = '$data' WHERE id = ".(int) $id;

        }

        
        $executar = mysqli_query($connect, $query);
        if($executar){
            echo "Usuário atualizado com sucesso";
        }
        else{
            echo "Erro ao atualizar Usuário";
        }
    }else{
        foreach($erros as $erro){
            echo "<p>$erro</p>";
    }

}
}

    }

    function insertCardapio($connect){
        if((isset($_POST['insert']) AND !empty($_POST['titulo']) AND !empty($_POST['descricao']))){
            
            $titulo = mysqli_real_escape_string($connect, $_POST['titulo']);
            $descricao = mysqli_real_escape_string($connect, $_POST['descricao']);
            $data = mysqli_real_escape_string($connect, $_POST['data_registro']);
            $imagem = !empty ($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] :"" ;
            $retornoUpload="";
            if(!empty($imagem)){
                $caminho = "uploads/";
                $retornoUpload = uploadImage($caminho);
                if(is_array($retornoUpload)){
                    foreach($retornoUpload as $erro){
                        echo $erro;
            }
            $imagem = "";   
        }else{
            $imagem = $retornoUpload;
        }
    }
                $query = "INSERT INTO cardapio (titulo, descricao, imagem, data_registro) VALUES('$titulo','$descricao','$imagem','$data')";
                $executar = mysqli_query($connect, $query);
                if($executar){
                    if(is_array($retornoUpload)){
                        echo "Item inserido com sucesso! Porem a imagem não pode ser inserida";
    
                    }else{
                        header("location: cardapio.php");
    
                    }
    
                }else{
                    echo "Erro ao inserir Usuário!";
                }
                
            
        }   
    }
    
function updateCardapio($connect){
    if((isset($_POST['update']) AND !empty($_POST['titulo']) AND !empty($_POST['descricao']))){
        
        $id = (int) $_POST['id'];
        $titulo = mysqli_real_escape_string($connect, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($connect, $_POST['descricao']);
        $data = mysqli_real_escape_string($connect, $_POST['data_registro']);
        
        $imagem = !empty ($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] :"" ;
        $retornoUpload = "";
        if(!empty($imagem)){
            $caminho = "uploads/";
            $retornoUpload = uploadImage($caminho);
            if(is_array($retornoUpload)){
                foreach($retornoUpload as $erro){
                    echo $erro;
        }
        $imagem = "";   
    }else{
        $imagem = $retornoUpload;
    }
}
       
        if(!empty($id)){
            if(!empty($imagem)){
                $query = "UPDATE cardapio SET imagem='$imagem', titulo = '$titulo',descricao = '$descricao', data_registro = '$data' WHERE 
            id = $id ";

            }else{
                $query = "UPDATE cardapio SET titulo = '$titulo',descricao = '$descricao', data_registro = '$data' WHERE 
            id = $id ";
            }     

             $executar = mysqli_query($connect, $query);
             if($executar){
                if(is_array($retornoUpload)){
                    echo "Item atualizado com sucesso! Porem a imagem não pode ser inserida";

                }else{
                    header("location: cardapio.php");

                }
     
             }else{
                 echo "Erro ao atualizar Usuário!";
             }
            }
       
            
    }
}   
       
function uploadImage($caminho){
    
    if(!empty ($_FILES['imagem']['name'])){

        $nomeImagem = $_FILES['imagem']['name'];
        $tipo = $_FILES['imagem']['type'];
        $nomeTemporario = $_FILES['imagem']['tmp_name'];
        $tamanho = $_FILES['imagem']['size'];
        $erros= array();
            
        $tamanhoMaximo = 1024 * 1024 * 5;// 5 MB
        if($tamanho > $tamanhoMaximo){
            $erros[] = "Seu arquivo excede o tamanho maximo<br>";

        }

        $arquivosPermitidos = ["png","jpg","jpeg"];
        $extensao = pathinfo($nomeImagem,PATHINFO_EXTENSION);
        if(!in_array($extensao, $arquivosPermitidos)){
                    $erros[] = "Arquivo não permitido.<br>";
            }
        $typesPermitidos = ["image/jpg", "image/png", "image/jpeg"];
        if(!in_array($tipo, $typesPermitidos)){
            $erros[] = "Tipo de arquivo não permitido.<br>";
        }
        if(!empty($erros)){
            /*foreach($erros as $erro){
                echo $erro;
        }*/
        return $erros;
    }
        else{
            
            $hoje = date("d-m-Y_h-i");
            $novoNome = $hoje."-".$nomeImagem;
            
            if(move_uploaded_file($nomeTemporario,$caminho.$novoNome)){
                return $novoNome;
                
            }
            else{
                return FALSE;
            }
        }

     }



}
function getImagePath($fileName) {
    return "uploads/" . $fileName;
}
