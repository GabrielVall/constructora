<?php
session_start();
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$hashed_password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$rpta = $sql->obtenerResultadoSimple("CALL sp_update_correo2('" . $hashed_password . "','" . $_SESSION['id_usuario_inmobiliaria'] . "')");

if ($rpta) {
    $response_array['status'] = 'success';
    $response_array['title'] = 'Contraseña';
    $response_array['message'] = 'actualizada correctamente';
    $response_array['time'] = 1500;
} else {
    $response_array['status'] = 'error';
    $response_array['title'] = 'Error';
    $response_array['message'] = 'algo salio mal, por favor intente de nuevo';
    $response_array['time'] = 3000;
}

header('Content-type: application/json');
echo json_encode($response_array);