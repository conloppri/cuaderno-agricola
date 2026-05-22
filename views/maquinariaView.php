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
            <div class="card-maquina">
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
</div>

<?php
include "../templates/footer.php";
?>