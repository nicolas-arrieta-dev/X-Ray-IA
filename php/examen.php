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
$result_categoria = $objconsulta->Mostrar_todo_categoria();
$result_zona = $objconsulta->Mostrar_todo_zona();


$empleado = mysqli_fetch_array($result); // Almacenar el resultado en una variable

$result_paciente = $objconsulta->Consultar_todo_paciente();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-RAY DIAGNOSTIC - Examen Médico</title>
    <link rel="shortcut icon" href="../assets/img/logo_icono_x_ray.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/Style/examen.css">
</head>

<body>
    <header class="main-header">
        <div class="logo-container" style="max-width: 100px;">
            <a href="examen.php">
                <img src="../assets/img/logo_x_ray.png" alt="X-RAY DIAGNOSTIC" class="logo" style="max-width: 100%; height: auto;">
            </a>
        </div>
        </div>
        <nav class="top-nav" style="display: flex; gap: 10px;">
            <a href="examen.php" class="nav-item active">
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
                <span><?php echo htmlspecialchars($empleado['Nombre'] . " " . $empleado['Apellido']); ?></span>
                <div class="status-indicator"></div>
            </div>
        </div>

        <button class="hamburger-btn" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
        </div>
    </header>


    <!-- Menú lateral (aparece en móvil) -->
    <nav class="sidebar-nav">
        <ul>
            <li class="active"><a href="examen.php"><i class="fas fa-file-medical"></i> EXAMEN</a></li>
            <li><a href="consultar.php"><i class="fas fa-search"></i> CONSULTAR</a></li>
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
            <h1>Registro de Examen Médico</h1>
            <p>Complete la información del paciente y suba la imagen para diagnóstico</p>
        </div>

        <form action="registrar_paciente.php" method="post" class="patient-form" enctype="multipart/form-data">
            <h2 class="form-title">Información del Paciente</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="id">Identificación</label>
                    <input id="id" name="id" type="number" list="pacieenteList" required>
                    <datalist id="pacieenteList">
                        <?php while ($paciente = mysqli_fetch_assoc($result_paciente)) : ?>
                            <option value="<?php echo htmlspecialchars($paciente['Id_paciente'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($paciente['Nombres'] . ' ' . $paciente['Apellidos'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>

                    </datalist>
                </div>

                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input id="nombres" name="nombres" type="text" required>
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input id="apellidos" name="apellidos" type="text" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input id="direccion" name="direccion" type="text" required>
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required>
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input id="celular" name="celular" type="number" required>
                </div>

                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input id="edad" name="edad" type="number" readonly required>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>

                    <select id="categoria" name="categoria">
                        <?php while ($categoria = mysqli_fetch_assoc($result_categoria)) : ?>
                            <option value="<?php echo htmlspecialchars($categoria['Id_categoria'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($categoria['Nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="zona">Zona</label>

                    <select id="zona" name="zona">
                        <?php while ($zona = mysqli_fetch_assoc($result_zona)) : ?>
                            <option value="<?php echo htmlspecialchars($zona['Id_zona'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($zona['Nombre_zona'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="estudio">Estudio</label>
                    <select id="estudio" name="estudio">
                        <option value="Analitico">Analítico</option>
                    </select>
                </div>
            </div>

            <div class="image-upload-section">
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/icono_archivo_DICOM.png" alt="Icono DICOM" class="dicom-icon">
                    <img id="previewImage" src="" alt="Vista previa" class="preview-image">
                </div>

                <div class="upload-controls">
                    <label for="fileUpload" class="file-upload-btn">
                        <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo
                    </label>
                    <input name="radiografia" type="file" id="fileUpload" accept="image/png, image/jpeg, image/jpg, image/gif">
                    <span id="fileName" class="file-name"></span>
                    <button type="button" id="removeImageBtn" class="remove-image-btn" style="display: none;">
                        <i class="fas fa-trash-alt"></i> Eliminar imagen
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i> GUARDAR
                </button>
            </div>
        </form>
    </main>
    <div class="notification" id="notification" style="display: none;">
        <span id="notification-message"></span>
        <span class="close" onclick="closeNotification()">&times;</span>
    </div>

    <script src="../assets/js/examen.js"></script>
    <script>
        const pacientes = <?php
                            mysqli_data_seek($result_paciente, 0); // Reiniciar puntero
                            $paciente_data = [];
                            while ($p = mysqli_fetch_assoc($result_paciente)) {
                                $paciente_data[$p['Id_paciente']] = [
                                    'nombres' => $p['Nombres'],
                                    'apellidos' => $p['Apellidos'],
                                    'direccion' => $p['Direccion'],
                                    'fecha_nacimiento' => $p['Fecha_nacimiento'],
                                    'email' => $p['Email'],
                                    'celular' => $p['Celular'],
                                    'sexo' => $p['Genero'],
                                ];
                            }
                            echo json_encode($paciente_data, JSON_UNESCAPED_UNICODE);
                            ?>;
    </script>

</body>

</html>