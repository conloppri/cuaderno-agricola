<?php
include "../config/db.php";

function addOrganizacion(PDO $connection, $nombre, $razon_social, $nif, $provincia_id, $municipio_id, $comunidad, $tlf_fijo, $tlf_movil, $direccion, $email, $cod_postal) {
    try {
        // Insertar nueva organización en la base de datos
        $sql = "INSERT INTO organizacion (nombre_organizacion, nombre_razon_social, nif, provincia_id, municipio_id, comunidad, tlf_fijo, tlf_movil, direccion, email, cod_postal) VALUES (:nombre_organizacion, :nombre_razon_social, :nif, :provincia_id, :municipio_id, :comunidad, :tlf_fijo, :tlf_movil, :direccion, :email, :cod_postal)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'nombre_organizacion' => $nombre,
            'nombre_razon_social' => $razon_social,
            'nif' => $nif,
            'provincia_id' => $provincia_id,
            'municipio_id' => $municipio_id,
            'comunidad' => $comunidad,
            'tlf_fijo' => $tlf_fijo,
            'tlf_movil' => $tlf_movil,
            'direccion' => $direccion,
            'email' => $email,
            'cod_postal' => $cod_postal
        ]);

        // Obtener el ID de la organización recién creada
        return $connection->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception('Error al guardar la organización: ' . $e->getMessage());
    }
}

function addOrganizacion(PDO $connection, $nombre, $razon_social, $nif, $provincia_id, $municipio_id, $comunidad, $tlf_fijo, $tlf_movil, $direccion, $email, $cod_postal) {
    try {
        // Insertar nueva organización en la base de datos
        $sql = "INSERT INTO organizacion (nombre_organizacion, nombre_razon_social, nif, provincia_id, municipio_id, comunidad, tlf_fijo, tlf_movil, direccion, email, cod_postal) 
            VALUES (:nombre_organizacion, :nombre_razon_social, :nif, :provincia_id, :municipio_id, :comunidad, :tlf_fijo, :tlf_movil, :direccion, :email, :cod_postal)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'nombre_organizacion' => $nombre,
            'nombre_razon_social' => $razon_social,
            'nif' => $nif,
            'provincia_id' => $provincia_id,
            'municipio_id' => $municipio_id,
            'comunidad' => $comunidad,
            'tlf_fijo' => $tlf_fijo,
            'tlf_movil' => $tlf_movil,
            'direccion' => $direccion,
            'email' => $email,
            'cod_postal' => $cod_postal
        ]);

        // Obtener el ID de la organización recién creada
        return $connection->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception('Error al guardar la organización: ' . $e->getMessage());
    }
}

function addUsuarioOrganizacion(PDO $connection, $usuario_id, $organizacion_id) {
    try {
        $sql = "INSERT INTO usuarios_organizacion (usuario_id, organizacion_id) VALUES (:usuario_id, :organizacion_id)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'usuario_id' => $usuario_id,
            'organizacion_id' => $organizacion_id
        ]);
    } catch (PDOException $e) {
        throw new Exception('Error al asociar la organización con el usuario: ' . $e->getMessage());
    }
}
?>