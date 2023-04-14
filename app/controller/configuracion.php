<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../model/conexion.php';

$consulta = consultar(
    'SELECT * FROM `configuraciones`'
);
$consulta['ruta_imagen_banner'] = obtenerImagen('../../img/','inicio/banner');
$consulta['ruta_imagen_seccion1'] = obtenerImagen('../../img/','inicio/seccion1');
$consulta['ruta_imagen_seccion3'] = obtenerImagen('../../img/','inicio/seccion3');

echo json_encode($consulta);