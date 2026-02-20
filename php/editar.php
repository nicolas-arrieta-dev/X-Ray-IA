<?php
include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->Usuario_logueado();
$result = $objconsulta->Consultar_empleado($resultado);

if (empty($resultado)) {
    header("Location: ../login.html");
    exit();
}

$nombre_empleado = '';
$empleado = mysqli_fetch_array($result);
$nombre_empleado = $empleado['Nombre'] . " " . $empleado['Apellido'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-RAY DIAGNOSTIC - Editar Diagnóstico</title>
    <link rel="shortcut icon" href="./assets/img/logo_icono_x_ray.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/Style/editar.css">
    <link rel="shortcut icon" href="../assets/img/logo_icono_x_ray.png" type="image/png">


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
                <span><?php echo $nombre_empleado; ?></span>
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
            <p>Ingrese el ID del diagnostico para acceder y modificar los diagnósticos existentes</p>
        </div>

        <div class="diagnostic-container">
            <div class="form-section">
                <h2>Ingrese el ID del Diagnóstico</h2>
                <form action="editar3.php" method="POST">
                    <div class="input-group">
                        <input type="text" name="id" placeholder="Id del diagnóstico" required>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> Buscar Diagnóstico
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
<div class="notification" id="notification" style="display: none;">
    <span id="notification-message"></span>
    <span class="close" onclick="closeNotification()">&times;</span>
</div>

<script src="../assets/js/editar.js"></script>

</html>