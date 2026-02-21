<?php 
$id_paciente = $_POST['id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos']; 
$direccion = $_POST['direccion'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$email = $_POST['email'];   
$celular = $_POST['celular'];
$genero = $_POST['sexo'];




date_default_timezone_set('America/Lima'); 

$fechaHoraActual = date('Y-m-d H:i:s');





include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->Actualizar_Paciente($id_paciente, $nombres, $apellidos, $direccion, $fecha_nacimiento, $email, $celular, $genero);
var_dump($resultado2);



if ($resultado['success']) {
    header("Location: consultar.php?ms=✅Se ha actualizado correctamente los datos&type=ok");
} else {
    $msg = urlencode($resultado['error']); 
    header("Location: consultar.php?ms=$msg&type=error");
}




?>