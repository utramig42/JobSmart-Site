<?php

// Seção 1: SMTP

// Obtendo as variaveis via POST.
$name = utf8_decode($_POST['name']);
$email = utf8_decode($_POST['email']);
$assunto = utf8_decode($_POST['assunto']);
$msg = utf8_decode($_POST['mensagem']);

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

require './vendor/autoload.php';

// Cria uma nova instância do PHPMailer
$mail = new PHPMailer;

// Diga ao PHPMailer para usar o SMTP
$mail->isSMTP();

// Retirando a necessidade de um SSL.
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

// Ativar depuração de SMTP
// 0 = off (para uso em produção)
// 1 = mensagens do cliente
// 2 = mensagens do cliente e do servidor
$mail->SMTPDebug = 2;

// Definir o nome do host do servidor de email
$mail->Host = 'smtp.gmail.com';

// Defina o número da porta SMTP.
$mail->Port = 587;

// Definir o sistema de criptografia para usar - ssl (depreciado) ou tls
$mail->SMTPSecure = 'tls';

// Se deseja usar a autenticação SMTP
$mail->SMTPAuth = true;

// Nome de usuário para usar na autenticação SMTP - use o endereço de e-mail completo para o gmail
$mail->Username = "utramiginformatica42@gmail.com";

// Senha para usar para autenticação SMTP - Senha do GMAIL.
$mail->Password = "utramig2019";

// Defina para quem a mensagem deve ser enviada
$mail->setFrom($email, $name);

// Defina para quem ira enviar a mensagem.
$mail->addAddress('utramiginformatica42@gmail.com', 'Contato Pelo Site');

// Definir a linha de assunto
$mail->Subject = 'Contato pelo site: ' . $assunto;

// Definir um endereço de resposta 
$mail->addReplyTo($email, $name);

// Corpo do texto.
$mail->Body = $name . " Disse: " . $msg;


// Iniciando a sessão para renderização da mensagem de sucesso ou erro.
session_start();

// Envia a mensagem,e verifique se há erros
if (!$mail->send()) {
    $_SESSION['msg'] = '<div class="alert alert-danger"> Ocorreu um erro ao enviar o e-mail: ' . $mail->ErrorInfo
        . '</div>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-success"> E-mail enviado com sucesso! </div>';
}

// Voltando a página para inicial
header('Location: index.php#contato');
