<?php include_once __DIR__.'/../templates/barra.php'; ?>
<h1 class="nombre-pagina">Actualizar Servicio</h1>

<form method="POST">
    <?php include_once __DIR__.'/../servicios/formulario.php' ?>
    <input type="submit" value="Guardar Cambios" class="boton">
</form>
<?php
    $script = "<script src='build/js/app.js'></script>
               <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
               <script type='module' src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js'></script>
               <script nomodule src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>"
?>

