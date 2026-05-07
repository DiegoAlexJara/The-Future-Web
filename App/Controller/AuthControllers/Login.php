<?php
require "../../Classes/ConexionClass.php";

use App\Classes\Conexion;


$db = new Conexion();


session_start();

$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

// Validación de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Credenciales incorrectas";
    header("Location: . ../../../views/auth/login.php");
    exit;
}

// Buscar El Usuario
$result = $db->executeQuery(
    "SELECT * FROM users WHERE email = ? LIMIT 1",
    [$email]
);

if (empty($result)) {
    $_SESSION["error"] = "Credenciales incorrectas";
    header("Location: ../../../views/auth/login.php");
    exit;
}
$usuario = $result[0];

// 3. Validar contraseña
if (!password_verify($password, $usuario['password'])) {
    // Contraseña incorrecta
    $_SESSION['error'] = "Contraseña incorrecta";
    header("Location: ../../../views/auth/login.php");
    exit;
}

// 4. Login exitoso
$_SESSION['user_id'] = $usuario['id'];
$_SESSION['user_name'] = $usuario['name'];
header("Location: ../../../");
