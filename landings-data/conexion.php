<?php
$servidor="localhost";
$usuario="shaio_prd";
$clave="wTOEFa5OCulw";
mysql_connect($servidor,$usuario,$clave) or die("no se pudo conectar"); 
mysql_select_db("shaio_landings") or die("no se puede conectar a la base de datos");
?>
