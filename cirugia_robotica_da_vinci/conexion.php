<?php
$servidor = "localhost";
$usuario  = "shaio_prd";
$clave    = "wTOEFa5OCulw";
$db       = "shaio_landings";

$connect = mysqli_connect($servidor, $usuario, $clave, $db);

if (!$connect)
{
    echo "Error: No se pudo conectar a MySQL.".PHP_EOL;
    echo "errno de depuración: ".mysqli_connect_errno().PHP_EOL;
    echo "error de depuración: ".mysqli_connect_error().PHP_EOL;
    exit;
}