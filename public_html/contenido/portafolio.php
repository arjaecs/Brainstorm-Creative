<?php require_once('../Connections/brainstorm.php'); ?>
<?php
$colname_cliente = "1";
if (isset($_GET['cliente'])) {
  $colname_cliente = (get_magic_quotes_gpc()) ? $_GET['cliente'] : addslashes($_GET['cliente']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_cliente = sprintf("SELECT * FROM clientes WHERE id_cliente = %s", $colname_cliente);
$cliente = mysql_query($query_cliente, $brainstorm) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

mysql_select_db($database_brainstorm, $brainstorm);
$query_proyecto = "SELECT * FROM proyectos WHERE cliente_proyecto = $colname_cliente";
$proyecto = mysql_query($query_proyecto, $brainstorm) or die(mysql_error());
$row_proyecto = mysql_fetch_assoc($proyecto);
$totalRows_proyecto = mysql_num_rows($proyecto);

$ideproyecto = $_POST['proyecto_imgportafolio'];

mysql_select_db($database_brainstorm, $brainstorm);
$query_archivo_proyecto = "SELECT * FROM proyectos WHERE id_proyecto = '$ideproyecto' AND id_proyecto <> '0'";
$archivo_proyecto = mysql_query($query_archivo_proyecto, $brainstorm) or die(mysql_error());
$row_archivo_proyecto = mysql_fetch_assoc($archivo_proyecto);
$totalRows_archivo_proyecto = mysql_num_rows($archivo_proyecto);

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

$imagen_id = mysql_insert_id();

// Subir file con ftp 1
if ( (isset($_FILES['imagen_imgportafolio'])) ) {

// Define variables
$tamano_max = "500000";
$archivocliente = $row_cliente['nombrecorto_cliente'];
if ($_POST['proyecto_imgportafolio'] <> '0') {
$archivoproyecto = $row_archivo_proyecto['nombrecorto_proyecto'];
$directorio = $_SERVER['DOCUMENT_ROOT'] . "/portafolio/" . $archivocliente . "/" . $archivoproyecto;
} else if ($_POST['proyecto_imgportafolio'] == '0') {
$directorio = $_SERVER['DOCUMENT_ROOT'] . "/portafolio/" . $archivocliente . "/otros";
}
$extensiones = "";
$texto_nombre = time(); // Como se llamará el arhivo final. NO incluye extensión. Ejmp.	time()
$archivo = $_FILES['imagen_imgportafolio'];
include("inc/ftp-upload.php");
$nombre_final_1 = $nombre_nuevo; 
}

  $insertSQL = sprintf("INSERT INTO portafolio (cliente_imgportafolio, proyecto_imgportafolio, genero_imgportafolio, titulo_imgportafolio, imagen_imgportafolio) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cliente_imgportafolio'], "int"),
                       GetSQLValueString($_POST['proyecto_imgportafolio'], "int"),
					   GetSQLValueString($_POST['genero_imgportafolio'], "int"),
                       GetSQLValueString($_POST['titulo_imgportafolio'], "text"),
                       GetSQLValueString($nombre_final_1, "text"));

  mysql_select_db($database_brainstorm, $brainstorm);
  $Result1 = mysql_query($insertSQL, $brainstorm) or die(mysql_error());

  $insertGoTo = "confirmacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt;A&ntilde;adir imagen</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
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
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">

<table  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="menu"><div align="right">Cliente:</div></td>
<td><strong class="menutop"><?php echo $row_cliente['cliente']; ?></strong></td>
</tr>
<tr>
<td class="menu"><div align="right">G&eacute;nero:</div></td>
<td><select name="genero_imgportafolio" id="genero_imgportafolio">
<option selected value="">(G&eacute;nero)</option>
<?php
do {  
?>
<option value="<?php echo $row_generos['id_genero']?>"><?php echo $row_generos['genero']?></option>
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
<option value="0" selected>(Ninguna)</option>
<?php
do {  
?>
<option value="<?php echo $row_proyecto['id_proyecto']?>"><?php echo $row_proyecto['proyecto']?></option>
<?php
} while ($row_proyecto = mysql_fetch_assoc($proyecto));
  $rows = mysql_num_rows($proyecto);
  if($rows > 0) {
      mysql_data_seek($proyecto, 0);
	  $row_proyecto = mysql_fetch_assoc($proyecto);
  }
?>
</select></td>
</tr>
<tr>
<td class="menu"><div align="right">T&iacute;tulo:</div></td>
<td><input name="titulo_imgportafolio" type="text" id="titulo_imgportafolio" size="55"></td>
</tr>
<tr>
<td class="menu"><div align="right">Imagen: </div></td>
<td><input name="imagen_imgportafolio" type="file" id="imagen_imgportafolio"></td>
</tr>
<tr>
<td class="menu"><div align="right"></div></td>
<td><input type="submit" name="Submit" value="Entrar"></td>
</tr>
</table>
<input name="cliente_imgportafolio" type="hidden" value="<?php echo $row_cliente['id_cliente']; ?>">
<input type="hidden" name="MM_insert" value="form1">
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
mysql_free_result($archivo_proyecto);

mysql_free_result($generos);
}
?>
