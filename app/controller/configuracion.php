<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../model/conexion.php';

$consulta = consultar(
    'SELECT * FROM `configuraciones`'
);
$consulta['ruta_imagen'] = obtenerImagen('../../img/','banner/');
echo json_encode($consulta);