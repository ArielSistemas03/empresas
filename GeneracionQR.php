<?php
include "config.php";



// Procesar el formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $empresa = $_POST['empresa'];
    $dependencia = $_POST['dependencia'];
    $ubicacion = $_POST['ubicacionGeografica'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $tel3 = $_POST['tel3'];
    $tel4 = $_POST['tel4'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $email3 = $_POST['email3'];
    $email4 = $_POST['email4'];
    $estatus = $_POST['estatus'];

    $ubicacionfisica = $_POST['ubicacionfisica'];

    $sql = "INSERT INTO QR_Dependencia (
                Empresa, Dependencia, UbicacionGeografica,
                TelContacto1, TelContacto2, TelContacto3, TelContacto4,
                Email1, Email2, Email3, Email4,
                Estatus,  UbicacionFisica
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, ?)";
    $params = array(
        $empresa,
        $dependencia,
        $ubicacion,
        $tel1,
        $tel2,
        $tel3,
        $tel4,
        $email1,
        $email2,
        $email3,
        $email4,
        $estatus,

        $ubicacionfisica
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "<div style='color: red;'>Error al insertar datos:</div>";
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "<div style='color: green;'>Datos insertados correctamente.</div>";
    }
}


// Ejecutar la consulta
$consulta = "SELECT IDQR, Empresa, UbicacionFisica FROM QR_Dependencia";
$resultado = sqlsrv_query($conn, $consulta);



?>


</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Generador de Códigos QR Personalizados</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
</head>

<body class="bg-light text-dark">

    <div class="container py-4">
        <header class="text-center mb-4">
            <h1 class="text-primary">Generador de QR Personalizado</h1>
            <p class="text-secondary fs-5">Crea códigos QR únicos con tu estilo personal</p>
        </header>

        <!-- Tarjeta: Datos de la Empresa -->
        <div class="container my-5">
            <div class="card shadow rounded-xl p-4">
                <div class="card-body">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Formulario de Empresa</h5>
                    </div>
                    <br>
                    <form action="" method="post">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="empresa" class="form-label">Empresa</label>
                                <input type="text" class="form-control" id="empresa" name="empresa">
                            </div>
                            <div class="col-md-4">
                                <label for="dependencia" class="form-label">Dependencia</label>
                                <input type="text" class="form-control" id="dependencia" name="dependencia">
                            </div>
                            <div class="col-md-4">
                                <label for="ubicacionfisica" class="form-label">Ubicación Fisica</label>
                                <input type="text" class="form-control" id="ubicacionfisica" name="ubicacionfisica">
                            </div>
                            <div class="col-md-4">
                                <label for="ubicacionGeografica" class="form-label">Ubicación Geográfica</label>
                                <input type="text" class="form-control" id="ubicacionGeografica" name="ubicacionGeografica">
                            </div>

                            <div class="col-md-4">
                                <label for="tel1" class="form-label">Tel. Contacto 1</label>
                                <input type="text" class="form-control" id="tel1" name="tel1">
                            </div>
                            <div class="col-md-4">
                                <label for="tel2" class="form-label">Tel. Contacto 2</label>
                                <input type="text" class="form-control" id="tel2" name="tel2">
                            </div>
                            <div class="col-md-4">
                                <label for="tel3" class="form-label">Tel. Contacto 3</label>
                                <input type="text" class="form-control" id="tel3" name="tel3">
                            </div>

                            <div class="col-md-4">
                                <label for="tel4" class="form-label">Tel. Contacto 4</label>
                                <input type="text" class="form-control" id="tel4" name="tel4">
                            </div>
                            <div class="col-md-4">
                                <label for="email1" class="form-label">Email 1</label>
                                <input type="email" class="form-control" id="email1" name="email1">
                            </div>
                            <div class="col-md-4">
                                <label for="email2" class="form-label">Email 2</label>
                                <input type="email" class="form-control" id="email2" name="email2">
                            </div>

                            <div class="col-md-4">
                                <label for="email3" class="form-label">Email 3</label>
                                <input type="email" class="form-control" id="email3" name="email3">
                            </div>
                            <div class="col-md-4">
                                <label for="email4" class="form-label">Email 4</label>
                                <input type="email" class="form-control" id="email4" name="email4">
                            </div>
                            <div class="col-md-4">
                                <label for="estatus" class="form-label">Estatus</label>
                                <select class="form-select" id="estatus" name="estatus">
                                    <option value="">Selecciona</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>



                            <button type="submit" class="btn btn-primary w-100 fw-semibold">Crear datos de QR</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>





        <div class="row g-4 bg-white rounded-3 shadow p-4">
            <div class="col-md-6">
                <form id="qrForm" novalidate>
                    <div id="errorContainer" class="alert alert-danger d-none" role="alert"></div>

                    <div class="mb-3">
                        <label for="data" class="form-label fw-semibold">Selecciona una opción:</label>
                        <select id="data" name="data" class="form-select" required>
                            <option value="">-- Selecciona una empresa --</option>
                            <?php
                            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                $id = $row['IDQR'];
                                $empresa = $row['Empresa'];
                                $ubicacion = $row['UbicacionFisica'];

                                $datocompleto = $id."_".$empresa;
                                $idsqr = $id;

                                echo "<option value='http://192.168.100.95/SisBacrocorp/Administracion/Rondines/asistenciaqr.php?idqr=$id'>$id - $empresa - $ubicacion</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label fw-semibold">Tamaño del código:</label>
                        <select id="size" name="size" class="form-select">
                            <option value="2">Pequeño</option>
                            <option value="5" selected>Mediano</option>
                            <option value="8">Grande</option>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6 position-relative">
                            <label for="color" class="form-label fw-semibold">Color del código:</label>
                            <input
                                type="text"
                                id="color"
                                name="color"
                                value="000000"
                                maxlength="6"
                                pattern="[a-fA-F0-9]{6}"
                                title="6 caracteres HEX sin #"
                                class="form-control pe-5" />
                            <div
                                id="colorPreview"
                                style="position:absolute; top: 2.5rem; right: 0.75rem; width: 24px; height: 24px; border-radius: 4px; border: 1px solid #ced4da; background-color: #000000;"></div>
                        </div>
                        <div class="col-6 position-relative">
                            <label for="bgcolor" class="form-label fw-semibold">Color de fondo:</label>
                            <input
                                type="text"
                                id="bgcolor"
                                name="bgcolor"
                                value="FFFFFF"
                                maxlength="6"
                                pattern="[a-fA-F0-9]{6}"
                                title="6 caracteres HEX sin #"
                                class="form-control pe-5" />
                            <div
                                id="bgcolorPreview"
                                style="position:absolute; top: 2.5rem; right: 0.75rem; width: 24px; height: 24px; border-radius: 4px; border: 1px solid #ced4da; background-color: #FFFFFF;"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Generar QR</button> <br><br>
                    
                    
                </form>
                <a href="index.php" class="btn btn-primary w-100 fw-semibold">Regresar Inicio</a>
            </div>

            <div
                class="col-md-6 d-flex flex-column align-items-center justify-content-center border border-secondary-subtle rounded-3 p-4"
                style="min-height: 400px;">
                <div
                    id="qrPlaceholder"
                    class="d-flex align-items-center justify-content-center bg-light text-secondary rounded mb-3"
                    style="width: 250px; height: 250px;">

                    <canvas
                        id="qrCanvas"
                        class="border rounded bg-white mb-3"
                        style="display: none; width: 250px; height: 250px;"
                        width="1000"
                        height="1000">
                    </canvas>
                </div>



                <div id="qrActions" class="d-flex gap-3" style="display: none;">
                    <a href="#" id="downloadBtn" class="btn btn-primary">Descargar QR</a>
                    <button id="resetBtn" class="btn btn-outline-secondary">Generar otro</button>
                    <a onclick="saveqr()" id="saveqr" class="btn btn-primary">Guardar QR</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var datocompleto = "<?php echo $datocompleto; ?>";
        var idqr = "<?php echo $idqr; ?>";
        
        // Convert HEX to RGB
        function hexToRgb(hex) {
            hex = hex.replace("#", "");
            hex = hex.padEnd(6, "0");
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            return [r, g, b];
        }

        // Update color previews
        function updateColorPreviews() {
            const color = document.getElementById("color").value;
            const bgcolor = document.getElementById("bgcolor").value;

            document.getElementById("colorPreview").style.backgroundColor = `#${color}`;
            document.getElementById("bgcolorPreview").style.backgroundColor = `#${bgcolor}`;
        }

        // Initialize QR code with canvas
        function generateQRCode() {
            const form = document.getElementById("qrForm");
            const data = document.getElementById("data").value.trim();
            const size = document.getElementById("size").value;
            const color = document.getElementById("color").value;
            const bgcolor = document.getElementById("bgcolor").value;

            // Validate inputs
            if (!data) {
                showError("Por favor ingresa texto o URL para generar el QR");
                return;
            }

            if (!/^[a-fA-F0-9]{6}$/.test(color) || !/^[a-fA-F0-9]{6}$/.test(bgcolor)) {
                showError("Los colores deben ser válidos (6 caracteres HEX sin #)");
                return;
            }

            // Hide placeholder and show canvas
            document.getElementById("qrPlaceholder").style.display = "flex";
            const canvas = document.getElementById("qrCanvas");
            canvas.style.display = "block";

            // Create QR code
            const qr = new QRious({
                element: canvas,
                value: data,
                size: 1000,
                padding: 25,
                foreground: `#${color}`,
                background: `#${bgcolor}`,
                level: "H", // Highest error correction
                mime: "image/png",
            });

            // Scale down for display
            canvas.style.width = "250px";
            canvas.style.height = "250px";

            // Show download button
            document.getElementById("qrActions").style.display = "flex";

            // Set download link
            const downloadBtn = document.getElementById("downloadBtn");
            const downloadCanvas = document.createElement("canvas");
            downloadCanvas.width = 1000;
            downloadCanvas.height = 1000;
            const ctx = downloadCanvas.getContext("2d");
            ctx.fillStyle = `#${bgcolor}`;
            ctx.fillRect(0, 0, 1000, 1000);
            ctx.drawImage(canvas, 0, 0);

            downloadCanvas.toBlob(function(blob) {
                downloadBtn.href = URL.createObjectURL(blob);
                downloadBtn.download = `${datocompleto}.png`;
            }, "image/png", 1.0);

        }

        function saveqr() {
            const canvas = document.getElementById("qrCanvas");
            const base64 = canvas.toDataURL("image/png"); // ✅ Correcto

            fetch("procesar_qr.php", {
                    method: "POST",
                    
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        imagen: base64,
                        datocompleto: datocompleto,
                        idqr : idqr
                    })
                })
                .then(res => res.text())
                .then(res => alert("Respuesta del servidor: " + res))
                .catch(err => console.error(err));
        }

        function showError(message) {
            const errorContainer = document.getElementById("errorContainer");
            errorContainer.textContent = message;
            errorContainer.classList.remove("d-none");
            setTimeout(() => {
                errorContainer.classList.add("d-none");
            }, 5000);
        }

        function resetForm() {
            document.getElementById("qrForm").reset();
            document.getElementById("qrPlaceholder").style.display = "flex";
            document.getElementById("qrCanvas").style.display = "flex";
            document.getElementById("qrActions").style.display = "flex";
            updateColorPreviews();
        }

        // Event listeners
        document.addEventListener("DOMContentLoaded", () => {
            99
            updateColorPreviews();

            document.getElementById("color").addEventListener("input", updateColorPreviews);
            document.getElementById("bgcolor").addEventListener("input", updateColorPreviews);

            document.getElementById("qrForm").addEventListener("submit", (e) => {
                e.preventDefault();
                generateQRCode();
            });

            document.getElementById("resetBtn").addEventListener("click", (e) => {
                e.preventDefault();
                resetForm();
            });
        });
    </script>
</body>

</html>