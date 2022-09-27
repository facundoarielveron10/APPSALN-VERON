<?php

namespace Controllers;

use Model\ActiveRecord;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController extends ActiveRecord {
    // PRINCIPAL
    // Traer los servicios datos de la base de datos
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios, JSON_UNESCAPED_UNICODE);
    }

    // Traer los servicios de la base de datos
    public static function citas() {
        $citas = Cita::all();
        echo json_encode($citas, JSON_UNESCAPED_UNICODE);
    }

    // Guardar los datos en la base de datos
    public static function almacenar() {
        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena la Cita y el Servicio
        $idServicios = explode(',', $_POST['servicios']);
        // Recorremos el arreglo con los servicios
        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            // Le pasamos a citaServicio los datos
            $citaServicio = new CitaServicio($args);
            // Guardamos en la tabla de citasservicios los datos
            $citaServicio->guardar();
        }
        
        // Retornamos una resultado
        echo json_encode([
            'resultado' => $resultado
        ]);
    }

    // Eliminar una cita
    public static function descartar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardamos el ID de la Cita
            $id = $_POST['id'];
            // Buscamos la cita a travez de ese ID
            $cita = Cita::find($id);
            // Eliminamos esa cita
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}