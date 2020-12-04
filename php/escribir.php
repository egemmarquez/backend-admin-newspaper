<?php
/**Notas**/
/**Variables**/
include('conectarse.php');
include('variables.php');

$DESTINO = $_POST['DESTINO'];

/*Define el destino*/

if ($DESTINO = 'quicknote')
{

$link=conectarse();   
$TITULO = $_POST[''.$TITULO.''];
$FECHA = $_POST[''.$FECHA.''];
$CONTENIDO = $_POST[''.$CONTENIDO.''];
$SECCION = $_POST[''.$SECCION.''];
$PORTADA = $_POST[''.$PORTADA.''];

echo $TITULO;
echo "<BR>";
echo $FECHA;
echo "<BR>";
echo $CONTENIDO;
echo "<BR>";
echo $SECCION;
echo "<BR>";
echo $PORTADA;
echo "<BR>";


}




?>