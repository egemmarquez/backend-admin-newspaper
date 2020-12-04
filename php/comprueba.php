<?Php 


function comprueba_datos() {

{
$resulta = '
   <script>

//Pon en la variable obligatorios el name de todos los campos que deben rellenar

obligatorio=["'.$CONTENIDO.'","'.$EXTRACTO.'"];

//Pon en la veriable textoObligatorio el texto que quieres que aparezca en el alert

textoObligatorio=["Contenido","Extracto"];

function comprobar(este){
for(a=0;a<obligatorio.length;a++){

if(este.elements[obligatorio[a]].value==""){

alert("Por favor, rellena el campo "+textoObligatorio[a]);
este.elements[obligatorio[a]].focus();
return false;


}

}

return true;
}

</script>
<style>
*{font:normal 10px/10px verdana;
}


</style> 

';

}
return $resulta;
}

?>