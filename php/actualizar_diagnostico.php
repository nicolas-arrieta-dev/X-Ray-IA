<?php
include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->Usuario_logueado();

// Verificar si el usuario está logueado
if (empty($resultado)) {
    header("Location: ../login.html");
    exit();
}

// Obtener datos del empleado
$result = $objconsulta->Consultar_empleado($resultado);
$empleado = mysqli_fetch_assoc($result);

$diagnosticos = $objconsulta->Mostrar_todo_diagnosticos();



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-RAY DIAGNOSTIC - Listado de Diagnósticos</title>
    <link rel="shortcut icon" href="../assets/img/logo_icono_x_ray.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/Style/actualizar_diagnostico.css">
    <style>
        /* Estilos adicionales para la tabla y el filtro */
        .diagnosticos-container {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            max-width: 1200px;
            margin: 0 auto;
        }

        .diagnosticos-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 18px;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            border-color: var(--primary);
            outline: none;
            background-color: white;
            box-shadow: 0 0 0 2px rgba(71, 79, 160, 0.2);
        }

        .new-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
            box-shadow: 0 4px 15px rgba(45, 192, 113, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .new-btn:hover {
            background: var(--accent-dark);
            transform: translateY(-2px);
        }

        .diagnosis-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .diagnosis-table th {
            background-color: var(--primary);
            color: white;
            text-align: left;
            padding: 15px;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .diagnosis-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .diagnosis-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .diagnosis-table tr:hover {
            background-color: #f0f8ff;
        }

        .action-cell {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            border: none;
            min-width: 100px;
        }

        .edit-btn {
            background-color: #4a6cf7;
            color: white;
        }

        .delete-btn {
            background-color: #ff4d4f;
            color: white;
        }

        .action-btn i {
            margin-right: 8px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .edit-btn:hover {
            background-color: #3a57e0;
        }

        .delete-btn:hover {
            background-color: #e04345;
        }

        .description-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .severity-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .severity-leve {
            background-color: #d9f7be;
            color: #389e0d;
        }

        .severity-moderado {
            background-color: #fff1b8;
            color: #d48806;
        }

        .severity-grave {
            background-color: #ffccc7;
            color: #cf1322;
        }

        .severity-muy_grave {
            background-color: #ff7875;
            color: #a8071a;
        }

        .confidence-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .confidence-bar {
            flex: 1;
            height: 10px;
            background: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }

        .confidence-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.5s ease;
        }

        .confidence-value {
            font-weight: 600;
            min-width: 40px;
            text-align: right;
        }

        .no-results {
            text-align: center;
            padding: 30px;
            color: var(--text-light);
            font-style: italic;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 8px;
        }

        .page-btn {
            padding: 8px 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .page-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .page-btn:hover:not(.active) {
            background: #f0f0f0;
        }

        .table-container {
            max-height: 600px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #eee;
            
        }

        @media (max-width: 900px) {
            .diagnosis-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 768px) {
            .action-cell {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="logo-container">
            <a href="examen.php">
                <img src="../assets/img/logo_x_ray.png" alt="X-RAY DIAGNOSTIC" class="logo">
            </a>
        </div>
        <nav class="top-nav">
            <a href="examen.php" class="nav-item">
                <i class="fas fa-file-medical"></i>
                <span>EXAMEN</span>
            </a>
            <a href="consultar.php" class="nav-item">
                <i class="fas fa-search"></i>
                <span>CONSULTAR</span>
            </a>
            <a href="configurar.php" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>AJUSTES</span>
            </a>
            <a href="editar.php" class="nav-item">
                <i class="fas fa-edit"></i>
                <span>EDITAR</span>
            </a>
            <a href="actualizar_diagnostico.php" class="nav-item active">
                <i class="fas fa-stethoscope"></i>
                <span>DIAGNÓSTICO</span>
            </a>
            <a href="registrar_patologia.php" class="nav-item">
                <i class="fas fa-notes-medical"></i>
                <span>PATOLOGÍAS</span>
            </a>
            <a href="cerrar_session.php" class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>SALIR</span>
            </a>
        </nav>

        <div class="user-info">
            <div class="user-avatar">
                <a href="configurar.php">
                            <?php if (empty($empleado['Foto'])): ?>
                <img src="../assets/img/icono_doctor.png" alt="Doctor">
            <?php else: ?>
                <img src="../assets/upload/<?php echo htmlspecialchars($empleado['Foto']); ?>" alt="Foto de perfil">
            <?php endif; ?>
            </a>
            </div>
            
            <div class="user-name">
                <span><?php echo htmlspecialchars($empleado['Nombre'] . " " . $empleado['Apellido']); ?></span>
                <div class="status-indicator"></div>
            </div>
        </div>

        <button class="hamburger-btn" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <nav class="sidebar-nav">
        <ul>
            <li><a href="examen.php"><i class="fas fa-file-medical"></i> EXAMEN</a></li>
            <li><a href="consultar.php"><i class="fas fa-search"></i> CONSULTAR</a></li>
            <li><a href="configurar.php"><i class="fas fa-cog"></i> AJUSTES</a></li>
            <li><a href="editar.php"><i class="fas fa-edit"></i> EDITAR</a></li>
            <li class="active"><a href="actualizar_diagnostico.php"><i class="fas fa-stethoscope"></i> DIAGNÓSTICO</a></li>
            <li><a href="registrar_patologia.php"><i class="fas fa-notes-medical"></i> PATOLOGÍAS</a></li>
            <li><a href="cerrar_session.php"><i class="fas fa-sign-out-alt"></i> SALIR</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="section-header">
            <h1>Listado de Diagnósticos</h1>
            <p>Gestión completa de los diagnósticos realizados en el sistema</p>
        </div>

        <div class="diagnosticos-container">
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar diagnóstico...">
                </div>
                <button class="new-btn" onclick="window.location.href='examen.php';">
                    <i class="fas fa-plus"></i> Nuevo Diagnóstico
                </button>
            </div>

            <div class="table-container">
                <table class="diagnosis-table" id="diagnosisTable">
                    <thead>
                        <tr>
                            <th>ID Diagnóstico</th>
                            <th>Descripción</th>
                            <th>Nivel Gravedad</th>
                            <th>Confianza IA</th>
                            <th>Tipo Fractura IA</th>
                            <th>Fecha y Hora</th>
                            <th>Radiografía</th>
                            <th>Patología</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($diag = mysqli_fetch_array($diagnosticos)){ ?>
                    <tr id="diag_<?php echo $diag['Id_diagnostico']; ?>">
                        <td><?php echo $diag['Id_diagnostico']; ?> </td>
                        <td class="description-cell"><?php echo $diag['Descripcion']; ?></td>
                        <td>
                            <?php 
                                $severityClass = 'severity-' . $diag['Nivel_gravedad'];
                                $severityText = '';
                                switch ($diag['Nivel_gravedad']) {
                                    case 'leve':
                                        $severityText = 'LEVE';
                                        break;
                                    case 'moderado':
                                        $severityText = 'MODERADO';
                                        break;
                                    case 'grave':
                                        $severityText = 'GRAVE';
                                        break;
                                    case 'muy_grave':
                                        $severityText = 'MUY GRAVE';
                                        break;
                                }
                                echo '<span class="severity-badge ' . $severityClass . '">' . $severityText . '</span>';
                            ?>
                        </td>
                        <td class="confidence-cell">
                            <div class="confidence-bar">
                                <div class="confidence-fill" 
                                    style="width: <?php echo $diag['Porcentaje_confianza_IA']; ?>%;
                                            background: <?php 
                                                $conf = $diag['Porcentaje_confianza_IA'];
                                                if ($conf < 50) echo '#ff6b6b';
                                                elseif ($conf < 80) echo '#ffd166';
                                                else echo '#06d6a0';
                                            ?>;">
                                </div>
                            </div>
                            <div class="confidence-value"><?php echo $diag['Porcentaje_confianza_IA']; ?></div>
                        </td>
                        <td><?php echo $diag['Tipo_Fractura_IA']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($diag['Fecha_hora'])); ?></td>
                        <td><?php echo $diag['Nombre_paciente'] . ' ' . $diag['Apellido_paciente'] . ' - Zona: ' . $diag['Zona_radiografiada']; ?></td>
                        <td><?php echo $diag['Nombre_patologia']; ?></td>
                        <td class="action-cell">

                        <form action="actulizar_un_diagnostico.php" method="POST">
                            <input type="hidden" name="id_diagnostico" value="<?php echo $diag['Id_diagnostico']; ?>">
                            <button type="submit" class="action-btn edit-btn" onclick="editDiagnostic('<?php echo $diag['Id_diagnostico']; ?>')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </form>
                            <button class="action-btn delete-btn" onclick="confirmDelete('<?php echo $diag['Id_diagnostico']; ?>')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr id="no-data-message" style="display: none;">
                        <td colspan="8" style="text-align:center; color: #888; font-style: italic;">
                            No se encontraron diagnósticos.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="no-results" id="noResults" style="display: none;">
                No se encontraron diagnósticos que coincidan con su búsqueda
            </div>
            
           <!-- <div class="pagination" id="pagination"> 
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
            </div>
            -->
        </div>

    </main>
    

        <div class="notification" id="notification" style="display: none;">
        <span id="notification-message"></span>
        <span class="close" onclick="closeNotification()">&times;</span>
    </div>
    <script src="../assets/js/actualizar_diagnostico.js"></script>

</body>
</html>