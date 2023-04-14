<?php
include_once('../../../m/SQLConexion.php');
include_once('../../../c/1/fn.php');
$sql = new SQLConexion();

$rpta_propiedad = $sql->obtenerResultadoID("CALL sp_insert_propiedad1('".$_POST['id_tipo_propiedad']."','".$_POST['id_tipo_venta']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."',
'".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".date("Y-m-d H:i")."',@_ID)");

if($rpta_propiedad[0][0] > 0){

    // CARACTERISTICAS
    $caracteristicas=json_decode(stripslashes($_POST['caracteristicas']));
    $total_caracteristicas=count($caracteristicas);
    for ($i=0; $i < $total_caracteristicas; $i++) { 
        $rpta_caracteristica = $sql->obtenerResultadoSimple("CALL sp_insert_detalle_caracteristicas('" . $rpta_propiedad[0]['_ID'] . "','" . $caracteristicas[$i]->id . "','" . $caracteristicas[$i]->cant . "')");
    }

    // IMAGENES
    $img=json_decode(stripslashes($_POST['img']));
    $total_img=count($img);
    for ($i=0; $i < $total_img; $i++) {
        upload_b64('propiedades', $rpta_propiedad[0]['_ID'], $img[$i]->src, 5, $img[$i]->formato);
    }

    $response_array['status'] = 'success';
	$response_array['title'] = 'Propiedad';
	$response_array['message'] = 'agregada con éxito';
	$response_array['time'] = 1500;

}else{

    $response_array['status'] = 'error';
	$response_array['title'] = 'Error';
	$response_array['message'] = 'Algo salió mal, por favor intente de nuevo';
	$response_array['time'] = 3000;

}
header('Content-type: application/json');
echo json_encode($response_array);
