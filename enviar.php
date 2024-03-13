<?php
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';
require './PHPMailer-master/src/Exception.php';

//recebendo valores do formulário
if (isset($_POST['email']) && isset($_POST['assunto']) && isset($_POST['mensagem'])) {
    $email_remetente = strip_tags(trim($_POST['email']));
    $assunto = strip_tags(trim($_POST['assunto']));
    $mensagem = trim($_POST['mensagem']);

//configurando o servidor smtp e autenticação
    $email = new PHPMailer\PHPMailer\PHPMailer();
    $email->isSMTP();                                  // Ativa SMTP
    $email->Host = "";
    $email->SMTPAuth = true;                                // Autenticação ativada
    $email->Username = "";   //email do destinatário
    $email->Password = "";                 //senha do email destinatário
    $email->Port = "";
    $email->SMTPSecure = '';
    $email->SMTPDebug = 0;                        // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
    $email->Debugoutput = "html";

//informando quais são os endereços de email envolvidos
    $email->setFrom("contato@chileprabrasileiros.com");    // Conta que fará o envio das mensagens (deve ser uma conta existente e ativa no seu domínio)
    $email->addReplyTo($email_remetente);
    $email->addAddress("contato@chileprabrasileiros.com");   //Defina a conta que receberá as mensagens (email destinatário)

//implementando o assunto e corpo do email
    $email->setLanguage('pt');
    $email->CharSet = "utf-8";
    $email->WordWrap = 70;
    $email->Subject = $assunto;
    $email->isHTML(true);
    $email->Body = $mensagem;

    //enviando
    $resultado = $email->Send();

    if ($resultado) {
        $email = new PHPMailer\PHPMailer\PHPMailer();
        $email->isSMTP();                                  // Ativa SMTP
        $email->Host = "";
        $email->SMTPAuth = true;                                // Autenticação ativada
        $email->Username = "";   //email do destinatário
        $email->Password = "";                 //senha do email destinatário
        $email->Port = "";
        $email->SMTPSecure = '';
        $email->SMTPDebug = 0;                        // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
        $email->Debugoutput = "html";

        //enviando email de agradecimento
        $email->setFrom("");  // Conta que fará o envio das mensagens (deve ser uma conta existente e ativa no seu domínio)
        $email->addReplyTo("");
        $email->addAddress($email_remetente);   //Defina a conta que receberá as mensagens (email destinatário)//
        
        //implementando o assunto e corpo do email
        $email->setLanguage('pt');
        $email->CharSet = "utf-8";
        $email->WordWrap = 70;
        $email->Subject = "Agradecimento pelo contato";
        $email->isHTML(true);
        $email->Body = "Obrigado pelo contato, em breve responderemos. <br><br><br> Atenciosamente, <br> Chileprabrasileiros.";

        $resultado = $email->Send();

        if ($resultado) {
            include './includes/alert_sucesso.php';
        } else {
            include './includes/alert_erro.php';
        }
    } else {
        include './includes/alert_erro.php';
    }
} else {
    include './includes/alert_aviso.php';
}
?>