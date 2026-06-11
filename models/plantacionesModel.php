<?php
function addPlantacion($connection, $parcela_id, $unidad_gestion_id, $cultivo_id, $densidad_unidad, $recinto, $fecha_inicio, $sistema_cultivo, 
            $sistema_riego, $finalidad, $manejo, $valor_densidad, $anotaciones) {
    try {
        // Insertar nueva plantación en la base de datos
        $sql = "INSERT INTO plantacion (parcela_id, unidad_gestion_id, cultivo_id, densidad_unidad, recinto, fecha_inicio, fecha_fin, sistema_cultivo, 
            sistema_riego, finalidad, manejo, valor_densidad, anotaciones) VALUES (:parcela_id, NULLIF(:unidad_gestion_id, ''), :cultivo_id, :densidad_unidad, :recinto, :fecha_inicio, 
            NULL, :sistema_cultivo, :sistema_riego, :finalidad, :manejo, :valor_densidad, :anotaciones)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':parcela_id' => $parcela_id,
            ':unidad_gestion_id' => $unidad_gestion_id,
            ':cultivo_id' => $cultivo_id,
            ':densidad_unidad' => $densidad_unidad,
            ':recinto' => $recinto,
            ':fecha_inicio' => $fecha_inicio,
            ':sistema_cultivo' => $sistema_cultivo,
            ':sistema_riego' => $sistema_riego,
            ':finalidad' => $finalidad,
            ':manejo' => $manejo,
            ':valor_densidad' => $valor_densidad,
            ':anotaciones' => $anotaciones
            ]);
    } catch (PDOException $e) {
        throw new Exception('Error al guardar la explotación: ' . $e->getMessage());
    }
}
?>