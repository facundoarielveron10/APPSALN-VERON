<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServiciosController {
    // PRINCIPAL
    public static function index(Router $router) {
        // Validamos si es un admin
        isAdmin();

        // Nos traemos todos los servicios
        $servicios = Servicio::all();

        // Renderizamos la vista
        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    // Crea un servicio nuevo
    public static function crear(Router $router) {
        // Validamos si es un admin
        isAdmin();

        // Creamos un objeto para guardar los datos
        $servicios = new Servicio;
        $alertas = [];
        // Leemos los datos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizamos el arreglo de servicios con todos los datos
            $servicios->sincronizar($_POST);
            // Validamos que los datos ingresados sean correctos
            $alertas = $servicios->validar();
            // Si no hay problemas
            if (empty($alertas)) {
                $servicios->guardar();
                header('Location: /servicios');
            }
        }

        // Renderizamos la vista
        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicios,
            'alertas' => $alertas
        ]);
    }

    // Actualiza los servicios
    public static function actualizar(Router $router) {
        // Validamos si es un admin
        isAdmin();

        // Nos traemos los datos del servicio seleccionado
        if (!is_numeric($_GET['id'])) return;
        $servicio = Servicio::find($_GET['id']);
        $alertas = [];

        // Leemos los datos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizamos el arreglo de servicios con todos los datos
            $servicio->sincronizar($_POST);
            // Validamos que los datos ingresados sean correctos
            $alertas = $servicio->validar();
            // Si no hay problemas
            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        // Renderizamos la vista
        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    // Elimina un servicio
    public static function eliminar() {
        // Validamos si es un admin
        isAdmin();
        
        // Leemos los datos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nos traemos el servicios a borrar
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            // Eliminamos ese servicio
            $servicio->eliminar();
            // Redirecionamos
            header('Location: /servicios');
        }
    }
}