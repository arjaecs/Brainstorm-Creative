<?php require_once('../Connections/brainstorm.php'); ?>
<?php
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
  $updateSQL = sprintf("UPDATE proyectos SET cliente_proyecto=%s, proyecto=%s WHERE id_proyecto=%s",
                       GetSQLValueString($_POST['cliente_proyecto'], "int"),
                       GetSQLValueString($_POST['proyecto'], "text"),
                       GetSQLValueString($_POST['id_proyecto'], "int"));

  mysql_select_db($database_brainstorm, $brainstorm);
  $Result1 = mysql_query($updateSQL, $brainstorm) or die(mysql_error());

  $updateGoTo = "confirmacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_cliente = "1";
if (isset($_GET['cliente'])) {
  $colname_cliente = (get_magic_quotes_gpc()) ? $_GET['cliente'] : addslashes($_GET['cliente']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_cliente = sprintf("SELECT * FROM clientes WHERE id_cliente = %s", $colname_cliente);
$cliente = mysql_query($query_cliente, $brainstorm) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

$colname_proyecto = "1";
if (isset($_GET['proyecto'])) {
  $colname_proyecto = (get_magic_quotes_gpc()) ? $_GET['proyecto'] : addslashes($_GET['proyecto']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_proyecto = sprintf("SELECT * FROM proyectos WHERE id_proyecto = %s", $colname_proyecto);
$proyecto = mysql_query($query_proyecto, $brainstorm) or die(mysql_error());
$row_proyecto = mysql_fetch_assoc($proyecto);
$totalRows_proyecto = mysql_num_rows($proyecto);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt; Editar proyecto</title>
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">

<table  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="menu"><div align="right">Cliente:</div></td>
<td class="menutop"><?php echo $row_cliente['cliente']; ?></td>
</tr>
<tr>
<td class="menu"><div align="right">Proyecto:</div></td>
<td><input name="proyecto" type="text" id="proyecto" value="<?php echo $row_proyecto['proyecto']; ?>" size="40"></td>
</tr>
<tr>
<td class="menu"><div align="right"></div></td>
<td><input type="submit" name="Submit" value="Entrar"></td>
</tr>
</table>
<input name="cliente_proyecto" type="hidden" id="cliente_proyecto" value="<?php echo $row_cliente['id_cliente']; ?>">
<input name="id_proyecto" type="hidden" id="id_proyecto" value="<?php echo $row_proyecto['id_proyecto']; ?>">
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
?>
