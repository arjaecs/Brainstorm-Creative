
<?php
/*
<?php require_once('Connections/brainstorm.php'); ?>
$persona = explode("=", $_SERVER['QUERY_STRING']);
$personaid = $persona[0];
$personaidnum = $persona[1];

$colname_seccion = "1";
if (isset($_GET['seccion'])) {
  $colname_seccion = (get_magic_quotes_gpc()) ? $_GET['seccion'] : addslashes($_GET['seccion']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_seccion = sprintf("SELECT * FROM secciones WHERE idseccion = %s", $colname_seccion);
$seccion = mysql_query($query_seccion, $brainstorm) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);

$colname_personal = "1";
if (isset($_GET['personal'])) {
  $colname_personal = (get_magic_quotes_gpc()) ? $_GET['personal'] : addslashes($_GET['personal']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_personal = sprintf("SELECT * FROM personal WHERE idpersonal = %s", $colname_personal);
$personal = mysql_query($query_personal, $brainstorm) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/seccion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>brainstorm-creative.com >> <?php /* echo $row_seccion['nombreseccion']; ?><?php if($personaid == 'personal' or $personaidnum == '3') {  echo " > " . $row_personal['nombrepersonal']; }*/ ?></title>
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
<?php if($colname_seccion == '3') { ?>
<table width="522"  border="0" cellspacing="0" cellpadding="0"> 
<tr> 
<td><img src="/imagenes/interface/secciones/personal2_07.gif" width="522" height="97" border="0" usemap="#Map"></td> 
</tr> 
<tr> 
<td><img src="/imagenes/secciones/<?php echo $row_personal['imagenpersonal']; ?>"></td> 
</tr> 
</table>
<?php } else if($colname_seccion == '4') { ?>
<img src="/imagenes/interface/secciones/contenidocontactenos_07.gif" width="522" height="455" border="0" usemap="#Map2">
<?php } else { ?>
<img src="/imagenes/secciones/<?php echo $row_seccion['imagencontenudoseccion']; ?>"> 
<?php } ?>
<map name="Map">
<area shape="rect" coords="53,3,194,81" href="seccion.php?personal=1&seccion=3">
<area shape="rect" coords="227,3,334,78" href="seccion.php?personal=2&seccion=3">
<area shape="rect" coords="366,3,476,79" href="seccion.php?personal=3&seccion=3">
</map>
<map name="Map2">
<area shape="rect" coords="16,55,307,105" href="mailto:creativo@brainstorm-creative.com">
<area shape="rect" coords="14,120,301,175" href="mailto:medios@brainstorm-creative.com">
<area shape="rect" coords="13,197,355,251" href="mailto:administracion@brainstorm-creative.com">
</map>
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
/*
mysql_free_result($seccion);

mysql_free_result($personal);
*/
?>
