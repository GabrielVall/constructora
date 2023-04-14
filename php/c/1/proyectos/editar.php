<?php
include_once('../../../m/SQLConexion.php');
include_once('../../../c/1/fn.php');
$sql = new SQLConexion();

if($_POST['tipo'] == 1){

    $rpta_proyecto = $sql->obtenerResultadoSimple("CALL sp_update_proyecto1('".$_POST['id']."','".$_POST['tipo_propiedad']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".NULL."','".$_POST['tipo']."')");

    if($rpta_proyecto){

    // IMAGENES
	$img=json_decode(stripslashes($_POST['img']));
	$total_img=count($img);
	for ($i=0; $i < $total_img; $i++) {
		if($img[$i]->id==0){
			upload_b64('proyectos', $_POST['id'], $img[$i]->src, 9, $img[$i]->formato);
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
	$response_array['title'] = 'Proyecto';
	$response_array['message'] = 'guardado con éxito';
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
    $rpta_proyecto = $sql->obtenerResultadoSimple("CALL sp_update_proyecto1('".$_POST['id']."','".$_POST['tipo_propiedad']."','".$_POST['precio']."','".$_POST['mts']."','".$_POST['descripcion']."','".$_POST['direccion']."','".$_POST['lat_direccion']."','".$_POST['lon_direccion']."','".$_POST['url']."','".$_POST['tipo']."')");

    if($rpta_proyecto){
    
        $response_array['status'] = 'success';
        $response_array['title'] = 'Proyecto';
        $response_array['message'] = 'guardado con éxito';
        $response_array['time'] = 1500;
    
        }
        else{
        $response_array['status'] = 'error';
        $response_array['title'] = 'Error';
        $response_array['message'] = 'Algo salió mal, por favor intente de nuevo';
        $response_array['time'] = 3000;
        }
    
}

header('Content-type: application/json');
echo json_encode($response_array);