<?php
$ID_Radiografia = $_POST['id'];
include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->Usuario_logueado();
$result = $objconsulta->Consultar_empleado($resultado);
$result_radiografia = $objconsulta->Consultar_radiografia($ID_Radiografia);
$radiografia = mysqli_fetch_array($result_radiografia);
$empleado = mysqli_fetch_array($result);
$nombre_empleado = $empleado['Nombre'] . " " . $empleado['Apellido'];
if (empty($radiografia)) {
    header("Location: editar.php?ms=Radiografía no encontrada&type=error");
    exit();
}

if (empty($resultado)) {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-RAY DIAGNOSTIC - Editar Diagnóstico</title>
    <link rel="shortcut icon" href="../assets/img/logo_icono_x_ray.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/Style/editar3.css">
    <style>
        /* Nuevo layout con imagen a la izquierda y paneles apilados a la derecha */
    .diagnostic-container {
        display: grid;
        grid-template-columns: 70% 30%;
        gap: 20px;
        margin-top: 20px;
    }
    
    .image-section {
        grid-column: 1;
        grid-row: 1 / span 2; /* Ocupa dos filas */
        background-color: var(--card-bg);
        border-radius: 15px;
        padding: 20px;
        box-shadow: var(--shadow);
        height: calc(100% - 40px); /* Ajuste de padding */
    }
    
    .tools-section {
        grid-column: 2;
        grid-row: 1;
        background-color: var(--card-bg);
        border-radius: 15px;
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        max-height: 50vh;
        overflow-y: auto;
    }
    
    .info-section {
        grid-column: 2;
        grid-row: 2;
        background-color: var(--card-bg);
        border-radius: 15px;
        padding: 20px;
        box-shadow: var(--shadow);
        height: fit-content;
    }
    
    .image-container {
        width: 100%;
        height: 700px; /* Altura aumentada */
        background-color: #f8f9fa;
        border-radius: 10px;
        overflow: auto; /* Scroll si la imagen es muy grande */
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #e0e0e0;
    }
    
    .image-container img {
        max-width: none; /* Quitamos la limitación */
        max-height: none;
        object-fit: contain;
        transform-origin: center center;
        transition: transform 0.3s ease;
    }
    
    @media (max-width: 1200px) {
        .diagnostic-container {
            grid-template-columns: 1fr;
        }
        
        .image-section {
            grid-column: 1;
            grid-row: 1;
            height: 500px;
        }
        
        .tools-section, .info-section {
            grid-column: 1;
        }
        
        .tools-section {
            grid-row: 2;
        }
        
        .info-section {
            grid-row: 3;
        }
    }

        @media (max-width: 768px) {
            .diagnostic-container {
                grid-template-columns: 1fr;
            }
        }

        .button_diagnostico {
            background-color: #2dbd2d;
            color: white;
            margin-bottom: 10px;
        }

        .button_diagnostico:hover {
            background-color: #28a745;
            color: white;
        }

        .input-label {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
        }
    </style>
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
            <a href="consultar.php" class="nav-item">
                <i class="fas fa-search"></i>
                <span>CONSULTAR</span>
            </a>
            <a href="configurar.php" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>AJUSTES</span>
            </a>
            <a href="editar.php" class="nav-item active">
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
                <span>
                    <?php
                    echo $nombre_empleado
                    ?>
                </span>
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
            <li><a href="consultar.php"><i class="fas fa-search"></i> CONSULTAR</a></li>
            <li><a href="configurar.php"><i class="fas fa-cog"></i> AJUSTES</a></li>
            <li class="active"><a href="editar.php"><i class="fas fa-edit"></i> EDITAR</a></li>
            <li><a href="actualizar_diagnostico.php"><i class="fas fa-stethoscope"></i> DIAGNÓSTICO</a></li>
            <li><a href="registrar_patologia.php"><i class="fas fa-notes-medical"></i> PATOLOGÍAS</a></li>
            <li><a href="cerrar_session.php"><i class="fas fa-sign-out-alt"></i> SALIR</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content">
        <div class="section-header">
            <h1>Editar Diagnóstico</h1>
            <p>Detalles del diagnóstico seleccionado</p>
        </div>

        <div class="diagnostic-container">
            <!-- Sección 1: Imagen -->
            <div class="image-section">
                <h2><i class="fas fa-image"></i> Imagen Radiológica</h2>
                <div class="image-container">
                    <?php
                    if (!empty($radiografia['Archivo_radiografia'])) {
                        echo '<img id="imagePreview" src="../assets/upload/' . $radiografia['Archivo_radiografia'] . '">';
                    } else {
                        echo '<div style="text-align: center; color: #6c757d;">
                            <i class="fas fa-image" style="font-size: 5rem; margin-bottom: 15px;"></i>
                            <p>No hay imagen disponible</p>
                        </div>';
                    }
                    ?>
                </div>
                <div class="zoom-controls">
                    <button class="zoom-btn" id="zoomIn"><i class="fas fa-search-plus"></i></button>
                    <button class="zoom-btn" id="zoomOut"><i class="fas fa-search-minus"></i></button>
                    <button class="zoom-btn" id="zoomReset"><i class="fas fa-expand"></i></button>
                </div>
            </div>

            <!-- Sección 2: Herramientas -->
            <div class="tools-section">
                <h2><i class="fas fa-tools"></i> Herramientas de Edición</h2>

                <div class="control-group">
                    <h3><i class="fas fa-font"></i> Texto</h3>
                    <label for="textInput">Texto a agregar:</label>
                    <input type="text" id="textInput" placeholder="Escribe tu texto aquí" class="form-control">

                    <div class="form-row">
                        <div class="form-col">
                            <label for="textColor">Color:</label>
                            <input type="color" id="textColor" value="#ffffff">
                        </div>
                        <div class="form-col">
                            <label for="textBgColor">Fondo:</label>
                            <input type="color" id="textBgColor" value="#00000000">
                        </div>
                    </div>

                    <label for="textSize">Tamaño: <span id="textSizeValue">24</span>px</label>
                    <input type="range" id="textSize" min="10" max="72" value="24" class="form-range">

                    <label for="textFont">Fuente:</label>
                    <select id="textFont" class="form-select">
                        <option value="Arial">Arial</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Courier New">Courier New</option>
                    </select>

                    <div class="button-group">
                        <button id="addTextBtn" class="btn-primary"><i class="fas fa-plus"></i> Agregar Texto</button>
                        <button id="clearTextBtn" class="btn-secondary"><i class="fas fa-trash"></i> Eliminar Texto</button>
                    </div>
                </div>

                <div class="control-group">
                    <h3><i class="fas fa-crop-alt"></i> Transformaciones</h3>
                    <div class="button-group">
                        <button id="rotateLeftBtn" class="btn-primary"><i class="fas fa-undo"></i> Girar Izquierda</button>
                        <button id="rotateRightBtn" class="btn-primary"><i class="fas fa-redo"></i> Girar Derecha</button>
                        <button id="flipHorizontalBtn" class="btn-secondary"><i class="fas fa-arrows-alt-h"></i> Horizontal</button>
                        <button id="flipVerticalBtn" class="btn-secondary"><i class="fas fa-arrows-alt-v"></i> Vertical</button>
                    </div>
                </div>

                <div class="control-group">
                    <h3><i class="fas fa-sliders-h"></i> Ajustes de Imagen</h3>
                    <label for="contrastRange">Contraste: <span id="contrastValue">100</span>%</label>
                    <input type="range" id="contrastRange" min="0" max="200" value="100" class="form-range">

                    <label for="brightnessRange">Brillo: <span id="brightnessValue">100</span>%</label>
                    <input type="range" id="brightnessRange" min="0" max="200" value="100" class="form-range">

                    <label for="saturationRange">Saturación: <span id="saturationValue">100</span>%</label>
                    <input type="range" id="saturationRange" min="0" max="200" value="100" class="form-range">
                </div>

                <div class="control-group">
                    <div class="button-group">
                        <button id="resetBtn" class="btn-warning"><i class="fas fa-sync-alt"></i> Reiniciar</button>
                        <button id="downloadBtn" class="btn-success"><i class="fas fa-download"></i> Descargar</button>
                    </div>
                </div>
            </div>

            <!-- Sección 3: Información del paciente -->
            <div class="info-section">
                <h2><i class="fas fa-user-injured"></i> Información del Paciente</h2>

                <div class="patient-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <form action="editar2.php" method="POST">
                            <div class="info-content">
                                <span class="info-label">ID Análisis</span>
                                <input class="input-label" name="id" value="<?php echo $radiografia['ID']; ?>" readonly>
                            </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">ID Paciente</span>
                            <span class="info-value"><?php echo $radiografia['Cedula paciente']; ?></span>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Nombre:</span>
                            <span class="info-value"><?php echo $radiografia['Nombre completo']; ?></span>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Fecha</span>
                            <span class="info-value"><?php echo $radiografia['Fecha y hora']; ?></span>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Edad</span>
                            <span class="info-value">
                                <?php
                                $fechaNacimiento = new DateTime($radiografia['Fecha_nacimiento']);
                                $hoy = new DateTime();
                                $edad = $hoy->diff($fechaNacimiento)->y;
                                echo $edad . " años";
                                ?>
                            </span>
                        </div>
                    </div>


                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Sexo</span>
                            <span class="info-value">
                                <?php
                                if ($radiografia['Genero'] == 'M') {
                                    echo "Masculino";
                                } elseif ($radiografia['Genero'] == 'F') {
                                    echo "Femenino";
                                } else {
                                    echo "Otro";
                                }
                                ?>
                            </span>
                        </div>
                    </div>

                </div>

                <button type="submit" class="button_diagnostico">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Empezar Diagnostico
                </button><br>
                </form>
                <div class="action-buttons">
                    <button class="btn-action btn-update">
                        <i class="fas fa-sync-alt"></i>
                        Actualizar Datos
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/editar3.js"></script>
</body>

</html>