<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    protected static $tabla = 'vendedores';
    protected static $columnDB = ['id', 'nombre', 'apellido', 'telefono', 'email'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
    }

    public function validar()
    {
        if ($this->nombre === '') {
            self::$errores[] = "Debes añadir un nombre";
        }

        if ($this->apellido === '') {
            self::$errores[] = "Debes añadir un apellido";
        }

        if ($this->telefono === '') {
            self::$errores[] = "Debes añadir un telefono";
        }

        if ($this->email === '') {
            self::$errores[] = "Debes añadir un email";
        }

        if (!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = "Formato de telefono no valido";
        }

        return self::$errores;
    }
}
