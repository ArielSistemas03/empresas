<?php
include "config.php";


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Revisión de Checadas por Jornada</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />

</head>
<style>
    .row-ultimo {
        background-color: #d4edda !important;
        /* Verde claro */
    }

    .row-penultimo {
        background-color: #fff3cd !important;
        /* Amarillo claro */
    }
</style>

<body>
    <div class="bg-primary bg-gradient text-white text-center py-1 mb-4 rounded-bottom">
        <div class="container">
            <div class="rounded-circle bg-white bg-opacity-25 d-flex justify-content-center align-items-center mx-auto mb-4" style="width: 80px; height: 80px;">
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/5daea7f6-cf23-457b-b137-5da270b9758f.png" alt="Logo de la aplicación mostrando manos formando un corazón en fondo blanco" class="img-fluid" style="max-width: 40px;" />
            </div>
            <h1 class="display-4 fw-bold mb-4">Revisión de Checadas</h1>
            <p class="lead mb-5">Registros por jornada de 8:00 AM a 8:00 AM</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card border-0 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0"></h3>

                    </div>
                    <div class="table-responsive">
                        <table id="tabla-registros" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Reg.</th>
                                    <th>No. Empleado</th>
                                    <th>Nombre Empleado</th>
                                    <th>Punto</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Observaciones</th>
                                    <th>QR</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpo-tabla">
                                <?php
                                $consulreg = "SELECT * FROM Registros ORDER BY IDRegistro DESC";
                                $resultados = sqlsrv_query($conn, $consulreg, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);

                                if ($resultados !== false) {
                                    $contador = 0;
                                    while ($row = sqlsrv_fetch_array($resultados, SQLSRV_FETCH_ASSOC)) {
                                        $fecha = $row['FechaRegistro'];
                                        $hora = $row['TiempoRegistro'];
                                        $fechaFormateada = $fecha ? $fecha->format('d/m/Y') : '';
                                        $horaFormateada = $hora ? $hora->format('H:i:s') : '';
                                        $number = $row['NumeroEmpleado'];

                                        // Valor predeterminado si no se encuentra el nombre
                                        $nombreEmpleado = 'Empleado no encontrado';

                                        $infoempleado = "SELECT 
                    e.AreaName, e.DepartmentName, e.PositionName, e.EmployeeNumber, e.Manager,
                    c.FirstName, c.MiddleName, c.LastNameFather, c.LastNameMother, c.NickName,
                    c.Phone, c.Email, c.AddressName, c.StateProvince, c.Municipality,
                    c.City, c.Zipcode, c.Street, c.MainAddress, c.CURP
                FROM vwLBSEmployeeList AS e
                INNER JOIN vwLBSContactList AS c ON c.NickName = e.EmployeeNumber
                WHERE e.EmployeeNumber = ?";

                                        $params = [$number];
                                        $employeinfo = sqlsrv_query($compaq, $infoempleado, $params);

                                        if ($employeinfo && sqlsrv_has_rows($employeinfo)) {
                                            $rowEmpleado = sqlsrv_fetch_array($employeinfo, SQLSRV_FETCH_ASSOC);
                                            $nombreEmpleado = trim(
                                                $rowEmpleado['FirstName'] . ' ' .
                                                    $rowEmpleado['MiddleName'] . ' ' .
                                                    $rowEmpleado['LastNameFather'] . ' ' .
                                                    $rowEmpleado['LastNameMother']
                                            );
                                        }

                                        $clase = '';
                                        if ($contador === 0) $clase = 'table-success';
                                        elseif ($contador === 1) $clase = 'table-warning';

                                        echo "<tr class='$clase'>";
                                        echo "<td>" . htmlspecialchars($row['IDRegistro']) . "</td>";
                                        echo "<td>#" . htmlspecialchars($number) . "</td>";
                                        echo "<td>" . htmlspecialchars($nombreEmpleado) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['PuntoControl']) . "</td>";
                                        echo "<td>" . $fechaFormateada . "</td>";
                                        echo "<td>" . $horaFormateada . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Observaciones']) . "</td>";
                                        echo "<td><span class='badge bg-primary'>" . htmlspecialchars($row['IDQR']) . "</span></td>";
                                        echo "</tr>";

                                        $contador++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let tabla;

        $(document).ready(function() {
            tabla = $('#tabla-registros').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                order: [
                    [0, 'desc']
                ]
            });


        });

        function cargarDatos() {
            $.ajax({
                url: window.location.href,
                type: 'GET',
                data: {
                    ajax: true
                },
                success: function(response) {
                    const html = $(response).find('#cuerpo-tabla').html(); // extrae solo el contenido del tbody
                    tabla.clear().destroy(); // destruye DataTable
                    $('#cuerpo-tabla').html(html); // actualiza contenido
                    tabla = $('#tabla-registros').DataTable({ // vuelve a activar DataTable
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                        },
                        pageLength: 10,
                        lengthMenu: [5, 10, 25, 50],
                        order: [
                            [0, 'desc']
                        ]
                    });
                }
            });
        }
    </script>
</body>

</html>