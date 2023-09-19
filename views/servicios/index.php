<?php include_once __DIR__.'/../templates/barra.php'; ?>
<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de servicios</p>

<?php include_once __DIR__.'/../templates/alertas.php'?>

<div class="servicios-admin">
    <?php foreach($servicios as $servicio): ?>
        <div class="servicio-admin">
            <p><?php echo $servicio->nombre  ?></p>
            <div class="botones-admin">
                <a href="servicios/actualizar?id=<?php echo $servicio->id  ?>"><ion-icon class="ico-actualizar" name="arrow-up-outline"></ion-icon></a>
                <a href="servicios/eliminar?id=<?php echo $servicio->id  ?>"><ion-icon class="ico-eliminar" name="close-circle-outline"></ion-icon></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
    $script = "<script src='build/js/app.js'></script>
               <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
               <script type='module' src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js'></script>
               <script nomodule src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>"
?>