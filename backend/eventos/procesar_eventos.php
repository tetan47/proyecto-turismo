<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
include("../Conexion.php");

// Verificar que el usuario esté logueado
if (!isset($_SESSION['ID_Cliente']) || !isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    echo "<script>
            alert('Debes iniciar sesión para crear un evento');
            window.location.href='login.php';
          </script>";
    exit();
}

// Verificar que el usuario sea organizador
$id_cliente = $_SESSION['ID_Cliente'];
$stmt_verificar = $conn->prepare("SELECT Cedula FROM organizadores WHERE ID_Cliente = ?");
$stmt_verificar->bind_param('i', $id_cliente);
$stmt_verificar->execute();
$result_org = $stmt_verificar->get_result();

if ($result_org->num_rows === 0) {
    echo "<script>
            alert('Debes ser organizador para crear eventos. Conviértete en organizador desde tu perfil.');
            window.location.href='index.php';
          </script>";
    $stmt_verificar->close();
    $conn->close();
    exit();
}

// Obtener la cédula del organizador
$organizador = $result_org->fetch_assoc();
$cedula = $organizador['Cedula'];
$stmt_verificar->close();

// Verificar que el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y sanitizar los datos del formulario
    $titulo = mysqli_real_escape_string($conn, trim($_POST['titulo']));
    $descripcion = mysqli_real_escape_string($conn, trim($_POST['descripcion']));
    $categoria = mysqli_real_escape_string($conn, trim($_POST['categoria']));
    $ubicacion = mysqli_real_escape_string($conn, trim($_POST['ubicacion']));
    $fecha_inicio = mysqli_real_escape_string($conn, $_POST['fecha_inicio']);
    $fecha_fin = mysqli_real_escape_string($conn, $_POST['fecha_fin']);
    $hora_evento = mysqli_real_escape_string($conn, $_POST['hora_evento']);
    $capacidad = intval($_POST['capacidad']);
    
    // Validaciones
    if (empty($titulo) || empty($categoria) || empty($ubicacion) || empty($fecha_inicio) || empty($fecha_fin) || empty($hora_evento) || $capacidad <= 0) {
        echo "<script>
                alert('Error: Todos los campos obligatorios deben estar completos');
                window.location.href='crear_eventos.php';
              </script>";
        $conn->close();
        exit();
    }
    
    // Validar que la fecha de fin no sea anterior a la fecha de inicio
    if (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
        echo "<script>
                alert('Error: La fecha de fin no puede ser anterior a la fecha de inicio');
                window.location.href='crear_eventos.php';
              </script>";
        $conn->close();
        exit();
    }
    
    // Validar que la fecha de inicio no sea en el pasado
    $fecha_actual = date('Y-m-d');
    if (strtotime($fecha_inicio) < strtotime($fecha_actual)) {
        echo "<script>
                alert('Error: La fecha de inicio no puede ser en el pasado');
                window.location.href='crear_eventos.php';
              </script>";
        $conn->close();
        exit();
    }
    
    // Procesar la imagen si fue subida
    $imagen_url = 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png'; // Imagen por defecto
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        
        // Validar el tipo de archivo
        $tipos_permitidos = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp');
        $tipo_archivo = $imagen['type'];
        
        if (in_array($tipo_archivo, $tipos_permitidos)) {
            // Validar el tamaño (máximo 5MB)
            if ($imagen['size'] <= 5000000) {
                // Usar ruta absoluta desde la raíz del servidor
                $directorio_destino = $_SERVER['DOCUMENT_ROOT'] . '/portadas-eventos/';
                
                if (!file_exists($directorio_destino)) {
                    mkdir($directorio_destino, 0777, true);
                }
                
                // Generar nombre único para la imagen
                $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $nombre_archivo = 'evento_' . time() . '_' . uniqid() . '.' . $extension;
                $ruta_destino = $directorio_destino . $nombre_archivo;
                
                // Mover el archivo subido al directorio destino
                if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
                    // Usar ruta absoluta desde la raíz del sitio web
                    $imagen_url = '/portadas-eventos/' . $nombre_archivo;
                } else {
                    echo "<script>alert('Error al subir la imagen. Se usará la imagen por defecto.');</script>";
                }
            } else {
                echo "<script>
                        alert('La imagen es demasiado grande. Tamaño máximo: 5MB. Se usará la imagen por defecto.');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Tipo de archivo no permitido. Solo se aceptan: JPG, JPEG, PNG, GIF, WEBP. Se usará la imagen por defecto.');
                  </script>";
        }
    }
    
    $sql = "INSERT INTO eventos (Título, Descripción, Ubicacion, Hora, imagen, categoria, Fecha_Inicio, Fecha_Fin, Cédula, Capacidad) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "sssssssssi", 
            $titulo, 
            $descripcion, 
            $ubicacion, 
            $hora_evento, 
            $imagen_url, 
            $categoria, 
            $fecha_inicio, 
            $fecha_fin, 
            $cedula, 
            $capacidad
        );
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Obtener el ID del evento recién creado
            $id_evento = mysqli_insert_id($conn);
            
            echo "<script>
                    alert('¡Evento creado exitosamente!\\n\\nID del evento: " . $id_evento . "\\nTítulo: " . addslashes($titulo) . "');
                    window.location.href='mis-eventos.php';
                  </script>";
        } else {
            // Error al ejecutar la consulta
            $error_msg = mysqli_error($conn);
            echo "<script>
                    alert('Error al crear el evento: " . addslashes($error_msg) . "');
                    window.location.href='crear_eventos.php';
                  </script>";
        }
        
        // Cerrar la sentencia
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la consulta
        $error_msg = mysqli_error($conn);
        echo "<script>
                alert('Error al preparar la consulta: " . addslashes($error_msg) . "');
                window.location.href='crear_eventos.php';
              </script>";
    }
    
    // Cerrar la conexión
    mysqli_close($conn);
    
} else {
    // Si se intenta acceder directamente sin enviar el formulario
    header("Location: crear_eventos.php");
    exit();
}
?>