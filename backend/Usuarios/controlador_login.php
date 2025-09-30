<?php
// backend/Usuarios/controlador_login.php

require_once __DIR__ . '/../Conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contraseña'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        header("Location: /proyecto-turismo/Frontend/login.php?error=campos_vacios");
        exit;
    }

    // BUSCA EN Administradores
    $stmt = $conn->prepare("SELECT ID_Administrador, Nombre, Apellido, Contraseña FROM administradores WHERE Correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($contrasena, $admin['Contraseña'])) {
        $_SESSION['usuario_id'] = $admin['ID_Administrador'];
        $_SESSION['rol'] = 'admin';
        $_SESSION['nombre'] = $admin['Nombre'] . ' ' . $admin['Apellido'];
        header("Location: /proyecto-turismo/Frontend/Index.php");
        exit;
    }

    // BUSCA EN Clientes
    $stmt = $conn->prepare("SELECT ID_Cliente, Nombre, Apellido, Contraseña FROM cliente WHERE Correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    if ($cliente && password_verify($contrasena, $cliente['Contraseña'])) {
        $stmt_org = $conn->prepare("SELECT Cedula FROM organizadores WHERE ID_Cliente = ?");
        $stmt_org->bind_param("i", $cliente['ID_Cliente']);
        $stmt_org->execute();
        $es_organizador = $stmt_org->get_result()->num_rows > 0;

        $_SESSION['usuario_id'] = $cliente['ID_Cliente'];
        $_SESSION['rol'] = $es_organizador ? 'organizador' : 'cliente';
        $_SESSION['nombre'] = $cliente['Nombre'] . ' ' . $cliente['Apellido'];
        header("Location: /proyecto-turismo/Frontend/Index.php");
        exit;
    }

    // CREDENCIALES INVÁLIDAS
    header("Location: /proyecto-turismo/Frontend/login.php?error=credenciales_invalidas");
    exit;
}

header("Location: /proyecto-turismo/Frontend/login.php");
exit;
?>