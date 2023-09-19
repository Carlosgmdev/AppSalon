<?php

namespace Model;

class Servicio extends ActiveRecord {

    protected static $tabla = 'servicios';
    protected static $columnasDB = [
        'id',
        'nombre',
        'precio'
    ];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }
}