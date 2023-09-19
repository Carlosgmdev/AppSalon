<h1 class="nombre-pagina">Recuperación de contraseña</h1>
<p class="descripcion-pagina">Introduce tu nueva contraseña a continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php if(!$error): ?>
    <form method="POST" class="formulario">
        <div class="campo">
            <label for="password">Nueva contraseña</label>
            <input 
            type="password"
            name="password"
            id="password"
            placeholder="Tu nueva password"
        >
        </div>
        <input type="submit" value="Reestablecer password" class="boton">
    </form>
<?php endif; ?>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/create-account">Registrarse</a>
</div>