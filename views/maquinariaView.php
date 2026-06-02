<?php
include "../templates/cabecera_explotacion.php";

include "../controllers/globalController.php";

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

include_once "../controllers/maquinariaController.php";
$maquinaria = maquinariaController::obtenerMaquinariaPorExplotacion($connection, $explotacion_id);
?>

<div class= "main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion?> </h1>
        <i class="ti ti-tractor"></i>
        <h2 class="titulo_principal">Maquinaria</h2>
    </div>
    <div class="lista-maquinaria">
        <?php foreach($maquinaria as $maquina): ?>
            <div class="card-maquina" onclick="mostrarDetallesMaquina(<?php echo $maquina['id']; ?>)">
                <div class="card-body">
                    <div class="tags">
                        <div class="tag"><?php echo $maquina['tipo']; ?></div>
                        <div class="tag" style="background-color: <?php if($maquina['estado'] == 'Activa') echo '#bdf8bf'; else if($maquina['estado'] == 'Fuera de servicio') echo '#ffaaa4'; else echo '#fad68d'; ?>">
                            <?php echo $maquina['estado']; ?>
                        </div>
                    </div>
                    <h3 class="card-title"><?php echo $maquina['alias']; ?></h3>
                    <p class="card-text">
                        <strong>Modelo:</strong> <?php echo $maquina['modeloCompleto']; ?><br>
                        <strong>Matrícula:</strong> <?php echo $maquina['matricula']; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <dialog id= "maquinaria_modal" class = "info_modal">
        <div class="modal_content">
            <span class="close_button" onclick="document.getElementById('maquinaria_modal').close();">&times;</span>
            <div class="modal_body">
                <h2 style="text-align: center;">Detalles de <span id="maq_alias"></span></h2>
                <table id="maq_detalles" class="info_table"></table>
            </div>
        </div>
    </dialog>

    <div class="fab-container">
        <span class="fab-etiqueta">Agregar maquinaria</span>
        <button class="fab" onclick="window.location.href='maquinariaAdd.php?explotacion_id=<?php echo $explotacion_id; ?>'">+</button>
    </div>

</div>

<script>
function mostrarDetallesMaquina(id){
    fetch(`../controllers/maquinariaController.php?accion=obtenerDetallesMaquina&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('maq_alias').textContent = data.alias;
            document.getElementById('maq_detalles').innerHTML = `
                <tr><td class="info_label"><strong>Tipo:</strong></td><td>${data.tipo}</td></tr>
                <tr><td class="info_label"><strong>Marca:</strong></td><td>${data.marca}</td></tr>
                <tr><td class="info_label"><strong>Modelo:</strong></td><td>${data.modelo}</td></tr>
                <tr><td class="info_label"><strong>Matrícula:</strong></td><td>${data.matricula}</td></tr>
                <tr><td class="info_label"><strong>Estado:</strong></td><td>${data.estado}</td></tr>
                <tr><td class="info_label"><strong>Titular:</strong></td><td>${data.titular}</td></tr>
                <tr><td class="info_label"><strong>Número de ROMA:</strong></td><td>${data.num_roma}</td></tr>
                <tr><td class="info_label"><strong>Número de REGANIP:</strong></td><td>${data.num_reganip}</td></tr>
                <tr><td class="info_label"><strong>Fecha de adquisición:</strong></td><td>${data.fecha_adquisicion}</td></tr>
                <tr><td class="info_label"><strong>Última inspección:</strong></td><td>${data.ultima_inspeccion}</td></tr>
                <tr><td class="info_label"><strong>Caducidad ITV:</strong></td><td>${data.caducidad_itv}</td></tr>
                <tr><td class="info_label"><strong>Observaciones:</strong></td><td>${data.observaciones}</td></tr>
            `;
            document.getElementById('maquinaria_modal').showModal();
        })
}
</script>
<?php
include "../templates/footer.php";
?>