<?php 

session_start();
include('../backend/conexion.php');

$texto = mysqli_query_escape_string ($conn, $_POST['Texto']);
$id_evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
$idUsuario = $_SESSION['ID_Cliente'] ?? 0;
$Nombre =



if (!empty($texto)){
    $sql = "SELECT INTO Comentarios (Texto, ID_Cliente, ID_Evento) VALUES ('$texto','$idUsuario', '$id_evento')";
}

 if (mysqli_query($conn, $sql)) {
            echo "Comentario enviado";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
     else {
        echo "Por favor rellena el campo de texto";
}

?>