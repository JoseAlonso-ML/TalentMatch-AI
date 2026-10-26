<?php
require 'conexion.php';
$mensaje = "";
$tipo_alerta = "";
$icono_alerta = "";

// 1. REGISTRAR EL DATO 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $razon_social = $_POST['razon_social'];
    $ruc = $_POST['ruc'];
    $sector = $_POST['sector'];

    $sql_insert = "INSERT INTO empresas (razon_social, ruc, sector) VALUES ('$razon_social', '$ruc', '$sector')";
    
    try {
        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "La organización se ha registrado correctamente en el sistema.";
            $tipo_alerta = "success";
            $icono_alerta = "bi-check-circle-fill";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $mensaje = "Operación rechazada: El RUC '$ruc' ya existe en los registros corporativos.";
        } else {
            $mensaje = "Error interno del servidor: " . $e->getMessage();
        }
        $tipo_alerta = "danger";
        $icono_alerta = "bi-exclamation-triangle-fill";
    }
}

// 2. CONSULTAR LOS DATOS (SELECT)
$sql_select = "SELECT * FROM empresas ORDER BY id_empresa DESC";
$resultado = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TalentMatch AI | Gestión Corporativa</title>
    
    <!-- Fuentes e Iconos Profesionales -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Diseño Estilo SaaS / Enterprise -->
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc; /* Fondo gris muy sutil */
            color: #334155;
        }
        /* Navbar corporativa oscura */
        .navbar {
            background-color: #0f172a !important; 
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
            font-size: 1.25rem;
        }
        /* Tarjetas limpias sin bordes gruesos */
        .card { 
            border: 1px solid #e2e8f0; 
            border-radius: 0.5rem; 
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); 
        }
        .card-header { 
            background-color: #ffffff; 
            border-bottom: 1px solid #e2e8f0; 
            font-weight: 600; 
            padding: 1rem 1.25rem; 
            color: #0f172a;
            font-size: 0.95rem;
        }
        /* Botones e Inputs modernos */
        .btn-primary { 
            background-color: #2563eb; 
            border-color: #2563eb; 
            font-weight: 500; 
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .btn-primary:hover { background-color: #1d4ed8; }
        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #475569;
            margin-bottom: 0.4rem;
        }
        .form-control, .form-select {
            border-color: #cbd5e1;
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
        }
        /* Tabla de datos profesional */
        .table { margin-bottom: 0; }
        .table th {
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.25rem;
        }
        .table td {
            vertical-align: middle;
            font-size: 0.85rem;
            color: #334155;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tbody tr:hover { background-color: #f8fafc; }
        /* Badge ID sutil */
        .badge-id {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            font-weight: 500;
        }
        /* Alertas limpias */
        .alert { border: none; font-size: 0.9rem; font-weight: 500; border-radius: 0.5rem; }
    </style>
</head>
<body>

    <!-- Navegación Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <i class="bi bi-hexagon-fill text-primary me-2"></i>TalentMatch <span class="text-secondary fw-normal">AI</span>
            </a>
            <div class="d-flex align-items-center">
                <span class="text-light opacity-75 small me-3"><i class="bi bi-shield-lock me-1"></i>Módulo de Reclutamiento</span>
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: bold;">
                    JR
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 pb-5">
        
        <!-- Notificaciones del Sistema -->
        <?php if($mensaje != ""): ?>
            <div class="alert alert-<?= $tipo_alerta ?> alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                <i class="bi <?= $icono_alerta ?> fs-5 me-2"></i>
                <div><?= $mensaje ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Panel Izquierdo: Formulario -->
            <div class="col-lg-4 col-xl-3">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-building-add text-primary me-2 fs-5"></i>
                        Alta de Organización
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Razón Social</label>
                                <input type="text" name="razon_social" class="form-control" placeholder="Ej. InnovaTech S.A.C." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Número de RUC</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="ruc" class="form-control border-start-0 ps-0" maxlength="11" pattern="\d{11}" title="Debe contener 11 dígitos numéricos" placeholder="20000000000" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Sector Comercial</label>
                                <select name="sector" class="form-select" required>
                                    <option value="" disabled selected>Seleccionar rubro...</option>
                                    <option value="Tecnología y Software">Tecnología y Software</option>
                                    <option value="Servicios Financieros">Servicios Financieros</option>
                                    <option value="Ingeniería y Operaciones">Ingeniería y Operaciones</option>
                                    <option value="Educación y EdTech">Educación y EdTech</option>
                                    <option value="Salud y Biotech">Salud y Biotech</option>
                                    <option value="Retail y E-commerce">Retail y E-commerce</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-cloud-arrow-up me-2"></i>Registrar Entidad</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho: Data Grid -->
            <div class="col-lg-8 col-xl-9">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-table text-primary me-2 fs-5"></i>
                            Directorio de Empresas Asociadas
                        </div>
                        <span class="badge bg-light text-dark border border-secondary-subtle">
                            Total: <?= $resultado->num_rows ?> registros
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 8%">ID</th>
                                        <th style="width: 35%">Razón Social</th>
                                        <th style="width: 20%">Identificador (RUC)</th>
                                        <th style="width: 22%">Sector</th>
                                        <th style="width: 15%">Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($resultado->num_rows > 0) {
                                        while($fila = $resultado->fetch_assoc()) {
                                            $fecha = date('d M, Y', strtotime($fila['fecha_registro']));
                                            echo "<tr>
                                                    <td><span class='badge badge-id px-2 py-1'>{$fila['id_empresa']}</span></td>
                                                    <td class='fw-medium text-dark'>{$fila['razon_social']}</td>
                                                    <td class='text-muted'><i class='bi bi-upc-scan me-1'></i>{$fila['ruc']}</td>
                                                    <td><span class='badge bg-light text-secondary border'>{$fila['sector']}</span></td>
                                                    <td class='text-muted small'>{$fecha}</td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'><i class='bi bi-inbox fs-3 d-block mb-2 text-light'></i>No hay organizaciones registradas en la base de datos.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>