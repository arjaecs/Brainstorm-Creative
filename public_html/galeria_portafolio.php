<?php require_once('Connections/brainstorm.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$division = explode("&", $_SERVER['QUERY_STRING']);
$proyectos = $division[1];
$divisionproyecto = explode("=",$proyectos);
$proy = $divisionproyecto[0];
$idproyecto = $proyectos[1];

mysql_select_db($database_brainstorm, $brainstorm);
$query_seccion = "SELECT * FROM secciones WHERE idseccion = 5";
$seccion = mysql_query($query_seccion, $brainstorm) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);

$colname_cliente = "0";
if (isset($_GET['cliente'])) {
  $colname_cliente = (get_magic_quotes_gpc()) ? $_GET['cliente'] : addslashes($_GET['cliente']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_cliente = sprintf("SELECT * FROM clientes WHERE id_cliente = %s", $colname_cliente);
$cliente = mysql_query($query_cliente, $brainstorm) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

$colname_genero = "0";
if (isset($_GET['genero'])) {
  $colname_genero = (get_magic_quotes_gpc()) ? $_GET['genero'] : addslashes($_GET['genero']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_genero = sprintf("SELECT * FROM generos WHERE id_genero = %s", $colname_genero);
$genero = mysql_query($query_genero, $brainstorm) or die(mysql_error());
$row_genero = mysql_fetch_assoc($genero);
$totalRows_genero = mysql_num_rows($genero);

$mainGrid = 0;
$RowStart = 0;
$RowEnd = 0;
$numberColumns = 3;
$numberRows = 3;
$mainGrid = $numberColumns * $numberRows;
$maxRows_portafolio_cliente = $mainGrid;
$pageNum_portafolio_cliente = 0;

if (isset($_GET['pageNum_portafolio_cliente'])) {
  $pageNum_portafolio_cliente = $_GET['pageNum_portafolio_cliente'];
}
$startRow_portafolio_cliente = $pageNum_portafolio_cliente * $maxRows_portafolio_cliente;

$maxRows_portafolio_cliente = $mainGrid;;
$pageNum_portafolio_cliente = 0;
if (isset($_GET['pageNum_portafolio_cliente'])) {
  $pageNum_portafolio_cliente = $_GET['pageNum_portafolio_cliente'];
}
$startRow_portafolio_cliente = $pageNum_portafolio_cliente * $maxRows_portafolio_cliente;

mysql_select_db($database_brainstorm, $brainstorm);
$query_portafolio_cliente = "SELECT * FROM portafolio, proyectos WHERE portafolio.proyecto_imgportafolio = id_proyecto AND portafolio.cliente_imgportafolio = $colname_cliente ORDER BY proyecto_imgportafolio";
$query_limit_portafolio_cliente = sprintf("%s LIMIT %d, %d", $query_portafolio_cliente, $startRow_portafolio_cliente, $maxRows_portafolio_cliente);
$portafolio_cliente = mysql_query($query_limit_portafolio_cliente, $brainstorm) or die(mysql_error());
$row_portafolio_cliente = mysql_fetch_assoc($portafolio_cliente);

if (isset($_GET['totalRows_portafolio_cliente'])) {
  $totalRows_portafolio_cliente = $_GET['totalRows_portafolio_cliente'];
} else {
  $all_portafolio_cliente = mysql_query($query_portafolio_cliente);
  $totalRows_portafolio_cliente = mysql_num_rows($all_portafolio_cliente);
}
$totalPages_portafolio_cliente = ceil($totalRows_portafolio_cliente/$maxRows_portafolio_cliente)-1;

$mainGrid = 0;
$RowStart = 0;
$RowEnd = 0;
$numberColumns = 3;
$numberRows = 3;
$mainGrid = $numberColumns * $numberRows;
$maxRows_portafolio_genero = $mainGrid;
$pageNum_portafolio_genero = 0;

if (isset($_GET['pageNum_portafolio_genero'])) {
  $pageNum_portafolio_genero = $_GET['pageNum_portafolio_genero'];
}
$startRow_portafolio_genero = $pageNum_portafolio_genero * $maxRows_portafolio_genero;

$maxRows_portafolio_genero = $mainGrid;;
$pageNum_portafolio_genero = 0;
if (isset($_GET['pageNum_portafolio_genero'])) {
  $pageNum_portafolio_genero = $_GET['pageNum_portafolio_genero'];
}
$startRow_portafolio_genero = $pageNum_portafolio_genero * $maxRows_portafolio_genero;

mysql_select_db($database_brainstorm, $brainstorm);
$query_portafolio_genero = "SELECT * FROM portafolio, proyectos, clientes WHERE portafolio.proyecto_imgportafolio = id_proyecto AND cliente_imgportafolio = clientes.id_cliente AND genero_imgportafolio = $colname_genero ORDER BY cliente_imgportafolio, proyecto_imgportafolio";
$query_limit_portafolio_genero = sprintf("%s LIMIT %d, %d", $query_portafolio_genero, $startRow_portafolio_genero, $maxRows_portafolio_genero);
$portafolio_genero = mysql_query($query_limit_portafolio_genero, $brainstorm) or die(mysql_error());
$row_portafolio_genero = mysql_fetch_assoc($portafolio_genero);

if (isset($_GET['totalRows_portafolio_genero'])) {
  $totalRows_portafolio_genero = $_GET['totalRows_portafolio_genero'];
} else {
  $all_portafolio_genero = mysql_query($query_portafolio_genero);
  $totalRows_portafolio_genero = mysql_num_rows($all_portafolio_genero);
}
$totalPages_portafolio_genero = ceil($totalRows_portafolio_genero/$maxRows_portafolio_genero)-1;

mysql_select_db($database_brainstorm, $brainstorm);
$query_clientes = "SELECT * FROM clientes WHERE clientes.id_cliente <> $colname_cliente ORDER BY cliente";
$clientes = mysql_query($query_clientes, $brainstorm) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_brainstorm, $brainstorm);
$query_generos = "SELECT * FROM generos  WHERE generos.id_genero <> $colname_genero ORDER BY genero";
$generos = mysql_query($query_generos, $brainstorm) or die(mysql_error());
$row_generos = mysql_fetch_assoc($generos);
$totalRows_generos = mysql_num_rows($generos);

$queryString_portafolio_cliente = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_portafolio_cliente") == false && 
        stristr($param, "totalRows_portafolio_cliente") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_portafolio_cliente = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_portafolio_cliente = sprintf("&totalRows_portafolio_cliente=%d%s", $totalRows_portafolio_cliente, $queryString_portafolio_cliente);

$queryString_portafolio_genero = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_portafolio_genero") == false && 
        stristr($param, "totalRows_portafolio_genero") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_portafolio_genero = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_portafolio_genero = sprintf("&totalRows_portafolio_genero=%d%s", $totalRows_portafolio_genero, $queryString_portafolio_genero);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/seccion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>brainstorm-creative.com >>
<?php echo $row_seccion['nombreseccion']; ?> > <?php if($totalRows_portafolio_genero == 0 && $totalRows_portafolio_cliente <> 0) { ?>
<?php echo $row_cliente['cliente']; ?>
<?php } ?>
<?php if($totalRows_portafolio_genero <> 0) { ?>
<?php echo $row_genero['genero']; ?>
<?php } ?>
</title>
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
<TD width="232" ROWSPAN=6 valign="top" background="imagenes/interface/backbarra.gif"><?php include("inc/barra_menu.php"); ?></TD> 
<TD background="imagenes/interface/secciones_01.gif"><IMG SRC="imagenes/interface/secciones_01.gif" WIDTH=16 HEIGHT=52 ALT=""> </TD> 
</TR> 
<TR> 
<TD> <IMG SRC="imagenes/interface/secciones_04.gif" WIDTH=16 HEIGHT=49 ALT=""></TD> 
<TD background="imagenes/interface/secciones_04.gif"><img src="/imagenes/secciones/<?php echo $row_seccion['imagenseccion']; ?>"> </TD> 
</TR> 
<TR> 
<TD background="imagenes/interface/secciones_01.gif"> <IMG SRC="imagenes/interface/secciones_06.gif" WIDTH=16 HEIGHT=455 ALT=""></TD> 
<TD valign="top" background="imagenes/interface/secciones_01.gif"><!-- InstanceBeginEditable name="contenido" -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="imagenes/interface/secciones_01.gif" width="16" height="5"></td>
</tr>
</table>
<table width="96%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="menusub">
<?php if($totalRows_portafolio_genero == 0 && $totalRows_portafolio_cliente <> 0) { ?>
<?php echo $row_cliente['cliente']; ?>
<?php } ?>
<?php if($totalRows_portafolio_genero <> 0) { ?>
<?php echo $row_genero['genero']; ?>
<?php } ?></td>
</tr>
<tr>
<td class="menusub"><img src="imagenes/interface/secciones_01.gif" width="16" height="5"></td>
</tr>
</table>
<?php if($totalRows_portafolio_genero == 0 && $totalRows_portafolio_cliente <> 0) { ?>
<?php do { ?>
<table  border="0" align="center" cellpadding="4">
<?php
				while((($numberRows != 0) && (!($row_portafolio_cliente == 0))))
				{
				$RowStart = $RowEnd + 1;
				$RowEnd = $RowEnd + $numberColumns;
				?>
<tr>
<?php
				while((($RowStart <= $RowEnd) && (!($row_portafolio_cliente == 0))))
				{
				?>
<td align="center">
<a href="#" class="negro11">
<?php
// Llamar el script de imagen
// // define los detalles del file
$dir = "portafolio/" . $row_cliente['nombrecorto_cliente'] . "/". $row_portafolio_cliente['nombrecorto_proyecto'] ."/"; // directorio de la imagen
$file = $row_portafolio_cliente['imagen_imgportafolio']; // nombre del file
$altext = ""; // alt tag
$tipo = "1";// tipo de redimención: 0 = ancho, 1 = alto y 2 = lado más grande

// Tamaño de la ventana
$idfile = $row_portafolio_cliente['id_imgportafolio'];
$max_size_ventana = "450"; // tamaño máximo en pixeles
$file_actual = $dir.$file;
$tamano_actual = getimagesize($file_actual);
$ancho_actual = $tamano_actual[0];
$alto_actual = $tamano_actual[1];
if ($ancho_actual > $alto_actual) {
$big_diff_ratio = $ancho_actual/$max_size_ventana;
$ancho_nuevo = $max_size_ventana;
$alto_nuevo = round($alto_actual/$big_diff_ratio);
} else if ($ancho_actual == $max_size_ventana) {
$ancho_nuevo = $ancho_actual;
$alto_nuevo = $alto_actual;
} else if  ($alto_actual == $max_size_ventana) {
$ancho_nuevo = $ancho_actual;
$alto_nuevo = $alto_actual;
} else {
$big_diff_ratio = $alto_actual/$max_size_ventana;
$alto_nuevo = $max_size_ventana;
$ancho_nuevo = round($ancho_actual/$big_diff_ratio);
}
$ancho = $ancho_nuevo + 237;
if($alto_nuevo < 335) {
$alto = "340";
} else {
$alto = $alto_nuevo + 8;
}
//
if ($ancho_actual > $alto_actual) {
$max_size = "100"; // tamaño máximo en pixeles
} else {
$max_size = "125"; // tamaño máximo en pixeles
}
$ext = "mini"; // extensión para renombrar la imagen
$atributos = " border=\"1\" align=\"center\" hspace = \"2\" onclick=\"MM_openBrWindow('imagen_portafolio.php?imagen=$idfile','','scrollbars=no,width=$ancho,height=$alto')\""; // atributos adicionales, ejemplo: border=\"0\" align=\"center\" etc..
$cropear = "0"; // si quieres cropear la imagen: 0 = no, 1 = si
$crop_dim = "200x125+0+0"; // dimensiones del crop. ejem. "230x170+0+0"
$crop_gravity = "Center"; // desde donde se cropea. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
$watermark = "0"; // si deseas tener texto integrado en la imagen. 0 = no (default), 1 = si.
$watermark_texto = ""; // texto a usarse en el watermark
$watermark_font = ""; // tipografía Ejem. Helvetica-bold (nota: la tipografía tiene que estar disponible en el servidor)
$watermark_size = ""; // tamaño de la letra
$watermark_gravity = ""; // desde donde se intriduce el texto. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
include("inc/inc-imagen.php"); // llama al script
?>
</a>
</td>
<?php 
				$RowStart = $RowStart + 1;
				$row_portafolio_cliente = mysql_fetch_array($portafolio_cliente);
				} 
				?>
</tr>
<?php 
				$numberRows = $numberRows - 1;
				} 
				?>
</table>
<?php } while ($row_portafolio_cliente = mysql_fetch_assoc($portafolio_cliente)); ?>
<?php } ?>
<?php if($totalRows_portafolio_genero <> 0) { ?>
<?php do { ?>
<table  border="0" align="center" cellpadding="4">
<?php
				while((($numberRows != 0) && (!($row_portafolio_genero == 0))))
				{
				$RowStart = $RowEnd + 1;
				$RowEnd = $RowEnd + $numberColumns;
				?>
<tr>
<?php
				while((($RowStart <= $RowEnd) && (!($row_portafolio_genero == 0))))
				{
				?>
<td align="center">
<a href="#" class="negro11">
<?php
// Llamar el script de imagen
// // define los detalles del file
$dir = "portafolio/" . $row_portafolio_genero['nombrecorto_cliente'] . "/" . $row_portafolio_genero['nombrecorto_proyecto'] . "/"; // directorio de la imagen
$file = $row_portafolio_genero['imagen_imgportafolio']; // nombre del file
$altext = ""; // alt tag
$tipo = "1";// tipo de redimención: 0 = ancho, 1 = alto y 2 = lado más grande

// Tamaño de la ventana
$idfile = $row_portafolio_genero['id_imgportafolio'];
$max_size_ventana = "450"; // tamaño máximo en pixeles
$file_actual = $dir.$file;
$tamano_actual = getimagesize($file_actual);
$ancho_actual = $tamano_actual[0];
$alto_actual = $tamano_actual[1];
if ($ancho_actual > $alto_actual) {
$big_diff_ratio = $ancho_actual/$max_size_ventana;
$ancho_nuevo = $max_size_ventana;
$alto_nuevo = round($alto_actual/$big_diff_ratio);
} else if ($ancho_actual == $max_size_ventana) {
$ancho_nuevo = $ancho_actual;
$alto_nuevo = $alto_actual;
} else if  ($alto_actual == $max_size_ventana) {
$ancho_nuevo = $ancho_actual;
$alto_nuevo = $alto_actual;
} else {
$big_diff_ratio = $alto_actual/$max_size_ventana;
$alto_nuevo = $max_size_ventana;
$ancho_nuevo = round($ancho_actual/$big_diff_ratio);
}
$ancho = $ancho_nuevo + 237;
if($alto_nuevo < 335) {
$alto = "340";
} else {
$alto = $alto_nuevo + 8;
}
//

if ($ancho_actual > $alto_actual) {
$max_size = "100"; // tamaño máximo en pixeles
} else {
$max_size = "125"; // tamaño máximo en pixeles
}
$ext = "mini"; // extensión para renombrar la imagen
$atributos = " border=\"1\" align=\"center\" hspace = \"2\" onclick=\"MM_openBrWindow('imagen_portafolio.php?imagen=$idfile','','scrollbars=no,width=$ancho,height=$alto')\""; // atributos adicionales, ejemplo: border=\"0\" align=\"center\" etc..
$cropear = "0"; // si quieres cropear la imagen: 0 = no, 1 = si
$crop_dim = "200x125+0+0"; // dimensiones del crop. ejem. "230x170+0+0"
$crop_gravity = "Center"; // desde donde se cropea. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
$watermark = "0"; // si deseas tener texto integrado en la imagen. 0 = no (default), 1 = si.
$watermark_texto = ""; // texto a usarse en el watermark
$watermark_font = ""; // tipografía Ejem. Helvetica-bold (nota: la tipografía tiene que estar disponible en el servidor)
$watermark_size = ""; // tamaño de la letra
$watermark_gravity = ""; // desde donde se intriduce el texto. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
include("inc/inc-imagen.php"); // llama al script
?>
</a>
</td>
<?php 
				$RowStart = $RowStart + 1;
				$row_portafolio_genero = mysql_fetch_array($portafolio_genero);
				} 
				?>
</tr>
<?php 
				$numberRows = $numberRows - 1;
				} 
				?>
</table>
<?php } while ($row_portafolio_genero = mysql_fetch_assoc($portafolio_genero)); ?>
<?php } ?>
</td>
<td width="3" valign="top" class="lineavertical">&nbsp;</td>
<td width="3" valign="top" class="menusub">&nbsp;</td>
<td width="125" valign="top">
<table width="125"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="menu">
<?php if($totalRows_portafolio_genero == 0 && $totalRows_portafolio_cliente <> 0) { ?>
Otros Clientes
<?php } ?>
<?php if($totalRows_portafolio_genero <> 0) { ?>
M&aacute;s categor&iacute;as
<?php } ?></td>
</tr>
</table>
<?php if($totalRows_portafolio_genero == 0 && $totalRows_portafolio_cliente <> 0) { ?>
<?php do { ?>
<table width="125"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="3" valign="top" class="menusimple">&#8226;</td>
<td><a href="galeria_portafolio.php?cliente=<?php echo $row_clientes['id_cliente']; ?>" class="menusimple"><?php echo $row_clientes['cliente']; ?></a></td>
</tr>
</table>
<?php } while ($row_clientes = mysql_fetch_assoc($clientes)); ?>
<?php } ?>
<?php if($totalRows_portafolio_genero <> 0) { ?>
<table width="125"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="3" valign="top" class="menusimple">&#8226;</td>
<td><a href="portafolio_clientes.php" class="menusimple">Clientes</a></td>
</tr>
</table>
<?php do { ?>
<table width="125"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="3" valign="top" class="menusimple">&#8226;</td>
<td><a href="galeria_portafolio.php?genero=<?php echo $row_generos['id_genero']; ?>" class="menusimple"><?php echo $row_generos['genero']; ?></a></td>
</tr>
</table>
<?php } while ($row_generos = mysql_fetch_assoc($generos)); ?>
<?php } ?></td>
</tr>
<tr>
<td colspan="4" class="lineahorizontaldot"><img src="imagenes/interface/secciones_01.gif" width="16" height="3"></td>
</tr>
</table>
<?php if($totalRows_portafolio_genero == 0 && $totalRows_portafolio_cliente <> 0) { ?>
<table width="96%"  border="0" align="center">
<tr>
<td width="33%" class="blanco11"><strong>&nbsp;<?php echo ($startRow_portafolio_cliente + 1) ?> al <?php echo min($startRow_portafolio_cliente + $maxRows_portafolio_cliente, $totalRows_portafolio_cliente) ?> de <?php echo $totalRows_portafolio_cliente ?> </strong></td>
<td width="33%"><div align="center">
<?php if ($pageNum_portafolio_cliente > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_portafolio_cliente=%d%s", $currentPage, max(0, $pageNum_portafolio_cliente - 1), $queryString_portafolio_cliente); ?>" class="blanco11">Anteriores</a>
<?php } // Show if not first page ?> <?php if ($pageNum_portafolio_cliente > 0 && $pageNum_portafolio_cliente < $totalPages_portafolio_cliente) { ?><span class="blanco11">|</span><?php } ?> 
<?php if ($pageNum_portafolio_cliente < $totalPages_portafolio_cliente) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_portafolio_cliente=%d%s", $currentPage, min($totalPages_portafolio_cliente, $pageNum_portafolio_cliente + 1), $queryString_portafolio_cliente); ?>" class="blanco11">Pr&oacute;ximos</a>
<?php } // Show if not last page ?> </div></td>
<td width="33%"><div align="right"><a href="portafolio.php" class="blanco11"><em>Regresar al portafolio</em></a>&nbsp;&nbsp;</div></td>
</tr>
</table>

<span class="menusub">
<?php } ?>
<?php if($totalRows_portafolio_genero <> 0) { ?>
</span>
<table width="96%"  border="0" align="center">
<tr>
<td width="33%" class="blanco11"><strong>&nbsp;<?php echo ($startRow_portafolio_genero + 1) ?> al <?php echo min($startRow_portafolio_genero + $maxRows_portafolio_genero, $totalRows_portafolio_genero) ?> de <?php echo $totalRows_portafolio_genero ?> </strong></td>
<td width="33%">
<div align="center">
<?php if ($pageNum_portafolio_genero > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_portafolio_genero=%d%s", $currentPage, max(0, $pageNum_portafolio_genero - 1), $queryString_portafolio_genero); ?>" class="blanco11">Anteriores</a>
<?php } // Show if not first page ?> 
<?php if ($pageNum_portafolio_genero > 0 && $pageNum_portafolio_genero < $totalPages_portafolio_genero) { ?>
<span class="blanco11">|</span>
<?php } ?> 
<?php if ($pageNum_portafolio_genero < $totalPages_portafolio_genero) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_portafolio_genero=%d%s", $currentPage, min($totalPages_portafolio_genero, $pageNum_portafolio_genero + 1), $queryString_portafolio_genero); ?>" class="blanco11">Pr&oacute;ximos</a>
<?php } // Show if not last page ?> 
</div></td>
<td width="33%"><div align="right"><a href="portafolio.php" class="blanco11"><em>Regresar al portafolio</em></a>&nbsp;&nbsp;</div></td>
</tr>
</table>
<?php } ?><!-- InstanceEndEditable --> 
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
<TD background="imagenes/interface/secciones_26.gif"> <IMG SRC="imagenes/interface/secciones_25.gif" WIDTH=522 HEIGHT=32 ALT=""></TD> 
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
mysql_free_result($cliente);
mysql_free_result($genero);
mysql_free_result($portafolio_cliente);
mysql_free_result($portafolio_genero);

mysql_free_result($clientes);

mysql_free_result($generos);
?>