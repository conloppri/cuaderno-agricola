<?php include "../templates/cabecera_explotacion.php";?>

<?php 

include "../controllers/globalController.php";
include_once "../controllers/instalacionesController.php";
include '../models/rolesUsuariosModel.php';
//Desde la pantalla de explotaciones, se envía el id de la explotación para mostrar solo las parcelas de esa explotación. 

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);
$rol = obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $explotacion_id);

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
                        <h3><?php echo $instalacion["nombre"]?></h3>
                    </div>
                </td>
                <td>
                    <p> <strong>Superficie:</strong> <?php echo $instalacion["superficie"] ?>  ha</p>
                </td>
                <td>
                    <div class="tags">
                        <div class="tag"><?php echo $instalacion['tipo']; ?></div>
                        <div class="tag" style="background-color: <?php if($instalacion['estado'] == 'Disponible') echo '#bdf8bf'; else if($instalacion['estado'] == 'No disponible') echo '#ffaaa4'; else echo '#fad68d'; ?>">
                            <?php echo $instalacion['estado']; ?>
                        </div>
                    </div>
                </td>
                <?php if($rol === 'administrador'):?>
                            <td>
                                <button class="editar_btn" type="button" onclick=""> <i class="ti ti-pencil"></i> </button>  
                                <button class="eliminar_btn" type="button" onclick=""><i class="ti ti-trash"></i> </button>
                            </td>
                <?php endif?>
            </tr>
            <?php endforeach;?>
        </table>
    </div>

    <dialog id="add_instalacion" class="modal_formulario instalacion_form">
        <div class="modal_content">
            <span class="close_button" onclick="document.getElementById('add_instalacion').close()">&times;</span>
            <h2>Agregar nueva instalación</h2>

            <form id="instalacion_form">
                <input type="hidden" name="accion" value="agregarInstalacion">
                <input type="hidden" name="explotacion_id" value="<?php echo $explotacion_id; ?>">
                <div class="grupo-form">
                    <label for="nombre">Nombre de la instalación:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="superficie">Superficie (ha):</label>
                    <input type="number" id="superficie" name="superficie" step="0.01" required>

                    <!--`tipo` ENUM("Nave", "Almacen", "Balsa", "Silo")-->
                    <label for="tipo">Tipo de instalación:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="" selected disabled>Selecciona un tipo</option>
                        <option value="Nave">Nave</option>
                        <option value="Almacen">Almacén</option>
                        <option value="Balsa">Balsa</option>
                        <option value="Silo">Silo</option>
                    </select>

                    <!-- `estado` ENUM("Disponible", "No disponible", "En mantenimiento") -->
                    <label for="estado">Estado de la instalación:</label>
                    <select id="estado" name="estado" required>
                        <option value="" selected disabled>Selecciona un estado</option>
                        <option value="Disponible">Disponible</option>
                        <option value="No disponible">No disponible</option>
                        <option value="En mantenimiento">En mantenimiento</option>
                    </select>
                </div>
                <div>
                    <p id="mensaje-error" style="color: red; text-align: center;"></p>
                </div>
                <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                    <button type="button" class="cancel_button" onclick="document.getElementById('add_instalacion').close();">Cancelar</button>
                    <button type="submit" class="add_button">Guardar</button>
                </div>
            </form>

    </dialog>

    <div class="fab-container">
        <span class="fab-etiqueta">Agregar instalación</span>
        <button class="fab" onclick="document.getElementById('add_instalacion').showModal();">+</button>
    </div>
</div>

<script>
    document.getElementById("instalacion_form").addEventListener("submit", async function(e) {
        e.preventDefault();
        const mensajeError = document.getElementById("mensaje-error");
        mensajeError.textContent = ""; // Limpiar mensaje de error previo
        const formData = new FormData(this);

        try{
            const respuesta = await fetch("../controllers/instalacionesController.php", {
                method: "POST",
                body: formData
            });

           const resultado = await respuesta.json();
            
            if(resultado.ok){ 
                alert(resultado.mensaje);
                location.reload();
            } else {
                mensajeError.textContent = resultado.mensaje;
                console.error(resultado.mensaje);
            }
        } catch (error) {
            mensajeError.textContent = "Error en la conexión con el servidor. Por favor, inténtalo de nuevo.";
            console.error("Error al guardar la maquinaria:", error);
        }
    
    });
    </script>

<?php include '../templates/footer.php';?>

