<h1 class="nombre-pagina">Recuperación de contraseña</h1>
<p class="descripcion-pagina">Introduce el email que registraste para recibir indicaciones</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form action="/forgot" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            placeholder="Tu email"
            name="email"
            id="email"
        >
    </div>
    <input type="submit" class="boton" value="Recuperar Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/create-account">Registrarse</a>
</div>