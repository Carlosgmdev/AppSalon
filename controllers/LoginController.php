<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {

        $alertas = [];
        $result = s($_GET['result']) ?? null;
        if($result === '1') {
            $alertas = Usuario::setAlerta('exito', 'PASSWORD CAMBIADA CON EXITO, INICIA SESIÓN');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new Usuario($_POST);
            $alertas = $auth->validar();

            if (empty($alertas)) {

                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    if($usuario->checkPassAndConfirmed($auth->password)) {
                        $usuario->autenticar();
                    } else {
                        $alertas = Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'EL USUARIO NO EXISTE');
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }

    public static function forgot(Router $router)
    {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarForgot();

            if(empty($alertas)) {

                $usuario = Usuario::where('email',$auth->email);

                if($usuario && $usuario->confirmado === "1") {
                    $usuario->createToken();
                    $usuario->guardar();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'REVISA TU EMAIL, ENVIAMOS INDICACIONES PARA RECUPERAR EL ACCESO A TU CUENTA');
                } else {
                    Usuario::setAlerta('error', 'EL USUARIO NO EXISTE O NO ESTA CONFIRMADO');
                    
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/forgot', [
            'alertas' => $alertas
        ]);
    }

    public static function recovery(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        $error = false;

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'TOKEN INVALIDO');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPass();
                $usuario->token = null;

                $result = $usuario->guardar();
                if($result) {
                    header('Location: /?result=1');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recovery', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function create(Router $router)
    {

        $usuario = new Usuario();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar('create');

            if (empty($alertas)) {
                $result = $usuario->userExist();
                if ($result->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPass();
                    $usuario->createToken();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    $result = $usuario->guardar();
                    if ($result) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/create-account', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where("token", $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'TOKEN NO VALIDO');
        } else {
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'CUENTA CONFIRMADA EXITOSAMENTE');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
