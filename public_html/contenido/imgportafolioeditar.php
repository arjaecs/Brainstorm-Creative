<?php require_once('../Connections/brainstorm.php'); ?>
<?php
$colname_imgeditar = "1";
if (isset($_GET['imagen'])) {
  $colname_imgeditar = (get_magic_quotes_gpc()) ? $_GET['imagen'] : addslashes($_GET['imagen']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_imgeditar = sprintf("SELECT * FROM portafolio, clientes, generos, proyectos WHERE portafolio.cliente_imgportafolio = clientes.id_cliente AND portafolio.proyecto_imgportafolio = proyectos.id_proyecto AND portafolio.genero_imgportafolio AND generos.id_genero AND id_imgportafolio = %s", $colname_imgeditar);
$imgeditar = mysql_query($query_imgeditar, $brainstorm) or die(mysql_error());
$row_imgeditar = mysql_fetch_assoc($imgeditar);
$totalRows_imgeditar = mysql_num_rows($imgeditar);

mysql_select_db($database_brainstorm, $brainstorm);
$query_cliente = "SELECT * FROM clientes";
$cliente = mysql_query($query_cliente, $brainstorm) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

mysql_select_db($database_brainstorm, $brainstorm);
$query_proyecto = "SELECT * FROM proyectos";
$proyecto = mysql_query($query_proyecto, $brainstorm) or die(mysql_error());
$row_proyecto = mysql_fetch_assoc($proyecto);
$totalRows_proyecto = mysql_num_rows($proyecto);

mysql_select_db($database_brainstorm, $brainstorm);
$query_generos = "SELECT * FROM generos";
$generos = mysql_query($query_generos, $brainstorm) or die(mysql_error());
$row_generos = mysql_fetch_assoc($generos);
$totalRows_generos = mysql_num_rows($generos);

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  $updateSQL = sprintf("UPDATE portafolio SET cliente_imgportafolio=%s, proyecto_imgportafolio=%s, genero_imgportafolio=%s, titulo_imgportafolio=%s WHERE id_imgportafolio=%s",
                       GetSQLValueString($_POST['cliente_imgportafolio'], "int"),
                       GetSQLValueString($_POST['proyecto_imgportafolio'], "int"),
                       GetSQLValueString($_POST['genero_imgportafolio'], "int"),
                       GetSQLValueString($_POST['titulo_imgportafolio'], "text"),
                       GetSQLValueString($_POST['id_imgportafolio'], "int"));

  mysql_select_db($database_brainstorm, $brainstorm);
  $Result1 = mysql_query($updateSQL, $brainstorm) or die(mysql_error());

  $updateGoTo = "confirmacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt; Editar imagen > <?php echo $row_imgeditar['titulo_imgportafolio']; ?></title>
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
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">

<table  border="0" align="center" cellpadding="1" cellspacing="1">
<tr align="center">
<td colspan="2" valign="top" class="menu"><div align="right"></div><?php
// Llamar el script de imagen
// // define los detalles del file
$dir = "../portafolio/" . $row_imgeditar['nombrecorto_cliente'] . "/". $row_imgeditar['nombrecorto_proyecto'] ."/"; // directorio de la imagen
$file = $row_imgeditar['imagen_imgportafolio']; // nombre del file
$altext = ""; // alt tag
$file_actual = $dir.$file;
$tamano_actual = getimagesize($file_actual);
$ancho_actual = $tamano_actual[0];
$alto_actual = $tamano_actual[1];
if ($ancho_actual > $alto_actual) {
$max_size = "400"; // tama&ntilde;o m&aacute;ximo en pixeles
$tipo = "0";// tipo de redimenci&oacute;n: 0 = ancho, 1 = alto y 2 = lado m&aacute;s grande
} else {
$max_size = "300"; // tama&ntilde;o m&aacute;ximo en pixeles
$tipo = "1";// tipo de redimenci&oacute;n: 0 = ancho, 1 = alto y 2 = lado m&aacute;s grande
}
$ext = "edit"; // extensi&oacute;n para renombrar la imagen
$atributos = " border=\"1\" align=\"center\" hspace = \"2\" vspace = \"2\""; // atributos adicionales, ejemplo: border=\"0\" align=\"center\" etc..
$cropear = "0"; // si quieres cropear la imagen: 0 = no, 1 = si
$crop_dim = "200x125+0+0"; // dimensiones del crop. ejem. "230x170+0+0"
$crop_gravity = "Center"; // desde donde se cropea. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
$watermark = "0"; // si deseas tener texto integrado en la imagen. 0 = no (default), 1 = si.
$watermark_texto = ""; // texto a usarse en el watermark
$watermark_font = ""; // tipograf&iacute;a Ejem. Helvetica-bold (nota: la tipograf&iacute;a tiene que estar disponible en el servidor)
$watermark_size = ""; // tama&ntilde;o de la letra
$watermark_gravity = ""; // desde donde se intriduce el texto. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
include("../inc/inc-imagen.php"); // llama al script
?>
<span class="blanco11"><a href="imageneditar.php?imagen=<?php echo $row_imgeditar['id_imgportafolio']; ?>" class="blanco11"><br>
</a></span><span class="menu">[ <a href="imageneditar.php?imagen=<?php echo $row_imgeditar['id_imgportafolio']; ?>" class="menu">Editar</a> ]</span></td>
</tr>
<tr>
<td colspan="2" class="lineahorizontaldot"><img src="../imagenes/transparente1px.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="2"><img src="../imagenes/transparente1px.gif" width="1" height="1"></td>
</tr>
<tr>
<td class="menu"><div align="right">Cliente:</div></td>
<td><select name="cliente_imgportafolio" id="cliente_imgportafolio">
<?php
do {  
?>
<option value="<?php echo $row_cliente['id_cliente']?>"<?php if (!(strcmp($row_cliente['id_cliente'], $row_imgeditar['cliente_imgportafolio']))) {echo "SELECTED";} ?>><?php echo $row_cliente['cliente']?></option>
<?php
} while ($row_cliente = mysql_fetch_assoc($cliente));
  $rows = mysql_num_rows($cliente);
  if($rows > 0) {
      mysql_data_seek($cliente, 0);
	  $row_cliente = mysql_fetch_assoc($cliente);
  }
?>
</select></td>
</tr>
<tr>
<td class="menu"><div align="right">G&eacute;nero:</div></td>
<td><select name="genero_imgportafolio" id="genero_imgportafolio">
<?php
do {  
?>
<option value="<?php echo $row_generos['id_genero']?>"<?php if (!(strcmp($row_generos['id_genero'], $row_imgeditar['genero_imgportafolio']))) {echo "SELECTED";} ?>><?php echo $row_generos['genero']?></option>
<?php
} while ($row_generos = mysql_fetch_assoc($generos));
  $rows = mysql_num_rows($generos);
  if($rows > 0) {
      mysql_data_seek($generos, 0);
	  $row_generos = mysql_fetch_assoc($generos);
  }
?>
</select></td>
</tr>
<tr>
<td class="menu"><div align="right">Campa&ntilde;a/Proyecto:</div></td>
<td><select name="proyecto_imgportafolio" id="proyecto_imgportafolio">
<?php
do {  
?>
<option value="<?php echo $row_proyecto['id_proyecto']?>"<?php if (!(strcmp($row_proyecto['id_proyecto'], $row_imgeditar['proyecto_imgportafolio']))) {echo "SELECTED";} ?>><?php echo $row_proyecto['proyecto']?></option>
<?php
} while ($row_proyecto = mysql_fetch_assoc($proyecto));
  $rows = mysql_num_rows($proyecto);
  if($rows > 0) {
      mysql_data_seek($proyecto, 0);
	  $row_proyecto = mysql_fetch_assoc($proyecto);
  }
?>
</select>
</td>
</tr>
<tr>
<td class="menu"><div align="right">T&iacute;tulo:</div></td>
<td><input name="titulo_imgportafolio" type="text" id="titulo_imgportafolio" value="<?php echo $row_imgeditar['titulo_imgportafolio']; ?>" size="40"></td>
</tr>
<tr>
<td class="menu"><div align="right"></div></td>
<td><input type="submit" name="Submit" value="Entrar"></td>
</tr>
</table>

<input name="id_imgportafolio" type="hidden" id="id_imgportafolio" value="<?php echo $row_imgeditar['id_imgportafolio']; ?>">
<input type="hidden" name="MM_update" value="form1">
</form>
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
mysql_free_result($cliente);
mysql_free_result($proyecto);
if ( (isset($_POST['proyecto_imgportafolio'])) ) {

mysql_free_result($generos);

mysql_free_result($imgeditar);
}
?>
