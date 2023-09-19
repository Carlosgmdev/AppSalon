<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController {
    public static function index(Router $router) {

        session_start();

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) {

        session_start();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio = new Servicio($_POST);
            $servicio->guardar();
            Servicio::setAlerta('exito', 'SERVICIO CREADO CON EXITO');
            $alertas = Servicio::getAlertas();
            header('Location: /servicios');
        }


        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {

        session_start();

        $id = $_GET['id'];
        $servicio = Servicio::find($id);
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->guardar();
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio
        ]);
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}