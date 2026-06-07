<?php
include '../models/instalacionesModel.php';

$accion =$_POST['accion'] ?? '';

switch($accion){
    case "agregarInstalacion":
        $explotacion_id = $_POST['explotacion_id'];
        $nombre = $_POST['nombre'];
        $superficie = $_POST['superficie'];
        $tipo = $_POST['tipo'];
        $estado = $_POST['estado'];

        header('Content-Type: application/json');

        $resultado = guardarInstalacion($explotacion_id, $nombre, $superficie, $tipo, $estado);
        if ($resultado) { // Si se ha guardado correctamente, se devuelve una respuesta de éxito
            echo json_encode([
                "ok" => true,
                "mensaje" => "Instalación guardada correctamente"
            ]);
        } else { // Si ha habido un error al guardar, se devuelve una respuesta de error
            echo json_encode([
                "ok" => false,
                "mensaje" => "Error al guardar la instalación"
            ]);
        }
        break;
}

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