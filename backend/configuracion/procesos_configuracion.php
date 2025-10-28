<?php
session_start();
require_once '../conexion.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['ID_Cliente'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];
$accion = $_POST['accion'] ?? '';

switch ($accion) {
    case 'obtener_datos':
        $sql = "SELECT Nombre, Apellido, Correo, imag_perfil FROM cliente WHERE ID_Cliente = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_cliente);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($resultado)) {
            if (empty($row['imag_perfil'])) {
                $row['imag_perfil'] = 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';
            }
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
        mysqli_stmt_close($stmt);
        break;

    case 'actualizar_perfil':
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $foto_url = trim($_POST['foto_url'] ?? '');

        if (empty($nombre) || empty($apellido)) {
            echo json_encode(['success' => false, 'message' => 'Nombre y apellido son obligatorios']);
            exit;
        }

        if (strlen($nombre) > 20 || strlen($apellido) > 20) {
            echo json_encode(['success' => false, 'message' => 'Nombre y apellido no pueden superar 20 caracteres']);
            exit;
        }

        if (empty($foto_url)) {
            $sql = "UPDATE cliente SET Nombre = ?, Apellido = ? WHERE ID_Cliente = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $nombre, $apellido, $id_cliente);
        } else {
            if (!filter_var($foto_url, FILTER_VALIDATE_URL)) {
                echo json_encode(['success' => false, 'message' => 'URL de foto no válida']);
                exit;
            }
            
            $sql = "UPDATE cliente SET Nombre = ?, Apellido = ?, imag_perfil = ? WHERE ID_Cliente = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $nombre, $apellido, $foto_url, $id_cliente);
        }

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['Nombre'] = $nombre;
            $_SESSION['Apellido'] = $apellido;
            if (!empty($foto_url)) {
                $_SESSION['imag_perfil'] = $foto_url;
            }
            echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el perfil']);
        }
        mysqli_stmt_close($stmt);
        break;

    case 'verificar_password':
        $password_actual = trim($_POST['password_actual'] ?? '');

        if (empty($password_actual)) {
            echo json_encode(['success' => false, 'message' => 'Debes ingresar tu contraseña']);
            exit;
        }

        $sql = "SELECT Contraseña FROM cliente WHERE ID_Cliente = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_cliente);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($resultado)) {
            if ($row['Contraseña'] === $password_actual) {
                echo json_encode(['success' => true, 'message' => 'Contraseña verificada']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
        mysqli_stmt_close($stmt);
        break;

    case 'actualizar_cuenta':
        $password_nueva = trim($_POST['password_nueva'] ?? '');
        $password_confirm = trim($_POST['password_confirm'] ?? '');

        if (empty($password_nueva)) {
            echo json_encode(['success' => false, 'message' => 'Debes ingresar una nueva contraseña']);
            exit;
        }

        if (strlen($password_nueva) < 8) {
            echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres']);
            exit;
        }

        if ($password_nueva !== $password_confirm) {
            echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
            exit;
        }

        $sql = "UPDATE cliente SET Contraseña = ? WHERE ID_Cliente = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $password_nueva, $id_cliente);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña']);
        }
        mysqli_stmt_close($stmt);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

mysqli_close($conn);
?>