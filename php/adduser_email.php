<font face="Arial, Helvetica, sans-serif" size="2">

<?php   
error_reporting(E_ALL);
   include("conectarse.php");
   $link=conectarse();   
   $NOMBRE_CORREO=$_POST['NOMBRE_CORREO'];
   $EMAIL_CORREO=$_POST['EMAIL_CORREO'];   
   $ACTIVO_CORREO='1';
 
   
   
if (($NOMBRE_CORREO === "") or ($EMAIL_CORREO === ""))
{
echo "Hay datos no llenados en el formulario anterior, por favor verifica";
}
else 
{

mysql_query("INSERT into correos (NOMBRE_CORREO,EMAIL_CORREO,ACTIVO_CORREO) values  (
'$NOMBRE_CORREO',
'$EMAIL_CORREO',
'$ACTIVO_CORREO')",$link); 
 

   echo "La informacion a sido registrada.";
   }
    echo "<br><a href=javascript:history.back()>Regresar</a>";
	
  ?> 
