<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form  method="POST" action="/" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            placeholder="Tu email"
            name="email"
            id="email"
        >
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            placeholder="Tu password"
            name="password"
            id="password"
        >
    </div>
    <input type="submit" value="Iniciar Sesión" class="boton">
</form>

<div class="acciones">
    <a href="/create-account">Registrarse</a>
    <a href="/forgot">Olvidé mi contraseña</a>
</div>