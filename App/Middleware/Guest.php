<?php

class GuestMiddleware
{
    public static function handle()
    {
        session_start();

        // Si ya existe sesión, redirige al dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location: /CRUD/");
            exit;
        }

        // Si no hay sesión, continúa normalmente (puede ver login/registro)
    }
}
