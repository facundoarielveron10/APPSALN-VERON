<?php

namespace Controllers;

use Model\ActiveRecord;
use Model\AdminCita;
use MVC\Router;

class AdminController {
    // PRINCIPAL
    public static function index( Router $router) {
        // Protegemos las rutas
        isAdmin();

        // Buscamos la cita en la fecha seleccionada
        $fecha = $_GET['fecha'] ?? date("Y-m-d");
        $fechas = explode('-', $fecha);
        // Revisamos que sea una fecha valida
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }

        // Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);
        
        // Renderizamos la vista
        $router->render("admin/index", [
            'nombre' => $_SESSION["nombre"],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}