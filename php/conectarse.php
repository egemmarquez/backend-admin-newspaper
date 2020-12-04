<?php

function conectarse()
{
global $conexion;
include ('variables.php');
   if (!($link=mysql_connect(''.$ADRESS.'',''.$USUARIO.'',''.$PASSWORD.'')))
   {
      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db(''.$DATABASE.'',$link))
   {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}

$link=Conectarse();
echo "";

$conexion = $link=Conectarse();
?> 