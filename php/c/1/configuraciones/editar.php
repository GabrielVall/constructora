<?php
session_start();
date_default_timezone_set('America/Mexico_City');
include_once('../../../m/SQLConexion.php');
include_once('../../../c/1/fn.php');
$sql = new SQLConexion();

$rpta = $sql->obtenerResultadoSimple("CALL sp_update_configuracion1('".$_POST['titulo']."','".$_POST['descripcion']."','".$_POST['id']."')");

if ($rpta) {
    $response_array['status'] = 'success';
    $response_array['title'] = 'Configuracion';
    $response_array['message'] = 'actualizada con éxito';
    $response_array['time'] = 1500;
} else {
    $response_array['status'] = 'error';
    $response_array['title'] = 'Error';
    $response_array['message'] = "Algo salió mal, por favor intente de nuevo";
    $response_array['time'] = 3000;
}

header('Content-type: application/json');
echo json_encode($response_array);
