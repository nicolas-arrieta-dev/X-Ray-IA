<?php
include_once("Cservicios.php");
$id_paciente = $_POST['id'];
$objconsulta = new cCliente;
$resultado = $objconsulta->Eliminar_Paciente($id_paciente);
if ($resultado) {
    echo 'ok';
} else {
    echo 'error';
}
?>