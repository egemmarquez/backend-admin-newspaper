<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<body>
<?php 

include('conectarse.php');

function muestra_correos()
{
$link = conectarse();
$consulta = "SELECT * FROM correos WHERE ACTIVO_CORREO = 1";
$query = mysql_query($consulta,$link) or die(mysql_error());
while ($row=mysql_fetch_array($query))
{
$resulta .= '
<td>
'.$row['EMAIL_CORREO'].'
<TD>
<a href="procesos/delete_mail.php?ID_CORREO='.$row['ID_CORREO'].'">Borrar</a>
</tr><tr>

';
}
return $resulta;
}



?>

<table border="1">
<td>
Correo
<td>
Opciones
</tr><tr>

<?php echo  muestra_correos() ?>
</body>
</html>
