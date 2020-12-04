<?php require_once('php/modulatemedia.php');
require_once('php/proceso_login.php');
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
background-image:url(img/loginbg.gif);

}
<!--
.style2 {font-size: 10px}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px; }
.style4 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
-->

#login {
text-align: center;
border: 1px solid #CFCFCF;
min-height: 330px;
_height: 330px;
width: 705px;
position: absolute;
left: 50%;
margin-left: -352px;
top: 50%;
margin-top: -165px;
-moz-border-radius-bottomright: 30px;
-webkit-border-bottom-right-radius: 30px;
_height: 100%; /* IE FIX */
	}


	h2 {
padding: 15px 0 15px 75px;
_padding-left: 38px;

font-size: 45px;
color: #2F2F2F;text-indent: -9999px;
width: 676px;
height: 73px;

left: -23px;
	}
	
	label {
	font-size: 24px;

	}



input {
width: 40%;
height: 30px;
position: relative;
top: -4px;
font-size: 20px;
padding: 0 .3em;
color: #555555;
}

small {
font-size: 16px;
position: relative;
top: -4px;
}

h4 {
color: #5F5F5F;
font-size: 23px;
}

h4.alert {
	background-Color: #bfbfbf;
	width: 80%;
	margin-left: auto;
	margin-right: auto;
	padding: .4em;
	border: 1px dotted white;
	font-size: 19px;
	line-height: 19px;
	position: relative;
-moz-border-radius: 2px;
-webkit-border-radius: 2px;
}

span.exit {
	position: absolute;
	top: 0;
	right: 0;
	background: #6361DF;
	color: #292929;
	font-size: 10px;
line-height: 14px;
	font-weight: bold;
	padding: 0 .3em;
	cursor: pointer;
border-left: 1px dotted white;
border-bottom: 1px dotted white;
}
</style>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>

<link rel="stylesheet" type="text/css" href="../tiempoahora.net/admin/style.css" />
<style type="text/css">
<!--
.style6 {font-size: 9px}
-->
</style>
</head>

<body>
<form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
  <label></label>
  <table width="241" border="0" align="center">
    <tr>
      <td colspan="2"><h2 class="style4"></h2><br />
      <center><strong><span class="style3"><font size="10"></font></span></strong></center>
      </td>
    </tr>
    <tr>
      <td width="79"><span class="style3"><strong>
        
      </strong>        
        
      </span>        <span class="style2">
     
      </span>      <div align="right" class="style3"><strong>Usuario:</strong></div>      </td>
      <td width="152"><input name="username" type="text" id="username" tabindex="1" cols="30" maxlength="20" /></td>
    </tr>
    <tr>
      <td><span class="style3"><strong>
       
      </strong>        
        
      </span>        <span class="style2">
      
      </span>     <div align="right" class="style3"><strong>Password:</strong></div>      </td>
      <td><input name="password" type="password" id="password" tabindex="2" cols="30" maxlength="20" /></td>
      
      <input type="hidden" name="ip" id="ip" value="<?php $ip=@$REMOTE_ADDR; echo $ip; ?>" />
    </tr>

    <tr>
   
      <td colspan="2"><center><input name="submit" type="submit" id="submit" tabindex="4" onclick="MM_validateForm('username','','R');MM_validateForm('password','','R');MM_validateForm('email','','RisEmail');return document.MM_returnValue" value="Login" /></center></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
       </tr>
  </table>
  
</form>
</body>
</html>
