<?php


use App\Classes\Conexion;

require "../../Classes/ConexionClass.php";

$db = new Conexion();

$id       = $_POST['id'] ?? null;
$name     = $_POST['name'] ?? null;
$email    = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$passwordConfirm = $_POST['passwordConfirm'] ?? null;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    $_SESSION["error"] = "Error En El Servidor";
    header("Location: ../../../");
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

date_default_timezone_set('America/Mexico_City');
$time = date('Y-m-d H:i:s');

// Si el usuario cambia la contraseña, aplicar la lógica correspondiente
if (!empty($password) || !empty($passwordConfirm)) {
    if ($password !== $passwordConfirm) {

        $_SESSION['toast'] = [
            "status" => "error",
            "message" => "Error al Crear el registro"
        ];
        header("Location: ../../../views/users/update.php?id=$id");
        exit;
        return;
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



    $db->executeQuery(
        "UPDATE users SET name = ?, email = ?, password = ?, update_time = ? WHERE id = ?",
        [$name, $email, $hash, $time, $id]
    );

    // Mandar una notificacion para decir el message
    $_SESSION['toast'] = [
        "status" => "success",
        "message" => "Registro Actualizado Correctamente"
    ];
    header("Location: ../../../");
    exit;
}
// Si el usuario no cambia la contraseña, aplicar la lógica correspondiente
$db->executeQuery(
    "UPDATE users SET name = ?, email = ?, update_time = ? WHERE id = ?",
    [$name, $email, $time, $id]
);

// Mandar una notificacion para decir el message
$_SESSION['toast'] = [
    "status" => "success",
    "message" => "Registro Actualizado Correctamente"
];
header("Location: ../../../");
