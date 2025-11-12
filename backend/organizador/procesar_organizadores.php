<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../Conexion.php");

if (!isset($_SESSION['ID_Cliente']) || !isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    echo "<script>
            alert('Debes iniciar sesión para enviar una solicitud');
            window.location.href='../../frontend/login.php';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_cliente = $_SESSION['ID_Cliente'];
    
    $cedula = mysqli_real_escape_string($conn, trim($_POST['cedula']));
    $telefono = mysqli_real_escape_string($conn, trim($_POST['telefono']));
    
    if (empty($cedula) || empty($telefono)) {
        echo "<script>
                alert('Error: Todos los campos son obligatorios');
                window.location.href='../../frontend/convertirse_organizador.php';
              </script>";
        $conn->close();
        exit();
    }
    
    if (strlen($cedula) < 7 || strlen($cedula) > 10) {
        echo "<script>
                alert('Error: La cédula debe tener entre 7 y 10 dígitos');
                window.location.href='../../frontend/convertirse_organizador.php';
              </script>";
        $conn->close();
        exit();
    }
    
    if (!ctype_digit($cedula)) {
        echo "<script>
                alert('Error: La cédula solo debe contener números');
                window.location.href='../../frontend/convertirse_organizador.php';
              </script>";
        $conn->close();
        exit();
    }
    
    if (strlen($telefono) < 8 || strlen($telefono) > 20) {
        echo "<script>
                alert('Error: El teléfono debe tener entre 8 y 20 caracteres');
                window.location.href='../../frontend/convertirse_organizador.php';
              </script>";
        $conn->close();
        exit();
    }
    
    $stmt_verificar = $conn->prepare("SELECT Cedula FROM organizadores WHERE ID_Cliente = ?");
    $stmt_verificar->bind_param('i', $id_cliente);
    $stmt_verificar->execute();
    $resultado = $stmt_verificar->get_result();
    
    if ($resultado->num_rows > 0) {
        echo "<script>
                alert('Ya has enviado una solicitud anteriormente. Por favor espera a que sea revisada.');
                window.location.href='../../frontend/Index.php';
              </script>";
        $stmt_verificar->close();
        $conn->close();
        exit();
    }
    $stmt_verificar->close();
    
    $stmt_verificar_cedula = $conn->prepare("SELECT ID_Cliente FROM organizadores WHERE Cedula = ?");
    $stmt_verificar_cedula->bind_param('s', $cedula);
    $stmt_verificar_cedula->execute();
    $resultado_cedula = $stmt_verificar_cedula->get_result();
    
    if ($resultado_cedula->num_rows > 0) {
        echo "<script>
                alert('Error: Esta cédula ya está registrada por otro usuario');
                window.location.href='../../frontend/convertirse_organizador.php';
              </script>";
        $stmt_verificar_cedula->close();
        $conn->close();
        exit();
    }
    $stmt_verificar_cedula->close();
    
    $sql = "INSERT INTO organizadores (Cedula, Teléfono, ID_Cliente) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssi", $cedula, $telefono, $id_cliente);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('¡Solicitud enviada correctamente!\\n\\nLos administradores revisarán tu solicitud pronto.\\nCédula: " . addslashes($cedula) . "');
                    window.location.href='../../frontend/Index.php';
                  </script>";
        } else {
            $error_msg = mysqli_error($conn);
            echo "<script>
                    alert('Error al enviar la solicitud: " . addslashes($error_msg) . "');
                    window.location.href='../../frontend/convertirse_organizador.php';
                  </script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $error_msg = mysqli_error($conn);
        echo "<script>
                alert('Error al preparar la consulta: " . addslashes($error_msg) . "');
                window.location.href='../../frontend/convertirse_organizador.php';
              </script>";
    }
    
    mysqli_close($conn);
    
} else {
    header("Location: ../../frontend/convertirse_organizador.php");
    exit();
}
?>