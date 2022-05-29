<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/PHPMailer.php';
require 'config.php';

$name = "";
$email = ""; //from
$tel = "";
$subject = "";
$message = "";
$terms = "";
$data = []; //message and status return

/* $token = $_POST['token'];
error_log("token " . $token);
// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => SECRET_KEY, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true); */

// verificar la respuesta (score es del 0 a 1 com de segur está de que es una persona. 0.7 es el filtro mes habitual)
//if ($arrResponse["success"] == '1' &&  $arrResponse["score"] >= 0.7) {

// Si entra aqui, es un humano, puedes procesar el formulario
if (isset($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
}

if (isset($_POST['email'])) {
    $email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
}
if (isset($_POST['tel'])) {
    $tel = htmlspecialchars($_POST['tel']);
}

if (isset($_POST['subject'])) {
    $subject = htmlspecialchars($_POST['subject']);
}

if (isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
}
if (isset($_POST['terms'])) {
    $terms = $_POST['terms'];
}

if ($_POST && $_POST['terms']) {
    try {
        $mail = new PHPMailer(true);

        /** Configurar SMTP **/
        $mail->IsSMTP();                            // Indicamos que use SMTP
        $mail->Host = SMTP_HOST;                    // Indicamos los servidores SMTP
        $mail->SMTPAuth = true;                     // Habilitamos la autenticación SMTP
        $mail->Username = SMTP_MAIL;                // SMTP username
        $mail->Password = SMTP_PWD;                 // SMTP password
        $mail->SMTPSecure = SMTP_SECURE;            // Habilitar encriptación TLS o SSL
        $mail->Port = SMTP_PORT;                    // TCP port

        /** Configurar cabeceras del mensaje **/
        $mail->From = $email;                     // Correo del remitente 
        $mail->FromName = $name;                  // Nombre del remitente
        $mail->Subject = $subject;                // Asunto

        /** Incluir destinatarios. El nombre es opcional **/
        $mail->addAddress(SMTP_MAIL, MAIL_NAME);
        /* $mail->addAddress('destinatario2@correo.com', 'Nombre2');
        $mail->addAddress('destinatario3@correo.com', 'Nombre3'); */

        /** Con RE, CC, BCC **/
        /*  $mail->addReplyTo('correo@correo.es', 'Informacion');
         $mail->addCC('cc@correo.com');
        $mail->addBCC('bcc@correo.com'); */

        /** Incluir archivos adjuntos. El nombre es opcional **/
        /* $mail->addAttachment('/archivos/miproyecto.zip');
        $mail->addAttachment('/imagenes/imagen.jpg', 'nombre.jpg'); */

        /** Enviarlo en formato HTML **/
        $mail->isHTML(true);

        /** Configurar cuerpo del mensaje **/
        $mail->Body    = '<p>' . $message . '<p>';
        $mail->AltBody = $message;

        /** Para que use el lenguaje español **/
        $mail->setLanguage('es');
        $mail->CharSet = 'UTF-8';

        $response = $mail->send();

        //Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
        //para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
        //del anterior, para ello se usa la funcion sleep
        $intentos = 1;
        while ((!$response) && ($intentos < 5)) {
            sleep(5);
            //echo $mail->ErrorInfo;
            $response = $mail->Send();
            $intentos = $intentos + 1;
        }
        if ($response) {
            $data = array(
                'status' => "Success",
                'message' => 'El mensaje se ha enviado correctamente.'
            );
        } else {
            $data = array(
                'status' => 'Error',
                'message' => 'El mensaje no se a podido enviar. Vuelve a intentarlo.'
            );
        }
    } catch (Exception $e) {
        $data = array(
            'status' => 'Error',
            'message' => 'El mensaje no se a podido enviar.'
        );
        error_log("Mailer Error: {$mail->ErrorInfo}");
        error_log("Exception Error: {$e->errorMessage()}");
    }
} else {
    $data = array(
        'status' => 'Warning',
        'message' => 'Parece que ha habido algun problema. Vuelve a intentarlo.'
    );
}
echo json_encode($data);
/*}  else {
    // Si entra aqui, es un robot....
    $data = array(
        'status' => 'Error',
        'message' => 'Your message did not send.'
    );
    error_log("es un robot....");
    echo json_encode($data);
} */
