<?php
include "../config/db.php";

// Función para obtener la información de provincia
function obtenerProvincia(PDO $connection, int $idProvincia) {

    $stmt = $connection->prepare("SELECT nombre FROM provincia WHERE provincia_id = :id");
    $stmt->execute(['id' => $idProvincia]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'] ?? 'Desconocida'; 
}

// Función para obtener la información de municipio
function obtenerMunicipio(PDO $connection, int $idMunicipio) {
    $stmt = $connection->prepare("SELECT nombre FROM municipio WHERE municipio_id = :id");
    $stmt->execute(['id' => $idMunicipio]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'] ?? 'Desconocido'; 
}

//Función para obtener lista de provincias
function obtenerProvincias(PDO $connection) {
    $stmt = $connection->prepare("SELECT provincia_id, nombre FROM provincia");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Función obtener lista de municipios por provincia
function obtenerMunicipiosPorProvincia(PDO $connection, int $provinciaId) {
    $municipiosLista = [];
    $stmt = $connection->prepare("SELECT municipio_id, nombre FROM municipio WHERE provincia_id = :id");
    $stmt->execute(['id' => $provinciaId]);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultado as $municipio) {
        $municipiosLista[] = [
            'id' => $municipio['municipio_id'],
            'nombre' => $municipio['nombre']
        ];
    }
    return $municipiosLista;
}

// Función para obtener la lista de explotaciones.
function obtenerExplotaciones(PDO $connection, $username) {
    $sql = "select e.* from explotacion e JOIN usuarios_explotacion ue ON e.explotacion_id = ue.explotacion_id JOIN usuarios u ON ue.usuario_id = u.id WHERE u.email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['email' => $username]);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

// Función para obtener la lista de provincias.
function obtenerListaProvincias(PDO $connection) {
    $stmt = $connection->prepare("SELECT provincia_id, nombre FROM provincia");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener la lista de municipios.
function obtenerListaMunicipios(PDO $connection) {
    $stmt = $connection->prepare("SELECT municipio_id, provincia_id, nombre FROM municipio");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener una organización por su ID.
function obtenerOrganizacion(PDO $connection, int $idOrganizacion) {
    $stmt = $connection->prepare("SELECT * FROM organizacion WHERE organizacion_id = :id");
    $stmt->execute(['id' => $idOrganizacion]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result; 
}

// Función para obtener la lista de organizaciones de un usuario.
function obtenerOrganizaciones(PDO $connection, int $usuarioId) {
    $stmt = $connection->prepare("SELECT organizacion_id, nombre_organizacion, nif FROM organizacion WHERE organizacion_id IN (SELECT organizacion_id FROM usuarios_organizacion WHERE usuario_id = :usuarioId)");
    $stmt->execute(['usuarioId' => $usuarioId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>