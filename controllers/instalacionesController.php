<?php
include '../models/instalacionesModel.php';

class instalacionesController{
    static function obtenerInstalacionesPorExplotacion(int $explotacion_id){
        $resultado = [];
        $instalaciones = obtenerInstalaciones($explotacion_id);
        foreach($instalaciones as $instalacion){
            array_push($resultado,[
                "id" => $instalacion["instalacion_id"],
                "nombre" => $instalacion["nombre"],
                "superficie" => $instalacion["superficie"],
                "estado" => $instalacion["estado"],
                "tipo" => $instalacion["tipo"]
            ]);
        }
        return $resultado;
    }
}

?>