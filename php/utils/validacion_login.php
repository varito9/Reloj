<?php
session_start();

// Simulación: usuario y clave correctos
$usuario_valido = 'admin';
$clave_valida = '1234';

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

if ($usuario === $usuario_valido && $clave === $clave_valida) {
    $_SESSION['usuario'] = $usuario;
    header("Location: ../index.php"); // o la página principal
    exit;
} else {
    echo "Credenciales incorrectas.";
}