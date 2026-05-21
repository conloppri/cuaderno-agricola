<?php 
include "../models/parcelaModel.php";
include "../models/globalModel.php";
include "../config/db.php";


$accion = $_POST['accion'] ?? null; // Acción a realizar (crearParcela, crearUniGestion, etc.)

switch($accion) {
    case 'crearParcela':
        header('Content-Type: application/json'); // Establecer el tipo de contenido a JSON para la respuesta
        
        // Aquí se procesaría la creación de una nueva parcela utilizando los datos recibidos del formulario
        $idExplotacion = $_POST['idExplotacion'];
        $nombreParcela = $_POST['nombreParcela'];
        $superficieParcela = $_POST['superficieParcela'];
        $sigpac = $_POST['sigpac'];
        $subdivisionesSigpac = ParcelaController::dividirSigpac($sigpac);

        if($subdivisionesSigpac === null){
            // Manejar el error de formato del código SIGPAC
            echo json_encode([
                "ok" => false,
                "mensaje" => "Formato de SIGPAC inválido"
            ]);
        }else{ // Si el formato del código SIGPAC es correcto, se guarda la parcela
            $resultado = guardarParcela($connection, $idExplotacion, $nombreParcela, $superficieParcela, $subdivisionesSigpac);
            if($resultado){ // Si se ha guardado correctamente, se devuelve una respuesta de éxito
                echo json_encode([
                    "ok" => true,
                    "mensaje" => "Parcela guardada correctamente"
                ]);
            } else { // Si ha habido un error al guardar, se devuelve una respuesta de error
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "Error al guardar la parcela"
                ]); 
            }
        }
        break;
    case 'crearUniGestion':
        header('Content-Type: application/json'); // Establecer el tipo de contenido a JSON para la respuesta

        // Aquí se procesaría la creación de una nueva unidad de gestión utilizando los datos recibidos del formulario
        $idParcela = $_POST['idParcela'];
        $nombreUniGestion = $_POST['nombreUnidad'];
        $superficieUniGestion = $_POST['superficieUnidad'];
        $uso = $_POST['uso'];
        $parcelaSuperficie = $_POST['parcelaSuperficie'];
        if($superficieUniGestion > $parcelaSuperficie){ // Validación para evitar que la superficie de la unidad de gestión sea mayor que la superficie de la parcela
            echo json_encode([
                "ok" => false,
                "mensaje" => "La superficie de la unidad de gestión (" . $superficieUniGestion . " ha) no puede ser mayor que la superficie de la parcela (" . $parcelaSuperficie . " ha)"
            ]);
        } else { // Si la validación es correcta, se guarda la unidad de gestión
            $resultado = guardarUnidadGestion($connection, $idParcela, $nombreUniGestion, $superficieUniGestion, $uso);
            if($resultado){ // Si se ha guardado correctamente, se devuelve una respuesta de éxito
                echo json_encode([
                    "ok" => true,
                    "mensaje" => "Unidad de gestión guardada correctamente"
                ]);
            } else { // Si ha habido un error al guardar, se devuelve una respuesta de error
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "Error al guardar la unidad de gestión"
                ]); 
            }
        }
        break;
    default:
        // Acción no reconocida, se puede manejar como un error o simplemente no hacer nada
        break;
}

class ParcelaController{
    //Función para obtener la información de las parcelas de una explotación, con el formato necesario para mostrarlo en la vista.
    static function obtenerInfoParcelas(PDO $connection, int $idExplotacion) {
        $parcelasDetails = [];
        $infoParcelas = obtenerParcelas($connection, $idExplotacion);
        foreach ($infoParcelas as &$parcela) {
            $provincia = obtenerProvincia($connection, $parcela['provincia_id']);
            $municipio = obtenerMunicipio($connection, $parcela['municipio_id']);
            $sigpac = str_pad($parcela['provincia_id'], 2, "0", STR_PAD_LEFT) . ':' . str_pad($parcela['municipio_id'], 3, "0", STR_PAD_LEFT) . ':' . $parcela['agregado'] . ':' . $parcela['zona'] . ':' . str_pad($parcela['poligono'], 5, "0", STR_PAD_LEFT) . ":" . str_pad($parcela['parcela'], 5, "0", STR_PAD_LEFT);
            array_push($parcelasDetails,[
                'id' => $parcela['parcela_id'],
                'nombre' => $parcela['nombre'],
                'sigpac' => $sigpac,
                'superficie' => $parcela['superficie'],
                'provincia' => $provincia,
                'municipio' => $municipio
            ]);
        }
        return $parcelasDetails;
    }

    //Función para obtener la información de las unidades de gestión de una parcela, con el formato necesario para mostrarlo en la vista.
    static function obtenerInfoUnidadesGestion(PDO $connection, int $idParcela) {
        $unidadesGestion = obtenerUnidadesGestion($connection, $idParcela);
        $resultado = [];
        foreach ($unidadesGestion as &$unidad) {
            array_push($resultado, [
                'nombre' => $unidad['nombre'],
                'superficie' => $unidad['superficie'] . ' ha',
                'uso' => $unidad['uso']
            ]);
        }
        return $resultado;
    }

    // Función para dividir un código SIGPAC en sus partes componentes (provincia, municipio, agregado, zona, polígono y parcela)
    static function dividirSigpac(String $sigpac) {
        try{
            if(strlen($sigpac) !== 22){
                throw new Exception("El código SIGPAC debe tener exactamente 22 caracteres");
            }
            return [
                    'provincia_id' => substr($sigpac, 0, 2),
                    'municipio_id' => substr($sigpac, 2, 3),
                    'agregado' => substr($sigpac, 5, 1),
                    'zona' => substr($sigpac, 6, 1),
                    'poligono' => substr($sigpac, 7, 5),
                    'parcela' => substr($sigpac, 12, 5)
                ];
        }catch(Exception $e){
            error_log("Error al dividir el código SIGPAC: " . $e->getMessage());
            return null; // O manejar el error de otra manera según tus necesidades
        }
    }
}
?>

