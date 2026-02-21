<?php
include_once("Cservicios.php");
$id_radiografia = $_POST['id'];
$objconsulta = new cCliente;
$directorio = '../assets/upload';
$resultado2 = $objconsulta->Buscar_ArchivoRadiografia($id_radiografia);
if ($resultado2 && $fila = $resultado2->fetch_assoc()) {

    $nombreArchivo = $fila['Archivo_Radiografia'];

    $rutaArchivo = __DIR__ . '/../assets/upload/' . $nombreArchivo;

    if (file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }
}
$resultado = $objconsulta->Eliminar_Radiografia($id_radiografia);
if ($resultado) {
    echo 'ok';
} else {
    echo 'error';
}
?>
