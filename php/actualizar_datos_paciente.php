<?php
$Id_Paciente = $_POST['id'];
include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->Usuario_logueado();

if (empty($resultado)) {
    header("Location: ../login.html");
    exit();
}
$result = $objconsulta->Consultar_empleado($resultado);
$empleado = mysqli_fetch_array($result); 
$result_paciente = $objconsulta->Consultar_paciente($Id_Paciente);
$paciente = mysqli_fetch_array($result_paciente);

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
            <h1>Foemulario de Actualizacion de paciente</h1>
            <p>Complete la información del paciente</p>
        </div>

        <form action="actualizar_datos_paciente2.php" method="post" class="patient-form" enctype="multipart/form-data">
            <h2 class="form-title">Información del Paciente</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="id">Identificación</label>
                    <input id="id" name="id" type="number" value="<?php echo htmlspecialchars($paciente['Id_paciente']); ?>" list="pacieenteList" readonly>
                </div>

                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input id="nombres" name="nombres" value="<?php echo htmlspecialchars($paciente['Nombres']); ?>" type="text" required>
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($paciente['Apellidos']); ?>" type="text" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input id="direccion" name="direccion" value="<?php echo htmlspecialchars($paciente['Direccion']); ?>" type="text" required>
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($paciente['Fecha_nacimiento']); ?>" type="date" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" value="<?php echo htmlspecialchars($paciente['Email']); ?>" type="email"  required>
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input id="celular" name="celular" value="<?php echo htmlspecialchars($paciente['Celular']); ?>" type="number" required>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="M" <?php echo ($paciente['Genero'] === 'M') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="F" <?php echo ($paciente['Genero'] === 'F') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="O" <?php echo ($paciente['Genero'] === 'O') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>

            </div>

            

            <div class="form-actions">
                <button type="submit" class="btn btn-save" >
                    <i class="fas fa-save"></i> Actualizar Datos Paciente
                </button>

            </div>
        </form>
    </main>
    <div class="notification" id="notification" style="display: none;">
        <span id="notification-message"></span>
        <span class="close" onclick="closeNotification()">&times;</span>
    </div>

    <script src="../assets/js/examen.js"></script>
</body>
</html>