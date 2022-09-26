<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    // Atributos
    protected $email;
    protected $nombre;
    protected $apellido;
    protected $token;

    // Constructor
    public function __construct($email, $nombre, $apellido, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->token = $token;
    }

    // Metodos
    // Enviar confirmacion al usuario
    public function enviarConfirmacion() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '4edaf39b9b83d2';
        $mail->Password = 'fbcf5b2fd609fe';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . "</strong> Has creado tu cuenta en AppSalon,
        solo debes confirmarla presionando el siguente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='https://". $_SERVER["HTTP_HOST"] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;
        // Enviar el mail
        $mail->send();
    }

    // Enviar intrucciones al usuario
    public function enviarInstrucciones() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '4edaf39b9b83d2';
        $mail->Password = 'fbcf5b2fd609fe';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Restablece tu contraseña';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola" . $this->nombre . " " . $this->apellido . "</strong> has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aqui: <a href='https://". $_SERVER["HTTP_HOST"] . "/reestablecer?token=" . $this->token . "'>Reestablecer Contraseña</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;
        // Enviar el mail
        $mail->send();
    }
}