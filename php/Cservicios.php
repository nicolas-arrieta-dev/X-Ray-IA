<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['k_id'])) {
    $id = $_SESSION['k_id'];
} else {
    //echo "Las variables de sesión no están establecidas.";
}
class cCliente {
    public $id;
    public function __construct() {
        global $id;
        $this->id_para_todo = $id;
    }

    public function obtenerIdParaTodo() {
        return $this->id_para_todo;
    }
  private function createConnection() {
    $conexion = new mysqli("127.0.0.1", "root", "", "x-ray");
    if ($conexion->connect_error) {
      die("Conexión fallida: " . $conexion->connect_error);
    }
    return $conexion;
  }

  function Usuario_logueado(){
    global $id;
    if (isset($id)) {
      return $id;
    } else {
      return false;
    }
  }

  function verificar_usuario($id_empleado, $password) {
    $conexion = $this->createConnection();
    $sql = "CALL verificar_usuario(?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $id_empleado, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
    }

  function consultar_todo_diagnosticos() {
    $conexion = $this->createConnection();
    $sql = "SELECT * FROM diagnostico";
    $rec = mysqli_query($conexion, $sql);
    return $rec;
  }
function cerrar_session(){
    global $id;
    $id = 0;
    session_start();
    session_destroy();
    header("Location: ../index.html");
    exit();
    return true;
}

function Consultar_empleado($id_empleado){
    $conexion = $this->createConnection();
    $sql = "CALL Consultar_empleado(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}

function Consultar_todo_paciente(){
  $conexion = $this->createConnection();
  $sql = "CALL Consultar_todo_paciente()";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();
  $resultado = $stmt->get_result();
  return $resultado;
}
function Registrar_paciente($id_paciente, $nombres, $apellidos, $direccion, $fecha_nacimiento, $email, $celular, $sexo) {
    $conexion = $this->createConnection();
    $sql = "CALL Registrar_paciente(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isssssss", $id_paciente, $nombres, $apellidos, $direccion, $fecha_nacimiento, $email, $celular, $sexo);

    try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => 'La Radiografia se ha registrado correctamente'];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}

function Mostrar_todo_categoria(){
  $conexion = $this->createConnection();
  $sql = "CALL Mostrar_todo_categoria()";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();
  $resultado = $stmt->get_result();
  return $resultado;
}
function Mostrar_todo_zona(){
  $conexion = $this->createConnection();
  $sql = "CALL Mostrar_todo_zona()";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();
  $resultado = $stmt->get_result();
  return $resultado;
}
function Registrar_radiografia($fechaHoraActual,$nombreArchivo, $observaciones, $zona, $categoria, $id_paciente){
   global $id; 
    $conexion = $this->createConnection();
    $sql = "CALL Registrar_radiografia(?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssss", $fechaHoraActual,$nombreArchivo, $observaciones, $zona, $categoria, $id, $id_paciente);
        try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => ''];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}
function Mostrar_todo_radiografia(){
    $conexion = $this->createConnection();
    $sql = "CALL Mostrar_todo_radiografia()";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}
function Consultar_radiografia($ID_Radiografia){
    $conexion = $this->createConnection();
    $sql = "CALL Consultar_radiografia(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $ID_Radiografia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}

function Mostrar_todo_patologia(){
    $conexion = $this->createConnection();
    $sql = "CALL Mostrar_todo_patologia()";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}

function Registrar_diagnostico($descripcion,$nivel_gravedad,$porcentaje, $tipo_de_fractura, $fecha_hora, $id_r, $id_patologia){
    $conexion = $this->createConnection();
    $sql = "CALL Insertar_diagnostico(?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssss", $descripcion,$nivel_gravedad,$porcentaje, $tipo_de_fractura, $fecha_hora, $id_r, $id_patologia);
            try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => ''];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}


function Registrar_patologia($nombre_patologia, $tipo_patologia, $descripcion_patologia){
    $conexion = $this->createConnection();
    $sql = "CALL Insertar_patologia(?, ?, ?)";
    $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $nombre_patologia, $tipo_patologia, $descripcion_patologia);
            try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => ''];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}
function Eliminar_patologia($id_patologia){
    $conexion = $this->createConnection();
    $sql = "CALL Eliminar_patologia(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $id_patologia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $id_patologia;
}
function  Actualizar_empleado($nombre, $apellido, $direccion, $email, $celular, $especialidad, $pass, $nombreArchivo){
    global $id;
    $conexion = $this->createConnection();
    $sql = "CALL Actualizar_Empleado(? ,?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("issssssss", $id, $nombre, $apellido, $direccion, $email, $celular, $especialidad, $pass, $nombreArchivo);
    
    try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => ''];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}
function Mostrar_todo_diagnosticos(){
    $conexion = $this->createConnection();
    $sql = "CALL Mostrar_todo_diagnostico()";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}
function Eliminar_Diagnostico($id_diagnostico){
    $conexion = $this->createConnection();
    $sql = "CALL Eliminar_Diagnostico(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_diagnostico);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
   
}

function Consultar_diagnostico($id_diagnostico){
    $conexion = $this->createConnection();
    $sql = "CALL Consultar_diagnostico(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_diagnostico);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}

function Actualizar_diagnostico($id_r, $id_patologia, $descripcion, $nivel_gravedad){
    $conexion = $this->createConnection();
    $sql = "CALL Actualizar_diagnostico(?, ?, ?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss",   $id_r, $id_patologia, $descripcion, $nivel_gravedad);
    
    try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => ''];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}
Function Buscar_ArchivoRadiografia($id_radiografia){
    $conexion = $this->createConnection();
    $sql = "CALL Consultar_ArchivoRadiografia(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_radiografia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}

Function Eliminar_Radiografia($id_radiografia){
 $conexion = $this->createConnection();
    $sql = "CALL Eliminar_Radiografia(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_radiografia);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
Function Consultar_paciente($Id_Paciente){
    $conexion = $this->createConnection();
    $sql = "CALL Consultar_Paciente(?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $Id_Paciente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}

Function Actualizar_Paciente($id_paciente, $nombres, $apellidos, $direccion, $fecha_nacimiento, $email, $celular, $genero){ 
    $conexion = $this->createConnection();
    $sql = "CALL Actualizar_Paciente(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isssssss", $id_paciente, $nombres, $apellidos, $direccion, $fecha_nacimiento, $email, $celular, $genero);

    try {
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Error al ejecutar el procedimiento'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            return ['success' => false, 'error' => 'El Paciente ya está registrado'];
        } else {
            return ['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()];
        }
    }
}
}
?>