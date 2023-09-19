<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'admin',
        'confirmado',
        'token'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id =         $args['id'] ?? null;
        $this->nombre =     $args['nombre'] ?? '';
        $this->apellido =   $args['apellido'] ?? '';
        $this->email =      $args['email'] ?? '';
        $this->password =   $args['password'] ?? '';
        $this->telefono =   $args['telefono'] ?? '';
        $this->admin =      $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token =      $args['token'] ?? '';
    }

    public function validar($action = "" ?? null)
    {

        if (!$this->email) {
            self::$alertas['error'][] = 'DEBES INTRODUCIR UN EMAIL';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'DEBES INTRODUCIR UN PASSWORD';
        }

        if ($action === 'create') {
            if (!$this->nombre) {
                self::$alertas['error'][] = 'DEBES INTRODUCIR UN NOMBRE';
            }

            if (!$this->apellido) {
                self::$alertas['error'][] = 'DEBES INTRODUCIR UN APELLIDO';
            }


            if (!$this->telefono) {
                self::$alertas['error'][] = 'DEBES INTRODUCIR UN TELEFONO';
            }


            if (strlen($this->password) < 6) {
                self::$alertas['error'][] = 'EL PASSWORD DEBE CONTENER AL MENOS 6 CARACTERES';
            }
        }

        return self::$alertas;
    }

    public function validarForgot() {
        if (!$this->email) {
            self::$alertas['error'][] = 'DEBES INTRODUCIR UN EMAIL';
        }

        return self::$alertas;
    }

    public function validarPassword() {

        if (!$this->password) {
            self::$alertas['error'][] = 'DEBES INTRODUCIR UN PASSWORD';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'EL PASSWORD DEBE CONTENER AL MENOS 6 CARACTERES';
        }

        return self::$alertas;
    }

    public function userExist()
    {

        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1;";
        $result = self::$db->query($query);


        if ($result->num_rows) {
            self::$alertas['error'][] = 'EL EMAIL YA FUE REGISTRADO EN OTRA CUENTA';
        }

        return $result;
    }

    public function hashPass()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken()
    {
        $this->token = uniqid();
    }

    public function checkPassAndConfirmed($password)
    {
        $autenticated = password_verify($password, $this->password);
        
        if(!$autenticated || !$this->confirmado) {
            self::$alertas['error'][] = 'PASSWORD INCORRECTO O CUENTA SIN CONFIRMAR';
        } else {
            return true;
        }
    }

    public function autenticar()
    {
        session_start();

        $_SESSION['id'] = $this->id;
        $_SESSION['nombre'] = $this->nombre." ".$this->apellido;
        $_SESSION['email'] = $this->email;
        $_SESSION['login'] = true;

        if($this->admin === "1") {
            $_SESSION['admin'] = $this->admin ?? null;
            header('Location: /admin');
        } else {
            header('Location: /cita');
        }
    }
}
