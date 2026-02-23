<?php 
$id_paciente = $_POST['id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos']; 
$direccion = $_POST['direccion'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$email = $_POST['email'];   
$celular = $_POST['celular'];
$genero = $_POST['sexo'];
$sexo = $genero == 'Masculino' ? "M" : ($genero == 'Femenino' ? "F" : "O");



$categoria = $_POST['categoria'];
$zona = $_POST['zona'];
$radiografia= $_POST['radiografia'];
$observaciones = $_POST['observaciones'];
$id_paciente = $_POST['id'];


if (isset($_FILES['radiografia']) && $_FILES['radiografia']['error'] === UPLOAD_ERR_OK) {
    $nombreTmp = $_FILES['radiografia']['tmp_name'];
    $extension = pathinfo($_FILES['radiografia']['name'], PATHINFO_EXTENSION);

    // Generar nombre aleatorio
    $nombreAleatorio = bin2hex(random_bytes(10)); // o usa uniqid()
    $nombreArchivo = $nombreAleatorio . '.' . $extension;

    $directorio = '../assets/upload/';
    $rutaDestino = $directorio . $nombreArchivo;

    // Crear carpeta si no existe
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    if (move_uploaded_file($nombreTmp, $rutaDestino)) {
        $rutaImagen = $rutaDestino;
        echo "<script>console.log('Imagen subida con éxito: " . $rutaImagen . "');</script>";
    } else {
        echo "<script>console.error('Error al mover la imagen al destino');</script>";
    }
} else {
    echo "<script>console.error('No se recibió una imagen válida');</script>";
}


date_default_timezone_set('America/Lima'); 

$fechaHoraActual = date('Y-m-d H:i:s');




if (empty($id_paciente ) || empty($nombres) || empty($apellidos) || empty($direccion) || empty($fecha_nacimiento) || empty($email) || empty($celular) || empty($sexo)) {
   header("Location: examen.php?ms=Todos los campos son obligatorios&type=error");
    exit;
}else{
include_once("Cservicios.php");

$objconsulta = new cCliente();

$resultado = $objconsulta->Registrar_paciente($id_paciente,$nombres,$apellidos,$direccion,$fecha_nacimiento,$email,$celular,$sexo);

if ($resultado['success']) {

    $id_paciente_generado = $resultado['id_paciente'];

    $resultado2 = $objconsulta->Registrar_radiografia(
        $fechaHoraActual,
        $nombreArchivo,
        $observaciones,
        $zona,
        $categoria,
        $id_paciente_generado
    );

    var_dump($resultado2);

    header("Location: examen.php?ms=✅Se ha registrado correctamente&type=ok");
    exit();

} else {

    $msg = urlencode($resultado['error']);
    header("Location: examen.php?ms=$msg&type=error");
    exit();
}
}



?>