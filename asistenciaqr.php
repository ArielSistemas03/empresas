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
} elseif ($empresa === "Bacrocorp") {
    $logo = "BACROCORP.png"; // Está en mayúsculas
} elseif ($empresa === "seinco") {
    $logo = "seinco.jpg";
}





?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Comunidad Solidaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Hero -->
    <section class="bg-gradient-to-r from-purple-700 to-blue-500 text-white py-16 rounded-b-3xl shadow-lg">
        <div class="container mx-auto text-center px-2">
            <div class="flex justify-center mb-1">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-white shadow">
                    <img src="logos/<?php echo $logo; ?>"
                        alt="Logo de <?php echo htmlspecialchars($empresa); ?>"
                        class="w-full h-full object-contain" />
                </div>
            </div>
            <h1 class="text-2xl font-bold mb-4">Empresa : <?php echo $empresa; ?></h1>
            <p class="text-whith-500">Selecciona una opción para comenzar</p>
        </div>
    </section>

    <!-- Opciones -->
    <section class="container mx-auto px-4 py-12">


        <div class="flex flex-col md:flex-row justify-center items-center gap-6">
            <!-- Colaborador -->
            <div class="bg-white shadow-md rounded-2xl p-6 text-center w-full max-w-sm transition-transform hover:-translate-y-2">
                <div class="flex justify-center mb-4">
                    <div class="bg-purple-100 p-4 rounded-full">
                        <img src="https://placehold.co/60x60" alt="Colaboradores" class="w-10 h-10" />
                    </div>
                </div>
                
                
               <a href="registro.php?idqr=<?php echo $idqr; ?>" 
   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-full w-full text-center block transition-all">
   Soy Colaborador
</a>
            </div>

            <!-- Solicitante -->
            <div class="bg-white shadow-md rounded-2xl p-6 text-center w-full max-w-sm transition-transform hover:-translate-y-2">
                <div class="flex justify-center mb-4">
                    <div class="bg-orange-100 p-4 rounded-full">
                        <img src="https://placehold.co/60x60" alt="Solicitar Ayuda" class="w-10 h-10" />
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-2">Solicitar Ayuda</h3>
                <p class="text-gray-600 mb-4">Encuentra a alguien que pueda ayudarte con lo que necesites</p>
                <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-full w-full transition-all">Necesito Ayuda</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-4 mt-10">
        <p class="text-sm text-gray-600">© 2023 Comunidad Solidaria. Todos los derechos reservados.</p>
    </footer>

</body>

</html>