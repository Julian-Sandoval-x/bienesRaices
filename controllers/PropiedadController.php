<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;
use VARIANT;

class PropiedadController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::all(); // Traemos todas las propiedades de la BD
        $vendedores = Vendedor::all(); // Traemos todos los vendedores de la BD
        $resultado = $_GET['resultado'] ?? null;
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router)
    {

        $propiedad = new Propiedad; // Creamos una instancia vacia
        $vendedores = Vendedor::all(); // Traemos todos los vendedores
        $errores = Propiedad::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            // Creamos una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);

            /** SUBIDA DE ARCHIVOS */

            // Generar un nombre unico para los archivos
            $nameImage = md5(uniqid(rand(), true)) . ".jpg";

            // Seteamos la imagen
            // Realizar un resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                // Guardar el nombre en la clase (Asignamos al atributo)
                $propiedad->setImage($nameImage);
            }

            $errores = $propiedad->validar();

            // Validamos que el array no tenga valores (No hay errores)
            if (empty($errores)) {
                // Subir la imagen

                // Dentro del arreglo de los archivos exite un nombre temporal el cual es la dirección donde se almacena temporalmente
                // move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nameImage);
                /** Lo que hace la función es mover un archivo de un directorio a otro siendo el primer parametro
                 * el origen y el segundo su destino
                 */

                // Verificamos si existe la carpeta
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES); // Crea la carpeta

                }

                // guardamos la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nameImage);

                // Almacena en la base de datos
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores ?? []
        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validateOrRedirect('/admin');

        $propiedad = Propiedad::find($id);

        $vendedores = Vendedor::all(); // Traemos todos los vendedores

        $errores = Propiedad::getErrores();

        // Metodo POST para actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            // Validacion
            $errores = $propiedad->validar();

            // Generar un nombre unico para los archivos
            $nameImage = md5(uniqid(rand(), true)) . ".jpg";

            // Subida de archivos
            // Seteamos la imagen
            // Realizar un resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                // Guardar el nombre en la clase (Asignamos al atributo)
                $propiedad->setImage($nameImage);
            }


            // Validamos que el array no tenga valores (No hay errores)
            if (empty($errores)) {

                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nameImage);
                }
                $propiedad->guardar();
            }
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
