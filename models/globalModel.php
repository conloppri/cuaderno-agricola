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
    $sql = "select e.*, ue.rol from explotacion e JOIN usuarios_explotacion ue ON e.explotacion_id = ue.explotacion_id JOIN usuarios u ON ue.usuario_id = u.id WHERE u.email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['email' => $username]);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

// Función para obtener una explotación por su ID.
function obtenerExplotacionPorId(PDO $connection, int $idExplotacion) {
    $sql = "SELECT * FROM explotacion WHERE explotacion_id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['id' => $idExplotacion]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
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
    $stmt = $connection->prepare("SELECT * FROM organizacion WHERE organizacion_id IN (SELECT organizacion_id FROM usuarios_organizacion WHERE usuario_id = :usuarioId)");
    $stmt->execute(['usuarioId' => $usuarioId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerRolPorUsuario(PDO $connection, int $usuarioId, int $explotacionId) {
    $stmt = $connection->prepare("SELECT rol FROM usuarios_explotacion WHERE usuario_id = :usuarioId AND explotacion_id = :explotacionId");
    $stmt->execute(['usuarioId' => $usuarioId, 'explotacionId' => $explotacionId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['rol'] ?? 'Desconocido'; 
}

function obtenerPlantacionesPorExplotacion(PDO $connection, int $explotacion_id) {
    $stmt = $connection->prepare("SELECT p.*, pa.nombre AS parcela_nombre, c.nombre AS cultivo_nombre, c.variedad AS variedad_nombre 
        FROM plantacion p 
        JOIN parcela pa ON p.parcela_id = pa.parcela_id
        JOIN explotacion e ON pa.explotacion_id = e.explotacion_id
        JOIN cultivo c ON p.cultivo_id = c.cultivo_id 
        WHERE e.explotacion_id = :explotacion_id
        ORDER BY p.fecha_inicio DESC");
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerParcelasPorExplotacion(PDO $connection, int $explotacion_id) {
    $stmt = $connection->prepare("SELECT parcela_id, nombre FROM parcela WHERE explotacion_id = :explotacion_id");
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerCultivos(PDO $connection) {
    $stmt = $connection->prepare("SELECT cultivo_id, nombre, variedad FROM cultivo");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerUnidadesGestionPorExplotacion(PDO $connection, int $explotacion_id) {
    $stmt = $connection->prepare("SELECT unidad_gestion_id, nombre, superficie FROM unidad_gestion WHERE parcela_id IN (SELECT parcela_id FROM parcela WHERE explotacion_id = :explotacion_id)");
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>