<font face="Arial, Helvetica, sans-serif" size="2">

<?php   
error_reporting(E_ALL);
   include("conectarse.php");
   $link=Conectarse();   
  
   $ID_CORREO=$_GET['ID_CORREO'];
   $ACTIVO_CORREO='0';

      
mysql_query("UPDATE correos SET ACTIVO_CORREO='$ACTIVO_CORREO' WHERE ID_CORREO = $ID_CORREO", $link);

   echo "El CORREO a sido eliminado";
   
   echo "<br><a href=javascript:history.back()>Regresar</a>";


  ?> 
