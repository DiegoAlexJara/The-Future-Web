<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Nombre -->
    <a class="navbar-brand" href="#">The Future Web</a>

    <!-- Botón toggle para móviles -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Botón Home centrado -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/CRUD">Home</a>
        </li>
      </ul>

      <!-- Dropdown a la derecha -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Opciones
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="App/Controller/AuthControllers/Logout.php">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
