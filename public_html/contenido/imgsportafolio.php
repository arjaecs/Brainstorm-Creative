<?php require_once('../Connections/brainstorm.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$colname_genero = "1";
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
$maxRows_portafolio = $mainGrid;
$pageNum_portafolio = 0;
if (isset($_GET['pageNum_portafolio'])) {
  $pageNum_portafolio = $_GET['pageNum_portafolio'];
}
$startRow_portafolio = $pageNum_portafolio * $maxRows_portafolio;

mysql_select_db($database_brainstorm, $brainstorm);
$query_portafolio = "SELECT * FROM portafolio, clientes, proyectos WHERE portafolio.cliente_imgportafolio = clientes.id_cliente AND portafolio.proyecto_imgportafolio = proyectos.id_proyecto AND portafolio.genero_imgportafolio = $colname_genero ORDER BY clientes.id_cliente";
$query_limit_portafolio = sprintf("%s LIMIT %d, %d", $query_portafolio, $startRow_portafolio, $maxRows_portafolio);
$portafolio = mysql_query($query_limit_portafolio, $brainstorm) or die(mysql_error());
$row_portafolio = mysql_fetch_assoc($portafolio);

if (isset($_GET['totalRows_portafolio'])) {
  $totalRows_portafolio = $_GET['totalRows_portafolio'];
} else {
  $all_portafolio = mysql_query($query_portafolio);
  $totalRows_portafolio = mysql_num_rows($all_portafolio);
}
$totalPages_portafolio = ceil($totalRows_portafolio/$maxRows_portafolio)-1;

mysql_select_db($database_brainstorm, $brainstorm);
$query_generos = "SELECT * FROM generos WHERE generos.id_genero <> $colname_genero  ORDER BY generos.genero";
$generos = mysql_query($query_generos, $brainstorm) or die(mysql_error());
$row_generos = mysql_fetch_assoc($generos);
$totalRows_generos = mysql_num_rows($generos);

$queryString_portafolio = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_portafolio") == false && 
        stristr($param, "totalRows_portafolio") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_portafolio = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_portafolio = sprintf("&totalRows_portafolio=%d%s", $totalRows_portafolio, $queryString_portafolio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt; <?php echo $row_genero['genero']; ?></title>
<script language="JavaScript" type="text/JavaScript">
<!--
function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
//-->
</script>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="menutop"><?php echo $row_genero['genero']; ?></td>
</tr>
</table>
<?php do { ?>
<table  border="0" align="center" cellpadding="0" cellspacing="0">
<?php
				while((($numberRows != 0) && (!($row_portafolio == 0))))
				{
				$RowStart = $RowEnd + 1;
				$RowEnd = $RowEnd + $numberColumns;
				?>
<tr>
<?php
				while((($RowStart <= $RowEnd) && (!($row_portafolio == 0))))
				{
				?>
<td><table  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="center"><?php
// Llamar el script de imagen
// // define los detalles del file
$dir = "../portafolio/" . $row_portafolio['nombrecorto_cliente'] . "/". $row_portafolio['nombrecorto_proyecto'] ."/"; // directorio de la imagen
$file = $row_portafolio['imagen_imgportafolio']; // nombre del file
$altext = ""; // alt tag
$tipo = "1";// tipo de redimenci&oacute;n: 0 = ancho, 1 = alto y 2 = lado m&aacute;s grande
$file_actual = $dir.$file;
$tamano_actual = getimagesize($file_actual);
$ancho_actual = $tamano_actual[0];
$alto_actual = $tamano_actual[1];
if ($ancho_actual > $alto_actual) {
$max_size = "100"; // tama&ntilde;o m&aacute;ximo en pixeles
} else {
$max_size = "125"; // tama&ntilde;o m&aacute;ximo en pixeles
}
$ext = "mini"; // extensi&oacute;n para renombrar la imagen
$atributos = " border=\"1\" align=\"center\" hspace = \"4\" vspace = \"4\""; // atributos adicionales, ejemplo: border=\"0\" align=\"center\" etc..
$cropear = "0"; // si quieres cropear la imagen: 0 = no, 1 = si
$crop_dim = "200x125+0+0"; // dimensiones del crop. ejem. "230x170+0+0"
$crop_gravity = "Center"; // desde donde se cropea. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
$watermark = "0"; // si deseas tener texto integrado en la imagen. 0 = no (default), 1 = si.
$watermark_texto = ""; // texto a usarse en el watermark
$watermark_font = ""; // tipograf&iacute;a Ejem. Helvetica-bold (nota: la tipograf&iacute;a tiene que estar disponible en el servidor)
$watermark_size = ""; // tama&ntilde;o de la letra
$watermark_gravity = ""; // desde donde se intriduce el texto. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
include("../inc/inc-imagen.php"); // llama al script
?></td>
</tr>
<tr>
<td align="center"><span class="blanco11">[</span> <a href="imgportafolioeditar.php?imagen=<?php echo $row_portafolio['id_imgportafolio']; ?>" class="blanco11">Editar</a> <span class="blanco11">|</span> <a href="borrar.php?imagen=<?php echo $row_portafolio['id_imgportafolio']; ?>" class="blanco11" onclick="GP_popupConfirmMsg('Si borra la imagen <?php echo $row_portafolio['titulo_imgportafolio']; ?>, después no lo podrá recuperar. ¿Esta seguro que quiere borrarlo?');return document.MM_returnValue">Borrar</a> <span class="blanco11">]</span></td>
</tr>
</table></td>
<?php 
				$RowStart = $RowStart + 1;
				$row_portafolio = mysql_fetch_array($portafolio);
				} 
				?>
</tr>
<?php 
				$numberRows = $numberRows - 1;
				} 
				?>
</table>
<?php } while ($row_portafolio = mysql_fetch_assoc($portafolio)); ?></td>
<td width="5" class="lineavertical">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="125" valign="top"><?php do { ?>
<table width="125"  border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="3" valign="top" class="menu">&#8226;</td>
<td><a href="imgsportafolio.php?genero=<?php echo $row_generos['id_genero']; ?>" class="menu"><?php echo $row_generos['genero']; ?></a></td>
</tr>
</table>
<?php } while ($row_generos = mysql_fetch_assoc($generos)); ?></td>
</tr>
<tr>
<td colspan="4" class="lineahorizontaldot"><img src="../imagenes/transparente1px.gif" width="1" height="3"></td>
</tr>
</table>
<table width="98%"  border="0">
<tr>
<td width="50%" class="blanco11"><strong><?php echo ($startRow_portafolio + 1) ?> al <?php echo min($startRow_portafolio + $maxRows_portafolio, $totalRows_portafolio) ?> de <?php echo $totalRows_portafolio ?> </strong></td>
<td width="50%"><div align="right">
<?php if ($pageNum_portafolio > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_portafolio=%d%s", $currentPage, max(0, $pageNum_portafolio - 1), $queryString_portafolio); ?>" class="blanco11">Anteriores</a>
<?php } // Show if not first page ?>
<?php if ($pageNum_portafolio > 0 && $pageNum_portafolio < $totalPages_portafolio) { ?><span class="blanco11">|</span><?php } ?>
<?php if ($pageNum_portafolio < $totalPages_portafolio) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_portafolio=%d%s", $currentPage, min($totalPages_portafolio, $pageNum_portafolio + 1), $queryString_portafolio); ?>" class="blanco11">Pr&oacute;ximas</a>
<?php } // Show if not last page ?>
</div></td>
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
mysql_free_result($generos);

mysql_free_result($portafolio);

mysql_free_result($genero);
?>
