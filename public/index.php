<?php

require_once __DIR__ . "/../includes/app.php";

use Controllers\LoginController;
use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\VisitasController;

$router = new Router();


// Zona privada
// Rutas para propiedades
$router->get("/admin", [PropiedadController::class, "index"]);
$router->get("/propiedad/crear", [PropiedadController::class, "crear"]);
$router->post("/propiedad/crear", [PropiedadController::class, "crear"]);
$router->get("/propiedad/actualizar", [PropiedadController::class, "actualizar"]);
$router->post("/propiedad/actualizar", [PropiedadController::class, "actualizar"]);
$router->post("/propiedad/eliminar", [PropiedadController::class, "eliminar"]);

// Rutas para vendedores
$router->get("/vendedores/crear", [VendedorController::class, "crear"]);
$router->post("/vendedores/crear", [VendedorController::class, "crear"]);
$router->get("/vendedores/actualizar", [VendedorController::class, "actualizar"]);
$router->post("/vendedores/actualizar", [VendedorController::class, "actualizar"]);
$router->post("/vendedores/eliminar", [VendedorController::class, "eliminar"]);

// Zona publica
// Visitantes
$router->get('/', [VisitasController::class, 'index']);
$router->get('/nosotros', [VisitasController::class, 'nosotros']);
$router->get('/propiedades', [VisitasController::class, 'propiedades']);
$router->get('/propiedad', [VisitasController::class, 'propiedad']);
$router->get('/blog', [VisitasController::class, 'blog']);
$router->get('/entrada', [VisitasController::class, 'entrada']);
$router->get('/contacto', [VisitasController::class, 'contacto']);
$router->post('/contacto', [VisitasController::class, 'contacto']);


// Login y autenticacion
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->comprobarRutas();
