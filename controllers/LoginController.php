<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    // Iniciar Sesion
    public static function login(Router $router) {
        // Creamos el arreglo de alertas
        $alertas = [];

        // Instanciamos el usuario
        $auth = new Usuario;

        // Hacemos las validaciones
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creamos un nuevo usuario para validar
            $auth = new Usuario($_POST);
            // Validamos que los datos del usuario sean correctos
            $alertas = $auth->validarLogin();
            // No hay problemas de validacion
            if (empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->getEmail());
                // El usuario existe
                if ($usuario) {
                    // El Usuario esta confirmado y su contraseña esta bien
                    if ($usuario->comprobarPasswordYVerificado($auth->getPassword())) {
                        // Creamos el arreglo de la sesion
                        $_SESSION["id"] = $usuario->getId();
                        $_SESSION["nombre"] = $usuario->getNombre() . " " . $usuario->getApellido();
                        $_SESSION["email"] = $usuario->getEmail();
                        $_SESSION["login"] = true;
                        
                        // Redireccionamiento
                        // Es un admin
                        if ($usuario->getAdmin() === "1") {
                            $_SESSION["admin"] = $usuario->getAdmin() ?? null;
                            header("Location: /admin");
                        }
                        // Es un cliente
                        else {
                            header("Location: /cita");
                        }
                    }
                }
                // El usuario no existe
                else {
                    Usuario::setAlerta('error', 'El Usuario no Existe o no fue Encontrado');
                }
            }
        }

        // Obtener las alertas
        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render("auth/login", [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    // Cerrar Sesion
    public static function logout() {
        // Limpiamos el arreglo de $_SESSION
        $_SESSION = [];

        header("Location: /");
    }

    // Olvide mi password
    public static function olvide(Router $router) {
        // Creamos el arreglo de alertas
        $alertas = [];

        // Hacemos las validaciones
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instanciamos Usuarios con los datos del usuario
            $auth = new Usuario($_POST);
            // Revisamos que haya ingresado un email
            $alertas = $auth->validarEmail();
            // No hay problemas de validacion
            if(empty($alertas)) {
                // Revisamos que en la base de datos este ese email
                $usuario = Usuario::where('email', $auth->getEmail());
                // El usuario existe y esta confirmado
                if ($usuario && $usuario->getConfirmado() === "1") {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellido(), $usuario->getToken());
                    $email->enviarInstrucciones();
                    // Alerta de exito
                    Usuario::setAlerta("exito", "Revisa tu email");

                }
                // El usuario no existe o no esta confirmado
                else{
                    Usuario::setAlerta("error", "El Usuario no Existe o no esta confirmado");
                }
            }
        }
        // Guardamos las alertas
        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render("auth/olvide-password", [
            'alertas' => $alertas
        ]);
    }

    // Reestablecer mi password
    public static function reestablecer(Router $router) {
        // Creando el arreglo de alertas
        $alertas = [];
        $error = false;
        $reestablecer = false;
        // Leemos el token
        $token = s($_GET["token"]);
        // Buscamos al usuario por su token
        $usuario = Usuario::where("token", $token);
        // El usuario no existe
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Valido');
            $error = true;
        }
        // El usuario existe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            // Validamos que el password sea valido
            $alertas = $password->validarPassword();
            
            // No hay problema de validacion
            if (empty($alertas)) {
                // Borramos el password anterior
                $usuario->setPassword(null);
                // Asignamos el nuevo password
                $usuario->setPassword($password->getPassword());
                // Hasheamos su password
                $usuario->hashPassword();
                // Borramos el token
                $usuario->setToken(null);
                // Guardamos el usuario con su nueva contraseña
                $resultado = $usuario->guardar();

                // Redireccionamos
                if ($resultado) {
                    Usuario::setAlerta("exito", "Contraseña Reestablecida");
                    $reestablecer = true;
                }
            }
        }

        // Guardamos las alertas
        $alertas = Usuario::getAlertas();
        // Renderizar la vistas
        $router->render("auth/reestablecer", [
            'alertas' => $alertas,
            'error' => $error,
            'reestablecer' => $reestablecer
        ]);
    }

    // Crear mi cuenta
    public static function crear(Router $router) {
        
        // Creamos el objeto Usuario
        $usuario = new Usuario;
        
        // Alertas vacias
        $alertas = [];

        // Hacemos las validaciones
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Le mandamos al objeto los datos del formulario
            $usuario->sincronizar($_POST);
            
            // Verificamos que los datos mandados sean correctos
            $alertas = $usuario->validarNuevaCuenta();
            
            // Revisamos que alertas este vacio, por lo tanto paso la validacion
            if (empty($alertas)) {
                // Verificamos que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                
                // El Usuario esta Registrado
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                }
                // El Usuario no esta resgistro
                else {
                    // Hasheamos su password
                    $usuario->hashPassword();

                    // Generar un Token unico
                    $usuario->crearToken();

                    // Enviar el Email para Confirma la Cuenta
                    $email = new Email($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellido(), $usuario->getToken());
                    $email->enviarConfirmacion();

                    // Creamos el usuario
                    $resultado = $usuario->guardar();
                    // Mandamos al usuario a confirmar su cuenta
                    if ($resultado) {
                        header("Location: /mensaje");
                    }
                }
            }
        }
        // Renderizar la vista
        $router->render("auth/crear-cuenta", [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    // Confirmar mi cuenta
    public static function confirmar(Router $router) {
        // Creamos un arreglo con las alertas
        $alertas = [];
        // Guardamos el token
        $token = s($_GET['token']);
        // Buscamos el token en la Base de Datos
        $usuario = Usuario::where('token', $token);
        // Validamos que el usuario exista
        if (empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', "Token no Valido");
        }
        else {
            // Modificar a usuario confirmado
            $usuario->setConfirmado("1");
            $usuario->setToken(null);
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }
        // Obtener las alertas
        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render("auth/confirmar-cuenta", [
            'alertas' => $alertas
        ]);
    }

    // Mensaje de confirmacion
    public static function mensaje(Router $router) {
        // Renderizar la vista
        $router->render("auth/mensaje", [  
        ]);
    }
}