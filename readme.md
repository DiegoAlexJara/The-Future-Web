# Nombre del Proyecto
Breve descripción de lo que hace tu aplicación y su propósito.

Esta aplicacion es una gestion de usuarios con un CRUD (Create, Read, Update, Delete), desarrollado en PHP,
con integración de MySQL/MariaDB y una interfaz moderna basada en Bootstrap 5. El objetivo es demostrar 
buenas prácticas de programación, modularidad y seguridad en un entorno realista de gestión de usuarios.

## Características
- Registro y login de usuarios
- Validación dinámica de contraseñas con tooltips
- CRUD completo (crear, listar, actualizar, eliminar)
- Buscador + paginación
- Toasts para feedback visual
- Bootstrap UI responsiva

## Requisitos
- PHP 8+
- MySQL/MariaDB
- XAMPP o similar


## Instalación
1. Clonar el repositorio:
   git clone https://github.com/usuario/proyecto.git

2. Crear la base de datos:
   - Abrir phpMyAdmin
   - Crear base de datos `crud_users`
   - Importar el archivo `database.sql`

3. Configurar conexión:
   - Editar `App/Helpers/db.php` con tus credenciales