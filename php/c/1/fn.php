<?php

// SUBIR IMAGENES EN BASE 64 A WEBP
function upload_b64($carpeta, $subcarpeta, $datosb64, $limite_img = 1, $formato = 'jpg')
{

    // CREA LAS CARPETAS EN CASO DE NO EXISTIR PREVIAMENTE
    $ruta = '../../../../img/' . $carpeta;
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }
    $ruta = '../../../../img/' . $carpeta . '/' . $subcarpeta;
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }

    // CREACIÓN DE LA IMAGEN
    $base_to_php = explode(',', $datosb64);
    $data = base64_decode($base_to_php[1]);
    $new_name = 'image_' . date("d-m-y_H-i-s");
    $i = 0;
    while (file_exists($ruta . '/' . $new_name . '.jpg') || file_exists($ruta . '/' . $new_name . '.jpeg') || file_exists($ruta . '/' . $new_name . '.png') || file_exists($ruta . '/' . $new_name . '.webp')) {
        $new_name .= '_' . $i;
        $i++;
    }

    $total_archivos = count(glob($ruta . '/*'));

    // ELIMINA LA ULTIMA IMAGEN DE EN CASO DE LLEGAR A SU LIMITE DE IMAGENES POR DIRECTORIO
    if ($total_archivos >= $limite_img) {

        $files_found = scandir($ruta, SCANDIR_SORT_DESCENDING);
        unlink($ruta . '/' . $files_found[0]);
    }
    $filepath = $ruta . "/" . $new_name . '.' . $formato;
    file_put_contents($filepath, $data);


    if ($formato != 'png') {
        $img_created_to_webp = @imagecreatefrompng($filepath);
        if (!$img_created_to_webp) {
            $img_created_to_webp = imagecreatefromjpeg($filepath);
        }

        $w = imagesx($img_created_to_webp);
        $h = imagesy($img_created_to_webp);
        $webp = imagecreatetruecolor($w, $h);
        imagecopy($webp, $img_created_to_webp, 0, 0, 0, 0, $w, $h);

        if (imagewebp($webp, $ruta . '/' . $new_name . '.webp', 80)) {
            unlink($ruta . "/" . $new_name . '.jpg');
            return 1;
        } else {
            return 0;
        }
    } else {
        if (imagecreatefrompng($filepath)) {
            return 1;
        } else {
            return 0;
        }
    }
}
// SUBIR IMAGENES EN BASE 64 A ORIGINAL
function upload_original_format($carpeta, $subcarpeta, $datosb64, $limite_img = 1)
{

    // CREA LAS CARPETAS EN CASO DE NO EXISTIR PREVIAMENTE
    $ruta = '../../../../img/' . $carpeta;
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }
    $ruta = '../../../../img/' . $carpeta . '/' . $subcarpeta;
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }

    $base_to_php = explode(',', $datosb64);
    $data = base64_decode($base_to_php[1]);
    $new_name = 'image_' . date("d-m-y_H-i-s");
    $i = 0;
    while (file_exists($ruta . '/' . $new_name . '.jpg') || file_exists($ruta . '/' . $new_name . '.jpeg') || file_exists($ruta . '/' . $new_name . '.png') || file_exists($ruta . '/' . $new_name . '.webp')) {
        $new_name .= '_' . $i;
        $i++;
    }

    $total_archivos = count(glob($ruta . '/*'));

    // ELIMINA LA ULTIMA IMAGEN DE EN CASO DE LLEGAR A SU LIMITE DE IMAGENES POR DIRECTORIO
    if ($total_archivos >= $limite_img) {

        $files_found = scandir($ruta, SCANDIR_SORT_DESCENDING);
        unlink($ruta . '/' . $files_found[0]);
    }
    $filepath = $ruta . "/" . $new_name . '.jpg';

    if (file_put_contents($filepath, $data)) {
        unlink($ruta . "/" . $new_name . '.jpg');
        return 1;
    } else {
        return 0;
    }
}
// RETORNAR EL SRC DE LA IMAGEN
function img_src($num, $carpeta, $subcarpeta, $error, $return_type = 1)
{
    $raiz = '';
    for ($i = 0; $i < $num; $i++) {
        $raiz .= '../';
    }
    if ($return_type == 1) {
        if (file_exists($raiz . 'img/' . $carpeta . '/' . $subcarpeta) && count(glob($raiz . 'img/' . $carpeta . '/' . $subcarpeta . '/*')) > 0) {
            $directorio = opendir($raiz . 'img/' . $carpeta . '/' . $subcarpeta);
            while ($archivo = readdir($directorio)) {
                if ($archivo != '.' && $archivo != '.htaccess' && $archivo != '..') {
                    return '../img/' . $carpeta . '/' . $subcarpeta . '/' . $archivo;
                }
            }
        } else {
            return 'svg/' . $error . '.svg';
        }
    } else if ($return_type == 2) {
        if (file_exists($raiz . 'img/' . $carpeta . '/' . $subcarpeta) && count(glob($raiz . 'img/' . $carpeta . '/' . $subcarpeta . '/*')) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
function delete_dir($num, $carpeta, $subcarpeta)
{
    $raiz = '';
    for ($i = 0; $i < $num; $i++) {
        $raiz .= '../';
    }
    $files = glob($raiz . 'img/' . $carpeta . '/' . $subcarpeta . '/*');
    foreach ($files as $file) {
        if (is_file($file))
            unlink($file);
    }
    rmdir($raiz . 'img/' . $carpeta . '/' . $subcarpeta);
}
function search_files($num, $capeta_raiz, $carpeta, $subcarpeta, $return_type = 1)
{
    $array_files = array();
    $raiz = '';
    for ($i = 0; $i < $num; $i++) {
        $raiz .= '../';
    }
    if (file_exists($raiz . $capeta_raiz . '/' . $carpeta . '/' . $subcarpeta) && count(glob($raiz . $capeta_raiz . '/' . $carpeta . '/' . $subcarpeta . '/*')) > 0) {
        $directorio = opendir($raiz . $capeta_raiz . '/' . $carpeta . '/' . $subcarpeta);
        while ($archivo = readdir($directorio)) {
            if ($archivo != '.' && $archivo != '.htaccess' && $archivo != '..') {
                // NOMBRE DEL ARCHIVO
                if ($return_type == 1) {
                    array_push($array_files, $archivo);
                }
                // TAMAÑO DEL ARCHIVO
                else if ($return_type == 2) {
                    array_push($array_files, formatSizeUnits(filesize($raiz . $capeta_raiz . '/' . $carpeta . '/' . $subcarpeta . '/' . $archivo)));
                }
                // EXTENSION DEL ARCHIVO
                else if ($return_type == 3) {
                    array_push($array_files, pathinfo($raiz . $capeta_raiz . '/' . $carpeta . '/' . $subcarpeta . '/' . $archivo)['extension']);
                }
                // RUTA DEL ARCHIVO
                else if ($return_type == 4) {
                    array_push($array_files, '../'.$capeta_raiz . '/' . $carpeta . '/' . $subcarpeta . '/' . $archivo);
                }
            }
        }
    }
    return $array_files;
}
// TAMAÑO DE ARCHIVOS
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $size = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $size = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $size = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $size = $bytes . ' Bytes';
    } elseif ($bytes == 1) {
        $size = $bytes .  'Byte';
    } else {
        $size = '0 bytes';
    }

    return $size;
}

function traerImagenes($ruta,$id,$n_carpetas = 0,$n_carpetas_vista = 0,$numero = 0){
    $dir = '';
    for ($i=0; $i < $n_carpetas; $i++) { 
        $dir = $dir.'../';
    }
    $vista = '';
    for ($i=0; $i < $n_carpetas_vista; $i++) { 
        $vista = $vista.'../';
    }
    // Toma la ruta desde el controlador a la imagen
    $ruta_full = $dir.'img/'.$ruta.'/'.$id;
    var_dump($ruta_full);
    // Si el directorio existe
    if(is_dir($ruta_full)){
        // Si existe más de un archivo (ignora '.','..')
        if(count(scandir($ruta_full)) > 2){
            $archivos = scandir($ruta_full);
            array_shift($archivos); 
            array_shift($archivos);
            $imagenes = concatenarUrl($archivos,$id);
            return $imagenes;
        }else{
            // Solo aparece cuando existe carpeta pero no la imagen
            return 3;
        }
    }else{
        // Solo aparece si no existe la carpeta, muestra la imagen por defecto de la carpeta
        return 11;
    }
}