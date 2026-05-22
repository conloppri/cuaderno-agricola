<?php

include "../models/maquinariaModel.php";

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