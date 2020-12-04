<?php 

function categorias() {
{
include('variables.php');

echo '<div class="applemenu">';

if($INICIO_SECCION == '1')
{
echo '
		
<div class="silverheader Estilo1"><a href="index.php"><b><img src="img/hom.png" border="0"/>Inicio</b></a></div>
	<div class="submenu Estilo1">
	- <a href="'.$URL.'" target="_blank">Ver pagina</a><br />
    - <a href="'.$ESTADISTICAS_ALEXA.'" target="_blank">Ver estadisticas</a><br />
    - <a href="index.php">Acerca de Administrador</a><br />   
        - <a href="index.php?doLogout=true">Desconectarse</a><br />   
	</div>
	
	';
	
	}
	
	if($SECCIONES_SECCION == '1')
	{
	echo '
<div class="silverheader Estilo1"><a href="index.php" ><img src="img/sec.png" border="0"/>Secciones</a></div>

	<div class="submenu Estilo1">
    - <a href="sec.php">Ver secciones</a><br />
    - <a href="sec.php?action=add" >Agregar secciones</a><br />
    - <a href="sec.php" >Editar secciones</a><br />	
    - <a href="sec.php" >Borrar Secciones</a><br />    
    </div>
	
	';
	}
	
	
	if($NOTICIAS_SECCION == '1')
	{
	
echo '


<div class="silverheader Estilo1"><a href="index.php"><img src="img/not.png" border="0"/>Noticias</a></div>
	<div class="submenu Estilo1">
    - <a href="not.php" >Ver Noticias</a><br />    
    - <a href="not.php?action=noticias_nueva">Agregar Noticias</a><br />
    - <a href="not.php" >Editar Noticias</a><br />          
    - <a href="not.php" >Borrar Noticias</a><br />   
	- <a href="javascript:despliega(\'art_Rotativo.php\', 550,310);">Portada Rotativa</a>
  
	</div>
';
}
if($CORREO_MASIVO_SECCION == '1')
	{
echo '
<div class="silverheader Estilo1"><a href="index.php"><img src="img/music.png" border="0"/>Enviar Correo Masivo</a></div>

	<div class="submenu Estilo1">
    - <a href="mai.php" >Agregar Correo</a><br />    
- <a href="mai.php" >Enviar Boletin</a><br />              

	</div>';

}

if($DENUNCIAS_SECCION == '1')
{
echo'
<div class="silverheader Estilo1"><a href="index.php"><img src="img/not.png" border="0"/>Denuncias</a></div>

	<div class="submenu Estilo1">
    - <a href="den.php" >Ver Denuncias</a><br />    

	</div>

';

}

if($GALERIA_SECCION == '1')
{
echo'
<div class="silverheader Estilo1"><a href="index.php"><img src="img/sec.png" border="0"/>Galeria</a></div>

	<div class="submenu Estilo1">
<a href="galeria.php">Agregar Galeria</a><br />
<a href="agregarfotos.php">Agregar Fotos</a><br />
<a href="galeria.php?action=modificar_galeria">Modificar/Borrar Galerias</a><br />
	</div>

';

}

if($RADIO_SECCION == '1')
{
echo'
<div class="silverheader Estilo1"><a href="index.php"><img src="img/rad.png" border="0"/>Radio</a></div>

	<div class="submenu Estilo1">
    - <a href="rad.php" >Administrar Radio</a><br />    
             

	</div>

';

}

if($ENCUESTAS_SECCION == '1')
{
echo'
<div class="silverheader Estilo1"><a href="index.php"><img src="img/enc.png" border="0"/>Encuestas</a></div>

	<div class="submenu Estilo1">
    - <a href="enc.php" >Administrar Encuestas</a><br />    
             

	</div>

';

}

if($MENSAJES_SECCION == '1')
{
echo'
<div class="silverheader Estilo1"><a href="index.php"><img src="img/men.png" border="0"/>Mensajes</a></div>

	<div class="submenu Estilo1">
    - <a href="men.php">Administrar Mensajes</a><br />    
             

	</div>

';

}

if($PUBLICIDAD_SECCION == '1')
{
echo'
<div class="silverheader Estilo1"><a href="index.php"><img src="img/music.png" border="0"/>Publicidad</a></div>

	<div class="submenu Estilo1">
    - <a href="pub.php" >Administrar Publicidad</a><br />    
             

	</div>

';

}


echo '</div>';


}
	
}

?>