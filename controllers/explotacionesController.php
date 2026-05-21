<?php 
include "../models/globalModel.php";

function obtenerExplotacionesUsuario(PDO $connection, $username) {
    $listaProvincias = obtenerListaProvincias($connection);
    $listaMunicipios = obtenerListaMunicipios($connection);
    $explotaciones = obtenerExplotaciones($connection, $username);
    $resultado = [];

    foreach ($explotaciones as &$explotacion) {
        $provincia = '';
        $municipio = '';
        foreach ($listaProvincias as $prov) {
            if ($prov['provincia_id'] == $explotacion['provincia_id']) {
                $provincia = $prov['nombre'];
                break;
            }
        }
        foreach ($listaMunicipios as $mun) {
            if ($mun['municipio_id'] == $explotacion['municipio_id'] && $mun['provincia_id'] == $explotacion['provincia_id']) {
                $municipio = $mun['nombre'];
                break;
            }
        }

        $organizacion = obtenerOrganizacion($connection, $explotacion['organizacion_id']);

        array_push($resultado, [
            'explotacion_id' => $explotacion['explotacion_id'],
            'nombre' => $explotacion['nombre'],
            'alias' => $explotacion['alias'],
            'organizacion' => $organizacion['nombre_organizacion'] ?? 'Desconocida',
            'provincia' => $provincia,
            'municipio' => $municipio,
            'comunidad' => $explotacion['comunidad'],
            'codigo_rea' => $explotacion['codigo_rea'],
            'codigo_siex' => $explotacion['codigo_siex']
        ]);
    }
    return $resultado;
}?>