<?php

include "../models/maquinariaModel.php";

$accion = $_GET['accion'] ?? '';

switch($accion) {
    case 'obtenerDetallesMaquina':
        $id = $_GET['id'];

        header('Content-Type: application/json');

        $maquina = obtenerMaquinaPorId($connection, $id);
        echo json_encode([
            'alias' => $maquina['alias'],
            'tipo' => $maquina['tipo_maquina'],
            'marca' => $maquina['marca'],
            'modelo' => $maquina['modelo'],
            'matricula' => $maquina['matricula'],
            'estado' => $maquina['estado'],
            'titular' => isset($maquina['titular']) ? $maquina['titular'] : 'Sin información',
            'num_roma' => isset($maquina['num_roma']) ? $maquina['num_roma'] : 'Sin información',
            'num_reganip' => isset($maquina['num_reganip']) ? $maquina['num_reganip'] : 'Sin información',
            'fecha_adquisicion' => isset($maquina['fecha_adquisicion']) ? $maquina['fecha_adquisicion'] : 'Sin información',
            'ultima_inspeccion' => isset($maquina['ultima_inspeccion']) ? $maquina['ultima_inspeccion'] : 'Sin información',
            'caducidad_itv' => isset($maquina['caducidad_itv']) ? $maquina['caducidad_itv'] : 'Sin información',
            'observaciones' => isset($maquina['observaciones']) ? $maquina['observaciones'] : 'Sin información'
        ]);
        break;
}

class maquinariaController{

    static function obtenerMaquinariaPorExplotacion(PDO $connection, int $explotacion_id) {
        $maquinaria = obtenerMaquinaria($connection, $explotacion_id);
        $infoMaquinaria = [];
        foreach($maquinaria as $maquina) {
            array_push($infoMaquinaria, [
                'id' => $maquina['maquinaria_id'],
                'alias' => $maquina['alias'],
                'tipo' => $maquina['tipo_maquina'],
                'modeloCompleto' => $maquina['marca'] . " " . $maquina['modelo'],
                'matricula' => $maquina['matricula'],
                'estado' => $maquina['estado']
            ]);
        }
        return $infoMaquinaria;
    }

}

?>