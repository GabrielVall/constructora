# Instalación

Para instalar la aplicación, se deben seguir los siguientes pasos:


Crear una carpeta llamada config fuera de la carpeta pública. Por ejemplo, si se está utilizando un servidor local con XAMPP o WAMP, la carpeta config se debe crear en el mismo nivel que las carpetas htdocs o www.

Ejemplo:

```
instalador(xampp o wampp)/
├── htdocs o www/
│   ├── proyecto1
│   └── proyecto2
├── config/
│   ├── constructora
|   |   ├── y1u8zv4k3q6r2o9.ini
```

Dentro del archivo `.ini` agregar las credenciales de instalación:

```ini
; Archivo de configuración para la base de datos
[database]
host = localhost
database = base_de_datos
user = root
password = password
```

## Como crear controladores

```php
<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../model/conexion.php';

$consulta = consultar(
    // Consulta mysql
);

echo json_encode($consulta);
```