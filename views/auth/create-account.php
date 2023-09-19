<h1 class="nombre-pagina">Regístrate</h1>
<p class="descripcion-pagina">Llena el siguiente formulario</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/create-account">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            name="nombre"
            placeholder="Tu nombre"
            id="nombre"
            value="<?php  echo s($usuario->nombre) ?>"
        >
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input 
            type="text"
            name="apellido"
            placeholder="Tu apellido"
            id="apellido"
            value="<?php  echo s($usuario->apellido) ?>"
        >
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input 
            type="tel"
            name="telefono"
            placeholder="Tu telefono"
            id="telefono"
            value="<?php  echo s($usuario->telefono) ?>"
        >
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            name="email"
            placeholder="Tu email"
            id="email"
            value="<?php  echo s($usuario->email) ?>"
        >
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            name="password"
            placeholder="Tu password"
            id="password"
        >
    </div>
    <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/forgot">Olvidé mi contraseña</a>
</div>