<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{

    public static function login(Router $router)
    {
        $inicio = true;
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creamos una nueva instancia de Admin
            $auth = new Admin($_POST);

            // Obtenemos los errores de validacion (En caso que existan)
            $errores = $auth->validar();;

            if (empty($errores)) {
                $resultado = $auth->existeUsuario();

                if (!$resultado) {
                    // Verificar si el usuario existe
                    $errores = $auth->getErrores();
                } else {
                    // Verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);

                    if ($autenticado) {
                        // Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        // Password incorrecto (Mensaje de error)
                        $errores = $auth->getErrores();
                    }
                }
            }
        }

        $router->render('auth/login', [
            'errores' => $errores,
            'inicio' => $inicio,
        ]);
    }

    public static function logout(Router $router)
    {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
}
