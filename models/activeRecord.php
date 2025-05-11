<?php

namespace Model;

class ActiveRecord
{

    // Base de datos
    protected static $db;
    protected static $columnDB = [];
    protected static $tabla = '';


    // Errores
    protected static $errores = [];



    // Conectar a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }



    public function guardar()
    {
        if (!is_null($this->id)) {
            // Actualiza un objeto
            $this->actualizar();
        } else {
            // Crea un objeto
            $this->crear();
        }
    }

    // Insertar en la base de datos
    public function crear()
    {

        // Sanitizar los datos
        $atributos = $this->sanitizarEntradas();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        // 
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos)) . " ') ";

        $resultado = self::$db->query($query);

        // Mesaje de exito o error
        if ($resultado) {
            // Redireccionar a un usuario

            header('location: /admin?resultado=1'); // Solo puede redireccionar solo si no exite nada de código HTML antes
            /**
             * Si se utiliza bastantes las redirecciones puede ocurrir un error
             * Too Many Redirection
             */
        }
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarEntradas();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
        $query .= " LIMIT 1  ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar a un usuario

            header('location: /admin?resultado=2'); // Solo puede redireccionar solo si no exite nada de código HTML antes
            /**
             * Si se utiliza bastantes las redirecciones puede ocurrir un error
             * Too Many Redirection
             */
        }
    }

    // Eliminar un registro
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            // Redireccionar a un usuario

            header('location: /admin?resultado=3'); // Solo puede redireccionar solo si no exite nada de código HTML antes
            /**
             * Si se utiliza bastantes las redirecciones puede ocurrir un error
             * Too Many Redirection
             */
        }
    }

    // Identificar y unir los atributos de la DB
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnDB as $columna) {
            if ($columna == 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function sanitizarEntradas()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Carga de archivos

    public function setImage($image)
    {
        // Elimina la imagen previa
        if (!is_null($this->id)) {
            // Comprobamos si existe el archivo
            $this->borrarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if ($image) {
            $this->imagen = $image;
        }
    }

    // Eliminar archivo
    public function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validacion
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {

        static::$errores = [];
        return static::$errores;
    }

    // Lista todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];

        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObject($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    protected static function crearObject($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
