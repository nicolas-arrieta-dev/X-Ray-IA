<?php
include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->Usuario_logueado();
$result = $objconsulta->Consultar_empleado($resultado);
$result_radiografia = $objconsulta->Mostrar_todo_radiografia();
if (empty($resultado)) {
    header("Location: ../login.html");
    exit();
}

// Obtener nombre del médico para mostrarlo una sola vez

$empleado = mysqli_fetch_array($result);
$nombre_medico = $empleado['Nombre'] . " " . $empleado['Apellido'];



?>
<!DOCTYPE html>
<html lang="es">
<style>
    .fila-seleccionada {
        background-color: #f0f0ff;
        border-left: 4px solid #7a00cc;
    }
    .delete-btn {
    background-color: #ff4d4f;
    color: white;
    }
    .action-btn2 {
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        gap: 8px;
        border: none;
        min-width: 100px;
        margin-top: 5px;
    }
    .action-btn2:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-RAY DIAGNOSTIC | Consultas</title>
    <link rel="shortcut icon" href="../assets/img/logo_icono_x_ray.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/Style/consultar.css">
</head>

<body>
    <!-- Barra de navegación superior -->
    <header class="main-header">
        <div class="logo-container" style="max-width: 100px;">
            <a href="examen.php">
                <img src="../assets/img/logo_x_ray.png" alt="X-RAY DIAGNOSTIC" class="logo" style="max-width: 100%; height: auto;">
            </a>
        </div>
        <nav class="top-nav" style="display: flex; gap: 10px;">
            <a href="examen.php" class="nav-item">
                <i class="fas fa-file-medical"></i>
                <span>EXAMEN</span>
            </a>
            <a href="consultar.php" class="nav-item active">
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
            <a href="actualizar_diagnostico.php" class="nav-item">
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
                <span><?php echo $nombre_medico; ?></span>
                <div class="status-indicator"></div>
            </div>
        </div>

        <button class="hamburger-btn" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <!-- Menú lateral (aparece en móvil) -->
    <nav class="sidebar-nav">
        <ul>
            <li><a href="examen.php"><i class="fas fa-file-medical"></i> EXAMEN</a></li>
            <li class="active"><a href="consultar.php"><i class="fas fa-search"></i> CONSULTAR</a></li>
            <li><a href="configurar.php"><i class="fas fa-cog"></i> AJUSTES</a></li>
            <li><a href="editar.php"><i class="fas fa-edit"></i> EDITAR</a></li>
            <li><a href="actualizar_diagnostico.php"><i class="fas fa-stethoscope"></i> DIAGNÓSTICO</a></li>
            <li><a href="registrar_patologia.php"><i class="fas fa-notes-medical"></i> PATOLOGÍAS</a></li>
            <li><a href="cerrar_session.php"><i class="fas fa-sign-out-alt"></i> SALIR</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content">
        <div class="section-header">
            <h1>Consultar Diagnósticos</h1>
            <p>Busque y visualice los diagnósticos existentes en el sistema</p>
        </div>

        <div class="diagnostic-container">
            <div class="preview-section">
                <div class="preview-card">
                    <div class="preview-icon">
                        <img src="../assets/img/icono_archivo_DICOM.png" alt="Preview Icon">
                    </div>
                    <p class="preview-text">Aquí se mostrará la imagen del diagnóstico al seleccionar un registro</p>
                    <div id="previewContainer">
                        <div class="preview-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Seleccione un diagnóstico</span>
                        </div>
                        <img id="previewImage" src="" alt="">
                    </div>
                </div>
            </div>

            <div class="table-section">
                <select id="filterColumn" class="filter-select">
                    <option value="1">ID</option>
                    <option value="2">Fecha y hora</option>
                    <option value="3">Edad</option>
                    <option value="4">Observaciones</option>
                    <option value="5">Zona</option>
                    <option value="6">Categoría</option>
                    <option value="7">Realizado por</option>
                    <option value="8">Cédula paciente</option>
                    <option value="9">Nombre paciente</option>
                    <option value="10">Género</option>
                </select>
                <div class="search-container">


                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="query" class="search-input" placeholder="Buscar por ID, nombre o fecha...">

                </div>

                <div class="table-container">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Fecha y hora</th>
                                <th>Edad</th>
                                <th>Observaciones</th>
                                <th>Zona</th>
                                <th>Categoria</th>
                                <th>Realizado por</th>
                                <th>Cedula paciente</th>
                                <th>Nombre completo</th>
                                <th>Genero</th>
                                <th>Archivo Radiografia</th>
                                <th>Funciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($radiografia = mysqli_fetch_array($result_radiografia)) { ?>
                                <tr>
                                    <td><input type="checkbox" class="fila-check"></td>
                                    <td><?php echo $radiografia['ID']; ?></td>
                                    <td><?php echo $radiografia['Fecha y hora']; ?></td>
                                    <td>
                                        <?php
                                        $fechaNacimiento = new DateTime($radiografia['Fecha_nacimiento']);
                                        $hoy = new DateTime();
                                        $edad = $hoy->diff($fechaNacimiento)->y;
                                        echo $edad;
                                        ?>
                                    </td>
                                    <td><?php echo $radiografia['Observaciones']; ?></td>
                                    <td><?php echo $radiografia['Zona']; ?></td>
                                    <td><?php echo $radiografia['Categoria']; ?></td>
                                    <td><?php echo $radiografia['nombre_empleado']; ?></td>
                                    <td><?php echo $radiografia['Cedula paciente']; ?></td>
                                    <td><?php echo $radiografia['Nombre completo']; ?></td>
                                    <td>
                                        <?php
                                        if ($radiografia['Genero'] == 'M') {
                                            echo "Masculino";
                                        } elseif ($radiografia['Genero'] == 'F') {
                                            echo "Femenino";
                                        } else {
                                            echo "Otro";
                                        }
                                        ?>
                                    </td>
                                    <td class="archivo-radiografia"><?php echo $radiografia['Archivo_radiografia']; ?></td>
                                    <td>
                                        <form method="GET" action="editar3.php">
                                            <input type="hidden" name="id" value="<?php echo $radiografia['ID']; ?>">
                                            <button type="submit" class="action-btn">
                                                <i class="fas fa-play"></i> Analizar
                                            </button>
                                        </form>
                                           
                                            <button class="delete-btn action-btn2" onclick="confirmDelete('<?php echo $radiografia['ID']; ?>')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
    <div class="notification" id="notification" style="display: none;">
        <span id="notification-message"></span>
        <span class="close" onclick="closeNotification()">&times;</span>
    </div>

<script src="../assets/js/consultar.js"></script>



</html>