<?php
include '../models/globalModel.php';

function obtenerOrganizacionesUsuario(PDO $connection, $usuarioId) {
    $listaProvincias = obtenerListaProvincias($connection);
    $listaMunicipios = obtenerListaMunicipios($connection);
    $organizaciones = obtenerOrganizaciones($connection, $usuarioId);
    $resultado = [];

    foreach ($organizaciones as $organizacion) {
        $provincia = '';
        $municipio = '';
        foreach ($listaProvincias as $prov) {
            if ($prov['provincia_id'] == $organizacion['provincia_id']) {
                $provincia = $prov['nombre'];
                break;
            }
        }
        foreach ($listaMunicipios as $mun) {
            if ($mun['municipio_id'] == $organizacion['municipio_id'] && $mun['provincia_id'] == $organizacion['provincia_id']) {
                $municipio = $mun['nombre'];
                break;
            }
        }

        array_push($resultado, [
            'organizacion_id' => $organizacion['organizacion_id'],
            'nombre_organizacion' => $organizacion['nombre_organizacion'],
            'nombre_razon_social' => $organizacion['nombre_razon_social'],
            'nif' => $organizacion['nif'],
            'tlf_fijo' => $organizacion['tlf_fijo'],
            'tlf_movil' => $organizacion['tlf_movil'],
            'direccion' => $organizacion['direccion'],
            'email' => $organizacion['email'],
            'cod_postal' => $organizacion['cod_postal'],
            'municipio' => $municipio,
            'provincia' => $provincia,
            'comunidad' => $organizacion['comunidad']
        ]);
    }
    return $resultado;
}
?>