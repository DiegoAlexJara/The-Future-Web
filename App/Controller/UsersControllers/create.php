<?php

use App\Classes\Conexion;

require "../../Classes/ConexionClass.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    $_SESSION["error"] = "Error En El Servidor";
    header("Location: ../../../views/users/create.php");
    exit;
    return;
}

$db = new Conexion();

$name = $_POST["name"] ?? '';
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';
$passwordConfirm = $_POST["passwordConfirm"] ?? '';

// Funcion para validar la contraseña 
$error = validatePassword($password);

if (!empty($error)) {
    $_SESSION['toast'] = [
        "status" => "error",
        "message" => "Error Al Crear Contraseña"
    ];
    header("Location: ../../../views/users/create.php");
    exit;
}

if ($password !== $passwordConfirm) {

    $_SESSION['toast'] = [
        "status" => "error",
        "message" => "Error al Crear el registro"
    ];
    header("Location: ../../../views/users/create.php");
    exit;
}

// Validación de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['toast'] = [
        "status" => "error",
        "message" => "Correo Invalido"
    ];
    header("Location: ../../../views/users/create.php");
    exit;
}

// Validación de password
$lengthValid = strlen($password) >= 8;
$uppercaseValid = preg_match("/[A-Z]/", $password);
$lowercaseValid = preg_match("/[a-z]/", $password);
$numberValid = preg_match("/[0-9]/", $password);
$specialValid = preg_match("/[\W_]/", $password);

if (!($lengthValid && $uppercaseValid && $lowercaseValid && $numberValid && $specialValid)) {
    $_SESSION['toast'] = [
        "status" => "error",
        "message" => "Contraseña Invalida"
    ];
    header("Location: ../../../views/users/create.php");
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

date_default_timezone_set('America/Mexico_City'); 
$time = date('Y-m-d H:i:s');

// Insertar Datos en La BDD con el comando Insert
$db->executeQuery(
    "INSERT INTO users (name, email, password, creation_time)
            VALUES (?, ?, ?, ?)",
    [$name, $email, $hash, $time]
);

$_SESSION['success'] = "Registro Creado Correctamente";
header("Location: ../../../views/auth/login.php");

function validatePassword($password)
{
    $errores = [];

    if (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errores[] = "Debe contener al menos una letra mayúscula.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errores[] = "Debe contener al menos una letra minúscula.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errores[] = "Debe contener al menos un número.";
    }
    if (!preg_match('/[\W]/', $password)) {
        $errores[] = "Debe contener al menos un carácter especial.";
    }

    return $errores;
}
