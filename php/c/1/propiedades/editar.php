<?php
include_once('../../../m/SQLConexion.php');
include_once('../../../c/1/fn.php');
$sql = new SQLConexion();

$rpta_propiedad = $sql->obtenerResultadoSimple("CALL sp_update_propiedad1('".$_POST['id_tipo_propiedad']."','".$_POST['id_tipo_venta']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".$_POST['id']."')");

if($rpta_propiedad){
    
    // CARACTERISTICAS
	$caracteristicas=json_decode(stripslashes($_POST['caracteristicas']));
	$total_caracteristicas=count($caracteristicas);
	for ($i=0; $i < $total_caracteristicas; $i++) { 
		$rpta_caracteristica = $sql->obtenerResultadoSimple("CALL sp_insert_detalle_caracteristicas('" . $_POST['id'] . "','" . $caracteristicas[$i]->id . "','" . $caracteristicas[$i]->cant . "')");
	}

    // CARACTERISTICAS ELIMINADAS
	$caracteristicas_not=json_decode(stripslashes($_POST['caracteristicas_not']));
	$total_caracteristicas_not=count($caracteristicas_not);
	for ($i=0; $i < $total_caracteristicas_not; $i++) { 
		$rpta_caracteristica_not = $sql->obtenerResultadoSimple("CALL sp_delete_detalle_caracteristica('" . $_POST['id'] . "','" . $caracteristicas_not[$i]->id . "')");
	}

    // IMAGENES
	$img=json_decode(stripslashes($_POST['img']));
	$total_img=count($img);
	for ($i=0; $i < $total_img; $i++) {
		if($img[$i]->id==0){
			upload_b64('propiedades', $_POST['id'], $img[$i]->src, 9, $img[$i]->formato);
		}
	}

    // IMAGENES ELIMINADAS
	$img_not=json_decode(stripslashes($_POST['img_not']));
	$total_img_not=count($img_not);
	for ($i=0; $i < $total_img_not; $i++) {
		if(file_exists("../../../".$img_not[$i]->src)){
			unlink("../../../".$img_not[$i]->src);
		}
	}

    $response_array['status'] = 'success';
	$response_array['title'] = 'Información';
	$response_array['message'] = 'actualizada con éxito';
	$response_array['time'] = 1500;
}
else{
    $response_array['status'] = 'error';
	$response_array['title'] = 'Error';
	$response_array['message'] = "CALL sp_update_propiedad1('".$_POST['id_tipo_propiedad']."','".$_POST['id_tipo_venta']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".$_POST['id']."')";
	$response_array['time'] = 3000;
}

header('Content-type: application/json');
echo json_encode($response_array);