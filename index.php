<?php

// Middleware de verificación de inicio de sesión
require_once __DIR__ . "/App/Middleware/Auth.php";
Auth::handle();

include 'App/Helpers/toast.php';

// Conexion a la BDD
use App\Classes\Conexion;

require_once "App/Classes/ConexionClass.php";
$db = new Conexion();

// Parámetros de búsqueda
$busqueda = $_GET['q'] ?? "";

// Parámetros de paginación
$registrosPorPagina = 5;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) $paginaActual = 1;

$offset = ($paginaActual - 1) * $registrosPorPagina;

// Construir consulta dinámica
$where = "";
$params = [];

if (!empty($busqueda)) {
    $where = "WHERE name LIKE ? OR email LIKE ?";
    $like = "%$busqueda%";
    $params = [$like, $like];
}

// Consulta de conteo
if (!empty($busqueda)) {
    $totalQuery = $db->executeQuery("SELECT COUNT(*) AS total FROM users $where", $params);
} else {
    $totalQuery = $db->executeQuery("SELECT COUNT(*) AS total FROM users");
}

$total = $totalQuery[0]['total'];
$totalPaginas = ceil($total / $registrosPorPagina);

// Consulta paginada con búsqueda
if (!empty($busqueda)) {
    $params[] = $registrosPorPagina;
    $params[] = $offset;
    $sql = "SELECT * FROM users $where LIMIT ? OFFSET ?";
    $usuarios = $db->executeQuery($sql, $params);
} else {
    $usuarios = $db->executeQuery(
        "SELECT * FROM users LIMIT ? OFFSET ?",
        [$registrosPorPagina, $offset]
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include 'views/layouts/head.php';
    ?>

    <title>INICIO</title>

</head>

<body class="bg-light">

    <?php include 'views/layouts/nav-bar.php' ?>

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-2">
                    <h2 class="fw-bold text-center text-md-start">Usuarios</h2>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="views/users/create.php" class="btn btn-success"><i class="fa-solid fa-user-plus"></i> Crear Usuario</a>
                    </div>
                    <form class="d-flex mb-3" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input
                                type="search"
                                name="q"
                                class="form-control"
                                placeholder="Buscar por nombre, email o rol..."
                                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive shadow-sm bg-white rounded">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Contraseña</th>
                                <th>Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($usuarios): ?>
                                <?php foreach ($usuarios  as $fila): ?>
                                    <tr>
                                        <td><?= $fila['id'] ?></td>
                                        <td><?= $fila['name'] ?></td>
                                        <td><?= $fila['email'] ?></td>
                                        <td> ***************** </td>
                                        <td><?= $fila['creation_time'] ?></td>
                                        <td>
                                            <a href="views/users/update.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></a>
                                            <form action="App/Controller/UsersControllers/delete.php" method="POST" style="display:inline;" id="deleteForm-<?= $fila['id'] ?>">
                                                <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                                                <button type="button" class="btn btn-sm btn-danger btnDelete" data-id="<?= $fila['id'] ?>">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>


                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- Botón Anterior -->
            <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>">Anterior</a>
            </li>

            <!-- Números -->
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Botón Siguiente -->
            <li class="page-item <?= ($paginaActual >= $totalPaginas) ? 'disabled' : '' ?>">
                <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
            </li>
        </ul>
    </nav>

    <?php showToast(); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="public/assets/js/delete.js"></script>

</body>

</html>