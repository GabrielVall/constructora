<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../model/conexion.php';

$debug = false;

// Read search values from GET request
$id_propiedad = $_GET['id_propiedad'];
$searchConditions = [
    [
        'column' => 'id_propiedad',
        'value' => $id_propiedad,
        'operator' => '='
    ]
];

$sql = "SELECT *, DATE_FORMAT(fecha_registro_propiedad,'%d-%m-%Y') AS 'fecha_registro_formato' FROM propiedades
INNER JOIN tipos_venta ON propiedades.id_tipo_venta = tipos_venta.id_tipo_venta
INNER JOIN tipos_propiedad ON propiedades.id_tipo_propiedad = tipos_propiedad.id_tipo_propiedad
WHERE 1=1 ";

$detalles = "SELECT * FROM detalle_caracteristicas
INNER JOIN caracteristicas ON detalle_caracteristicas.id_caracteristica = caracteristicas.id_caracteristica
WHERE 1=1";

$params = [];
$params_2 = [];


foreach ($searchConditions as $condition) {
    if (isset($condition['value']) && !empty($condition['value'])) {
        // Verificar si el valor es numérico
        if (is_numeric($condition['value'])) {
            $sql .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}";
            $params[":{$condition['column']}"] = $condition['value'];
        } else {
            $sql .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}_search";
            $params[":{$condition['column']}_search"] = "{$condition['value']}%";
        }
    } elseif (isset($condition['min']) && isset($condition['max'])) {
        $sql .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}_min AND :{$condition['column']}_max";
        $params[":{$condition['column']}_min"] = $condition['min'];
        $params[":{$condition['column']}_max"] = $condition['max'];
    }
}

foreach ($searchConditions as $condition) {
    if (isset($condition['value']) && !empty($condition['value'])) {
        // Verificar si el valor es numérico
        if (is_numeric($condition['value'])) {
            $detalles .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}";
            $params_2[":{$condition['column']}"] = $condition['value'];
        } else {
            $detalles .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}_search";
            $params_2[":{$condition['column']}_search"] = "{$condition['value']}%";
        }
    } elseif (isset($condition['min']) && isset($condition['max'])) {
        $detalles .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}_min AND :{$condition['column']}_max";
        $params_2[":{$condition['column']}_min"] = $condition['min'];
        $params_2[":{$condition['column']}_max"] = $condition['max'];
    }
}


$result = consultar($sql,$params,$debug);
$result_car = consultar($detalles,$params_2,$debug);

// Inicializar arreglo vacío
$result['result'][0]['caracteristicas'] = [];

for ($i = 0; $i < count($result_car['result']); $i++) {
    // Crear arreglo asociativo con los datos de esta fila
    $fila = [        'cantidad_detalle_caracteristica' => $result_car['result'][$i]['cantidad_detalle_caracteristica'],
        'nombre_caracteristica' => $result_car['result'][$i]['nombre_caracteristica'],
    ];
    // Agregar el arreglo asociativo a "cas"
    $result['result'][0]['caracteristicas'][] = $fila;
}

$result['result'][0]['ruta_archivos'] = obtenerArchivos('../../img/propiedades/',$result['result'][0]['id_propiedad']);

echo json_encode($result);
