<?php
// Datos de conexión a SQL Server
$serverName = "DESAROLLO-BACRO\SQLEXPRESS"; // Usa doble backslash
$connectionOptions = array(
    "Database" => "Operaciones1",
    "Uid" => "Larome03",
    "PWD" => "Larome03",
    "CharacterSet" => "UTF-8"
);

// Crear conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Verificar conexión
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}


$serverName = "WIN-44O80L37Q7M\COMERCIAL"; // o IP, ejemplo: "192.168.1.100"
$connectionOptions = array(
    "Database" => "BASENUEVA",
    "Uid" => "sa",
    "PWD" => "Administrador1*",
    "CharacterSet" => "UTF-8"
);

// Establecer la conexión
$compaq = sqlsrv_connect($serverName, $connectionOptions);

// Verificar conexión
if ($compaq) {
    //echo "✅ Conexión A COMPAQI exitosa a SQL Server.";
} else {
    echo "❌ Error en la conexión:<br>";
    die(print_r(sqlsrv_errors(), true));
}

?>
