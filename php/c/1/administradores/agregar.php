<?php
session_start();
date_default_timezone_set('America/Mexico_City');
include_once('../../../m/SQLConexion.php');
include_once('../../../c/1/fn.php');
$sql = new SQLConexion();

$row_telefono = $sql->obtenerResultado("SELECT fn_select_telefono('" . $_POST['telefono'] . "',0)");


if ($row_telefono[0][0] == 0) {

	$row_correo = $sql->obtenerResultado("SELECT fn_select_correo('" . $_POST['correo'] . "',0)");

	if ($row_correo[0][0] == 0) {

		$hashed_password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

		$rpta = $sql->obtenerResultadoSimple("CALL sp_insert_administrador1('" . $_POST['nombre'] . "','" . $_POST['apellido'] . "','" . $_POST['correo'] . "','" . $hashed_password . "','" . $_POST['telefono'] . "')");

		if ($rpta) {

			$response_array['status'] = 'success';
			$response_array['title'] = 'Administrador';
			$response_array['message'] = 'agregado con éxito';
			$response_array['time'] = 1500;
		} else {
			$response_array['status'] = 'error';
			$response_array['title'] = 'Error';
			$response_array['message'] = "Algo salió mal, por favor intente de nuevo";
			$response_array['time'] = 3000;
		}
	} else {
		$response_array['status'] = 'error';
		$response_array['title'] = 'Error';
		$response_array['message'] = "El correo ya se encuentra en uso";
		$response_array['time'] = 3000;
	}
} else {
	$response_array['status'] = 'error';
	$response_array['title'] = 'Error';
	$response_array['message'] = "El teléfono ya se encuentra en uso";
	$response_array['time'] = 3000;
}
header('Content-type: application/json');
echo json_encode($response_array);
