<?php include "../templates/cabecera_explotacion.php";?>

<?php 

include "../controllers/globalController.php";

//Desde la pantalla de explotaciones, se envía el id de la explotación para mostrar solo las parcelas de esa explotación. 

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

include_once "../controllers/instalacionesController.php";
$instalaciones = instalacionesController::obtenerInstalacionesPorExplotacion($explotacion_id);

?>

<div class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion ?></h1>
        <i class="ti ti-building-cottage"></i>
        <h2 class="titulo_principal">Instalaciones</h2>
    </div>
    <div>
        <table class="table_exp_inst">
            <?php foreach($instalaciones as $instalacion):?>
            <tr>
                <td>
                    <div>
                        <h4><?php echo $instalacion["nombre"]?></h4>
                    </div>
                </td>
                <td>
                    <p> Superficie: <?php echo $instalacion["superficie"] ?> </p>
                </td>
                <td>
                    <div class="tags">
                        <div class="tag"><?php echo $instalacion['tipo']; ?></div>
                        <div class="tag" style="background-color: <?php if($instalacion['estado'] == 'Activa') echo '#bdf8bf'; else if($instalacion['estado'] == 'No disponible') echo '#ffaaa4'; else echo '#fad68d'; ?>">
                            <?php echo $instalacion['estado']; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>

<?php include '../templates/footer.php';?>

