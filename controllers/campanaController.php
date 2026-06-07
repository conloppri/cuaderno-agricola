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
    $resumen['tratamientos'] = obtenerResumenTratamientos($explotacion_id, $ano);
    $resumen['fertilizaciones'] = obtenerResumenFertilizaciones($explotacion_id, $ano);
    $resumen['riegos'] = obtenerResumenRiegos($explotacion_id, $ano);
    return $resumen;
}

function obtenerDetallesPlantacionesPorCampana(int $explotacion_id, int $ano) {
    return obtenerPlantacionesPorCampana($explotacion_id, $ano);
}

function obtenerDetallesCosechasPorCampana(int $explotacion_id, int $ano) {
    return obtenerCosechasPorCampana($explotacion_id, $ano);
}

function obtenerDetallesTratamientosPorCampana(int $explotacion_id, int $ano) {
    return obtenerTratamientosPorCampana($explotacion_id, $ano);
}

function obtenerDetallesFertilizacionesPorCampana(int $explotacion_id, int $ano) {
    return obtenerFertilizacionesPorCampana($explotacion_id, $ano);
}

function obtenerDetallesRiegosPorCampana(int $explotacion_id, int $ano) {
    return obtenerRiegosPorCampana($explotacion_id, $ano);
}
?>