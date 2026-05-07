<?php

class Auth
{

    public static function handle()
    {
        session_start();
        // Verifica si existe la variable de sesión 'user_id'
        if (!isset($_SESSION['user_id'])) {
            // Si no hay sesión, redirige al login
            $_SESSION['error'] = "Debes iniciar sesión para continuar";
            header("Location: views/auth/login.php");
            exit;
        }

        // Si la sesión existe, continúa con la ejecución normal
    }
}
