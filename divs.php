<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario con Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <div class="container">
        <!-- Tarjeta: Datos de la Empresa -->
        <div class="container my-5">
            <div class="card shadow rounded-xl p-4">
                <div class="card-body">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Formulario de Empresa</h5>
                    </div>
                    <br>
                    <form>
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

                            <div class="col-md-4">
                                <label for="rutaQR" class="form-label">Ruta QR</label>
                                <input type="text" class="form-control" id="rutaQR" name="rutaQR">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Datos del Código QR -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Datos del Código QR</h5>
            </div>
            <div class="card-body">
                <form id="qrForm">
                    <div id="errorContainer" class="error-message" style="display: none;"></div>

                    <div class="form-group">
                        <label for="data">Texto o URL:</label>
                        <input type="text" id="data" name="data" placeholder="Ingresa texto, URL o datos" required>
                    </div>

                    <div class="form-group">
                        <label for="size">Tamaño del código:</label>
                        <select id="size" name="size">
                            <option value="2">Pequeño</option>
                            <option value="5" selected>Mediano</option>
                            <option value="8">Grande</option>
                        </select>
                    </div>

                    <div class="form-group color-pickers">
                        <div class="color-input">
                            <label for="color">Color del código:</label>
                            <input type="text" id="color" name="color" value="000000" maxlength="6" pattern="[a-fA-F0-9]{6}" title="6 caracteres HEX sin #">
                            <div class="color-preview" id="colorPreview" style="background-color: #000000;"></div>
                        </div>

                        <div class="color-input">
                            <label for="bgcolor">Color de fondo:</label>
                            <input type="text" id="bgcolor" name="bgcolor" value="FFFFFF" maxlength="6" pattern="[a-fA-F0-9]{6}" title="6 caracteres HEX sin #">
                            <div class="color-preview" id="bgcolorPreview" style="background-color: #FFFFFF;"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn">Generar QR</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>