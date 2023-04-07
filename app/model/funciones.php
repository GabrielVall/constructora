<?php
function consultar($sql, $params = []) {
    try {
        // Obtener marca de tiempo antes de la ejecución
        $startTime = microtime(true);

        $stmt = DBConnection::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener marca de tiempo después de la ejecución
        $endTime = microtime(true);

        // Calcular el tiempo de ejecución en milisegundos
        $executionTime = intval(($endTime - $startTime) * 1000);

        // Devolver el resultado y el objeto de tiempo de ejecución
        return [
            'result' => $result,
            'execution_time' => [
                'value' => $executionTime,
                'unit' => 'ms'
            ]
        ];
    } catch (PDOException $e) {
        // Devolver una respuesta de error en formato JSON
        $error = [
            'message' => 'Error de la base de datos',
            'details' => $e->getMessage()
        ];
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode($error);
        exit();
    }
}

function obtenerImagen($carpeta, $id) {
    // Obtener la ruta absoluta de la carpeta
    $ruta_absoluta_carpeta = realpath($carpeta);

    // Verificar si la carpeta existe y es válida
    if (!$ruta_absoluta_carpeta || !is_dir($ruta_absoluta_carpeta)) {
        // Si la carpeta no existe o no es válida, se muestra un mensaje de error
        return 'default.webp';
    }

    // Obtener la ruta absoluta de la carpeta/id
    $ruta_absoluta_carpeta_id = realpath($carpeta . '/' . $id);

    // Verificar si la carpeta/id existe y es válida
    if (!$ruta_absoluta_carpeta_id || !is_dir($ruta_absoluta_carpeta_id)) {
        // Si la carpeta/id no existe o no es válida, se devuelve una cadena vacía
        return 'default.webp';
    }

    // Obtener el listado de archivos en la carpeta/id
    $archivos = scandir($ruta_absoluta_carpeta_id);

    // Eliminar los elementos . y .. de la lista de archivos
    $archivos = array_diff($archivos, array('.', '..'));

    // Buscar la primera imagen en la carpeta/id
    $imagen = null;
    foreach ($archivos as $archivo) {
        if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $archivo)) {
            $imagen = $archivo;
            break;
        }        
    }

    if (!$imagen) {
        // Si no se encontró ninguna imagen en la carpeta/id, se devuelve una cadena vacía
        return '';
    } else {
        // Si se encontró una imagen, se devuelve su ruta relativa
        return $id . '/' . $imagen;
    }
}



function obtenerArchivos($carpeta, $id) {
    // Obtener la ruta absoluta de la carpeta
    $ruta_absoluta_carpeta = realpath($carpeta);

    // Verificar si la carpeta existe y es válida
    if (!$ruta_absoluta_carpeta || !is_dir($ruta_absoluta_carpeta)) {
        // Si la carpeta no existe o no es válida, se muestra un mensaje de error
        // var_dump("error");
        // return 'default.webp';
        return 0;
    }

    // Obtener la ruta absoluta de la carpeta/id
    $ruta_absoluta_carpeta_id = realpath($carpeta . '/' . $id);

    // Verificar si la carpeta/id existe y es válida
    if (!$ruta_absoluta_carpeta_id || !is_dir($ruta_absoluta_carpeta_id)) {
        // Si la carpeta/id no existe o no es válida, se devuelve una cadena vacía
        // var_dump("error");
        // return 'default.webp';
        return 0;
    }

    // Obtener el listado de archivos en la carpeta/id
    $archivos = scandir($ruta_absoluta_carpeta_id);

    // Eliminar los elementos . y .. de la lista de archivos
    $archivos = array_diff($archivos, array('.', '..'));

    // Función de callback para array_filter
    $callback = function($element) {
        return strpos($element, 'front_image') !== 0;
    };

    $archivos = array_filter($archivos,$callback);

    // Buscar la primera imagen en la carpeta/id
    $imagen = null;
    foreach ($archivos as $archivo) {
        if (preg_match('/\.(pdf|docx|webp|jpg|jpeg)$/i', $archivo)) {
            $imagen[] = $id . '/' . $archivo;
        }
    }

    if (!$imagen) {
        // Si no se encontró ninguna imagen en la carpeta/id, se devuelve una cadena vacía
        return '';
    } else {
        // Si se encontró una imagen, se devuelve su ruta relativa
        return $imagen;
    }
}

function obtenerCarpeta($carpeta){
    // Obtener la ruta absoluta de la carpeta
    $ruta_absoluta_carpeta = realpath($carpeta);

    // Verificar si la carpeta existe y es válida
    if (!$ruta_absoluta_carpeta || !is_dir($ruta_absoluta_carpeta)) {
        // Si la carpeta no existe o no es válida, se muestra un mensaje de error
        // var_dump("error");
        // return 'default.webp';
        return 0;
    }

    // Obtener la ruta absoluta de la carpeta/id
    $ruta_absoluta_carpeta_id = realpath($carpeta);

    // Verificar si la carpeta/id existe y es válida
    if (!$ruta_absoluta_carpeta_id || !is_dir($ruta_absoluta_carpeta_id)) {
        // Si la carpeta/id no existe o no es válida, se devuelve una cadena vacía
        // var_dump("error");
        // return 'default.webp';
        return 0;
    }

    // Obtener el listado de archivos en la carpeta/id
    $archivos = scandir($ruta_absoluta_carpeta_id);

    // Eliminar los elementos . y .. de la lista de archivos
    $archivos = array_diff($archivos, array('.', '..'));

    // Función de callback para array_filter
    $callback = function($element) {
        return strpos($element, 'front_image') !== 0;
    };

    $archivos = array_filter($archivos,$callback);

    // Buscar la primera imagen en la carpeta/id
    $imagen = null;
    foreach ($archivos as $archivo) {
        if (preg_match('/\.(pdf|docx|webp|jpg|jpeg)$/i', $archivo)) {
            $imagen[] = $archivo;
        }
    }

    if (!$imagen) {
        // Si no se encontró ninguna imagen en la carpeta/id, se devuelve una cadena vacía
        return '';
    } else {
        // Si se encontró una imagen, se devuelve su ruta relativa
        return $imagen;
    }
}
