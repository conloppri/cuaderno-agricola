<?php include "../templates/cabecera_explotacion.php";?>

<?php
include "../controllers/globalController.php";

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

?>

<div class= "main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion; ?></h1>
        <i class="ti ti-calendar"></i>
        <h2 class="titulo_principal">Campañas</h2>
    </div>
    <div class="lista-campanas">
        <p>Aún no hay campañas registradas.</p>
    </div>

    <div class="fab-container">
        <span class="fab-etiqueta">Agregar campaña</span>
        <button class="fab" onclick="window.location.href='campanaAdd.php'">+</button>
    </div>
</div>


<?php include "../templates/footer.php";?>