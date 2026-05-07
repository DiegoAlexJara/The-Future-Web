<?php

// Conexion a la BDD
use App\Classes\Conexion;
require "../../Classes/ConexionClass.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../../../");
    exit;
}

$db = new Conexion();
$id = $_POST["id"] ?? '';

// DELETE FROM users WHERE id = 5;

$db->executeQuery(
    "DELETE FROM users WHERE id = ?",
    [$id]
);

// Mandar una notificacion para decir el message
$_SESSION['toast'] = [
        "status" => "success",
        "message" => "Registro Se Ha Eliminado Correctamente"
    ];
header("Location: ../../../");
exit;
