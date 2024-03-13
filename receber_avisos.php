<?php
include 'includes/conexao.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';
require './PHPMailer-master/src/Exception.php';

//Recupera valores da tabela
$idResposta = $_REQUEST['comentario_resp_id'];

//verifica o comentário pai
if ($idResposta != 0) {
    $query = mysqli_query($conexao, "SELECT email_usuario, comentario, flag_comentario, comentario_resp_id FROM comentarios WHERE id=$idResposta");
    $registro = mysqli_fetch_array($query);
    $idResposta = $registro['comentario_resp_id'];
    $comentario_pai = $registro['comentario'];

//Verifica se o usuário quer ou não receber notificação por email
    if ($registro['flag_comentario'] == 1) {
        $query_categoria = mysqli_query($conexao, "SELECT nome FROM categoria WHERE id=$idCategoria");
        $registro_categoria = mysqli_fetch_array($query_categoria);
        $nome_categoria = $registro_categoria['nome'];

        $email = new PHPMailer\PHPMailer\PHPMailer();       // cria uma Instância da classe PHPMailer
        $email->isSMTP();                                   // define que é uma conexão SMTP 
        $email->Host = "";               // define o servidor
        $email->SMTPAuth = true;
        $email->Username = "";    // email ou usuário para autenticação 
        $email->Password = "";                     // senha do usuário 
        $email->Port = "";
        $email->SMTPSecure = '';
        $email->SMTPDebug = 0;
        $email->Debugoutput = "html";

        //informando quais são os endereços de email envolvidos
        $email->setFrom("admin@chileprabrasileiros.com");    //email do remetente (site)
        $email->addReplyTo("");
        $email->addAddress($registro['email_usuario']); //email destinatário
        
        //implementando o assunto e corpo do email
        $email->setLanguage('pt');
        $email->CharSet = "utf-8";
        $email->WordWrap = 70;
        $email->Subject = "Resposta ao seu post no site Chileprabrasileiros";
        $email->isHTML(true);
        $email->Body = "O seu post: <br><br> " . '"' . " $comentario_pai" . '"' . ", <br><br> na categoria " . '"' . "$nome_categoria" . '"' . " no fórum de Chileprabrasileiros "
                . "foi respondido por $nome em $data: <br><br> Resposta: <br>" . '"' . " $comentario" . '"' . "<br><br><br> Atenciosamente<br>Chileprabrasileiros";

        //enviando email
        $resultado = $email->Send();

        if ($resultado) {
            include './includes/alert_sucesso.php';
        } else {
            include './includes/alert_erro.php';
        }
    } else {
        //não enviar notificação por email
    }
}
?>