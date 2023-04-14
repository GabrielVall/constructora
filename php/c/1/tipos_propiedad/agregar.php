<?php 
session_start();
date_default_timezone_set('America/Mexico_City');
include_once("../../../m/SQLConexion.php");
$sql = new SQLConexion();

$rpta = $sql->obtenerResultadoID("CALL sp_insert_tipo_propiedad1('".$_POST['propiedad']."',1,@_ID)");

if($rpta){
    $response_array['status'] = 'success';
    $response_array['title'] = 'Tipo de propiedad';
    $response_array['message'] = 'agregado con exito';
    $response_array['time'] = '1500';
    $response_array['id'] = $rpta[0]['_ID'];
    $response_array['retorno'] = 
    '
    <td>'.$_POST['propiedad'].'</td>
    ';
}
else{
    $response_array['status'] = 'error';
    $response_array['title'] = 'Error';
    $response_array['message'] = 'Algo salio mal, por favor intente de nuevo';
    $response_array['time'] = '3000';
}

header('Content-type: application/json');
echo json_encode($response_array);