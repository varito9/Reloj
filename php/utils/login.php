<?php
session_start();
require_once 'conexion.php';

$login = $password = "";
$errorLogin = $errorPassword = $mensajeError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    // Validar campos vacíos
    if (empty($login)) {
        $errorLogin = "Por favor, ingresa tu usuario o correo.";
    }

    if (empty($password)) {
        $errorPassword = "Por favor, ingresa tu contraseña.";
    }

    if (empty($errorLogin) && empty($errorPassword)) {
        // Validar formato de login
        if (
            !filter_var($login, FILTER_VALIDATE_EMAIL) &&
            !preg_match('/^[a-zA-Z0-9_]{3,30}$/', $login)
        ) {
            $errorLogin = "El usuario o correo tiene un formato inválido.";
        }

        if (strlen($login) > 100 || strlen($password) > 100) {
            $mensajeError = "Los datos ingresados son demasiado largos.";
        }

        if (empty($errorLogin) && empty($mensajeError)) {
            $stmt = $conn->prepare("SELECT id, usuario, email, contraseña FROM USUARIOS WHERE usuario = ? OR email = ? LIMIT 1");
            $stmt->bind_param("ss", $login, $login);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $usuario = $resultado->fetch_assoc();

                if (password_verify($password, $usuario["contraseña"])) {
                    $_SESSION["usuario_id"] = $usuario["id"];
                    $_SESSION["usuario"] = $usuario["usuario"];
                    header("Location: ../index.php");
                    exit;
                } else {
                    $errorPassword = "Contraseña incorrecta.";
                }
            } else {
                $errorLogin = "Usuario o correo no encontrados.";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Iniciar sesión</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../scss/custom.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h3 class="text-center mb-3">Iniciar Sesión</h3>

        <?php if (!empty($mensajeError)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensajeError) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Nombre de usuario o correo electrónico</label>
                <input type="text" name="login" class="form-control <?= $errorLogin ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($login) ?>">
                <?php if ($errorLogin): ?>
                    <div class="invalid-feedback"><?= $errorLogin ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control <?= $errorPassword ? 'is-invalid' : '' ?>">
                <?php if ($errorPassword): ?>
                    <div class="invalid-feedback"><?= $errorPassword ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-oro-100 w-100">Iniciar Sesión</button>
            <p class="text-center mt-3">
                <a href="registro.php" class="oro">¿No tienes cuenta? Regístrate</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>