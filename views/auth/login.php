<?php

// Middleware de verificación de inicio de sesión
require_once __DIR__ . "../../../App/Middleware/Guest.php";

GuestMiddleware::handle();
?>

<!DOCTYPE html>
<html lang="en">


<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../layouts/head.php'; ?>
    <title>INICIO</title>
</head>

<body>
    <div class="d-flex flex-column min-vh-100 bg-light">

        <!-- Contenido principal -->
        <main class="flex-grow-1 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                        <div class="text-center mb-4">
                            <img src="../../public/assets/img/Usuario.png" alt="Usuario" class="img-fluid" width="150">
                            <h2 class="mt-3">INICIO DE SESIÓN</h2>
                        </div>

                        <form method="post" action="../../App/Controller/AuthControllers/Login.php" class="p-3 p-md-4 border rounded bg-white shadow-sm">
                            <div class="mb-3">
                                <label class="form-label">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" id="icono">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                            <?php if (isset($_SESSION["error"])): ?>
                                <div class="alert alert-danger text-center">
                                    <?= $_SESSION["error"]; ?>
                                </div>
                                <?php unset($_SESSION["error"]); ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION["success"])): ?>
                                <div class="alert alert-success text-center">
                                    <?= $_SESSION["success"]; ?>
                                </div>
                                <?php unset($_SESSION["success"]); ?>
                            <?php endif; ?>

                            <button type="submit" class="btn btn-primary w-100">INGRESAR</button>
                        </form>

                        <div class="text-center mt-3">
                            ¿No tienes cuenta? <a href="../users/create.php">REGISTRARSE</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class=" text-dark pt-4 pb-2 mt-auto">
            <div class="container">
                <div class="text-center border-top border-secondary pt-3">
                    <small>
                        &copy; 2026 Diego Alejandro Jaramillo. Todos los derechos
                    </small>
                </div>
            </div>
        </footer>


        <script src="../../public/assets/js/pasword.js"></script>
</body>

</html>