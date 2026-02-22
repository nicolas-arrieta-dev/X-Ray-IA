<?php 
session_start();

/* ==========================
   VALIDACIÓN DE reCAPTCHA
   ========================== */

$secretKey = "6Le_knQsAAAAAMMRJeFMwLHNwFd4HF1bhKI1XIlO"; // ← pon aquí tu clave secreta real

if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
    header("Location: ../login.html?error=captcha");
    exit;
}

$response = $_POST['g-recaptcha-response'];
$verifyURL = "https://www.google.com/recaptcha/api/siteverify";

$data = [
    'secret' => $secretKey,
    'response' => $response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];

$context  = stream_context_create($options);
$verify = file_get_contents($verifyURL, false, $context);
$responseData = json_decode($verify);

if (!$responseData->success) {
    header("Location: ../login.html?error=captcha");
    exit;
}

/* ==========================
   TU LÓGICA ORIGINAL (NO TOCADA)
   ========================== */

$id_empleado = $_POST['id_empleado'];
$password = $_POST['password'];

include_once("Cservicios.php");
$objconsulta = new cCliente;
$resultado = $objconsulta->verificar_usuario($id_empleado, $password);

if ($resultado && $resultado->num_rows > 0) {
    $row = mysqli_fetch_array($resultado); 

    if ($row) {
        $_SESSION['k_id'] = $row['Cedula']; 
        $resultado = $objconsulta->verificar_usuario($id_empleado, $password);
        header("Location: examen.php");
    } else {
        header("Location: ../login.html?error=1");
        exit;
    }

} else {
    header("Location: ../login.html?error=1");
    exit;
}
?>
