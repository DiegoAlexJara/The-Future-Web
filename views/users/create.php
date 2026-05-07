<?php

include '../../App/Helpers/Toast.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include '../layouts/head.php';
    ?>

    <title>AÑADIR USUARIO</title>
</head>


<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img src="../../public/assets/img/Usuario.png" alt="Usuario" class="img-fluid" width="150">
                    <h2 class="mt-3">CREAR USUARIO</h2>
                </div>

                <form method="post" action="../../App/Controller/UsersControllers/create.php" class="p-3 p-md-4 border rounded bg-white shadow-sm">

                    <input type="hidden" id="formAction" value="create">

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                            <input type="text" class="form-control" name="name" placeholder="Nombre" required>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
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
                    <button type="submit" id="submitBtn" class="btn btn-primary w-100" style="height: 50px;" disabled>
                        CREAR USUARIO
                    </button>


                </form>

                <!-- Link -->
                <div class="text-center mt-3">
                    ¿Ya tienes cuenta? <a href="../auth/login.php">Iniciar sesión</a>
                </div>

            </div>
        </div>
    </div>



    <?php showToast(); ?>
    <script src="../../public/assets/js/pasword.js" defer></script>
</body>


</html>