<?php include '../config/db.php';


function obtenerCultivos() {
    global $connection;
    $sql = "SELECT * FROM cultivo";
    $result = $connection->prepare($sql);
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerEcorregimenes() {
    global $connection;
    $sql = "SELECT * FROM ecorregimen";
    $result = $connection->prepare($sql);
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerFertilizantes() {
    global $connection;
    $sql = "SELECT * FROM fertilizante";
    $result = $connection->prepare($sql);
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerFitosanitarios() {
    global $connection;
    $sql = "SELECT * FROM fitosanitario";
    $result = $connection->prepare($sql);
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

?>