<?php

namespace Controllers;

use Model\Cita;
use MVC\Router;

class CitaController {
    // Pagina principal de Citas
    public static function index(Router $router) {
        // Revisamos si el usuario esta autenticado
        isAuth();

        $id = $_SESSION['id'];

        // Consultar la base de datos
        $consulta = "SELECT * FROM citas WHERE usuarioId = ${id}";
        $citas = Cita::SQL($consulta);

        // Formatear la fecha
        foreach( $citas as $cita ):
            $fecha = $cita->fecha;
            $fecha = fechaEs($fecha);
            $cita->fecha = $fecha;
        endforeach;

        // Renderiza la vista
        $router->render('cita/index', [
            'nombre' => $_SESSION["nombre"],
            'id' => $id,
            'citas' => $citas
        ]);
    }
}