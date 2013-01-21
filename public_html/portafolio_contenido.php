<?php require_once('Connections/brainstorm.php'); ?>
<?php
mysql_select_db($database_brainstorm, $brainstorm);
$query_seccion = "SELECT * FROM secciones WHERE idseccion = 5";
$seccion = mysql_query($query_seccion, $brainstorm) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);

$maxRows_clientes = 25;
$pageNum_clientes = 0;
if (isset($_GET['pageNum_clientes'])) {
  $pageNum_clientes = $_GET['pageNum_clientes'];
}
$startRow_clientes = $pageNum_clientes * $maxRows_clientes;

mysql_select_db($database_brainstorm, $brainstorm);
$query_clientes = "SELECT * FROM clientes";
$query_limit_clientes = sprintf("%s LIMIT %d, %d", $query_clientes, $startRow_clientes, $maxRows_clientes);
$clientes = mysql_query($query_limit_clientes, $brainstorm) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);

if (isset($_GET['totalRows_clientes'])) {
  $totalRows_clientes = $_GET['totalRows_clientes'];
} else {
  $all_clientes = mysql_query($query_clientes);
  $totalRows_clientes = mysql_num_rows($all_clientes);
}
$totalPages_clientes = ceil($totalRows_clientes/$maxRows_clientes)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/seccion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>brainstorm-creative.com >> <?php echo $row_seccion['nombreseccion']; ?></title>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<!-- InstanceBeginEditable name="head" -->
<link href="inc/estilos.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
</head>
<body onLoad="MM_preloadImages('/imagenes/interface/menu_over_10.gif','/imagenes/interface/menu_over_13.gif','/imagenes/interface/menu_over_15.gif','/imagenes/interface/menu_over_17.gif','/imagenes/interface/menu_over_19.gif')"> 
<TABLE WIDTH=770 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_01.gif" WIDTH=16 HEIGHT=52 ALT=""></TD> 
<TD width="232" ROWSPAN=6><?php include("inc/barra_menu.php"); ?></TD> 
<TD background="imagenes/interface/secciones_01.gif"><IMG SRC="imagenes/interface/secciones_01.gif" WIDTH=16 HEIGHT=52 ALT=""> </TD> 
</TR> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_04.gif" WIDTH=16 HEIGHT=49 ALT=""></TD> 
<TD background="imagenes/interface/secciones_04.gif"><img src="/imagenes/secciones/<?php echo $row_seccion['imagenseccion']; ?>"> </TD> 
</TR> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_06.gif" WIDTH=16 HEIGHT=455 ALT=""></TD> 
<TD valign="top" background="imagenes/interface/secciones_01.gif"><!-- InstanceBeginEditable name="contenido" -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="imagenes/interface/secciones_01.gif" width="16" height="5"></td>
</tr>
</table>
<?php if(
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="menutop">Clientes</td>
</tr>
<tr>
<td>
<?php do { ?>
<table width="100%"  border="0" cellpadding="1" cellspacing="1">
<tr>
<td width="3" align="center" valign="top" class="menu">&#8226;</td>
<td><a href="galeria_portafolio.php" class="menu"><?php echo $row_clientes['cliente']; ?></a></td>
</tr>
</table>
<?php } while ($row_clientes = mysql_fetch_assoc($clientes)); ?></td>
</tr>
</table>
<!-- InstanceEndEditable --> 
</TD> 
</TR> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_21.gif" WIDTH=16 HEIGHT=8 ALT=""></TD> 
<TD background="imagenes/interface/secciones_21.gif"><IMG SRC="imagenes/interface/secciones_21.gif" WIDTH=16 HEIGHT=8 ALT=""> </TD> 
</TR> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_23.gif" WIDTH=16 HEIGHT=4 ALT=""></TD> 
<TD background="imagenes/interface/secciones_23.gif"><IMG SRC="imagenes/interface/secciones_23.gif" WIDTH=16 HEIGHT=4 ALT=""> </TD> 
</TR> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_25.gif" WIDTH=16 HEIGHT=32 ALT=""></TD> 
<TD> <IMG SRC="imagenes/interface/secciones_26.gif" WIDTH=522 HEIGHT=32 ALT=""></TD> 
</TR> 
</TABLE> 
<map name="Map">
<area shape="rect" coords="53,3,194,81" href="seccion.php?personal=1&seccion=3">
<area shape="rect" coords="227,3,334,78" href="seccion.php?personal=2&seccion=3">
<area shape="rect" coords="366,3,476,79" href="seccion.php?personal=3&seccion=3">
</map>
<map name="Map2">
<area shape="rect" coords="14,120,301,175" href="mailto:medios@brainstorm-creative.com">
<area shape="rect" coords="13,197,355,251" href="mailto:administracion@brainstorm-creative.com">
</map>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($seccion);

mysql_free_result($clientes);
?>
