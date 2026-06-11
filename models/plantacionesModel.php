<?php
function addPlantacion($connection, $parcela_id, $unidad_gestion_id, $cultivo_id, $densidad_unidad, $recinto, $fecha_inicio, $sistema_cultivo, 
            $sistema_riego, $finalidad, $manejo, $valor_densidad, $anotaciones) {
    try {
        // Limpieza rápida por si acaso el controlador envía "null" en texto
        $unidad_gestion = ($unidad_gestion_id === 'null' || $unidad_gestion_id === '') ? null : $unidad_gestion_id;

        $sql = "INSERT INTO plantacion (parcela_id, unidad_gestion_id, cultivo_id, densidad_unidad, recinto, fecha_inicio, fecha_fin, sistema_cultivo, 
            sistema_riego, finalidad, manejo, valor_densidad, anotaciones) VALUES (:parcela_id, :unidad_gestion_id, :cultivo_id, :densidad_unidad, :recinto, :fecha_inicio, 
            NULL, :sistema_cultivo, :sistema_riego, :finalidad, :manejo, :valor_densidad, :anotaciones)";
        
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':parcela_id' => $parcela_id,
            ':unidad_gestion_id' => $unidad_gestion,
            ':cultivo_id' => $cultivo_id,
            ':densidad_unidad' => !empty($densidad_unidad) ? $densidad_unidad : null,
            ':recinto' => $recinto,
            ':fecha_inicio' => $fecha_inicio,
            ':sistema_cultivo' => !empty($sistema_cultivo) ? $sistema_cultivo : null,
            ':sistema_riego' => !empty($sistema_riego) ? $sistema_riego : null,
            ':finalidad' => !empty($finalidad) ? $finalidad : null,
            ':manejo' => !empty($manejo) ? $manejo : null,
            ':valor_densidad' => ($valor_densidad === '' || $valor_densidad === null) ? null : $valor_densidad,
            ':anotaciones' => !empty($anotaciones) ? $anotaciones : null
        ]);
    } catch (PDOException $e) {
        throw new Exception('Error al insertar en la base de datos: ' . $e->getMessage());
    }
}

function modPlantacion($connection, $plantacion_id, $parcela_id, $unidad_gestion_id, $cultivo_id, $densidad_unidad, $recinto, $fecha_inicio, $fecha_fin, $sistema_cultivo, 
            $sistema_riego, $finalidad, $manejo, $valor_densidad, $anotaciones) {
    try {
        // Aseguramos que los campos vacíos u opcionales se mapeen como NULL reales de PHP
        $unidad_gestion = ($unidad_gestion_id === 'null' || $unidad_gestion_id === '') ? null : $unidad_gestion_id;
        $fecha_final_limpia = !empty($fecha_fin) ? $fecha_fin : null;

        $sql = "UPDATE plantacion SET 
        parcela_id = :parcela_id, 
        unidad_gestion_id = :unidad_gestion_id, 
        cultivo_id = :cultivo_id, 
        densidad_unidad = :densidad_unidad, 
        recinto = :recinto, 
        fecha_inicio = :fecha_inicio, 
        fecha_fin = :fecha_fin, 
        sistema_cultivo = :sistema_cultivo, 
        sistema_riego = :sistema_riego, 
        finalidad = :finalidad, 
        manejo = :manejo, 
        valor_densidad = :valor_densidad, 
        anotaciones = :anotaciones 
        WHERE plantacion_id = :plantacion_id";
        
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':parcela_id' => $parcela_id,
            ':unidad_gestion_id' => $unidad_gestion,
            ':cultivo_id' => $cultivo_id,
            ':densidad_unidad' => !empty($densidad_unidad) ? $densidad_unidad : null,
            ':recinto' => $recinto,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_final_limpia,
            ':sistema_cultivo' => !empty($sistema_cultivo) ? $sistema_cultivo : null,
            ':sistema_riego' => !empty($sistema_riego) ? $sistema_riego : null,
            ':finalidad' => !empty($finalidad) ? $finalidad : null,
            ':manejo' => !empty($manejo) ? $manejo : null,
            ':valor_densidad' => ($valor_densidad === '' || $valor_densidad === null) ? null : $valor_densidad,
            ':anotaciones' => !empty($anotaciones) ? $anotaciones : null,
            ':plantacion_id' => $plantacion_id
        ]);
    } catch (PDOException $e) {
        throw new Exception('Error al modificar en la base de datos: ' . $e->getMessage());
    }
}
?>