<?php
include "../models/campanaModel.php";

function obtenerCampanas(int $explotacion_id) {
    $anos = obtenerAnosCampanas($explotacion_id);
    $campanas = [];
    foreach ($anos as $ano) {
        $campanas[] = ['ano' => $ano, 'nombre' => "Campaña $ano"];
    }
    return $campanas;
}

function obtenerResumenCampana(int $explotacion_id, int $ano) {
    $resumen =[];
    $resumen['plantaciones'] = obtenerResumenPlantaciones($explotacion_id, $ano);
    $resumen['cosechas'] = obtenerResumenCosechas($explotacion_id, $ano);
    return $resumen;
}

function obtenerDetallesPlantacionesPorCampana(int $explotacion_id, int $ano) {
    return obtenerPlantacionesPorCampana($explotacion_id, $ano);
}

?>