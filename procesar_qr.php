<?php
include "config.php"; // Asegúrate de que aquí esté la conexión $conn

// Recibir JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['imagen']) || !isset($data['datocompleto']) || !isset($data['idqr'])) {
    http_response_code(400);
    echo "Datos no válidos.";
    exit;
}

$base64 = $data['imagen'];
$datocompleto = $data['datocompleto'];
$idqr = $data['idqr'];

// Limpiar nombre de archivo para evitar caracteres peligrosos
$datocompleto = preg_replace('/[^A-Za-z0-9_\-]/', '_', $datocompleto);

// Eliminar encabezado: data:image/png;base64,
$base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);

// Decodificar
$decoded = base64_decode($base64);

if (!$decoded) {
    http_response_code(500);
    echo "Error al decodificar imagen.";
    exit;
}

// Guardar la imagen
$nombreArchivo = $datocompleto . ".png";
$ruta = "qrfile/" . $nombreArchivo;

if (!file_exists("qrfile")) {
    mkdir("qrfile", 0777, true);
}

if (file_put_contents($ruta, $decoded)) {
    echo "QR guardado exitosamente: $nombreArchivo\n";
$partes = explode('_', $nombreArchivo);
$digitos = $partes[0];

//echo "digitos".$digitos; // 12345
    // Actualizar la ruta en la base de datos
    $sql = "UPDATE QR_Dependencia SET RutaQR = ? WHERE idQR = ?";
    $params = array($nombreArchivo, $digitos);
    $stmt = sqlsrv_query($conn, $sql, $params);
    

    if ($stmt === false) {
        echo "Error al actualizar la ruta del QR: ";
        print_r(sqlsrv_errors());
    } else {
        echo "Ruta del QR actualizada exitosamente.";

    }

} else {
    http_response_code(500);
    echo "Error al guardar la imagen.";
}
?>
