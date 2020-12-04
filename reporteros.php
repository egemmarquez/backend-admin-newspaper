<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);

  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  // For security, start by assuming the visitor is NOT authorized.
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
  // Therefore, we know that a user is NOT logged in if that Session variable is blank.
  if (!empty($UserName)) {
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
    // Parse the strings into arrays.
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    // Or, you may restrict access to only certain users based on their username.
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && true) {
      $isValid = true;
    }
  }
  return $isValid;
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>

<?php

include('php/funciones.php');

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <?php header("Content-Type: text/html;charset=utf-8"); ?>
<title>Administraci&oacute;n</title>
<script type="text/javascript" src="js/switchcontent.js" >

</script>


<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="css/jquery-1.2.6.pack.js"></script>

<script type="text/javascript" src="css/ddaccordion.js"></script>


<script type="text/javascript">
ddaccordion.init({
	headerclass: "silverheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "mouseover", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: true, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})


</script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 12px;
	text-align:left;
}
-->
</style>

<script language="javascript" src="js/exampleconfig2.js"></script>
 <script>function despliega(variable,ancho,alto){ window.open(variable,"Online","scrollbars=yes,resizable=yes,width="+ancho+",height="+alto); }</script>



<?php

$action = $_GET['action'];

if ($action == 'noticias_nueva')
{
 ?>

<script language="JavaScript" type="text/javascript" src="scripts/wysiwyg.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/wysiwyg-settings.js"></script>
<script language="javascript1.2">

   // attach the editor to the textarea with the identifier 'textarea1'.

</script>
<?php } else { ?>

<?php } ?>


<?php

$action = $_GET['action'];

if ($action == 'modificar')
{
 ?>

<script language="JavaScript" type="text/javascript" src="scripts/wysiwyg.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/wysiwyg-settings.js"></script>
<script language="javascript1.2">

   // attach the editor to the textarea with the identifier 'textarea1'.

</script>
<?php } else { ?>

<?php } ?>


</head>
<body>



<div id="content">
<?php
include('head.php');
?>
<div id="menu_left">
<?php echo categorias() ?>
</div>
<div class="Estilo1" id="menu_right">
<div id="margentexto">
<div style="width:auto; height:60px; text-align:right">
<b><h1><img src="img/noticias.png" align="right">Reporteros</h1></b>
</div></div>

<br />

<div id="margentexto">

<form action="reporterosresultado.php" method="POST">
  Fecha Inicio:
  <input type="date" name="FINICIO">
  Fecha Final:
  <input type="date" name="FFINAL">
<br>
Reportero:
<SELECT id="REPORTEROS_LISTA" name="REPORTEROS_LISTA">
<option value="0">SIN REPORTERO</option>
<?php echo listadereporteros() ?></SELECT>

  <input type="submit">
</form>


</div>



</div>
</div>
</body>
</html>
