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
  $updateSQL = sprintf("UPDATE generos SET genero=%s WHERE id_genero=%s",
                       GetSQLValueString($_POST['genero'], "text"),
                       GetSQLValueString($_POST['id_genero'], "int"));

  mysql_select_db($database_brainstorm, $brainstorm);
  $Result1 = mysql_query($updateSQL, $brainstorm) or die(mysql_error());

  $updateGoTo = "confirmacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_genero = "1";
if (isset($_GET['genero'])) {
  $colname_genero = (get_magic_quotes_gpc()) ? $_GET['genero'] : addslashes($_GET['genero']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_genero = sprintf("SELECT * FROM generos WHERE id_genero = %s", $colname_genero);
$genero = mysql_query($query_genero, $brainstorm) or die(mysql_error());
$row_genero = mysql_fetch_assoc($genero);
$totalRows_genero = mysql_num_rows($genero);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido &gt;&gt; Editar género</title>
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
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
<table  border="0" align="center">
<tr>
<td width="8%" class="menu"><div align="right">G&eacute;nero:</div></td>
<td width="92%"><input name="genero" type="text" id="genero" value="<?php echo $row_genero['genero']; ?>"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Entrar"></td>
</tr>
</table>


<input name="id_genero" type="hidden" id="id_genero" value="<?php echo $row_genero['id_genero']; ?>">
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
mysql_free_result($genero);
?>
