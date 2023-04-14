<?php
session_start();
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_correo=$sql->obtenerResultado("SELECT fn_select_usuario1('".$_POST['correo']."','". $_SESSION['id_usuario_inmobiliaria'] ."')");

if($row_correo[0][0]==0){
    
    $rpta = $sql->obtenerResultadoSimple("CALL sp_update_correo1('" . $_POST['correo'] . "','". $_SESSION['id_usuario_inmobiliaria'] ."')");
    
    if ($rpta) {
    
        $response_array['status'] = 'success';
        $response_array['title'] = 'Correo';
        $response_array['message'] = 'actualizado correctamente';
        $response_array['time'] = 1500;
    } else {
        $response_array['status'] = 'error';
        $response_array['title'] = 'Error';
        $response_array['message'] = 'algo salio mal, por favor intente de nuevo';
        $response_array['time'] = 3000;
    }
}
else{
    $response_array['status'] = 'error';
    $response_array['title'] = 'Error.';
    $response_array['message'] = 'correo en uso';
    $response_array['time'] = 3000;
}

header('Content-type: application/json');
echo json_encode($response_array);
