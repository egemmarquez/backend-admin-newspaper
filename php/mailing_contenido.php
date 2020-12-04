<?php 

include('../funciones/conectarse.php');
include('../funciones/funciones.php');
?>
<center>
<table border= 0  width= 800 >
<td>
<a href="http://www.cntamaulipas.info" target="_blank" border="0" ><img src="http://localhost/admin/img/eld_boletin.png" border="0">
</tr><tr>
<td bgcolor= #000000 ><font face= Arial, Helvetica, sans-serif  color= #FFFFFF  size= 2 >Portada</font>
</tr><tr>
<td><font face= Arial, Helvetica, sans-serif  size= 2 >
<?php echo portada_n() ?>
</table>
<table border= 0  width= 800 >
<td width= 250  valign= top >
<table border= 0  width= 250 >
<td bgcolor= #000000 ><font face= Arial, Helvetica, sans-serif  color= #FFFFFF  size= 2 >Más portadas:</font>
</tr><tr>
<td><font face= Arial, Helvetica, sans-serif  size= 2 >
<?php echo portadas_n() ?>
</table>
<td width= 520  valign="top">
<table border= 0  width= 529 >
<td bgcolor= #000000 ><font face= Arial, Helvetica, sans-serif  color= #FFFFFF  size= 2 >Destacados:</font>
</tr><tr>
<?php echo destacados_n() ?>
</table>

<table border= 0  width= 529 >
<td><font face= Arial, Helvetica, sans-serif  size= 2 >
<b>Columnas:</b><br />
<?php echo index_opinion_n() ?>

</table>
</table>
<table border= 0  width= 800 >
<td width= 800  colspan= 4  bgcolor= #000000 ><font face= Arial, Helvetica, sans-serif  color= #FFFFFF  size= 2 > Multimedia</font>
</tr><tr><font face= Arial, Helvetica, sans-serif  size= 2 >
<?Php echo muestra_masvideos_n() ?>


</table>
<center>
<font face= Arial, Helvetica, sans-serif  size= 4 >
<b>¿No visualizas bien este boletín? visita, <a href= http://www.cntamaulipas.info  target= _blank >WWW.CNTAMAULIPAS.INFO</a><br />
</center>
<img src="http://www.astromante.com/admin/mailing_bottom.png" />

</center>
