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
$resulta .= ''.$row['EMAIL_CORREO'].', ';
}


return $resulta;
}

function muestra_correos2()
{
$link = conectarse();
$consulta = "SELECT * FROM correos WHERE ACTIVO_CORREO = 1 order by ID_CORREO desc limit 0,1";
$query = mysql_query($consulta,$link) or die(mysql_error());
while ($row=mysql_fetch_array($query))
{
$resulta .= ''.$row['EMAIL_CORREO'].'';
}
return $resulta;
}

?>

<form name="envia_correo" action="mailing.php" method="post">
<B> Direcciones:</B> 

<textarea type="text" cols="60" rows="2" name="direcciones" id="direcciones" /><?php echo muestra_correos() ?><?php echo muestra_correos2() ?></textarea>
<br />
<? 
error_reporting(E_ALL);

$contenido = file_get_contents("http://localhost/admin/php/mailing_contenido.php"); 
$archivo = fopen("contents.html", "w");
fwrite($archivo, $contenido);
fclose($archivo);
echo 'Boletin Generado: ' . (is_resource($archivo) ? '<img src=no.gif>': '<img src=yes.gif>');

?>

<a href="contents.html" target="_blank">
Ver Boletin</a>

<br /><Br />
Todo correcto?, envia el boletin, YA:

<input type="submit" />
</form>

</body>
</html>
