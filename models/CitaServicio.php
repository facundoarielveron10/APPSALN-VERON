<?php

namespace Model;

class CitaServicio extends ActiveRecord {
    // Base de Datos
    protected static $tabla = 'citasServicios';
    protected static $columnasDB = ['id', 'citaId', 'servicioId'];

    // Atributos
    public $id;
    public $citaId;
    public $servicioId;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
}