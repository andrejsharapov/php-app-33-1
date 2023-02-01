<?php

use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @return void
 */
function sendMessageToEmail()
{
    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        // $mail->Mailer = 'smtp';
        // $mail->Host = 'ssl://smtp.yandex.ru';
        $mail->Host = 'smtp.gmail.com';
        // $mail->Port = 465;
        $mail->Port = 587;
        $mail->Username = $_ENV['EMAIL_NAME'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPAuth = true;
        $mail->setFrom("php-app-33-1@gmail.com", "Имя Отправителя"); // от кого
        $mail->addAddress($_ENV['EMAIL_TO'], 'Имя Получателя');  // кому
        $mail->SMTPSecure = 'tls';
        $mail->isHTML(true); // HTML формат
        $mail->Subject = "Регистрация в чате.";
        $mail->Body = '
            <html lang="en">
                <head>
                    <title>Подтвердите Email</title>
                </head>
                <body>
                    <p>Просто скажите "Подтверждаю" и регистрация будет завершена.</p>
                </body>
            </html>
        ';
//        $mail->AltBody = "Альтернативное содержание сообщения";

        $mail->send();
        $_SESSION['checkReg'] = 'Вы успешно зарегистрированы, проверьте свою почту.';
    } catch (Exception $e) {
        $_SESSION['checkReg'] = 'Error: ' . $mail->ErrorInfo;
    }
}
