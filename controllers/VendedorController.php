<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;


class VendedorController
{
    public static function crear(Router $router)
    {
        // Obtenemos los vendedores
        $errores = Vendedor::getErrores();

        // Instanciamos el vendedor
        $vendedor = new Vendedor;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Creamos una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validamos que no haya campos vacios
            $errores = $vendedor->validar();

            // No hay errores

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("vendedores/crear", [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();

        $id = validateOrRedirect('/admin');

        // Obtener datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar los atributos
            $args = $_POST['vendedor'];

            $vendedor->sincronizar($args);

            // Validar
            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("/vendedores/actualizar", [
            'errores' => $errores,
            'vendedor' => $vendedor,

        ]);
    }

    public static function eliminar()
    {
        // Validar el id
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            // Valida el tipo a eliminar
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
