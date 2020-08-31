<?php
include("conexion.php");

if (isset($_POST['insertar']))
{
    $nombre      = $_POST['nombre'];
    $apellido      = $_POST['apellido'];
    $telefono    = $_POST['telefono'];
    $email       = $_POST['email'];
    $comentarios = $_POST['comentarios'];
    $nombre_apellido = $nombre." ".$apellido;

    $sql = "INSERT INTO `shaio_landings`.`davinci` (`id`, `nombre`, `telefono`, `email`, `comentarios`,`timestamp`) 
            VALUES (NULL, '$nombre_apellido', '$telefono', '$email', '$comentarios', CURRENT_TIMESTAMP);";

    $connect->query($sql);
    $connect->close();

    echo '<script>window.location="/cirugia_robotica_da_vinci/gracias.php";</script>';
} else
{
    echo '<script>alert("No se logro obtener su información por favor volver a intentarlo");window.location="/cirugia_robotica_da_vinci/";</script>';
}
