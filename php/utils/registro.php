<?php
session_start();
require_once 'conexion.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $pass1 = $_POST['contraseña'];
    $pass2 = $_POST['confirmar'];

    // Validaciones básicas
    if (empty($usuario) || empty($email) || empty($pass1) || empty($pass2)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } elseif ($pass1 !== $pass2) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Comprobar si el usuario o correo ya están registrados
        $stmt = $conn->prepare("SELECT id FROM USUARIOS WHERE email = ? OR usuario = ?");
        $stmt->bind_param("ss", $email, $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ahora determinamos cuál está duplicado
            $stmtCheck = $conn->prepare("SELECT usuario, email FROM USUARIOS WHERE email = ? OR usuario = ?");
            $stmtCheck->bind_param("ss", $email, $usuario);
            $stmtCheck->execute();
            $resultado = $stmtCheck->get_result();
            $fila = $resultado->fetch_assoc();

            if ($fila['email'] === $email) {
                $error = "Este correo electrónico ya está registrado.";
            } elseif ($fila['usuario'] === $usuario) {
                $error = "Este nombre de usuario ya está en uso.";
            } else {
                $error = "Este usuario o correo ya están registrados.";
            }

            $stmtCheck->close();
        } else {
            // Insertar usuario
            $hashedPassword = password_hash($pass1, PASSWORD_DEFAULT);

            $insertStmt = $conn->prepare("INSERT INTO USUARIOS (usuario, email, contraseña) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sss", $usuario, $email, $hashedPassword);

            if ($insertStmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error al registrar el usuario.";
            }
            $insertStmt->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrarse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../scss/custom.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h3 class="text-center mb-3">Crear cuenta</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Nombre de usuario</label>
                <input type="text" name="usuario" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contraseña" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="confirmar" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-oro-100 w-100">Registrarme</button>
            <p class="text-center mt-3">
                <a href="login.php" class="oro">¿Ya tienes cuenta? Inicia sesión</a>
            </p>
        </form>
    </div>
</div>

</body>
<?php include 'header.php'; ?> 

</html>
