<?php

include "../models/maquinariaModel.php";

$accion = $_GET['accion'] ?? '';

switch ($accion) {
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
    case 'agregarMaquinaria':
        header('Content-Type: application/json');
        
        $explotacion_id = $_POST['explotacion_id'];
        $alias = $_POST['alias'];
        $tipo = $_POST['tipo'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $matricula = $_POST['matricula'];
        $estado = $_POST['estado'];
        $titular = $_POST['titular'] ?? null;
        $num_roma = $_POST['num_roma'] ?? null;
        $num_reganip = $_POST['num_reganip'] ?? null;
        $fecha_adquisicion = $_POST['fecha_adquisicion'] ?? null;
        $ultima_inspeccion = $_POST['ultima_inspeccion'] ?? null;
        $caducidad_itv = $_POST['caducidad_itv'] ?? null;
        $observaciones = $_POST['observaciones'] ?? null;

        $resultado = guardarMaquinaria($explotacion_id, $alias, $tipo, $marca, $modelo, $matricula, $estado, $titular, $num_roma, $num_reganip, $fecha_adquisicion, $ultima_inspeccion, $caducidad_itv, $observaciones);
        if ($resultado) { // Si se ha guardado correctamente, se devuelve una respuesta de éxito
            echo json_encode([
                "ok" => true,
                "mensaje" => "Maquinaria guardada correctamente"
            ]);
        } else { // Si ha habido un error al guardar, se devuelve una respuesta de error
            echo json_encode([
                "ok" => false,
                "mensaje" => "Error al guardar la maquinaria"
            ]);
        }
        break;
}

class maquinariaController
{

    static function obtenerMaquinariaPorExplotacion(PDO $connection, int $explotacion_id)
    {
        $maquinaria = obtenerMaquinaria($connection, $explotacion_id);
        $infoMaquinaria = [];
        foreach ($maquinaria as $maquina) {
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
