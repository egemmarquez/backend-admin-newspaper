<?php
error_reporting(0);
include ('conectarse.php');

global $link;

function regresa_fecha($FECHA){

	$mes[0]="-";
	$mes[1]="Ene";
	$mes[2]="Feb";
	$mes[3]="Mar";
	$mes[4]="Abr";
	$mes[5]="May";
	$mes[6]="Jun";
	$mes[7]="Jul";
	$mes[8]="Ago";
	$mes[9]="Sep";
	$mes[10]="Oct";
	$mes[11]="Nov";
	$mes[12]="Dic";
	return date("j",$FECHA).' '.$mes[date("n",$FECHA)].' '.date("Y",$FECHA).'('.date("H:i:s",$FECHA).')';
	return $muestra;
}

function cambiarfecha($dias){
return date('Y-m-d H:i:s', strtotime($dias.' days'));
}

function UpdateTwitter($a, $b, $c, $d){

	include('variables.php');
	$link = conectarse();
	if($sql = mysql_query("update twitter_config set hashtag='".$a."', twitter_title='".$b."', twitter_subjet='".$c."', twitter_search='".$d."' where twitter_id=1",$link)){
		echo "<strong>Modificado Exitosamente</strong>";
	}
}

function ViewDatosTwitter(){
	include('variables.php');
	$link = conectarse();

	if($mysql = mysql_query("select * from twitter_config limit 1")){
		$row = mysql_fetch_array($mysql);

		$hashtag = $row["hashtag"];
		$ttile = $row["twitter_title"];
		$tsubject = $row["twitter_subjet"];
		$tsearch = $row["twitter_search"];

		return $hashtag."*".$ttile."*".$tsubject."*".$tsearch;
	}
}



function last_news()
{
$resultado = '';
include('variables.php');
$link = conectarse();
ERROR_REPORTING(E_ALL);
$consulta = 'SELECT * FROM '.$NOTICIAS.' ORDER BY '.$ID.' DESC LIMIT 0,5';
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$resultado .= '
- <a href="../nota.php?'.$ID.'='.$row[''.$ID.''].'" target="_blank">'.$row[''.$TITULO.''].'</a><br>

';

}
return $resultado;

}

function last_categories()
{
$resultado = '';
include('variables.php');
$link = conectarse();
$consulta = 'SELECT * FROM '.$SECCIONES.' ORDER BY '.$SECCION.' DESC LIMIT 0,5';
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$resultado .= '
- '.$row[''.$SECCIONOMBRE.''].'</a><br>

';

}
return $resultado;

}

function last_messages()
{
$resultado = '';
include('variables.php');
$link = conectarse();
$consulta = 'SELECT * FROM '.$MENSAJES.' where '.$MEN_ACTIVO.' = 0 ORDER BY '.$MEN_ID.' DESC LIMIT 0,8';
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$resultado .= '
- <b>'.$row[''.$MEN_NOMBRE.''].' : </b><font size="1">'.substr($row[''.$MEN_MENSAJE.''],0, 200).' ... <a href="men.php?action=autorizar&'.$MEN_ID.'='.$row[''.$MEN_ID.''].'"><img src="img/nota_editar2.gif" border="0" width="15" height="15"></a></font><br>

';

}
return $resultado;

}



function last_denuncias()
{
include('variables.php');
if($DENUNCIAS_SECCION == '1')
{
$link = conectarse();
$consulta = 'SELECT * FROM '.$DENUNCIAS.' ORDER BY '.$DEN_ID.' DESC LIMIT 0,5';
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$resultado .= '
- '.$row[''.$DEN_NOMBRE.''].' : '.substr($row[''.$DEN_MENSAJE.''],0,50).' ... <a href="den.php?action=autorizar&'.$DEN_ID.'='.$row[''.$DEN_ID.''].'"><img src="img/nota_editar2.gif" border="0" width="15" height="15"></a><br>
';
}
}
else
{
$resultado = '';
}

return $resultado;

}


function quicknote()
{

$resultados_categorias ='';
$resultados_portada = '';
$action = '';

include('variables.php');
$link = conectarse();
/*Consultas*/
$consulta_categorias = 'SELECT * FROM '.$SECCIONES.' order by '.$SECCION.' desc';
$consulta_portada = 'SELECT * FROM '.$PORTADA.' order by '.$PORTADA_ID.' desc';

/*FIN consultas*/

$query_categorias = mysql_query($consulta_categorias,$link) or die(mysql_error());
while($row_categorias=mysql_fetch_array($query_categorias))

{
$resultados_categorias .= '<option value="'.$row_categorias[''.$SECCION.''].'">'.$row_categorias[''.$SECCIONOMBRE.''].'</option>';
}

$query_portada = mysql_query($consulta_portada,$link) or die(mysql_error());
while($row_portada=mysql_fetch_array($query_portada))

{

$resultados_portada .= '<option value="'.$row_portada[''.$PORTADA_ID.''].'">'.$row_portada[''.$PORTADANOMBRE.''].'</option>';
}

$fecha = cambiarfecha('0');

{
$resultado = '';
$action = $_GET['action'];

if ($action == '')
{
if($FECHACONFIGURACION == '1')
{
$fecha = cambiarfecha('0');
}
else
{
$fecha = time ();
$fechabin = time ();
		   $mes= date("M",$fechabin);
			   switch ($mes){
			   		case "Jan": $mes="Ene";break;
					case "Aug": $mes="Ago";break;
					case "Dec": $mes="Dic";break;
				}
					$fechabin = time();
				$fecha = time();
			   $fechabin = date("j ",$fechabin).$mes.date(" y(H:i:s)",$fechabin);

}



$resultado .= '


<form action="index.php?action=registro_quick" method="post" enctype="multipart/form-data">
<input type="hidden" name="DESTINO" value="quicknote">
<textarea name="'.$TITULO.'" id="'.$TITULO.'" cols="37" class="myinputstyle"></textarea>
<br>
<b>Fecha:</B>
 <i>'.$fechabin.'</i>
<input type="hidden" name="'.$FECHA.'" id="'.$FECHA.'" value="'.$fecha.'" /><br>
<textarea name="'.$CONTENIDO.'" id="'.$CONTENIDO.'" cols="37" rows="20" class="myinputstyle"></textarea>
<br>
Subir foto: <input name="'.$FOTO1.'" type="file" id="'.$FOTO1.'"  class="myinputstyle" /><br>
<br>

Seccion: <select name="'.$SECCION.'"  class="myinputstyle">
'.$resultados_categorias.'
</select>
<br><br>
En Portada: <select name="'.$PORTADA.'"  class="myinputstyle">
'.$resultados_portada.'
</select>
<br><Br>
<INPUT TYPE="submit" NAME="accion" VALUE="Grabar"  class="myinputstyle">
</form>
';
}
elseif ($action == 'registro_quick')
{
include('variables.php');
$link = conectarse();
//OBTENEMOS LOS DATOS DEL FORMULARIO ANTERIOR
$TITULO_DATO=$_POST[''.$TITULO.''];
$EXTRACTO_DATO=$_POST[''.$EXTRACTO.''];
$FECHA_DATO=$_POST[''.$FECHA.''];
$REPORTERO_DATO=$_POST[''.$REPORTERO.''];
$CONTENIDO_DATO=$_POST[''.$CONTENIDO.''];
$SECCION_ID_DATO=$_POST[''.$SECCION.''];
$PORTADA_ID_DATO=$_POST[''.$PORTADA_ID.''];
$MULTI_FOTO1_DATO= basename( $_FILES[''.$FOTO1.'']['name']);
//subimos los archivos, se hace un foreach para cada archivo

$target = "../fotos/"; //directorio a donde van los archivos
//subir fotos
$target1 = $target . basename( $_FILES[''.$FOTO1.'']['name']);
move_uploaded_file($_FILES[''.$FOTO1.'']['tmp_name'], $target1);

if ($RESIZE_ON = 'on')
{
	include('imgsize.php');
   $image = new SimpleImage();
   $image->load(''.$target1.'');
   $image->resizeToWidth(500);
   $image->save(''.$target1.'');
}
else
{

}

mysql_query("INSERT into $NOTICIAS ($TITULO,$EXTRACTO,$FECHA,$CONTENIDO,$SECCION,$PORTADA_ID,$FOTO1) values ('$TITULO_DATO', '$EXTRACTO_DATO', '$FECHA_DATO', '$CONTENIDO_DATO', '$SECCION_ID_DATO', '$PORTADA_ID_DATO', '$MULTI_FOTO1_DATO')",$link);

$resultado = '
<center><b>Nota registrada</b></center>
<meta HTTP-EQUIV="Refresh" CONTENT="1;URL=index.php">
';
}


}
return $resultado;
}

function detecttab($cattab)
{
	if($cattab == '1')
	{
		$resulta = '<img src="img/tab.png">';
	}
	else
	{
		$resulta = '';
	}
	return $resulta;
}

function detecttab2($cattab)
{
	if($cattab == '0')
	{
		$resulta = '<img src="img/visible.png" alt="visible">';
	}
	else
	{
		$resulta = '';
	}
	return $resulta;
}

function detecttab3($cattab)
{
	if($cattab == '')
	{
		$resulta = '';
	}
	else
	{
		$resulta = '<img src="img/wall.png" alt="visible">';
	}
	return $resulta;
}


function todas_secciones() {
include('variables.php');
$link = conectarse();
$consulta = 'SELECT * FROM '.$SECCIONES.''; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query



while($row=mysql_fetch_array($query))
{
$resultado .= '
<th bgcolor=""><b><center>
'.$row[''.$SECCIONOMBRE.''].' </b></center>
<hr>
<td style="text-align:right">

'.detecttab($row['cat_tab']).'
'.detecttab2($row['cat_aparece']).'
'.detecttab3($row['cat_wallpaper']).'
<a href="sec.php?action=edit&'.$SECCION.'='.$row[''.$SECCION.''].'">
<img src="img/edit.gif" border="0" alt="Editar"></a>
<a href="sec.php?action=delete&'.$SECCION.'='.$row[''.$SECCION.''].'">
<img src="img/delete.gif" border="0" alt="Borrar"></a></center>
</tr><tr>
';

}

return $resultado;
}

function verificachecked($id)
{
	if($id == '1')
	{
		$regresa= 'checked="checked"';
	}
	else
	{
	$regresa = '';
	}
	return $regresa;

}


function editar_secciones() {
include('variables.php');
$link = conectarse();
$SEC_ID = $_GET[''.$SECCION.''];
$action = $_GET['action'];

if ($action == "edit")

{
$consulta = 'SELECT * FROM '.$SECCIONES.' where '.$SECCION.' = '.$SEC_ID.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$resultado = '
<center>
<div style="width:500px; height:auto; background-color:#CCCCCC; border:1px solid #999999">
<b>Editar Seccion</b>
<form action="sec.php?action=edit_complete&'.$SECCION.'='.$SEC_ID.'" name="nuevanota" method="post" enctype="multipart/form-data">
<textarea name="'.$SECCIONOMBRE.'" ID="'.$SECCIONOMBRE.'" cols="50" class="myinputstyle">'.$row[''.$SECCIONOMBRE.''].'</textarea>
<input type="hidden" name="'.$SECCION.'" ID="'.$SECCION.'" value="'.$SEC_ID.'"><br>

Background para la seccion: <input type="file" name="background" id="background"> <br>

<INPUT TYPE="CHECKBOX" NAME="sectab" ID="sectab" value="1" '.verificachecked($row['cat_tab']).'> Aparecer en el tab de destacados.
<br>
<INPUT TYPE="CHECKBOX" NAME="cat_aparece" ID="cat_aparece" value="1" '.verificachecked($row['cat_aparece']).'>Seccion oculta<br>

<input type="submit" value="Cambiar" class="myinputstyle">

</div>
</center>
<br><br>
';
}
return $resultado;
}

}


function borrar_secciones() {
include('variables.php');
$link = conectarse();
$SEC_ID = $_GET[''.$SECCION.''];
$SEC_ID = $_GET[''.$SECCION.''];
$action = $_GET['action'];

if ($action == "delete")

{
$consulta = 'SELECT * FROM '.$SECCIONES.' where '.$SECCION.' = '.$SEC_ID.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$resultado = '
<center>
<div style="width:500px; height:auto; background-color:#CCCCCC; border:1px solid #999999">
<b>Borrar Seccion</b>
<form action="sec.php?action=edit_delete&'.$SECCION.'='.$SEC_ID.'" name="nuevanota" method="post">
<textarea name="'.$SECCIONOMBRE.'" ID="'.$SECCIONOMBRE.'" cols="50" disabled>'.$row[''.$SECCIONOMBRE.''].'</textarea>
<input type="hidden" name="'.$SECCION.'" ID="'.$SECCION.'" value="'.$SEC_ID.'" class="myinputstyle"><br>
<input type="submit" value="Borrar" class="myinputstyle"><br>
<b>�Seguro que desea realizar esta acci�n?: <font color="red">Esta acci�n es permanente y no puede deshacerse</font>

</div>
</center>
<br><br>
';
}
return $resultado;
}

}

function editar_secciones_completo() {
include('variables.php');
$link = conectarse();
$SEC_ID = $_GET[''.$SECCION.''];
$action = $_GET['action'];

	if ($action == "edit_complete")

{

$SEC_ID=$_POST[''.$SECCION.''];
$SEC_NOMBRE=$_POST[''.$SECCIONOMBRE.''];
$sectab = $_POST['sectab'];
$SEC_BACKGROUND = basename($_FILES['background']['name']);

$cat_aparece = $_POST['cat_aparece'];
//**Modifica Seccion**//

if ($SEC_BACKGROUND == '')
{
mysql_query("UPDATE $SECCIONES SET $SECCIONOMBRE='$SEC_NOMBRE', cat_tab='$sectab', cat_aparece='$cat_aparece' WHERE $SECCION='$SEC_ID'", $link) or die(mysql_error());
}
else
{
$target_path = "../fotos/";

$target_path = $target_path . basename( $_FILES['background']['name']);

if(move_uploaded_file($_FILES['background']['tmp_name'], $target_path)) {

} else{

}
echo "si detecta wallpaper";

mysql_query("UPDATE $SECCIONES SET $SECCIONOMBRE='$SEC_NOMBRE', cat_wallpaper='$SEC_BACKGROUND' WHERE $SECCION='$SEC_ID'", $link) or die(mysql_error());
}


echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>La Informacion fue modificada</b>
<br><br>
Datos cambiados:
<br>
Nombre de la Secci�n: <b>$SEC_NOMBRE</b>
<br>


</div>
</center>
<br><br>
";
}
	elseif ($action == "edit_delete")

{
$SEC_ID=$_POST[''.$SECCION.''];
mysql_query("delete from $SECCIONES where $SECCION='$SEC_ID'",$link);
echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>La Informacion fue Borrada</b>
</div>
</center>
<br><br>
";
}
}

function agregar_secciones() {
include('variables.php');
$link = conectarse();
$action = $_GET['action'];

if ($action == "add")
{
$formulario = '
<center>
<form action="sec.php?action=add_complete" method="post">
<div style="width:500px; height:auto; background-color:#CCCCCC; border:1px solid #999999">
<b>Crear Seccion</b><br>
<textarea name="'.$SECCIONOMBRE.'" ID="'.$SECCIONOMBRE.'" cols="50" class="myinputstyle"></textarea>
<br>

<INPUT TYPE="CHECKBOX" NAME="sectab" ID="sectab" value="1"> Aparecer en el tab de destacados.
<br>
<INPUT TYPE="CHECKBOX" NAME="cat_aparece" ID="cat_aparece" value="1"> Seccion oculta.
<br>

<input type="submit" value="Crear" class="myinputstyle"><br>

</div>
</center>
</form><br><br>
';
}
if ($action == "add_complete")
{
$NOMBRE=$_POST[''.$SECCIONOMBRE.''];
$TAB = $_POST['sectab'];
$cat_aparece = $_POST['cat_aparece'];

echo $TAB;
mysql_query("INSERT into $SECCIONES ($SECCIONOMBRE,cat_tab,cat_aparece) values ('$NOMBRE','$TAB','$cat_aparece')",$link) or die (mysql_error());
echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>La Informacion fue registrada</b>
</div>
</center>
<br><br>
";
}
return $formulario;
}


function portada_seleccionada($art_Portada)
{
include('variables.php');
$link = Conectarse();
$consulta_portadasel = 'SELECT '.$PORTADA_ID.', '.$PORTADANOMBRE.' from '.$PORTADA.' where '.$PORTADA_ID.' = '.$art_Portada.'';

$query_portadasel = mysql_query($consulta_portadasel,$link) or die(mysql_error());
while($row_portadasel=mysql_fetch_array($query_portadasel))
{
$resultado = '

'.$row_portadasel[''.$PORTADANOMBRE.''].'

';
}
return $resultado;
}

function categoria_seleccionada($cat_ID)
{
include('variables.php');
$link = Conectarse();
$consulta_categoriasel = 'SELECT '.$SECCION.', '.$SECCIONOMBRE.' from '.$SECCIONES.' where '.$SECCION.' = '.$cat_ID.'';

$query_categoriasel = mysql_query($consulta_categoriasel,$link) or die(mysql_error());
while($row_categoriasel=mysql_fetch_array($query_categoriasel))
{
$resultado = '

'.$row_categoriasel[''.$SECCIONOMBRE.''].'

';
}
return $resultado;
}

function filtra_categoria($id)
{
$id = $_GET[id];
if($id = '')
{
}
else
{
include('variables.php');
$link = Conectarse();
$consulta_categoriasel = 'where '.$SECCION.' = '.$ID.'';
return $consulta_categoriasel;
}
}

function filtra_noticias()
{
include('variables.php');
$link = Conectarse();
mysql_set_charset('utf8',$link);
$consulta = 'SELECT * FROM '.$SECCIONES.'';
$query = mysql_query($consulta,$link) or die(mysql_error());

while($row=mysql_fetch_array($query))
{
$resultado .= '
<option value="not.php?action2=FiltrarPorSeccion&'.$SECCION.'='.$row[''.$SECCION.''].'">'.$row[''.$SECCIONOMBRE.''].'</option>

';
}
mysql_set_charset('ISO-8895-15',$link);
return $resultado;
}


function listadereporteros()
{
$consulta = "select * from reporteros order by REP_ID asc";
$link = Conectarse();
mysql_set_charset('utf8',$link);
$query =mysql_query($consulta,$link);
while($row = mysql_fetch_array($query))
{
$resulta .= '<option value="'.$row['REP_ID'].'">'.$row['REP_NOMBRE'].'</option>';
}
mysql_set_charset('ISO-8895-15',$link);
	return $resulta;
}

function filtra_accion() {
include('variables.php');
$action2 = $_GET['action2'];
if ($action2 == 'FiltrarPorSeccion')
{
$ID = $_GET[''.$SECCION.''];
echo 'SELECT * from '.$NOTICIAS.' where '.$SECCION.' = '.$ID.' order by '.$ID.' desc';
}
else
{
echo 'SELECT * from '.$NOTICIAS.' order by '.$ID.' desc';
}

}

function cambiar_espacios($texto){
	$valornuevo=str_replace(' ','_',$texto);
	$valornuevo=str_replace(':','_',$valornuevo);
	$valornuevo=str_replace('?','_',$valornuevo);
	$valornuevo=str_replace('"','_',$valornuevo);
	$valornuevo=str_replace('-','_',$valornuevo);
	$valornuevo=str_replace('/','_',$valornuevo);
	$valornuevo=str_replace('%','_',$valornuevo);
	$valornuevo=str_replace('�','_',$valornuevo);
		$valornuevo=str_replace('�','_',$valornuevo);
			$valornuevo=str_replace('�','_',$valornuevo);
				$valornuevo=str_replace('�','_',$valornuevo);
			$valornuevo=str_replace('�','_',$valornuevo);

return $valornuevo;
}

function cuentavisitas($ID)
{
	$link = conectarse();
	$consulta = "SELECT idnota from visitas where idnota = $ID";
	$query = mysql_query($consulta,$link);
	$num_rows = mysql_num_rows($query);
	return $num_rows*2;
}



function noticias_index() {
$action = $_GET['action'];
include('variables.php');
if (!$action)
{

{
//Conexi�n a la base de datos
$con = mysql_connect("$ADRESS","$USUARIO","$PASSWORD") or die (mysql_error());
mysql_select_db("$DATABASE",$con) or die (mysql_error());

//Sentencia sql (sin limit)


$action2 = $_GET['action2'];
if ($action2 == 'FiltrarPorSeccion')
{
$SECCIONID = $_GET[''.$SECCION.''];
$consulta = 'SELECT * from '.$NOTICIAS.' where '.$SECCION.' = '.$SECCIONID.' order by '.$ID.' desc';
}
else
{
$consulta = 'SELECT * from '.$NOTICIAS.' order by '.$ID.' desc';
}




$_pagi_sql = ''.$consulta.'';

//$_pagi_sql = 'SELECT * FROM '.$NOTICIAS.' ORDER BY '.$ID.' desc';
//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 50;

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
include("paginator.inc.php");
include("variables.php");
//Leemos y escribimos los registros de la p�gina actual
while($row = mysql_fetch_array($_pagi_result))



{
$paginador .= '
<th>'.$row[''.$ID.''].'
<td>'.$row[''.$TITULO.''].' </div>
<td><center><font size="1">'.regresa_fecha($row[''.$FECHA.'']).'</font>
<th> '.portada_seleccionada($row[''.$PORTADA_ID.'']).'
<th> '.categoria_seleccionada($row[''.$SECCION.'']).'


<th><centeR>
<table border="0">
<td>
<a href=not.php?action=modificar&'.$ID.'='.$row[''.$ID.''].'><img src=img/nota_editar2.gif border=0 align=left> Editar</a>
<td>
<a href=not.php?action=borrar&'.$ID.'='.$row[''.$ID.''].'><img src=img/nota_borrar2.gif border=0 align=left> Borrar </a>
</table>
</center>
</tr><tr>
';
}

}


$muestra = '


<script type="text/javascript">

<!--

//Hide from Java Script

function goToPage2()

{

PageIndex2=document.form2.select2.selectedIndex

if (document.form2.select2.options[PageIndex2].value != "none")

{

location = document.form2.select2.options[PageIndex2].value

}

}

//-->

</script>
<center>
<table border="0" width="500">
<th>
<a href="not.php?action=noticias_nueva">
<img src="img/nota_nuevo.gif" border="0" style="-moz-opacity:0.5;filter:alpha(opacity=50);cursor:hand"
onmouseover="this.style.MozOpacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.MozOpacity=0.5;this.filters.alpha.opacity=50">
<br>
Nueva Noticia
</a>

<th>
<a href="not.php">
<img src="img/nota_editar.gif" border="0" style="-moz-opacity:0.5;filter:alpha(opacity=50);cursor:hand"
onmouseover="this.style.MozOpacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.MozOpacity=0.5;this.filters.alpha.opacity=50">
<br>
Modifica Noticia</a>
<th>
<a href="not.php">
<img src="img/nota_borrar.gif" border="0" style="-moz-opacity:0.5;filter:alpha(opacity=50);cursor:hand"
onmouseover="this.style.MozOpacity=1;this.filters.al$ADRESSpha.opacity=100"
onmouseout="this.style.MozOpacity=0.5;this.filters.alpha.opacity=50">
<br>
Borra Noticia
</a></table>
</table></center>
<br><br>

<form name="form2" id="form2"action="" ><b>Filtra noticias por seccion:</B>
<select name="select2" class="myinputstyle">
<option value="none" selected="selected" >
Selecciona...
</option>
'.filtra_noticias().'
</option>
</select>
<input type="button" name="B2" id="B2" value="Filtrar" onclick="goToPage2()" class="myinputstyle" />
</form>
<center>


<table border="1" cellpadding="0" cellspacing="0" width="90%">
<th width="3%" background="css/silvergradient.gif"> ID
<th width="40%" background="css/silvergradient.gif"> Titulo
<th width="15%" background="css/silvergradient.gif"> Fecha de entrada
<th width="15%" background="css/silvergradient.gif"> En Portada
<th width="15%" background="css/silvergradient.gif"> Categoria

<th width="27%" background="css/silvergradient.gif"> Opciones</tr><tr>
'.$paginador.'

</table>
</center>

'.$_pagi_navegacion.'



';
}
elseif ($action == 'noticias_nueva')
{
include('variables.php');
$link = conectarse();
mysql_set_charset('utf8',$link);
/*Consultas*/
$consulta_categorias = 'SELECT * FROM '.$SECCIONES.' order by '.$SECCION.' desc';
$consulta_categorias2 = 'SELECT * FROM '.$SECCIONES.' where cat_gobierno = 1 order by '.$SECCION.' desc';
$consulta_portada = 'SELECT * FROM '.$PORTADA.' where POR_ACTIVO = 1 order by Orden asc';

/*FIN consultas*/

$query_categorias = mysql_query($consulta_categorias,$link) or die(mysql_error());
while($row_categorias=mysql_fetch_array($query_categorias))

{
$resultados_categorias .= '<option value="'.$row_categorias[''.$SECCION.''].'">'.$row_categorias[''.$SECCIONOMBRE.''].'</option>';
}

$query_categorias2 = mysql_query($consulta_categorias2,$link) or die(mysql_error());
while($row_categorias2=mysql_fetch_array($query_categorias2))

{
$resultados_categorias2 .= '<option value="'.$row_categorias2[''.$SECCION.''].'">'.$row_categorias2[''.$SECCIONOMBRE.''].'</option>';
}

$query_portada = mysql_query($consulta_portada,$link) or die(mysql_error());
while($row_portada=mysql_fetch_array($query_portada))

{
$resultados_portada .= '<option value="'.$row_portada[''.$PORTADA_ID.''].'">'.$row_portada[''.$PORTADANOMBRE.''].'</option>';
}


if($FECHACONFIGURACION == '1')
{
$fecha = cambiarfecha('0');
}
else
{
date_default_timezone_set('America/Mexico_City');
$fechaC = date("Y-m-d H:i:s");

$fecha = strtotime("-5 hours");
$fechabin =  date("Y-m-d H:i:s");

}

{
$muestra .= '
<form action="not.php?action=registro" enctype="multipart/form-data" method="post">
<input type="hidden" name="DESTINO" value="quicknote">
<b>Fecha:</B><br>
 <i>'.$fechabin.' </i><br>
<input type="hidden" name="'.$FECHA.'" id="'.$FECHA.'" value="'.$fecha.'" />

<b>Titulo:</b><br>
<textarea name="'.$TITULO.'" id="'.$TITULO.'" cols="84" class="myinputstyle"></textarea>
<br>

<b>Sumario:</b><br>
<textarea name="'.$EXTRACTO.'" id="'.$EXTRACTO.'" cols="84" class="myinputstyle"></textarea>

<br>

<b>Reportero:</b><br>
Selecciona un reportero de la lista: <br>

<SELECT id="REPORTEROS_LISTA" name="REPORTEROS_LISTA">
<option value="0">SIN REPORTERO</option>

'.listadereporteros().'</SELECT> o escribe aqui su nombre para registrarlo:
 <input name="REPORTERO_NUEVO" id="REPORTERO_NUEVO" type="text" size="30" class="myinputstyle">

<div style="width:780px;">
<b>Contenido:</B><br>
<textarea name="'.$CONTENIDO.'" id="'.$CONTENIDO.'" style="width:100%;height:200px; margin-bottom:5px;"></textarea>

</div>

<div style="width:400px; float:left;">
Video:  <input name="art_Youtube" id="art_Youtube" type="text" size="27" class="myinputstyle"><br>
foto1: <input name="'.$FOTO1.'" type="file" id="'.$FOTO1.'"/><br>
foto2: <input name="'.$FOTO2.'" type="file" id="'.$FOTO2.'"/><br>
foto3: <input name="'.$FOTO3.'" type="file" id="'.$FOTO3.'"/><br>
foto4: <input name="'.$FOTO4.'" type="file" id="'.$FOTO4.'"/><br>
foto5: <input name="'.$FOTO5.'" type="file" id="'.$FOTO5.'"/><br>
foto6: <input name="'.$FOTO6.'" type="file" id="'.$FOTO6.'"/><br>
foto7: <input name="'.$FOTO7.'" type="file" id="'.$FOTO7.'"/><br>
<b>Las fotos deben estar en formato .jpg o gif.</b><br>
<br>
<b>Codigo de Video / Enlace Nacionales:</b>

<textarea name="art_Coment" id="art_Coment" cols="30" class="myinputstyle"></textarea>
<br>

</div>
 Pie de Foto(s): <input name="art_PieFoto" id="art_PieFoto" type="text" size="30" class="myinputstyle">
 <Br>
 Seccion: <select name="'.$SECCION.'" id="'.$SECCION.'" class="myinputstyle">
'.$resultados_categorias.'
</select>
<br><br>
Act. de Gobierno: <select name="GOBIERNO" id="GOBIERNO" class="myinputstyle">
<option value="0"></option>
'.$resultados_categorias2.'
</select>

<br><br>
En Portada: <select name="'.$PORTADA_ID.'" id="'.$PORTADA_ID.'" class="myinputstyle">
'.$resultados_portada.'
</select>
<br><br>
<table border="1" cellpading="0" cellspacing="0" width="380">
<td width="50%" valign="top">

<input type="checkbox" name="art_Seguridad" id="art_Seguridad" value="1"> <b>Seguridad</b> <br>
<input type="checkbox" name="art_noesdeldia" id="art_noesdeldia" value="1"> No es nota del dia<br>
<input type="checkbox" name="art_Protegido" id="art_Protegido" value="1" />Protegida?<br>
<input type="checkbox" name="art_Actividades" id="art_Actividades" value="1" /> Actividades de Gobierno<br>
<input type="checkbox" name="art_Comentarios" id="art_Comentarios" value="1" /> Activar Comentarios
<br>
Orientacion:
<select name="art_Orientacion" id="art_Orientacion" class="myinputstyle">
<option value="1">Der</option>
<option value="2">Izq</option>
<option value="3">Panoramica</option>
</select>
<br><br>

Color Titulo: <select name="art_Titulo_color" id="art_Titulo_color" class="myinputstyle">
<option value="0">Default (Blanco)</option>
<option value="1">Obscuro</option>
</select>
<br><br>

<td width="50%" valign="top">
<input type="checkbox" name="art_Elecciones" id="art_Elecciones" value="1" /> Elecciones 2018<br>
<br>
Seccion 2018:
<select name="art_Portada_Elecciones" id="art_Portada_Elecciones" class="myinputstyle">
<option value="0"></option>
<option value="1">Principal</option>
<option value="2">Destacados</option>
<option value="3">Mas informacion</option>
</select>
<br><br>

Partidos:
<select name="art_Partido" id="art_Partido" class="myinputstyle">
<option value=""></option>
<option value="1">PRI</option>
<option value="2">PAN</option>
<option value="3">PRD</option>
<option value="6">MORENA</option>
<option value="4">INDEPENDIENTES</option>
<option value="5">OTROS</option>
</select>


<select name="art_elec_distrito" id="art_elec_distrito" class="myinputstyle">
	<option value=""></option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
</select>

</table>


<br><Br>
<INPUT TYPE="submit" NAME="accion" VALUE="Grabar" class="myinputstyle">
</form>

';
}
}
elseif($action == 'registro')
{
include('variables.php');
$link = conectarse();
//OBTENEMOS LOS DATOS DEL FORMULARIO ANTERIOR
$TITULO_DATO=$_POST[''.$TITULO.''];
$EXTRACTO_DATO=$_POST[''.$EXTRACTO.''];
$FECHA_DATO=$_POST[''.$FECHA.''];
$REPORTERO_DATO=$_POST[''.$REPORTERO.''];
$CONTENIDO_DATO=$_POST[''.$CONTENIDO.''];
$SECCION_ID_DATO=$_POST[''.$SECCION.''];
$PORTADA_ID_DATO=$_POST[''.$PORTADA_ID.''];
$MULTI_FOTO1_DATO= basename( $_FILES[''.$FOTO1.'']['name']);

$MULTI_FOTO2_DATO= basename( $_FILES[''.$FOTO2.'']['name']);

$MULTI_FOTO3_DATO= basename( $_FILES[''.$FOTO3.'']['name']);

$MULTI_FOTO4_DATO= basename( $_FILES[''.$FOTO4.'']['name']);

$MULTI_FOTO5_DATO= basename( $_FILES[''.$FOTO5.'']['name']);

$MULTI_FOTO6_DATO= basename( $_FILES[''.$FOTO6.'']['name']);

$MULTI_FOTO7_DATO= basename( $_FILES[''.$FOTO7.'']['name']);

$art_Coment = $_POST['art_Coment'];

$art_Protegido = $_POST['art_Protegido'];

$art_Orientacion = $_POST['art_Orientacion'];

$art_Elecciones = $_POST['art_Elecciones'];

$art_Partido = $_POST['art_Partido'];

$art_Actividades = $_POST['art_Actividades'];

$art_PieFoto = $_POST['art_PieFoto'];

$art_Youtube = $_POST['art_Youtube'];

$GOBIERNO = $_POST['GOBIERNO'];

$art_Seguridad = $_POST['art_Seguridad'];

$art_noesdeldia = $_POST['art_noesdeldia'];

$art_Portada_Elecciones = $_POST['art_Portada_Elecciones'];

$art_elec_distrito = $_POST['art_elec_distrito']; ///CAMPO SAUL

//Reportero stuff

$REPORTEROLISTA = $_POST['REPORTEROS_LISTA'];

$REPORTERO_NUEVO = $_POST['REPORTERO_NUEVO'];


if($REPORTEROLISTA == '0')
{
if($REPORTERO_NUEVO == '')
{

}
else
{

mysql_query("insert INTO reporteros (REP_NOMBRE) values ('$REPORTERO_NUEVO')",$link);
$query = mysql_query("SELECT REP_ID from reporteros order by REP_ID desc",$link);
$data = mysql_fetch_array($query);

	$REPORTERO_DEFINITIVO = $data['REP_ID'];
}
}
else
{
$REPORTERO_DEFINITIVO = $REPORTEROLISTA;
}


//Si elecciones 2016 maneja nueva principal, entonces.

if($art_Portada_Elecciones == '1')
{

//Como se pone una nota en principal, la informacion que este en principal se mueve a destacados
$query = mysql_query("SELECT art_ID from tabart where art_Portada_Elecciones = 1 order by art_ID desc limit 0,1",$link);
$data = mysql_fetch_array($query);
$IDANTERIOR = $data['art_ID'];

mysql_query("UPDATE tabart set art_Portada_Elecciones = 2 where art_ID = $IDANTERIOR",$link);

echo "y el ID ".$IDANTERIOR." se ha movido a Destacados (Elecciones 2018)";

}

$art_Comentarios = $_POST['art_Comentarios'];

//subimos los archivos, se hace un foreach para cada archivo
$target = "../fotos/"; //directorio a donde van los archivos
//subir fotos
$target1 = $target . basename( $_FILES[''.$FOTO1.'']['name']);
move_uploaded_file($_FILES[''.$FOTO1.'']['tmp_name'], $target1);
rename("../fotos/" . $MULTI_FOTO1_DATO, "../fotos/" . cambiar_espacios($MULTI_FOTO1_DATO));
$target2 = $target . basename( $_FILES[''.$FOTO2.'']['name']);
move_uploaded_file($_FILES[''.$FOTO2.'']['tmp_name'], $target2);
$target3 = $target . basename( $_FILES[''.$FOTO3.'']['name']);
move_uploaded_file($_FILES[''.$FOTO3.'']['tmp_name'], $target3);
$target4 = $target . basename( $_FILES[''.$FOTO4.'']['name']);
move_uploaded_file($_FILES[''.$FOTO4.'']['tmp_name'], $target4);
$target5 = $target . basename( $_FILES[''.$FOTO5.'']['name']);
move_uploaded_file($_FILES[''.$FOTO5.'']['tmp_name'], $target5);
$target6 = $target . basename( $_FILES[''.$FOTO6.'']['name']);
move_uploaded_file($_FILES[''.$FOTO6.'']['tmp_name'], $target6);
$target7 = $target . basename( $_FILES[''.$FOTO7.'']['name']);
move_uploaded_file($_FILES[''.$FOTO7.'']['tmp_name'], $target7);


$MULTI_FOTO_DATO = cambiar_espacios($MULTI_FOTO1_DATO);

$CONTENT = addslashes($CONTENIDO_DATO);

//inserta datos en la base de datos


mysql_query("INSERT into $NOTICIAS ($TITULO,$EXTRACTO,$FECHA,$REPORTERO,$CONTENIDO,$SECCION,$PORTADA_ID,$FOTO1,$FOTO2,$FOTO3,$FOTO4,$FOTO5,$FOTO6,$FOTO7,art_Protegido,art_Coment,art_Orientacion,art_Elecciones,art_PieFoto,art_Actividades,art_Youtube,art_GobiernoID,art_Seguridad,art_noesdeldia,art_Comentarios,art_Partido,art_Portada_Elecciones,art_elec_distrito) values ('$TITULO_DATO', '$EXTRACTO_DATO', '$FECHA_DATO', '$REPORTERO_DEFINITIVO', '$CONTENT', '$SECCION_ID_DATO', '$PORTADA_ID_DATO', '$MULTI_FOTO_DATO', '$MULTI_FOTO2_DATO', '$MULTI_FOTO3_DATO', '$MULTI_FOTO4_DATO', '$MULTI_FOTO5_DATO', '$MULTI_FOTO6_DATO', '$MULTI_FOTO7_DATO', '$art_Protegido', '$art_Coment', '$art_Orientacion', '$art_Elecciones', '$art_PieFoto', '$art_Actividades', '$art_Youtube','$GOBIERNO','$art_Seguridad','$art_noesdeldia','$art_Comentarios','$art_Partido','$art_Portada_Elecciones','$art_elec_distrito')",$link);


echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>La Informacion fue registrada</b><BR>
<a href=\"not.php\">Continuar</a>
<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"5;URL=not.php\">
</div>
</center>
<br><br>";
}
return $muestra;
}

function verifica_protegido()
{
include('variables.php');
$NOT_ID_DATO = $_GET[''.$ID.''];
$link = conectarse();
$consulta_verifica_protegido = 'SELECT art_Protegido FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de
$query_verifica_protegido = mysql_query($consulta_verifica_protegido,$link) or die(mysql_error()); // Creacion del query
while($row_protegido=mysql_fetch_array($query_verifica_protegido))
{
$art_Protegido_dato = $row_protegido['art_Protegido'];
if ($art_Protegido_dato == '1')
{
$resulta = 'checked';
}
else
{
$resulta = '';
}

}
return $resulta;
}


function nombrereportero($idreportero)
{
include('variables.php');
$link = conectarse();
mysql_set_charset('utf8',$link);
$consulta_verifica_protegido = 'SELECT REP_NOMBRE from reporteros where REP_ID = '.$idreportero.''; //Consulta a la base de
$query_verifica_protegido = mysql_query($consulta_verifica_protegido,$link) or die(mysql_error()); // Creacion del query
while($row_protegido=mysql_fetch_array($query_verifica_protegido))
{
$resulta = ''.$row_protegido[REP_NOMBRE].'';
}
return $resulta;
}

function verifica_Elecciones($art_Elecciones)
{
if ($art_Elecciones == 1)
{
$muestra = 'checked';
}
else
{
$muestra = '';
}
return $muestra;

}

function verifica_Segurdad($art_Seguridad)
{
if ($art_Seguridad == 1)
{
$muestra = 'checked';
}
else
{
$muestra = '';
}
return $muestra;

}

function verifica_noesdeldia($art_noesdeldia)
{
if ($art_noesdeldia == 1)
{
$muestra = 'checked';
}
else
{
$muestra = '';
}
return $muestra;

}

function verifica_actividades($art_Elecciones)
{
if ($art_Elecciones == 1)
{
$muestra = 'checked';
}
else
{
$muestra = '';
}
return $muestra;

}


function verifica_orientacion($art_Orientacion)
{
if ($art_Orientacion == 1)
{
$muestra = '<option value="1">Der</option>
<option value="2">Izq</option>
<option value="3">Panoramica</option>
';
}
elseif ($art_Orientacion == 2)
{
$muestra = '<option value="2">Izq</option>
<option value="1">Der</option>
<option value="3">Panoramica</option>
';
}
else
{
	$muestra = '<option value="3">Panoramica</option>
	<option value="2">Izq</option>
<option value="1">Der</option>

';
}
return $muestra;

}

function damereportero($REP_ID)
{
	if($REP_ID == '')
	{
		$REP_ID = 0;
	}

	$link = Conectarse();
$consulta = 'select REP_NOMBRE from reporteros where REP_ID = '.$REP_ID.'';

$query = mysql_query($consulta,$link) or die (mysql_error());
$data = mysql_fetch_array($query);
return $data['REP_NOMBRE'];
}

function modificar_nota()
{
$action = $_GET[action];
if($action == 'modificar')
{
include('variables.php');
$NOT_ID_DATO = $_GET[''.$ID.''];
$link = conectarse();
if($_GET[art_ID] <= '321479')
{
	error_reporting(E_ALL);
	mysql_set_charset('utf8',$link);
}
$consulta = 'SELECT * FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
$consulta_categorias = 'SELECT * FROM '.$SECCIONES.' order by '.$SECCION.' desc';
$consulta_portada = 'SELECT * FROM '.$PORTADA.' order by '.$PORTADA_ID.' desc';

/*AREAS SELECCIONADA*/

/*FIN consultas*/

$query_categorias = mysql_query($consulta_categorias,$link) or die(mysql_error());
while($row_categorias=mysql_fetch_array($query_categorias))

{
$resultados_categorias .= '<option value="'.$row_categorias[''.$SECCION.''].'">'.$row_categorias[''.$SECCIONOMBRE.''].'</option>';
}

$query_portada = mysql_query($consulta_portada,$link) or die(mysql_error());
while($row_portada=mysql_fetch_array($query_portada))

{
$resultados_portada .= '<option value="'.$row_portada[''.$PORTADA_ID.''].'">'.$row_portada[''.$PORTADANOMBRE.''].'</option>';
}
while($row=mysql_fetch_array($query))
{
$muestra = '
<form action="not.php?action=modificar_completa&'.$ID.'='.$NOT_ID_DATO.'" enctype="multipart/form-data" method="post">
<input type="hidden" name="DESTINO" value="quicknote">
<b>Fecha:</B><br>
 <i>'.regresa_fecha($row[''.$FECHA.'']).'</i>
<input type="hidden" name="'.$FECHA.'" id="'.$FECHA.'" value="'.$row[''.$FECHA.''].'" />
<BR>
<b>Titulo:</b><br>
<textarea name="'.$TITULO.'" id="'.$TITULO.'" cols="84" class="myinputstyle">'.$row[''.$TITULO.''].'</textarea><BR>
<b>Sumario:</b><br>
<textarea name="'.$EXTRACTO.'" id="'.$EXTRACTO.'" cols="84" class="myinputstyle">'.$row[''.$EXTRACTO.''].'</textarea>
<br>
<b>Reportero:</B><br>
El Reportero Seleccionado es: '.damereportero($row['NOT_REPORTERO']).'<br>
<SELECT id="REPORTEROS_LISTA" name="REPORTEROS_LISTA">
<option value="'.$row['NOT_REPORTERO'].'">Modifica Reportero</option>
<option value="0">SIN REPORTERO</option>
'.listadereporteros().'</SELECT> o escribe aqui su nombre para registrarlo:
 <input name="REPORTERO_NUEVO" id="REPORTERO_NUEVO" type="text" size="30" class="myinputstyle">
</div>

<div style="width:780px;">
<b>Contenido:</B><br>
<textarea name="'.$CONTENIDO.'" id="'.$CONTENIDO.'" style="width:100%;height:200px;">'.$row[''.$CONTENIDO.''].'</textarea>
</div>

<div style="width:400px; float:left;">
Video: <input name="art_Youtube" id="art_Youtube" value="'.$row['art_Youtube'].'" type="text" size="30" class="myinputstyle"><br>
foto1: <input name="'.$FOTO1.'" type="file" id="'.$FOTO1.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO1.''].''."'".',500,500);">
<img src="img/camera.png" border="0"></a><br>
foto2: <input name="'.$FOTO2.'" type="file" id="'.$FOTO2.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO2.''].''."'".',500,500);"><img src="img/camera.png" border="0"></a><br>
foto3: <input name="'.$FOTO3.'" type="file" id="'.$FOTO3.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO3.''].''."'".',500,500);"><img src="img/camera.png" border="0"></a><br>
foto4: <input name="'.$FOTO4.'" type="file" id="'.$FOTO4.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO4.''].''."'".',500,500);"><img src="img/camera.png" border="0"></a><br>
foto5: <input name="'.$FOTO5.'" type="file" id="'.$FOTO5.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO5.''].''."'".',500,500);"><img src="img/camera.png" border="0"></a><br>
foto6: <input name="'.$FOTO6.'" type="file" id="'.$FOTO6.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO6.''].''."'".',500,500);"><img src="img/camera.png" border="0"></a><br>
foto7: <input name="'.$FOTO7.'" type="file" id="'.$FOTO7.'"/>
<a href="javascript:despliega('."'".'../fotos/'.$row[''.$FOTO7.''].''."'".',500,500);"><img src="img/camera.png" border="0"></a><br>
<b>Las fotos deben estar en formato .jpg o gif.</b><br><br>
<b>Codigo de Video / Enlace Nacionales:</b>

<textarea name="art_Coment" id="art_Coment" cols="30" class="myinputstyle">'.$row['art_Coment'].'</textarea>
<br>

<br>
</div>

 Pie de Foto(s): <input name="art_PieFoto" id="art_PieFoto" type="text" size="30" class="myinputstyle">
<br>
Seccion: <select name="'.$SECCION.'" id="'.$SECCION.'" class="myinputstyle">
<option value="'.$row[''.$SECCION.''].'" selected>'.categoria_seleccionada($row[''.$SECCION.'']).'</option>
'.$resultados_categorias.'
</select>
<br><br>


Act. de Gobierno: <select name="GOBIERNO" id="GOBIERNO" class="myinputstyle">
<option value="'.$row['art_GobiernoID'].'" selected>Cambiar seccion</option>
'.$resultados_categorias.'
</select><br><br>

En Portada: <select name="'.$PORTADA_ID.'" id="'.$PORTADA_ID.'" class="myinputstyle">
<option value="'.$row[''.$PORTADA_ID.''].'" selected>'.portada_seleccionada($row[''.$PORTADA_ID.'']).'</option>
'.$resultados_portada.'
</select>
<br><Br>
<table border="1" cellpading="0" cellspacing="0" width="380">
<td width="50%" valign="top">

<input type="checkbox" name="art_Seguridad" id="art_Seguridad" value="1" '.verifica_Segurdad($row['art_Seguridad']).'> <b>Seguridad</b>
	<br>
<input type="checkbox" name="art_noesdeldia" id="art_noesdeldia" value="1" '.verifica_noesdeldia($row['art_noesdeldia']).'> <b>No es del dia</b>
		   <br>

<input type="checkbox" name="art_Protegido" id="art_Protegido" value="1" '.verifica_protegido().'> Protegida?		  <br>

<input type="checkbox" name="art_Actividades" id="art_Actividades" value="1"
'.verifica_actividades($row['art_Actividades']).' /> Actividades de Gobierno
<br>
<input type="checkbox" name="art_Comentarios" id="art_Comentarios" value="1" '.verifica_actividades($row['art_Comentarios']).' /> Activar Comentarios
<br>
Orientacion:
<select name="art_Orientacion" id="art_Orientacion" class="myinputstyle">
'.verifica_orientacion($row['art_Orientacion']).'
</select>
<br>
<td width="50%" valign="top">
 <input type="checkbox" name="art_Elecciones" id="art_Elecciones" value="1"  '.verifica_elecciones($row['art_Elecciones']).' /> Elecciones 2018<br>
<br>
Seccion 2018:
<select name="art_Portada_Elecciones" id="art_Portada_Elecciones" class="myinputstyle">
<option value="'.$row['art_Portada_Elecciones'].'">Cambiar</option>
<option value="1">Principal</option>
<option value="2">Destacados </option>
<option value="3">Mas informacion </option>

</select>
<br><br>

Partidos:
<select name="art_Partido" id="art_Partido" class="myinputstyle">
<option value="'.$row['art_Partido'].'">Cambiar</option>
<option value=""></option>
<option value="1">PRI</option>
<option value="2">PAN</option>
<option value="3">PRD</option>
<option value="6">MORENA</option>
<option value="4">INDEPENDIENTES</option>
<option value="5">OTROS</option>


</select>

Distrito:
<select name="art_elec_distrito" id="art_elec_distrito" class="myinputstyle">
	<option value="'.$row['art_elec_distrito'].'">Cambiar</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
</select>


</table>
<br><br>
<input type="submit" value="Salvar cambios">
</form>


';
}
}

elseif($action == 'modificar_completa')
{
include('variables.php');
$NOT_ID_DATO = $_GET[''.$ID.''];
$link = conectarse();
$consulta = 'SELECT '.$FOTO1.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto1 = ''.$row[''.$FOTO1.''].'';
}
$consulta = 'SELECT '.$FOTO2.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto2 = ''.$row[''.$FOTO2.''].'';
}
$consulta = 'SELECT '.$FOTO3.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto3 = ''.$row[''.$FOTO3.''].'';
}
$consulta = 'SELECT '.$FOTO4.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto4 = ''.$row[''.$FOTO4.''].'';
}
$consulta = 'SELECT '.$FOTO5.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto5 = ''.$row[''.$FOTO5.''].'';
}
$consulta = 'SELECT '.$FOTO6.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto6 = ''.$row[''.$FOTO6.''].'';
}
$consulta = 'SELECT '.$FOTO7.' FROM '.$NOTICIAS.' where '.$ID.' = '.$NOT_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$foto7 = ''.$row[''.$FOTO7.''].'';
}

//OBTENEMOS LOS DATOS DEL FORMULARIO ANTERIOR
$TITULO_DATO=$_POST[''.$TITULO.''];
$EXTRACTO_DATO=$_POST[''.$EXTRACTO.''];
$FECHA_DATO=$_POST[''.$FECHA.''];
$REPORTERO_DATO=$_POST[''.$REPORTERO.''];
$CONTENIDO_DATO=$_POST[''.$CONTENIDO.''];

$SECCION_ID_DATO=$_POST[''.$SECCION.''];
$PORTADA_ID_DATO=$_POST[''.$PORTADA_ID.''];
$MULTI_FOTO1_DATO= basename( $_FILES[''.$FOTO1.'']['name']);
$MULTI_FOTO2_DATO= basename( $_FILES[''.$FOTO2.'']['name']);
$MULTI_FOTO3_DATO= basename( $_FILES[''.$FOTO3.'']['name']);
$MULTI_FOTO4_DATO= basename( $_FILES[''.$FOTO4.'']['name']);
$MULTI_FOTO5_DATO= basename( $_FILES[''.$FOTO5.'']['name']);
$MULTI_FOTO6_DATO= basename( $_FILES[''.$FOTO6.'']['name']);
$MULTI_FOTO7_DATO= basename( $_FILES[''.$FOTO7.'']['name']);
$art_Protegido = $_POST['art_Protegido'];
$art_Coment = $_POST['art_Coment'];
$art_Orientacion = $_POST['art_Orientacion'];
$art_Elecciones = $_POST['art_Elecciones'];
$art_PieFoto = $_POST['art_PieFoto'];
$art_Actividades = $_POST['art_Actividades'];
$art_Youtube = $_POST['art_Youtube'];

$GOBIERNO = $_POST['GOBIERNO'];
$art_Seguridad = $_POST['art_Seguridad'];
$art_Partido = $_POST['art_Partido'];

$art_noesdeldia = $_POST['art_noesdeldia'];
$art_Portada_Elecciones = $_POST['art_Portada_Elecciones'];
$art_elec_distrito = $_POST['art_elec_distrito'];

//Reportero stuff

$REPORTEROLISTA = $_POST['REPORTEROS_LISTA'];

$REPORTERO_NUEVO = $_POST['REPORTERO_NUEVO'];

if($REPORTEROLISTA == '0')
{
if($REPORTERO_NUEVO == '')
{

}
else
{

mysql_query("insert INTO reporteros (REP_NOMBRE) values ('$REPORTERO_NUEVO')",$link);
$query = mysql_query("SELECT REP_ID from reporteros order by REP_ID desc",$link);
$data = mysql_fetch_array($query);

	$REPORTERO_DEFINITIVO = $data['REP_ID'];
}
}
else
{
$REPORTERO_DEFINITIVO = $REPORTEROLISTA;
}

$art_Comentarios = $_POST['art_Comentarios'];




if($art_Portada_Elecciones == '1')
{

//Como se pone una nota en principal, la informacion que este en principal se mueve a destacados
$query = mysql_query("SELECT art_ID from tabart where art_Portada_Elecciones = 1 order by art_ID desc limit 0,1",$link);
$data = mysql_fetch_array($query);
$IDANTERIOR = $data['art_ID'];

mysql_query("UPDATE tabart set art_Portada_Elecciones = 2 where art_ID = $IDANTERIOR",$link);

echo "y el ID ".$IDANTERIOR." se ha movido a Destacados (Elecciones 2016)";

}

if($art_Portada_Elecciones == '2')
{

//Como se mueve una nota a destacados, la informacion que este en el 6to lugar de destacados, dicha nota se ira a Mas inforamcion
$query = mysql_query("SELECT art_ID from tabart where art_Portada_Elecciones = 2 order by art_ID desc limit 4,1",$link);
$data = mysql_fetch_array($query);
$IDANTERIOR = $data['art_ID'];

mysql_query("UPDATE tabart set art_Portada_Elecciones = 3 where art_ID = $IDANTERIOR",$link);

echo "y el ID ".$IDANTERIOR." se ha movido a Mas Informacion (Elecciones 2016)";

}


//Verificamos que no se borren las fotos
if ($MULTI_FOTO1_DATO == '')
{
$MULTI_FOTO1_DATO= ''.$foto1.'';
}



if ($MULTI_FOTO2_DATO == '')
{
$MULTI_FOTO2_DATO= ''.$foto2.'';
}

if ($MULTI_FOTO3_DATO == '')
{
$MULTI_FOTO3_DATO= ''.$foto3.'';
}

if ($MULTI_FOTO4_DATO == '')
{
$MULTI_FOTO4_DATO= ''.$foto4.'';
}
if ($MULTI_FOTO5_DATO == '')
{
$MULTI_FOTO5_DATO= ''.$foto5.'';
}

if ($MULTI_FOTO6_DATO == '')
{
$MULTI_FOTO6_DATO= ''.$foto6.'';
}

if ($MULTI_FOTO7_DATO == '')
{
$MULTI_FOTO7_DATO= ''.$foto7.'';
}
//Termina Verificacion


//subimos los archivos, se hace un foreach para cada archivo
$target = "../fotos/"; //directorio a donde van los archivos
//subir fotos


$target1 = $target . basename( $_FILES[''.$FOTO1.'']['name']);
move_uploaded_file($_FILES[''.$FOTO1.'']['tmp_name'], $target1);
rename("../fotos/" . $MULTI_FOTO1_DATO, "../fotos/" . cambiar_espacios($MULTI_FOTO1_DATO));
$target2 = $target . basename( $_FILES[''.$FOTO2.'']['name']);
move_uploaded_file($_FILES[''.$FOTO2.'']['tmp_name'], $target2);
$target3 = $target . basename( $_FILES[''.$FOTO3.'']['name']);
move_uploaded_file($_FILES[''.$FOTO3.'']['tmp_name'], $target3);
$target4 = $target . basename( $_FILES[''.$FOTO4.'']['name']);
move_uploaded_file($_FILES[''.$FOTO4.'']['tmp_name'], $target4);
$target5 = $target . basename( $_FILES[''.$FOTO5.'']['name']);
move_uploaded_file($_FILES[''.$FOTO5.'']['tmp_name'], $target5);
$target6 = $target . basename( $_FILES[''.$FOTO6.'']['name']);
move_uploaded_file($_FILES[''.$FOTO6.'']['tmp_name'], $target6);
$target7 = $target . basename( $_FILES[''.$FOTO7.'']['name']);
move_uploaded_file($_FILES[''.$FOTO7.'']['tmp_name'], $target7);



$NOT_ID_DATO = $_GET[''.$ID.''];

	include('imgsize.php');
$target1 = "../fotos/" . cambiar_espacios($MULTI_FOTO1_DATO);
   if ($art_Orientacion == '3')
   {
	    $image = new SimpleImage();
   $image->load(''.$target1.'');
   $image->resizeToWidth(800);
   $image->save(''.$target1.'');
   }
   else
   {
   $image = new SimpleImage();
   $image->load(''.$target1.'');
   $image->resizeToWidth(500);
   $image->save(''.$target1.'');
   }


   /*Imagen de previo a una resolucion de 180px*/
   $image = new SimpleImage();
   $image->load(''.$target1.'');
   $image->resizeToWidth(180);
   $image->save(''.$target1.'_prev');

  $image = new SimpleImage();
   $image->load(''.$target2.'');
   $image->resizeToWidth(500);
   $image->save(''.$target2.'');
  $image = new SimpleImage();
   $image->load(''.$target3.'');
   $image->resizeToWidth(500);
   $image->save(''.$target3.'');
  $image = new SimpleImage();
   $image->load(''.$target4.'');
   $image->resizeToWidth(500);
   $image->save(''.$target4.'');
  $image = new SimpleImage();
   $image->load(''.$target5.'');
   $image->resizeToWidth(500);
   $image->save(''.$target5.'');
  $image = new SimpleImage();
   $image->load(''.$target6.'');
   $image->resizeToWidth(500);
   $image->save(''.$target6.'');
  $image = new SimpleImage();
   $image->load(''.$target7.'');
   $image->resizeToWidth(500);
   $image->save(''.$target7.'');


   $MULTI_FOTO_DATO = cambiar_espacios($MULTI_FOTO1_DATO);
//solo si activan modo de proteccion
//convertimos la variable art_Protegido a 0, si es null o vacio, para evitar bugs.
if($art_Protegido == '')
{
$art_Protegido = 0;
}



if ($art_Protegido == '1')
{
$verifica = verifica_protegido();

//Solo se activa si las fotos no han sido selladas
if ($verifica == "checked")
{

}
else
{

//Si no esta "checked" el campo "Art_Protegido", este automaticamente sellara las fotos, ya que solo debe hacerlas una vez, de lo contrario las letras se iran haciendo menos tenues.
include("watermark_image.class.php");
$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO_DATO.''); //Output Image

$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO2_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO2_DATO.''); //Output Image

$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO3_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO3_DATO.''); //Output Image

$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO4_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO4_DATO.''); //Output Image

$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO5_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO5_DATO.''); //Output Image

$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO6_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO6_DATO.''); //Output Image

$watermark = new watermark();
$main_img_obj = imagecreatefromjpeg('../fotos/'.$MULTI_FOTO7_DATO.''); //Image which you want to put watermark on
$watermark_img_obj = imagecreatefrompng("cntwatermark.png"); //Watermark image (PNG file)
$watermark->create_watermark( $main_img_obj, $watermark_img_obj, 100 );
$watermark->write('../fotos/'.$MULTI_FOTO7_DATO.''); //Output Image



}

}
else
{
}

$CONTENT = addslashes($CONTENIDO_DATO);

//inserta datos en la base de datos
mysql_query("UPDATE $NOTICIAS SET $TITULO='$TITULO_DATO', $EXTRACTO='$EXTRACTO_DATO', $REPORTERO='$REPORTERO_DEFINITIVO', $CONTENIDO='$CONTENT', $SECCION='$SECCION_ID_DATO', $FOTO1='$MULTI_FOTO_DATO', $FOTO2='$MULTI_FOTO2_DATO', $FOTO3='$MULTI_FOTO3_DATO', $FOTO4='$MULTI_FOTO4_DATO', $FOTO5='$MULTI_FOTO5_DATO', $FOTO6='$MULTI_FOTO6_DATO', $FOTO7='$MULTI_FOTO7_DATO', $PORTADA_ID='$PORTADA_ID_DATO', art_Protegido='$art_Protegido', art_Coment='$art_Coment', art_Orientacion='$art_Orientacion', art_Elecciones='$art_Elecciones', art_PieFoto='$art_PieFoto', art_Actividades='$art_Actividades', art_Youtube='$art_Youtube', art_GobiernoID='$GOBIERNO', art_Seguridad='$art_Seguridad', art_noesdeldia='$art_noesdeldia', art_Comentarios='$art_Comentarios', art_Partido='$art_Partido', art_Portada_Elecciones='$art_Portada_Elecciones', art_elec_distrito='$art_elec_distrito' WHERE $ID='$NOT_ID_DATO'", $link);
echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>La Informacion fue modificada</b><BR>
<a href=\"not.php\">Continuar</a>
<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"5;URL=not.php\">
</div>
</center>
<br><br>";
}
return $muestra;
}

function borrar_nota() {
$action = $_GET['action'];
include('variables.php');
$NOT_ID = $_GET[''.$ID.''];

if($action == 'borrar')
{
echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>Confirma eliminar la nota seleccionada</b><BR>
<a href=\"not.php?action=borrar_completado&$ID=$NOT_ID\">Confirmar</a>
</center>
<br><br>";
}
if($action == 'borrar_completado')
{
echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>Nota Borrada</b><BR>
<a href=\"not.php\">Continuar</a>
</center>
<br><br>
<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"5;URL=not.php\">
";

$link = conectarse();
include('variables.php');
mysql_query("delete from $NOTICIAS where $ID='$NOT_ID'",$link);
}
}

//MENSAJES//

function verifica_mensajes($MEN_ACTIVO)
{
if($MEN_ACTIVO == 1)
{
$resulta = '<img src="img/yes.gif">';
}
else
{
$resulta = '<img src="img/wrong.gif">';
}
return $resulta;

}

function mensajes_index() {
$action = $_GET['action'];
if (!$action)
{

{
include('variables.php');
//Conexi�n a la base de datos
$con = mysql_connect("$ADRESS","$USUARIO","$PASSWORD") or die (mysql_error());
mysql_select_db("$DATABASE",$con) or die (mysql_error());

//Sentencia sql (sin limit)
$_pagi_sql = 'SELECT * FROM '.$MENSAJES.' ORDER BY '.$MEN_ID.' desc';

//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 10;

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
include("paginator.inc.php");
include("variables.php");
//Leemos y escribimos los registros de la p�gina actual
while($row = mysql_fetch_array($_pagi_result))
{
$paginador .= '

<th>'.$row[''.$MEN_ID.''].'<td>'.$row[''.$MEN_NOMBRE.''].'<th>'.substr(($row[''.$MEN_MENSAJE.'']),0,100).'...
<th>
'.verifica_mensajes($row[''.$MEN_ACTIVO.'']).'

<th>

<table border="0">
<td>
<a href=men.php?action=autorizar&'.$MEN_ID.'='.$row[''.$MEN_ID.''].'><img src=img/nota_editar2.gif border=0 align=left> Autorizar</a>
</table>
</center>
</tr><tr>
';
}


}


$muestra = '<center>
<table border="0" width="500">
<th>


<th>
<a href="men.php">
<img src="img/nota_editar.gif" border="0" style="-moz-opacity:0.5;filter:alpha(opacity=50);cursor:hand"
onmouseover="this.style.MozOpacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.MozOpacity=0.5;this.filters.alpha.opacity=50">
<br>
Autoriza</a>
<th>

</table></center>
<br><br>
<center>

<table border="1" cellpadding="0" cellspacing="0" width="90%">
<th width="3%" background="css/silvergradient.gif"> ID
<th width="11%" background="css/silvergradient.gif"> Nombre
<th width="45%" background="css/silvergradient.gif"> Mensaje
<th width="10%" background="css/silvergradient.gif"> Autorizado

<th width="27%" background="css/silvergradient.gif"> Opciones</tr><tr>
'.$paginador.'

</table>
</center>

'.$_pagi_navegacion.'



';
}
if ($action == 'autorizar')
{
include('variables.php');
$MEN_ID_DATO = $_GET[''.$MEN_ID.''];
$link = conectarse();
$consulta = 'SELECT * FROM '.$MENSAJES.' where '.$MEN_ID.' = '.$MEN_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$muestra= '
<form action="men.php?action=autorizado_completo&'.$MEN_ID.'='.$MEN_ID_DATO.'" method="POST">
<b>Nombre:</b> <Input type name="MEN_NOMBRE" id="MEN_NOMBRE" value="'.$row[''.$MEN_NOMBRE.''].'" size="60"><br>
<b>Direccion IP:</b> '.$row[''.$MEN_IP.''].' '.$row['opi_Email'].'
<br>
<b>Mensaje:</b><br>
<textarea name="MEN_MENSAJE" id="MEN_MENSAJE" cols="84" rows="20" class="myinputstyle">'.$row[''.$MEN_MENSAJE.''].'</textarea>
<br><br>
<b>Autorizado</b><br>
<select name="MEN_ACTIVO" id="MEN_ACTIVO" class="myinputstyle">
<option value="0">No</option>
<option value="1">Si</option>
</select>

<INPUT TYPE="submit" NAME="accion" VALUE="Grabar" class="myinputstyle">
</form>

<br>


<br><Br><br></br>
';
}
}
if ($action == 'autorizado_completo')
{
include('variables.php');

$MEN_ID_DATO = $_GET[''.$MEN_ID.''];
$MEN_MENSAJE_DATO=$_POST['MEN_MENSAJE'];
$MEN_ACTIVO_DATO=$_POST['MEN_ACTIVO'];
$MEN_NOMBRE_DATO=$_POST['MEN_NOMBRE'];
include('variables.php');
$link=conectarse();
mysql_query("UPDATE $MENSAJES SET $MEN_MENSAJE='$MEN_MENSAJE_DATO', $MEN_ACTIVO='$MEN_ACTIVO_DATO', $MEN_NOMBRE='$MEN_NOMBRE_DATO' WHERE $MEN_ID='$MEN_ID_DATO'", $link);


$muestra = '
<center>
<div style="width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999">
<b>El mensaje fue modificado</b><br>
<a href="men.php">Continuar</a>
<meta HTTP-EQUIV="Refresh" CONTENT="5;URL=men.php">
</div>
</center>
<br><br>

';

}
return $muestra;
}


//*Denuncias*//

function denuncias_index() {
$action = $_GET['action'];
if (!$action)
{

{
include('variables.php');
//Conexi�n a la base de datos
$con = mysql_connect("$ADRESS","$USUARIO","$PASSWORD") or die (mysql_error());
mysql_select_db("$DATABASE",$con) or die (mysql_error());
mysql_set_charset('utf8',$con);

//Sentencia sql (sin limit)
$_pagi_sql = 'SELECT * FROM '.$DENUNCIAS.' ORDER BY '.$DEN_ID.' desc';

//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 50;

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
include("paginator.inc.php");
include("variables.php");
//Leemos y escribimos los registros de la p�gina actual
while($row = mysql_fetch_array($_pagi_result))
{
$paginador .= '
<th>'.$row[''.$DEN_ID.''].'<td>'.$row[''.$DEN_NOMBRE.''].'<th>'.substr(($row[''.$DEN_MENSAJE.'']),0,200).'...
<th><centeR>
<table border="0">
<td>
<a href=den.php?action=autorizar_denuncia&'.$DEN_ID.'='.$row[''.$DEN_ID.''].'><img src=img/nota_editar2.gif border=0 align=left> Autorizar</a>
</table>
</center>
</tr><tr>
';
}


}


$muestra = '<center>
<table border="0" width="500">
<th>


<th>
<a href="men.php">
<img src="img/nota_editar.gif" border="0" style="-moz-opacity:0.5;filter:alpha(opacity=50);cursor:hand"
onmouseover="this.style.MozOpacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.MozOpacity=0.5;this.filters.alpha.opacity=50">
<br>
Autoriza</a>
<th>

</table></center>
<br><br>
<center>

<table border="0" cellpadding="0" cellspacing="0" width="90%">
<th width="3%" background="css/silvergradient.gif"> ID
<th width="11%" background="css/silvergradient.gif"> Nombre
<th width="45%" background="css/silvergradient.gif"> Mensaje
<th width="27%" background="css/silvergradient.gif"> Opciones</tr><tr>
'.$paginador.'

</table>
</center>

'.$_pagi_navegacion.'



';
}
if ($action == 'autorizar_denuncia')
{
include('variables.php');
$DEN_ID_DATO = $_GET[''.$DEN_ID.''];
$link = conectarse();
$consulta = 'SELECT * FROM '.$DENUNCIAS.' where '.$DEN_ID.' = '.$DEN_ID_DATO.' '; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$muestra= '
<form action="den.php?action=autorizado_completo_denuncia&'.$DEN_ID.'='.$DEN_ID_DATO.'" method="POST">
<b>Nombre:</b> <Input type name="MEN_NOMBRE" id="MEN_NOMBRE" value="'.$row[''.$DEN_NOMBRE.''].'" size="60" disabled><br>
<b>Direccion IP:</b> '.$row[''.$DEN_IP.''].'
<br>
<b>Mensaje:</b><br>
<textarea name="MEN_MENSAJE" id="MEN_MENSAJE" cols="84" rows="20" class="myinputstyle">'.$row[''.$DEN_MENSAJE.''].'</textarea>
<br><br>
<b>Autorizado</b><br>
<select name="MEN_ACTIVO" id="MEN_ACTIVO" class="myinputstyle">
<option value="0" selected>No</option>
<option value="1" selected>Si</option>
</select>

<INPUT TYPE="submit" NAME="accion" VALUE="Grabar" class="myinputstyle">
</form>

<br>


<br><Br><br></br>
';
}
}
if ($action == 'autorizado_completo_denuncia')
{
include('variables.php');
$link=conectarse();
$MEN_ID_DATO = $_GET['DEN_ID'];
$MEN_MENSAJE_DATO=$_POST['MEN_MENSAJE'];
$MEN_ACTIVO_DATO=$_POST['MEN_ACTIVO'];
mysql_query("UPDATE $DENUNCIAS SET $DEN_MENSAJE='$MEN_MENSAJE_DATO', $DEN_ACTIVO='$DEN_ACTIVO_DATO' WHERE $DEN_ID='$MEN_ID_DATO'", $link);

$muestra = '
<center>
<div style="width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999">
<b>La denuncia fue modificada</b><br>
<a href="den.php">Continuar</a>
<meta HTTP-EQUIV="Refresh" CONTENT="5;URL=den.php">
</div>
</center>
<br><br>

';

}
return $muestra;
}

function radioonline()

{
include('variables.php');
$link = conectarse();
$consulta = "select * from $RADIO";
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$resulta = '
Nombre de la Radio: <b>'.$row[''.$RAD_NOMBRE.''].'</b><br>
</div>
';
$radstatus = 	$row[''.$RAD_STATUS.''];

}

echo "
<h1>Radio Online</h1>
<div style='width:98%; height:auto; float:left; border:1px solid #999999; margin-bottom:5px;'>
<br>
";

if($radstatus == 1)
{
echo "Status de la Radio Online: <b><font color=green>On</font></b>/
<a href=rad.php?action=desactivar>Desactivar</a><br>";
}
else
{
	echo "Status de la Radio Online: <b><font color=red>Off</font></b>/<a href=rad.php?action=activar>Activar</a><br> ";
	}

return $resulta;



}

function radionline()
{

$action = $_GET['action'];
if($action == 'desactivar')
{
include('variables.php');
$link=conectarse();
mysql_query("UPDATE $RADIO SET $RAD_STATUS='0' WHERE $RAD_STATUS='1'", $link);
echo '<center>

<div style="width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999">
<b>La Informacion fue modificada</b><BR>


</div>
</center>
<br><br>';

}

if($action == 'activar')
{
include('variables.php');
$link=conectarse();
mysql_query("UPDATE $RADIO SET $RAD_STATUS='1' WHERE $RAD_STATUS='0'", $link);
echo '<center>

<div style="width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999">
<b>La Informacion fue modificada</b><BR>


</div>
</center>
<br><br>';

}




}


function radioffline()
{

	echo "
<h1>Radio Offline</h1>
<div style='width:98%; height:auto; float:right; border:1px solid #999999; margin-bottom:5px;'>
<center><a href=../radio/admin/>Administrar Radio Offline</a></center>
</div>
";
	}


function encuesta()

{
echo '
<table border="0" width="100%">
<th><center>
<a href="enc.php?action=agregar_encuesta">Agregar nueva encuesta
<img src="img/encuesta.jpg" border="0">
</a><br>

</center>
<th>
<center>
<a href="enc.php?action=resultados_encuesta">Ver resultados de la encuesta actual
<img src="img/encuestaop.jpg" border="0"></a>
</center>
</table>
';
	}


	function encuesta_agregar()
	{
$action = $_GET['action'];
if ($action == 'agregar_encuesta')
{
		echo '

<br><br>
<center>
<div style="width:500px; height:auto; background: #CC0000; border:1px solid #999999; color:#FFFFFF">
<b>IMPORTANTE: Si ya existe otra encuesta, al registrar una nueva, todos los votos y preguntas de la encuesta activa seran borrados.</b>
</div>
</center>
<br><br>

<h2>Nueva Encuesta</h2>
<form action="enc.php?action=encuesta_completa" method="post" enctype="multipart/form-data">
<center>
Pregunta: <Input type name="ENC_PREGUNTA" id="ENC_PREGUNTA" size="60" class="myinputstyle">
<br><br>
</center>
<b>Respuestas</b>
<br><br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 1 <Input type name="ENC_OPCION1" id="ENC_OPCION1" size="60" class="myinputstyle">
</div></div>
<br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 2 <Input type name="ENC_OPCION2" id="ENC_OPCION2" size="60" class="myinputstyle">
</div></div>
<br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 3 <Input type name="ENC_OPCION3" id="ENC_OPCION3" size="60" class="myinputstyle">
</div></div>
<br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 3 <Input type name="ENC_OPCION3" id="ENC_OPCION3" size="60" class="myinputstyle">
</div></div>

<br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 4 <Input type name="ENC_OPCION4" id="ENC_OPCION4" size="60" class="myinputstyle">
</div></div>

<br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 5 <Input type name="ENC_OPCION5" id="ENC_OPCION5" size="60" class="myinputstyle">
</div></div>

<br>
<div style="width:100%; height:auto; border:1px solid #CCCCCC;">
<div id="margentexto">
Opcion 6 <Input type name="ENC_OPCION6" id="ENC_OPCION6" size="60" class="myinputstyle">
</div></div>
<br>
<input type="submit" value="Registrar" class="myinputstyle">
<br>
*Una  vez registrada la encuesta, esta se publicara de forma inmediata en el sitio. usted puede monitorear en cada momento la encuesta y sus resultados.
</form>
';
}
if ($action == "encuesta_completa")
{
echo "
<br><br>
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>La Informacion fue registrada</b>
</div>
</center>
<br><br>
";
include('variables.php');
$link = conectarse();
$ENC_PREGUNTA_DATO=$_POST[''.$ENC_PREGUNTA.''];
$ENC_OPCION1_DATO=$_POST[''.$ENC_OPCION1.''];
$ENC_OPCION2_DATO=$_POST[''.$ENC_OPCION2.''];
$ENC_OPCION3_DATO=$_POST[''.$ENC_OPCION3.''];
$ENC_OPCION4_DATO=$_POST[''.$ENC_OPCION4.''];
$ENC_OPCION5_DATO=$_POST[''.$ENC_OPCION5.''];
$ENC_OPCION6_DATO=$_POST[''.$ENC_OPCION6.''];

mysql_query("UPDATE $ENCUESTA SET $ENC_PREGUNTA='$ENC_PREGUNTA_DATO', $ENC_OPCION1='$ENC_OPCION1_DATO', $ENC_OPCION2='$ENC_OPCION2_DATO', $ENC_OPCION3='$ENC_OPCION3_DATO', $ENC_OPCION4='$ENC_OPCION4_DATO', $ENC_OPCION5='$ENC_OPCION5_DATO', $ENC_OPCION6='$ENC_OPCION6_DATO' WHERE ENC_ID='1'", $link);

mysql_query("UPDATE $ENCUESTA SET $ENC_CANTIDAD1='0', $ENC_CANTIDAD2='0', $ENC_CANTIDAD3='0', $ENC_CANTIDAD4='0', $ENC_CANTIDAD5='0', $ENC_CANTIDAD6='0' WHERE ENC_ID='1'", $link);

	}
		}

function resultados_encuesta()
{
include('variables.php');
$action = $_GET['action'];
if($action == 'resultados_encuesta')
{
$link = conectarse();
$consulta = 'SELECT * FROM '.$ENCUESTA.' WHERE ENC_ID = 1';
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
	$resulta = '
<center><b><h1>Resultados actuales de la encuesta</h1></b></center>
<br>
<B>Pregunta</b> '.$row[''.$ENC_PREGUNTA.''].'
<br><CENTER>
<table border="1" CELLPADDING="0" CELLSPACING="0" width="50%">
<th WIDTH="23%">
OPCION
<TH WIDTH="56%">

<TH WIDTH="23%">
CANTIDAD
</TR><TR>
<th>
Opcion 1:
<th>
'.$row[''.$ENC_OPCION1.''].'
</Th>
<th>
'.$row[''.$ENC_CANTIDAD1.''].'
</Th>
</TR><TR>
<th>
Opcion 2:
<th>
'.$row[''.$ENC_OPCION2.''].'
</Th>
<th>
'.$row[''.$ENC_CANTIDAD2.''].'
</Th>
</TR><TR>
<th>
Opcion 3:
<th>
'.$row[''.$ENC_OPCION3.''].'
</Th>
<th>
'.$row[''.$ENC_CANTIDAD3.''].'
</Th>
</TR><TR>
<th>
Opcion 4:
<th>
'.$row[''.$ENC_OPCION4.''].'
</Th>
<th>
'.$row[''.$ENC_CANTIDAD4.''].'
</Th>
</TR><TR>
<th>
Opcion 5:
<th>
'.$row[''.$ENC_OPCION5.''].'
</Th>
<th>
'.$row[''.$ENC_CANTIDAD5.''].'
</Th>
</TR><TR>
<th>
Opcion 6:
<th>
'.$row[''.$ENC_OPCION6.''].'
</Th>
<th>
'.$row[''.$ENC_CANTIDAD6.''].'
</Th>

</table>
<BR><BR><BR><BR>
';
	}
return $resulta;
}
else
{
	echo "";
	}
}

function newsletter()
{
	echo '<center>Opciones: <a href="php/add_mail.php" target="work">Agregar nueva direccion de email</a> // <a href="php/delete_mail.php" target="work">Borrar direccion de Mail</a> // <a href="php/send_mail.php" target="work">Enviar Newsletter!</a>

<iframe src="" width="600" height="400" scrolling="yes" name="work"></iframe></center>';

	}



function frase_index() {
include('variables.php');

$link = conectarse();
$action = $_GET['action'];
$consulta = 'SELECT * FROM frase where ID_FRASE = 1'; //Consulta a la base de datos
$query = mysql_query($consulta,$link) or die(mysql_error()); // Creacion del query
while($row=mysql_fetch_array($query))
{
$muestra= '
<form action="fra.php?action=fraseactualizada" method="POST">
<b>Nombre:</b> <Input type name="AUTOR" id="AUTOR" value="'.$row['AUTOR'].'" size="60"><br>

<br>
<b>Frase</b><br><center>
<textarea name="FRASE" id="FRASE" cols="80" rows="5" class="myinputstyle">'.$row['FRASE'].'</textarea>
<br><br></center>


<INPUT TYPE="submit" NAME="accion" VALUE="Grabar" class="myinputstyle">
</form>

<br>


<br><Br><br></br>
';
}

if ($action == 'fraseactualizada')
{

include('variables.php');
$link=conectarse();
$AUTOR=$_POST['AUTOR'];
$FRASE=$_POST['FRASE'];
mysql_query("UPDATE frase SET AUTOR='$AUTOR', FRASE='$FRASE' WHERE ID_FRASE='1'", $link);

$muestra = '
<center>
<div style="width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999">
<b>El mensaje fue modificado</b><br>
<a href="fra.php">Continuar</a>
<meta HTTP-EQUIV="Refresh" CONTENT="5;URL=fra.php">
</div>
</center>
<br><br>

';

}
return $muestra;
}

//Publicidad
function publicidad()
{

$action = $_GET['action'];
if($action == '')
{
echo '
<center>
<table border="0" width="80%">
<th>
<a href="pub.php?action=publicidad_nueva">
<img src="img/pub.jpg" border="0"><br>
Nueva Publicidad</a><br>

<th>

<a href="pub.php?action=publicidad_modificar">
<img src="img/pubmd.jpg" border="0"><br>
Modificar Publicidad</a><br>
</table>
</center>
';
}

if($action == 'publicidad_nueva')
{
echo '
<center>
<table width="50%" border="1" cellpadding="0" cellspacing="0">
<td>
<div id="margentexto">
<form action="pub.php?action=publicidad_registro"  method="post" enctype="multipart/form-data">
Nombre: <input type="text" id="PUB_NOMBRE" name="PUB_NOMBRE" size="40"><br>

<input type="radio" name="PUB_TIPO" id="PUB_TIPO" value="Archivo" selected> Mediante archivo<br>
Archivo: <input name="PUB_IMAGEN" id="PUB_IMAGEN" type="file" /><br />
Link*: <i>http://</i> <input type="text" id="PUB_ENLACE" name="PUB_ENLACE" size="36"><br>
<br>
<input type="radio" name="PUB_TIPO" id="PUB_TIPO" value="Codigo" selected> Mediante un codigo<br>
<textarea style="width:80%" name="PUB_CODIGO" id="PUB_CODIGO"></textarea>
<br>
Area: <select name="PUB_REGION" id="PUB_REGION">
<option value="0">Selecciona</option>
<option value="1">Area 1</option>
<option value="2">Area 2</option>
<option value="3">Area 3</option>
<option value="4">Area 4</option>
<option value="5">Area 5</option>
<option value="6">Area 6</option>
<option value="7">Area 7</option>
<option value="8">Area 8</option>
</select><br>

<input type="submit" value="Subir" />
</form>
</div>
</table>
<br>
<img src="img/mapa.gif">
</center>

';
}
if($action == 'publicidad_registro')
{
$link = conectarse();
$target = "../fotos/";
$target = $target . basename( $_FILES['PUB_IMAGEN']['name']) ;
$PUB_IMAGEN_DATO = basename( $_FILES['PUB_IMAGEN']['name']);
$PUB_NOMBRE = $_POST['PUB_NOMBRE'];
$PUB_ENLACE = $_POST['PUB_ENLACE'];
$PUB_REGION = $_POST['PUB_REGION'];
$PUB_TIPO = $_POST['PUB_TIPO'];
$PUB_CODIGO = $_POST['PUB_CODIGO'];
$ok=1;
if(move_uploaded_file($_FILES['PUB_IMAGEN']['tmp_name'], $target))
{
echo "<center>�El archivo ". basename( $_FILES['uploadedfile']['name']). " Ha sido subido con exito!, La publicidad debe estar online ahora.</center>
<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=pub.php'>

";
}
else {
echo "Hubo un problema subiendo el archivo, por favor, verifica.
<body onload=\"javascript:history.back()\">
";
}
error_reporting(E_ALL);

mysql_query("INSERT into publicidad (PUB_NOMBRE, PUB_IMAGEN, PUB_ENLACE, PUB_REGION, PUB_TIPO) values ('$PUB_NOMBRE', '$PUB_IMAGEN_DATO', '$PUB_ENLACE', '$PUB_REGION', '$PUB_TIPO')",$link);

}
if($action == 'publicidad_modificar')
{

$resultado = '';
include('variables.php');
$link = conectarse();
ERROR_REPORTING(E_ALL);
$consulta = 'SELECT * FROM publicidad ORDER BY PUB_ID DESC LIMIT 0,100';
$query = mysql_query($consulta,$link) or die(mysql_error());
echo '<center><table border="1" cellpadding="0" cellspacing="0" width="80%">
';

while($row=mysql_fetch_array($query))
{
$resultado .= '
<td>
- <a href="pub.php?action=publicidad_modificar_registro&PUB_ID='.$row['PUB_ID'].'">'.$row['PUB_NOMBRE'].'</a><br>
<th width="30%"><center>
<a href="pub.php?action=publicidad_modificar_registro&PUB_ID='.$row['PUB_ID'].'">Modificar</a> //
<a href="pub.php?action=publicidad_borrar_registro&PUB_ID='.$row['PUB_ID'].'">Borrar</a>
</center>

</tr><tr>
';

}
return $resultado;
echo '</table></center>';
}
if($action == 'publicidad_modificar_registro')

{
include('variables.php');
$link = conectarse();
ERROR_REPORTING(E_ALL);
$PUB_ID = $_GET['PUB_ID'];
$consulta = 'SELECT * FROM publicidad where PUB_ID = '.$PUB_ID.' LIMIT 0,1';
$query = mysql_query($consulta,$link) or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$resulta = '
<center>
<table width="50%" border="1" cellpadding="0" cellspacing="0">
<td>
<div id="margentexto">
<form action="pub.php?action=modifica_completo&PUB_ID='.$PUB_ID.'"  method="post" enctype="multipart/form-data">
Nombre: <input type="text" id="PUB_NOMBRE" name="PUB_NOMBRE" value='.$row['PUB_NOMBRE'].' size="40"><br>
Archivo: <input name="PUB_IMAGEN" id="PUB_IMAGEN" type="file" /><br />
Link*: <i>http://</i> <input type="text" id="PUB_ENLACE" name="PUB_ENLACE" value="'.$row['PUB_ENLACE'].'" size="36"><br>
<br>
Tipo de Banner:
<select name="PUB_TIPO" id="PUB_TIPO">
<option value="'.$row['PUB_TIPO'].'">Cambiar</option>
<option value="0">Selecciona</option>
<option value="1">Flash (.swf)</option>
<option value="2">Imagen (JPG,PNG,GIF...)</option>
</select><br>

Area: <select name="PUB_REGION" id="PUB_REGION">
<option value="'.$row['PUB_REGION'].'">Cambiar</option>
<option value="0">Selecciona</option>
<option value="1">Area 1</option>
<option value="2">Area 2</option>
<option value="3">Area 3 (Dentro de la nota)</option>
</select><br>
<br>
<b>Banner:</b>
<img src="../fotos/'.$row['PUB_IMAGEN'].'">

<input type="submit" value="Modificar" />
</form>
</div>
</table>
<br>
<img src="img/mapa.gif">

';

}
return $resulta;
}

if($action == 'modifica_completo')
{

$link = conectarse();
error_reporting(E_ALL);
$target = "../fotos/";
$PUB_ID = $_GET['PUB_ID'];

$target = $target . basename( $_FILES['PUB_IMAGEN']['name']) ;
$PUB_IMAGEN_DATO = basename( $_FILES['PUB_IMAGEN']['name']);

$PUB_NOMBRE = $_POST['PUB_NOMBRE'];
$PUB_ENLACE = $_POST['PUB_ENLACE'];
$PUB_REGION = $_POST['PUB_REGION'];
$PUB_TIPO = $_POST['PUB_TIPO'];
$ok=1;



if(move_uploaded_file($_FILES['PUB_IMAGEN']['tmp_name'], $target))
{
echo "<center>�El archivo Ha sido subido con exito!, La publicidad debe estar online ahora.</center>
<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=pub.php'>

";
}
else {
echo "
<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=pub.php'>
";
}

if($PUB_IMAGEN_DATO == '')
{
mysql_query("UPDATE publicidad SET PUB_NOMBRE='$PUB_NOMBRE', PUB_ENLACE='$PUB_ENLACE', PUB_REGION='$PUB_REGION', PUB_TIPO='$PUB_TIPO' WHERE PUB_ID='$PUB_ID'", $link);
}
else
{
mysql_query("UPDATE publicidad SET PUB_NOMBRE='$PUB_NOMBRE', PUB_IMAGEN='$PUB_IMAGEN_DATO', PUB_ENLACE='$PUB_ENLACE', PUB_REGION='$PUB_REGION', PUB_TIPO='$PUB_TIPO' WHERE PUB_ID='$PUB_ID'", $link);
}

}

if($action == 'publicidad_borrar_registro')
{
$PUB_ID = $_GET['PUB_ID'];
echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>Confirma eliminar la publicidad seleccionada</b><BR>
<a href=\"pub.php?action=publicidad_borrar_registro_completo&PUB_ID=$PUB_ID\">Confirmar</a>
</center>
<br><br>";
}

if($action == 'publicidad_borrar_registro_completo')
{
{
$PUB_ID = $_GET['PUB_ID'];

$link = conectarse();
mysql_query("delete from publicidad where PUB_ID='$PUB_ID'",$link);

echo "
<center>
<div style='width:500px; height:auto; background: #CCCCCC url(img/bga.gif); border:1px solid #999999'>
<b>Publicidad Borrada</b><BR>
</center>
<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=pub.php'>

<br><br>";
}
}


}

function subircomic()
{


$resultados_categorias ='';
$resultados_portada = '';
$action = '';
	$action = $_GET['action'];
include('variables.php');
$link = conectarse();
if($FECHACONFIGURACION == '1')
{
$fecha = cambiarfecha('0');
}
else
{
$fecha = time ();
$fechabin = time ();
		   $mes= date("M",$fechabin);
			   switch ($mes){
			   		case "Jan": $mes="Ene";break;
					case "Aug": $mes="Ago";break;
					case "Dec": $mes="Dic";break;
				}
					$fechabin = time();
				$fecha = time();
			   $fechabin = date("j ",$fechabin).$mes.date(" y(H:i:s)",$fechabin);

}

echo '

<form action="index.php?action=subircomic_completo" enctype="multipart/form-data" method="post">
<textarea name="'.$TITULO.'" id="'.$TITULO.'" cols="39" class="myinputstyle"></textarea>
<div style="width:380px; float:left;">
<b>Fecha:</B><br>
 <i>'.$fechabin.'</i>
<input type="hidden" name="'.$FECHA.'" id="'.$FECHA.'" value="'.$fecha.'" /><br>
carton: <input name="'.$FOTO1.'" type="file" id="'.$FOTO1.'"/><br>
<input type="hidden" name="art_Portada" value="13">

<input type="hidden" name="cat_ID" value="94">

<input type="submit" value="Grabar">
</form>
';
if ($action == 'subircomic_completo')
{
include('variables.php');
$link = conectarse();
//OBTENEMOS LOS DATOS DEL FORMULARIO ANTERIOR
$TITULO_DATO=$_POST[''.$TITULO.''];
$EXTRACTO_DATO=$_POST[''.$EXTRACTO.''];
$FECHA_DATO=$_POST[''.$FECHA.''];
$REPORTERO_DATO=$_POST[''.$REPORTERO.''];
$CONTENIDO_DATO=$_POST[''.$CONTENIDO.''];
$SECCION_ID_DATO=$_POST[''.$SECCION.''];
$PORTADA_ID_DATO=$_POST[''.$PORTADA_ID.''];
$MULTI_FOTO1_DATO= basename( $_FILES[''.$FOTO1.'']['name']);
//subimos los archivos, se hace un foreach para cada archivo

$target = "../fotos/"; //directorio a donde van los archivos
//subir fotos
$target1 = $target . basename( $_FILES[''.$FOTO1.'']['name']);
move_uploaded_file($_FILES[''.$FOTO1.'']['tmp_name'], $target1);

if ($RESIZE_ON = 'on')
{
	include('imgsize.php');
   $image = new SimpleImage();
   $image->load(''.$target1.'');
   $image->resizeToWidth(500);
   $image->save(''.$target1.'');
}
else
{

}

mysql_query("INSERT into $NOTICIAS ($TITULO,$EXTRACTO,$FECHA,$CONTENIDO,$SECCION,$PORTADA_ID,$FOTO1) values ('$TITULO_DATO', '$EXTRACTO_DATO', '$FECHA_DATO', '$CONTENIDO_DATO', '$SECCION_ID_DATO', '$PORTADA_ID_DATO', '$MULTI_FOTO1_DATO')",$link);

echo '
<center><b>Carton registrado</b></center>
<meta HTTP-EQUIV="Refresh" CONTENT="1;URL=index.php">
';




}

}

function activarenvivo()
{
	$action = $_GET['action'];
echo '

<form action="index.php?action=modificacion" method="post">
<table border="1" width="100%">
<td width="70%" valign="top">

<td width="15%" valign="top" bgcolor="#990000" style="color:#FFF">
Off
<td width="15%" valign="top" bgcolor="#009900" style="color:#FFF">
On




</tr><tr>
<td width="70%" valign="top">
Activar transmision en vivo<br>

<td width="15%" valign="top">
    <input type="radio" name="envivo" value="0" />

<td width="15%" valign="top">
    <input type="radio" name="envivo" value="1" />
</tr><tr>
<td width="70%" valign="top">
Solo 1 portada<br>

<td width="15%" valign="top">
    <input type="radio" name="1portada" value="0" />

<td width="15%" valign="top">
    <input type="radio" name="1portada" value="1" />

</table>
<input type="submit" value="Grabar">
</form>
';
if ($action == 'modificacion')
{
include('variables.php');

$link = conectarse();
//OBTENEMOS LOS DATOS DEL FORMULARIO ANTERIOR
$activa_envivo=$_POST['envivo'];
$activa_1portada=$_POST['1portada'];
if($activa_envivo == '')
{}
else {
mysql_query("UPDATE eld_config SET ACTIVO = '$activa_envivo' WHERE ID = '2'", $link);
}
if($activa_1portada == '')
{}
else
{
mysql_query("UPDATE eld_config SET ACTIVO = '$activa_1portada' WHERE ID = '1'", $link);
}
echo '
<center><b>Modificacion realizada</b></center>
<meta HTTP-EQUIV="Refresh" CONTENT="1;URL=index.php">
';




}

}


?>
