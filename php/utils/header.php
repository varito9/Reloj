<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Zafiro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../scss/custom.css">

</head>

<body class ="bg-claro">
  <header class="bg-white shadow py-2">
    <nav class="navbar navbar-expand-lg bg-white">
      <div class="container-fluid">
        <a class="navbar-brand cyan-900  px-5" href="../index.php">ZAFIRO</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class=" poppins collapse navbar-collapse justify-content-between" id="navbarContent">
          <div class="navbar-nav d-flex gap-4 mt-4 mt-lg-0">
            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            $menuItems = [
              'noticias.php' => 'NOTICIAS',
              'relojes.php' => 'RELOJES',
              'joyeria.php' => 'JOYERÍA',
              'servicio.php' => 'SERVICIO',
            ];
            foreach ($menuItems as $file => $name): ?>
              <a   href="../secciones/<?= $file ?>"
                class="nav-link <?= $currentPage == $file ? 'text-decoration-underline text-dark' : 'text-dark' ?>">
                <?= $name ?>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="dropdown mt-4 mt-lg-0">
            <a class="nav-link dropdown-toggle oro d-flex align-items-center me-4" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-person me-2"></i>
              <span class="text-dark poppins">CUENTA</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if (isset($_SESSION['usuario'])): ?>
                <li><a class="dropdown-item" href="#">Hola, <?= htmlspecialchars($_SESSION['usuario']) ?></a></li>
                <li><a class="dropdown-item" href="../utils/logout.php">Cerrar sesión</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="../utils/login.php">Iniciar sesión</a></li>
                <li><a class="dropdown-item" href="../utils/registro.php">Registrarse</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
