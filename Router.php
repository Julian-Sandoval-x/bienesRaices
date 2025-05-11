<?php

namespace MVC;

class Router
{

    public $rutasGET = [];

    public $rutasPOST = [];

    public function get($url, $fn)
    {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()

    {
        session_start();

        $auth = $_SESSION['login'] ?? null;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedad/crear', '/propiedad/actualizar', '/propiedad/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/vendedores/crear',];

        // Leemos la url actual
        $urlActual = $_SERVER["PATH_INFO"] ?? "/";

        // Leemos el método de la petición
        $metodo = $_SERVER["REQUEST_METHOD"];

        // Obtenemos la función asociada a la url
        if ($metodo === "GET") {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if ($fn) {
            // La url existe y tiene una función asociada

            /**
             * Con call_user_func() podemos ejecutar una función
             * que no sabemos como se llama le pasamos la funcion
             * almacenada en $fn y le pasamos el objeto $this
             * para que tenga todas las rutas
             */
            call_user_func($fn, $this);
        } else {
            echo "Página no encontrada";
        }
    }

    // Muestra una vista

    public function render($view, $data = [])
    {

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start(); // Inicia el almacenamiento en memorio a partir de aqui
        include __DIR__ . "/views/$view.php"; // 

        $contenido = ob_get_clean(); // Limpia el buffer y lo guarda en la variable contenido

        include __DIR__ . "/views/layout.php";
    }
}
