<?php

$db = mysqli_connect('localhost','root','root','appsalon',3306);
//mysqli_set_charset($db,'UTF8');

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
