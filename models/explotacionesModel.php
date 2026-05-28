<?php
include "../config/db.php";

/* Repetido en globalModel?
function obtenerExplotaciones(PDO $connection, $username) {
    $sql = "select e.* from explotacion e JOIN usuarios_explotacion ue ON e.explotacion_id = ue.explotacion_id JOIN usuarios u ON ue.usuario_id = u.id WHERE u.email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['email' => $username]);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}
*/
function addExplotacion(PDO $connection, $nombre, $alias, $organizacion_id, $provincia_id, $municipio_id, $comunidad, $codigo_rea, $codigo_siex) {
    try {
        // Insertar nueva explotación en la base de datos
        $sql = "INSERT INTO explotacion (nombre, alias, organizacion_id, provincia_id, municipio_id, comunidad, codigo_rea, codigo_siex) VALUES (:nombre, :alias, :organizacion_id, :provincia_id, :municipio_id, :comunidad, :codigo_rea, :codigo_siex)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre,
            'alias' => $alias,
            'organizacion_id' => $organizacion_id,
            'provincia_id' => $provincia_id,
            'municipio_id' => $municipio_id,
            'comunidad' => $comunidad,
            'codigo_rea' => $codigo_rea,
            'codigo_siex' => $codigo_siex
        ]);

        // Obtener el ID de la explotación recién creada
        return $connection->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception('Error al guardar la explotación: ' . $e->getMessage());
    }
}

function addUsuarioExplotacion(PDO $connection, $usuario_id, $explotacion_id, $rol) {
    try {
        $sql = "INSERT INTO usuarios_explotacion (usuario_id, explotacion_id, rol) VALUES (:usuario_id, :explotacion_id, :rol)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'usuario_id' => $usuario_id,
            'explotacion_id' => $explotacion_id,
            'rol' => $rol
        ]);
    } catch (PDOException $e) {
        throw new Exception('Error al asociar la explotación con el usuario: ' . $e->getMessage());
    }
}

function modificarExplotacion(PDO $connection, $explotacion_id, $nombre, $alias, $organizacion_id, $provincia_id, $municipio_id, $comunidad, $codigo_rea, $codigo_siex) {
    try {
        // Actualizar la explotación en la base de datos
        $sql = "UPDATE explotacion SET nombre = :nombre, alias = :alias, organizacion_id = :organizacion_id, provincia_id = :provincia_id, municipio_id = :municipio_id, comunidad = :comunidad, codigo_rea = :codigo_rea, codigo_siex = :codigo_siex WHERE explotacion_id = :explotacion_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre,
            'alias' => $alias,
            'organizacion_id' => $organizacion_id,
            'provincia_id' => $provincia_id,
            'municipio_id' => $municipio_id,
            'comunidad' => $comunidad,
            'codigo_rea' => $codigo_rea,
            'codigo_siex' => $codigo_siex,
            'explotacion_id' => $explotacion_id
        ]);
    } catch (PDOException $e) {
        throw new Exception('Error al modificar la explotación: ' . $e->getMessage());
    }
}

function eliminarExplotacion(PDO $connection, $explotacion_id) {
    try {
        // Eliminar la explotación de la base de datos
        $sql = "DELETE FROM explotacion WHERE explotacion_id = :explotacion_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['explotacion_id' => $explotacion_id]);

        // Eliminar las asociaciones con los usuarios
        $sqlUsuariosExplotacion = "DELETE FROM usuarios_explotacion WHERE explotacion_id = :explotacion_id";
        $stmtUsuariosExplotacion = $connection->prepare($sqlUsuariosExplotacion);
        $stmtUsuariosExplotacion->execute(['explotacion_id' => $explotacion_id]);
    } catch (PDOException $e) {
        throw new Exception('Error al eliminar la explotación: ' . $e->getMessage());
    }
}
?>