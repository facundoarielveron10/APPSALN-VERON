<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    // Pagina principal de Citas
    public static function index(Router $router) {
        // Revisamos si el usuario esta autenticado
        isAuth();

        // Renderiza la vista
        $router->render('cita/index', [
            'nombre' => $_SESSION["nombre"],
            'id' => $_SESSION['id']
        ]);
    }
}