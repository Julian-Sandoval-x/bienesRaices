<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Crea una instancia de Dotenv
$dotenv->safeLoad(); // Carga las variables de entorno

// Conectarnos a la base de datos
$db = conectarDB();

use Model\ActiveRecord;

ActiveRecord::setDB($db);
