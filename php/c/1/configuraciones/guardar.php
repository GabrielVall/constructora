<?php
session_start();
include_once("../fn.php");
include_once('../../../m/SQLConexion.php');
$sql = new SQLConexion();

$valores = json_decode(stripslashes($_POST['valores']));
$total_valores=count($valores);

// IMG BANNER
$img_banner = json_decode(stripslashes($_POST['img_banner']));
$total_img_banner = count($img_banner);
for($i=0;$i < $total_img_banner; $i++){
    if($img_banner[$i]->id==0 && $img_banner[$i] !== null){
        upload_b64('inicio','banner',$img_banner[$i]->src,1,$img_banner[$i]->formato,1);
    }
}

// IMG BANNER ELIMINADAS
$not_img_banner=json_decode(stripslashes($_POST['not_img_banner']));
$total_not_img_banner=count($not_img_banner);
for ($i=0; $i < $total_not_img_banner; $i++) {
    if(file_exists("../../../".$not_img_banner[$i]->src)){
        unlink("../../../".$not_img_banner[$i]->src);
    }
}

// IMG SECCION 1
$img_seccion_1 = json_decode(stripslashes($_POST['img_seccion_1']));
$total_img_seccion_1 = count($img_seccion_1);
for($i=0;$i<$total_img_seccion_1;$i++){
    if($img_seccion_1[$i]->id==0 && $img_seccion_1[$i] !== null){
        upload_b64('inicio','seccion1',$img_seccion_1[$i]->src,1,$img_seccion_1[$i]->formato,1);
    }
}

// IMG SECCION 1 ELIMINADAS
$not_img_seccion1=json_decode(stripslashes($_POST['not_img_seccion_1']));
$total_not_img_seccion1=count($not_img_seccion1);
for ($i=0; $i < $total_not_img_seccion1; $i++) {
    if(file_exists("../../../".$not_img_seccion1[$i]->src)){
        unlink("../../../".$not_img_seccion1[$i]->src);
    }
}

// IMG SECCION 3
$img_seccion_3 = json_decode(stripslashes($_POST['img_seccion_3']));
$total_img_seccion_3 = count($img_seccion_3);
for($i=0;$i<$total_img_seccion_3;$i++){
    if($img_seccion_3[$i]->id==0 && $img_seccion_3[$i] !== null){
        upload_b64('inicio','seccion3',$img_seccion_3[$i]->src,1,$img_seccion_3[$i]->formato,1);
    }
}

// IMG SECCION 3 ELIMINADAS
$not_img_seccion3=json_decode(stripslashes($_POST['not_img_seccion_3']));
$total_not_img_seccion3=count($not_img_seccion3);
for ($i=0; $i < $total_not_img_seccion3; $i++) {
    if(file_exists("../../../".$not_img_seccion3[$i]->src)){
        unlink("../../../".$not_img_seccion3[$i]->src);
    }
}

for ($i=0; $i < $total_valores; $i++) {    
    $rpta = $sql->obtenerResultadoSimple("CALL sp_update_configuraciones('" . $valores[$i]->id . "','" . $valores[$i]->value . "')");
}


if ($rpta) {
    $response_array['status'] = 'success';
    $response_array['title'] = 'Successful.';
    $response_array['message'] = 'Informacion guardada con éxito';
    $response_array['time'] = 2000;
    $response_array['rows'] = '';
} else {
    $response_array['status'] = 'error';
    $response_array['title'] = 'Error.';
    $response_array['message'] = 'Algo salió mal, por favor intente de nuevo';
    $response_array['time'] = 3000;
}

header('Content-type: application/json');
echo json_encode($response_array);
