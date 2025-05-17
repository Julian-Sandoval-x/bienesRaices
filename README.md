# Bienes Raíces - Portal Inmobiliario en PHP MVC

Este proyecto es una aplicación web desarrollada en PHP orientada a la gestión de propiedades inmobiliarias. Funciona como un portal donde los administradores pueden publicar, editar y eliminar propiedades, así como gestionar la información de los vendedores. El sistema está construido con el patrón de arquitectura MVC (Modelo-Vista-Controlador) e incluye automatización de estilos y scripts mediante Gulp, junto con una interfaz limpia y responsive para facilitar su uso desde cualquier dispositivo.

## 🚀 Características

- **Gestión de propiedades**: Alta, edición y eliminación de propiedades en venta o renta.
- **Panel de administración**: Interfaz protegida para administradores con control total del contenido.
- **Gestión de vendedores**: Asociación de propiedades con vendedores registrados.
- **Sistema de autenticación**: Login seguro para acceso al panel administrativo.
- **Diseño responsive**: Interfaz adaptable a móviles, tabletas y computadoras.
- **Automatización de tareas**: Gulp compila SCSS y minifica recursos de forma automática.

## 🛠️ Tecnologías utilizadas

- **Backend**: PHP
- **Frontend**: SCSS, JavaScript
- **Base de datos**: MySQL
- **Herramientas**: Gulp, Composer, NPM

## 📁 Estructura del proyecto

- `controllers/`: Controladores que gestionan peticiones del usuario.
- `models/`: Modelos que interactúan con la base de datos.
- `views/`: Plantillas HTML estructuradas por componentes.
- `public/`: Punto de entrada de la app, contiene los archivos accesibles públicamente.
- `src/`: Archivos fuente de estilos (SCSS) y scripts JS.
- `includes/`: Componentes comunes como headers, footers, alertas, etc.
- `Router.php`: Enrutador personalizado que administra las URLs del sistema.

## ⚙️ Instalación

Sigue estos pasos para instalar y ejecutar el proyecto localmente:

1. Clona el repositorio:

   ```bash
   git clone https://github.com/Julian-Sandoval-x/bienesRaices.git
   cd bienesRaices

   ```

2. Instala dependencias de PHP

   ```bash
   composer install
   ```

3. Instala dependencias de JavaScript

   ```bash
   npm install
   ```

4. Configura las crendenciales tomando como base el archivo **.env.example**

5. Compila los archivos SASS y JavaScript con gulp
   ```bash
   npm run dev
   ```
6. Arranca el servidor en local
   ```bash
   php -S localhost:3000
   ```
