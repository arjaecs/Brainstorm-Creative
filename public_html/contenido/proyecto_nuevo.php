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
  $insertSQL = sprintf("INSERT INTO proyectos (cliente_proyecto, proyecto, nombrecorto_proyecto) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['cliente_proyecto'], "int"),
                       GetSQLValueString($_POST['proyecto'], "text"),
                       GetSQLValueString($_POST['nombrecorto_proyecto'], "text"));

  mysql_select_db($database_brainstorm, $brainstorm);
  $Result1 = mysql_query($insertSQL, $brainstorm) or die(mysql_error());

  $insertGoTo = "proyecto_nuevo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  
// Crear folders ftp por edición
// Define variables
$ftp_server = "localhost";
$ftp_user_name = "brainstorm";
$ftp_user_pass = "cerebrito";
$proyecto_nuevo = $_POST['nombrecorto_proyecto'];
$cliente = $row_cliente['nombrecorto_cliente'];

// set up basic ftp connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// Cambiar y crear directorios
ftp_chdir($conn_id, $_SERVER['DOCUMENT_ROOT'] . "/portafolio/".$cliente);

// proyecto
if (!in_array($proyecto_nuevo, ftp_nlist($conn_id, "."))) {
ftp_mkdir($conn_id, $proyecto_nuevo); }
ftp_chdir($conn_id, $proyecto_nuevo);  

// close the FTP stream
ftp_close($conn_id);  
  
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt; Proyecto nuevo</title>
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
</table>
<!-- InstanceBeginEditable name="contenido" -->
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">

<table  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="menu"><div align="right">Cliente:</div></td>
<td class="menutop"><?php echo $row_cliente['cliente']; ?></td>
</tr>
<tr>
<td class="menu"><div align="right">Proyecto:</div></td>
<td><input name="proyecto" type="text" id="proyecto" size="40"></td>
</tr>
<tr>
<td class="menu"><div align="right">Nombre corto: </div></td>
<td><input name="nombrecorto_proyecto" type="text" id="nombrecorto_proyecto" size="15" maxlength="15"></td>
</tr>
<tr>
<td class="menu"><div align="right"></div></td>
<td><input type="submit" name="Submit" value="Entrar"></td>
</tr>
</table>
<input name="cliente_proyecto" type="hidden" id="cliente_proyecto" value="<?php echo $row_cliente['id_cliente']; ?>">
<input type="hidden" name="MM_insert" value="form1">
</form>
<!-- InstanceEndEditable -->
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
?>
