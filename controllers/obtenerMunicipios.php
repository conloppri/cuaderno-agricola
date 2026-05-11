<?php
include "../models/globalModel.php";
include "../config/db.php";

//Obtener listado de municipios por provincia a través de AJAX

// Obtener el ID de la provincia desde la solicitud GET
$provinciaId = $_GET['provincia_id'] ?? 41;

// Obtener la lista de municipios para la provincia dada
$listaMunicipios = obtenerMunicipiosPorProvincia($connection, $provinciaId);

// Devolver la lista de municipios como JSON
header('Content-Type: application/json');
echo json_encode($listaMunicipios);

?>