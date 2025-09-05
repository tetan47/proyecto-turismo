<?php
session_start();
include('../backend/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar sesión
    if (!isset($_SESSION['ID_Cliente'])) {
        echo "Debes iniciar sesión para comentar.";
        exit;
    }

    $idUsuario = $_SESSION['ID_Cliente'];
    $id_evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
    $texto = mysqli_real_escape_string($conn, $_POST['Texto'] ?? '');

    if (empty($texto)) {
        echo "Por favor escribe un comentario.";
        exit;
    }

    // Insertar comentario
    $sql = "INSERT INTO Comentarios (Texto, ID_Cliente, ID_Evento) 
            VALUES ('$texto', '$idUsuario', '$id_evento')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Comentario enviado correctamente.";
    } else {
        echo "Error al guardar: " . mysqli_error($conn);
    }
}
?>
