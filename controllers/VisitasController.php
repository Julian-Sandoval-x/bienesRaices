<?php

namespace Controllers;

use FFI;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class VisitasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = validateOrRedirect('/propiedades');

        // Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {

        $mensaje = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Obtenemos los datos del formulario
            $respuesta = $_POST['contacto'];

            // Crear una instacia de PHPMailer
            $mail = new PHPMailer(true);

            // Configurar SMTP
            $mail->isSMTP(); // Usar SMTP
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = "46d05c45b10475";
            $mail->Password = "186a0347115efb";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del email
            $mail->setFrom('Admin@bienesraices.com'); // Quien envia el email
            $mail->addAddress('Admin@bienesraices.com', 'Bienes Raices'); // A donde se envia el email, nombre opcional
            $mail->Subject = 'Tienes un nuevo mensaje'; // Asunto del email
            $mail->isHTML(true); // Soporte para HTML
            $mail->CharSet = 'UTF-8'; // Soporte para tildes y caracteres especiales

            $contenido = '<html>';
            $contenido .= ' <p>Tienes un nuevo mensaje</p>';
            $contenido .= ' <p>Nombre: ' . $respuesta['nombre']  . '</p>';
            // Enviar de forma condicional algunos campos de email o telefono

            if ($respuesta['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado por Teléfono</p>';
                $contenido .= ' <p>Teléfono: ' . $respuesta['telefono']  . '</p>';
                $contenido .= ' <p>Fecha contacto: ' . $respuesta['fecha']  . '</p>';
                $contenido .= ' <p>Hora: ' . $respuesta['hora']  . '</p>';
            } else {
                // Es email, agregamos los campos de email 
                $contenido .= '<p>Eligió ser contactado por Email</p>';
                $contenido .= ' <p>Email: ' . $respuesta['email']  . '</p>';
            }
            $contenido .= ' <p>Mensaje: ' . $respuesta['mensaje']  . '</p>';
            $contenido .= ' <p>Vende o Compra: ' . $respuesta['tipo']  . '</p>';
            $contenido .= ' <p>Precio o Presupuesto: $' . $respuesta['precio']  . '</p>';

            $contenido .= '</hmtl>';

            $mail->Body = $contenido; // Contenido del email en HTML

            $mail->AltBody = 'Texto sin formato HTML'; // Texto sin formato HTML

            // Enviamos el email
            ($mail->send()) ? $mensaje = 'Mensaje enviado' : $mensaje = 'Error al enviar mensaje';
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
