<?php
include_once('../../../m/SQLConexion.php');
include_once('../../../c/1/fn.php');
$sql = new SQLConexion();

if($_POST['tipo'] == 1){
    $rpta_proyecto = $sql->obtenerResultadoID("CALL sp_insert_proyecto1('".$_POST['tipo_propiedad']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".NULL."','".date("Y-m-d H:i")."',1,'".$_POST['tipo']."',@_ID)");

    if($rpta_proyecto[0][0] > 0){

    // IMAGENES
    $img=json_decode(stripslashes($_POST['img']));
    $total_img=count($img);
    for ($i=0; $i < $total_img; $i++) {
        upload_b64('proyectos', $rpta_proyecto[0]['_ID'], $img[$i]->src, 9, $img[$i]->formato);
    }

    $response_array['status'] = 'success';
	$response_array['title'] = 'Proyecto';
	$response_array['message'] = 'agregado con éxito';
	$response_array['time'] = 1500;

    }
    else{
    $response_array['status'] = 'error';
	$response_array['title'] = 'Error';
	$response_array['message'] = 'Algo salió mal, por favor intente de nuevo';
	$response_array['time'] = 3000;
    }

}
else if($_POST['tipo'] == 2){
    $rpta_proyecto = $sql->obtenerResultadoID("CALL sp_insert_proyecto1('".$_POST['tipo_propiedad']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".$_POST['url_video']."','".date("Y-m-d H:i")."',1,'".$_POST['tipo']."',@_ID)");

    if($rpta_proyecto[0][0] > 0){
    
        $response_array['status'] = 'success';
        $response_array['title'] = 'Proyecto';
        $response_array['message'] = 'agregado con éxito';
        $response_array['time'] = 1500;
    
        }
        else{
        $response_array['status'] = 'error';
        $response_array['title'] = 'Error';
        $response_array['message'] = "CALL sp_insert_proyecto1('".$_POST['tipo_propiedad']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".$_POST['url_video']."','".date("Y-m-d H:i")."',1,@_ID)";
        $response_array['time'] = 3000;
        }
    
}


header('Content-type: application/json');
echo json_encode($response_array);