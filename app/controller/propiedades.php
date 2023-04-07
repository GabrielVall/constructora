<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../model/conexion.php';

$debug = false;

// Read search values from GET request
$id_tipo_propiedad = $_GET['id_tipo_propiedad'] ?? null;
$id_tipo_venta = $_GET['id_tipo_venta'] ?? null;
$min_precio = $_GET['min_precio'] ?? null;
$max_precio = $_GET['max_precio'] ?? null;
$min_mts = $_GET['min_mts'] ?? null;
$max_mts = $_GET['max_mts'] ?? null;
$busqueda = $_GET['busqueda'] ?? null;

$searchConditions = [
    [
        'column' => 'id_tipo_propiedad',
        'value' => $id_tipo_propiedad,
        'operator' => '='
    ],
    [
        'column' => 'id_tipo_venta',
        'value' => $id_tipo_venta,
        'operator' => '='
    ],
    [
        'column' => 'precio_propiedad',
        'min' => $min_precio,
        'max' => $max_precio,
        'operator' => 'BETWEEN'
    ],
    [
        'column' => 'mts_propiedad',
        'min' => $min_mts,
        'max' => $max_mts,
        'operator' => 'BETWEEN'
    ],
    [
        'column' => 'direccion_propiedad',
        'value' => $busqueda,
        'operator' => 'LIKE'
    ],
    [
        'column' => 'descripcion_propiedad',
        'value' => $busqueda,
        'operator' => 'LIKE'
    ]
];

$sql = "SELECT * FROM propiedades  LIMIT 0,20";
$params = [];

foreach ($searchConditions as $condition) {
    if (isset($condition['value']) && !empty($condition['value'])) {
        $sql .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}";
        $params[":{$condition['column']}"] = "{$condition['value']}%";
    } elseif (isset($condition['min']) && isset($condition['max'])) {
        $sql .= " AND {$condition['column']} {$condition['operator']} :{$condition['column']}_min AND :{$condition['column']}_max";
        $params[":{$condition['column']}_min"] = $condition['min'];
        $params[":{$condition['column']}_max"] = $condition['max'];
    }
}

$result = consultar($sql, $params,$debug);

echo json_encode($result);
