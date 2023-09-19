<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\AdminController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);
$router->get('/forgot',[LoginController::class,'forgot']);
$router->post('/forgot',[LoginController::class,'forgot']);
$router->get('/recovery',[LoginController::class,'recovery']);
$router->post('/recovery',[LoginController::class,'recovery']);
$router->get('/create-account',[LoginController::class,'create']);
$router->post('/create-account',[LoginController::class,'create']);
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

$router->get('/cita',[CitaController::class, 'index']);
$router->get('/admin',[AdminController::class, 'index']);

$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();