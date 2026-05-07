<?php

// Middleware de verificación de inicio de sesión
require_once __DIR__ . "../../../App/Middleware/Auth.php";
Auth::handle();

// Conexion a la BDD
use App\Classes\Conexion;
require "../../App/Classes/ConexionClass.php";
$db = new Conexion();

// Helper de notificaciones
include '../../App/Helpers/Toast.php';

if ($_SERVER["REQUEST_METHOD"] !== "GET") {

    $_SESSION["error"] = "Error En El Servidor";
    header("Location: ../../");
    exit;
}

if (!$_GET['id']) {
    $_SESSION["error"] = "Error En El Servidor";
    header("Location: ../../");
    exit;
}

$id = $_GET['id'] ?? null;

// Comando SQL para buscar usuario
$stmt = $db->executeQuery("SELECT * FROM users WHERE id = ?", [$id]);

if (empty($stmt)) {
    $_SESSION["error"] = "Error En El Servidor";
    header("Location: ../../");
    exit;
}

$resultado = $stmt[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include '../layouts/head.php';
    ?>

    <title>ACTUALIZAR USUARIO</title>
</head>

<body class="bg-light">

    <?php include '../layouts/nav-bar.php' ?>

    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height:90vh;">
        <div class="row w-100 justify-content-center align-items-center">

            <!-- 🖼️ IMAGEN (solo en pantallas medianas en adelante) -->
            <div class="col-md-5 col-lg-4 d-none d-md-flex justify-content-end align-items-center">
                <img src="../../public/assets/img/creacion.png" alt="Usuario trabajando"
                    class="img-fluid" style="max-height: 500px;">
            </div>

            <!-- 🧩 FORMULARIO -->
            <div class="col-12 col-md-7 col-lg-5 d-flex justify-content-center align-items-center">
                <form method="post" action="../../App/Controller/UsersControllers/update.php"
                    class="p-1 w-100"
                    style="max-width: 550px;">

                    <h2 class="mb-4 text-center">Actualizar Usuario</h2>

                    <input type="hidden" id="formAction" value="  ">
                    <input type="hidden" name="id" value="<?= $resultado['id'] ?>">

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                            <input type="text" class="form-control" name="name" placeholder="Nombre" value="<?= $resultado['name'] ?>" required>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" value="<?= $resultado['email'] ?>" required>
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="********">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" id="icono">
                                <i class="fa-regular fa-eye-slash"></i>
                            </button>
                            <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Debe tener mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial (!@#$%^&*)">?</span>
                        </div>
                    </div>

                    <!-- Feedback dinámico -->
                    <div id="feedback" class="mt-2 d-none">
                        <p id="length" class="invalid">Mínimo 8 caracteres</p>
                        <p id="uppercase" class="invalid">1 Letra mayúscula</p>
                        <p id="lowercase" class="invalid">1 Letra minúscula</p>
                        <p id="number" class="invalid">1 número</p>
                        <p id="special" class="invalid">1 carácter especial (!@#$%^&*)</p>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" placeholder="********">
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleConfirmPassword()" id="icono1">
                                <i class="fa-regular fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mensajes de error -->
                    <?php if (isset($_SESSION["error"])): ?>
                        <div class="alert alert-danger text-center">
                            <?= $_SESSION["error"]; ?>
                        </div>
                        <?php unset($_SESSION["error"]); ?>
                    <?php endif; ?>

                    <!-- Botón -->
                    <button type="submit" id="submitBtn" class="btn btn-primary w-100" style="height: 50px;">
                        ACTUALIZAR USUARIO
                    </button>

                    <!-- Link -->
                    <div class="text-center mt-3">
                        <a href="../../"> REGRESAR</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php showToast(); ?>
    <script src="../../public/assets/js/pasword.js"></script>

</body>

</html>