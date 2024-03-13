<?php
$host = "localhost";
$user = "";
$password = "";
$database = "";

$conexao = mysqli_connect($host, $user, $password, $database);

//verifica a conexão com o banco 
if(!$conexao){
    echo "Erro ao conectar banco de dados";
    echo mysqli_connect_error();
} else{
    mysqli_select_db($conexao, $database);
}
?>