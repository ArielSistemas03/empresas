<?php

include "config.php";
$idqr = $_GET['idqr'];

$datosempresa = "SELECT * FROM QR_Dependencia where IDQR = '$idqr'";
$infoempresa = sqlsrv_query($conn, $datosempresa);


while ($row = sqlsrv_fetch_array($infoempresa)) {
    $idqrr = $row['IDQR'];
    $empresa = $row['Empresa'];
    $dependencia = $row['Dependencia'];
    $ubicacionGeografica = $row['UbicacionGeografica'];
    $tel1 = $row['TelContacto1'];
    $tel2 = $row['TelContacto2'];
    $tel3 = $row['TelContacto3'];
    $tel4 = $row['TelContacto4'];
    $email1 = $row['Email1'];
    $email2 = $row['Email2'];
    $email3 = $row['Email3'];
    $email4 = $row['Email4'];
    $estatus = $row['Estatus'];
    $rutaQR = $row['RutaQR'];
    $ubicacionFisica = $row['UbicacionFisica'];
}

$logo = "logo.jpg"; // Logo por defecto

if ($empresa === "CONSEGLOB") {
    $logo = "ConceglobB.png";
} elseif ($empresa === "bacrocorp") {
    $logo = "BACROCORP.png"; // Está en mayúsculas
} elseif ($empresa === "seinco") {
    $logo = "seinco.jpg";
}
$tamanoLogo = 60;

$consulreg = "SELECT *, 
       CAST(FechaRegistro AS DATETIME) + CAST(TiempoRegistro AS DATETIME) AS FechaHoraCompleta
FROM Registros
WHERE (CAST(FechaRegistro AS DATETIME) + CAST(TiempoRegistro AS DATETIME)) >= DATEADD(HOUR, 8, CAST(CAST(GETDATE() AS DATE) AS DATETIME))
  AND (CAST(FechaRegistro AS DATETIME) + CAST(TiempoRegistro AS DATETIME)) < DATEADD(HOUR, 8, DATEADD(DAY, 1, CAST(CAST(GETDATE() AS DATE) AS DATETIME)))
ORDER BY IDRegistro DESC;";
$detale = sqlsrv_query($conn, $consulreg);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Checadas para Guardias</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="bg-primary bg-gradient text-white text-center py-1 mb-2 rounded-bottom">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center mx-auto mb-4"
                style="width: <?= $tamanoLogo ?>px; height: <?= $tamanoLogo ?>px; border-radius: 50%; background-color: rgba(255,255,255,0.25); overflow: hidden;">
                <img src="logos/<?php echo $logo; ?>"
                    alt="Logo de la aplicación"
                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            </div>
            <p class="lead mb-2">Sistema de control de rondín para guardias de seguridad</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h2 class="text-center mb-4">Registrar Checada</h2>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="numeroempleado" class="form-label">Numero Empleado</label>
                            <input type="text" class="form-control" id="numeroempleado" name="numeroempleado" required>
                        </div>
                        <div class="mb-3">
                            <label for="checkpoint" class="form-label">Punto de Control</label>
                            <input type="text" class="form-control" id="numeroempleado" name="checkpoint" value="<?php echo $ubicacionFisica; ?>" readonly required>
                        </div>

                        <div class="mb-3">
                            <label for="observations" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observations" name="observaciones" rows="2"></textarea>
                        </div>
                        <input type="hidden" name="idqr" value="<?= $idqr ?>">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-3 px-4 rounded-pill fw-semibold">Registrar Checada</button>
                        </div>
                    </form>
                </div>
                <div class="card border-0 shadow-sm p-4">
                    <h3 class="text-center mb-3">Últimas Checadas</h3>
                    <div class="list-group">
                        <?php
                        date_default_timezone_set("America/Mexico_City"); // Ajusta la zona si es necesario

                        while ($che = sqlsrv_fetch_array($detale, SQLSRV_FETCH_ASSOC)) {
                            $nombre = $che['NumeroEmpleado'] ?? 'Sin nombre';
                            $punto = $che['PuntoControl'] ?? 'Punto desconocido';
                            $estado = $che['Observaciones'] ?? 'OK'; // O cualquier campo que determine el estado
                            $tiempoRegistro = $che['TiempoRegistro'];

                            // Calcular diferencia en minutos
                            $ahora = new DateTime();
                            $registro = new DateTime($tiempoRegistro->format('Y-m-d H:i:s'));
                            $diferencia = $ahora->getTimestamp() - $registro->getTimestamp();
                            $minutos = floor($diferencia / 60);

                            // Texto de tiempo
                            if ($minutos < 1) {
                                $tiempoTexto = "Hace menos de un minuto";
                            } elseif ($minutos == 1) {
                                $tiempoTexto = "Hace 1 minuto";
                            } else {
                                $tiempoTexto = "Hace $minutos minutos";
                            }

                            // Color de la insignia
                            $badgeClass = ($estado == 'Ninguna') ? 'bg-success' : 'bg-warning text-dark';

                            echo "
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <div>
                    <strong>Guardia $nombre</strong> - $punto
                    <div class='text-muted small'>$tiempoTexto</div>
                </div>
                <span class='badge $badgeClass rounded-pill'>$estado</span>
            </div>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="py-4 mt-5 bg-light">
        <div class="container text-center">
            <p class="mb-0 text-muted">© 2023 Sistema de Rondines. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $numeroEmpleado = $_POST['numeroempleado'];
    $puntoControl = $_POST['checkpoint'];
    $observaciones = $_POST['observaciones'] ?? '';
    $idqr = $_POST['idqr'] ?? null;

    $fechaRegistro = date('Y-m-d');
    $tiempoRegistro = date('H:i:s');

    // Insertar en la base de datos
    $registross = "INSERT INTO Registros (NumeroEmpleado, PuntoControl, FechaRegistro, TiempoRegistro, Observaciones, IDQR)
                   VALUES (?, ?, ?, ?, ?, ?)";

    $params = array($numeroEmpleado, $puntoControl, $fechaRegistro, $tiempoRegistro, $observaciones, $idqr);

    $instertar = sqlsrv_query($conn, $registross, $params);

    if ($instertar === false) {
        echo "Error al insertar: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "<script>alert('Registro exitoso ');</script>";
    }
}
?>
