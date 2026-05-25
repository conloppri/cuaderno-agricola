<?php
include "../templates/cabecera_explotacion.php";

$explotacion_id = $_GET['explotacion_id'];

include_once "../controllers/maquinariaController.php";
$maquinaria = maquinariaController::obtenerMaquinariaPorExplotacion($connection, $explotacion_id);
?>

<div class= "main_content">
    <div class="cabecera_main">
        <h1>Maquinaria</h1>
        <button class="add_button" onclick="window.location.href='maquinariaAdd.php?explotacion_id=<?php echo $explotacion_id; ?>'">+ Agregar Maquinaria</button>
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
                <p id="maq_detalles" class="info_text"></p>
            </div>
        </div>
    </dialog>
</div>

<script>
function mostrarDetallesMaquina(id){
    fetch(`../controllers/maquinariaController.php?accion=obtenerDetallesMaquina&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('maq_alias').textContent = data.alias;
            document.getElementById('maq_detalles').innerHTML = `
                <strong>Tipo:</strong> ${data.tipo}<br>
                <strong>Marca:</strong> ${data.marca}<br>
                <strong>Modelo:</strong> ${data.modelo}<br>
                <strong>Matrícula:</strong> ${data.matricula}<br>
                <strong>Estado:</strong> ${data.estado}<br>
                <strong>Titular:</strong> ${data.titular}<br>
                <strong>Número ROMA:</strong> ${data.num_roma}<br>
                <strong>Número REGANIP:</strong> ${data.num_reganip}<br>
                <strong>Fecha de adquisición:</strong> ${data.fecha_adquisicion}<br>
                <strong>Última inspección:</strong> ${data.ultima_inspeccion}<br>
                <strong>Caducidad ITV:</strong> ${data.caducidad_itv}<br>
                <strong>Observaciones:</strong> ${data.observaciones}
            `;
            document.getElementById('maquinaria_modal').showModal();
        })
}
</script>
<?php
include "../templates/footer.php";
?>