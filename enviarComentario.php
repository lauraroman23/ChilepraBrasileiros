<?php
include 'includes/conexao.php';

//Recupera dados do form
$nome = $_POST['nome'];
$email = $_POST['email'];
$comentario = $_POST['comentario'];
$idConteudo = $_POST['idConteudo'];
$idCategoria = $_POST['idCategoria'];
$flag = isset($_POST['aviso']) ? 1 : 0;
$resposta = $_POST['resposta'];
$comentario_resp_id = $_POST['comentario_resp_id'];

if (empty($nome) || empty($email) || empty($comentario)) {
    include './includes/alert_erro.php';
} else {
    try {
        $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d H:i:s');
        $comentario = nl2br($comentario);
        $result = mysqli_query($conexao, "INSERT INTO comentarios(email_usuario, nome_usuario, comentario, 
            data_public_comentario, flag_comentario, resposta, comentario_resp_id, IdConteudo) VALUES
              ('$email',
               '$nome',
               '$comentario',
               '$data',
               $flag,
               $resposta,
               '$comentario_resp_id', $idConteudo)");
        include 'receber_avisos.php';
        header("Location: conteudo.php?idCategoria=$idCategoria");
    } catch (Exception $ex) {
        echo 'ERRO';
        echo $nome;
        echo $email;
        echo $comentario;
        echo $flag;
        echo $resposta;
        echo $comentario_resp_id;
        echo $idConteudo;
        echo $idCategoria;
    }
}
?>