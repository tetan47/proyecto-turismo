<?php

if (!empty($_POST["iniciar_sesion"])) {
    if (empty($_POST["correo"]) and empty($_POST["contraseña"])) {
        echo '<div class="alert alert-danger">Los campos estan vacios, por favor ingrese sus datos</div>';
    }   else {
        $email=$_POST["correo"];
        $passw=$_POST["contraseña"];
        $sql=$conn->query(" select * from usuario where Correo='$email' and Contraseña='$passw' ");
        if ($datos=$sql->fetch_object()) {
            header("location: index.php");
            exit;
        } else {
            echo '<div class=" alert alert-danger>No se ha encntrado al usuario';
        }
        
    }
        # code...                                                                                     
    }
    


?>