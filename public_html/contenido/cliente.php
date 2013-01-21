<?php require_once('../Connections/brainstorm.php'); ?>
<?php

$archivo = explode("=", $_SERVER['QUERY_STRING']);
$idarchivo = $archivo[1];

mysql_select_db($database_brainstorm, $brainstorm);
$query_clientes = "SELECT * FROM clientes";
$clientes = mysql_query($query_clientes, $brainstorm) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt; <?php if($idarchivo == 'portafolio') { ?>Añadir imagen<?php } else { ?>Proyecto nuevo<?php } ?></title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->


<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<!-- InstanceEndEditable -->
<link href="../inc/estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" background="../imagenes/interface/secciones_01.gif">
<tr>
<td width="180" valign="top" bgcolor="#D2232A">
<?php include("inc/menu.php"); ?>
</td>
<td>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="../imagenes/interface/spacer.gif" width="1" height="10"></td>
</tr>
</table><table width="600" height="400" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td><!-- InstanceBeginEditable name="contenido" -->

<table  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="menutop">Selecciona el cliente </td>
</tr>
<tr>
<td><select name="clientes" id="clientes" onChange="MM_jumpMenu('parent',this,0)">
<option selected value="">(Clientes)</option>
<?php
do {  
?>
<option value="<?php if($idarchivo == 'portafolio') { ?>portafolio.php<?php } else { ?>proyectonuevo.php<? } ?>?cliente=<?php echo $row_clientes['id_cliente']?>"><?php echo $row_clientes['cliente']?></option>
<?php
} while ($row_clientes = mysql_fetch_assoc($clientes));
  $rows = mysql_num_rows($clientes);
  if($rows > 0) {
      mysql_data_seek($clientes, 0);
	  $row_clientes = mysql_fetch_assoc($clientes);
  }
?>
</select></td>
</tr>
</table>
<!-- InstanceEndEditable --></td>
</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="../imagenes/interface/spacer.gif" width="1" height="10"></td>
</tr>
</table></td>
</tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($clientes);
?>
