

<!-- Cabecera -->
<?php include "../templates/cabecera_explotacion.php";?>

<!-- Contenido principal -->
<?php include "../controllers/parcelaController.php";

$parcelas = obtenerInfoParcelas($connection);
?>

<div class="cabecera_parcelas">
    <h1>Parcelas y unidades de gestión</h1>
    <button class="add_button">+ Añadir parcela</button>
</div>


<div class="table_exp">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>SIGPAC</th>
                <th>Provincia</th>
                <th>Municipio</th>
                <th>Superficie (ha)</th>
                <th>Unidades de gestión</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parcelas as $parcela): ?>
                <tr>
                    <td><?php echo htmlspecialchars($parcela['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($parcela['sigpac']); ?></td>
                    <td><?php echo htmlspecialchars($parcela['provincia']); ?></td>
                    <td><?php echo htmlspecialchars($parcela['municipio']); ?></td>
                    <td><?php echo htmlspecialchars($parcela['superficie']); ?></td>
                    <td><button onclick="toggleFila(<?php echo $parcela['id']; ?>)"> + </button></td>
                </tr>
                <tr id="fila-<?php echo $parcela['id']; ?>" style="display: none;">
                    <td colspan="6">
                        <h4>Unidades de gestión</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Superficie (ha)</th>
                                    <th>Uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $unidadesGestion = obtenerInfoUnidadesGestion($connection, $parcela['id']);
                                foreach ($unidadesGestion as $unidad): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($unidad['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($unidad['superficie']); ?></td>
                                        <td><?php echo htmlspecialchars($unidad['uso']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function toggleFila(id) {
    var fila = document.getElementById("fila-" + id);
    if (fila.style.display === "none") {
        fila.style.display = "table-row";
    } else {
        fila.style.display = "none";
    }
}
</script>
<!-- Pie de página -->
<?php include "../templates/footer.php";?>