<?php require_once('../Connections/brainstorm.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$ideditar = explode("=", $_SERVER['QUERY_STRING']);
$preid = $ideditar[0];
$id = $ideditar[1];

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

mysql_select_db($database_brainstorm, $brainstorm);
$query_proyectos = "SELECT * FROM proyectos, clientes WHERE proyectos.cliente_proyecto = clientes.id_cliente ORDER BY clientes.cliente";
$proyectos = mysql_query($query_proyectos, $brainstorm) or die(mysql_error());
$row_proyectos = mysql_fetch_assoc($proyectos);
$totalRows_proyectos = mysql_num_rows($proyectos);

mysql_select_db($database_brainstorm, $brainstorm);
$query_generos = "SELECT * FROM generos";
$generos = mysql_query($query_generos, $brainstorm) or die(mysql_error());
$row_generos = mysql_fetch_assoc($generos);
$totalRows_generos = mysql_num_rows($generos);

mysql_select_db($database_brainstorm, $brainstorm);
$query_generos_imagen = "SELECT * FROM generos";
$generos_imagen = mysql_query($query_generos_imagen, $brainstorm) or die(mysql_error());
$row_generos_imagen = mysql_fetch_assoc($generos_imagen);
$totalRows_generos_imagen = mysql_num_rows($generos_imagen);

$queryString_clientes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_clientes") == false && 
        stristr($param, "totalRows_clientes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_clientes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_clientes = sprintf("&totalRows_clientes=%d%s", $totalRows_clientes, $queryString_clientes);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/contenido.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>:: Brainstorm Creative :: &Aacute;rea de Contenido >> <?php if($id == cliente) { ?>Clientes<?php } ?><?php if($id == proyecto) { ?>Proyectos<?php } ?><?php if($id == genero) { ?>Géneros<?php } ?></title>
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
<table width="98%"  border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="bordenegro">
<tr>
<td><?php if($id == cliente) { ?>
<?php do { ?>
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="3" align="center" class="menunegro">&#8226;</td>
<td><span class="menusubnegro"><?php echo $row_clientes['cliente']; ?></span> <span class="gris11">[ <a href="clienteditar.php?cliente=<?php echo $row_clientes['id_cliente']; ?>" class="gris11">Editar</a>  ]</span></td>
</tr>
</table>
<?php } while ($row_clientes = mysql_fetch_assoc($clientes)); ?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="lineahordotgris"><img src="../imagenes/transparente1px.gif" width="1" height="3"></td>
</tr>
<tr>
<td><img src="../imagenes/transparente1px.gif" width="1" height="3"></td>
</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="50%" class="gris11"><strong>&nbsp;<?php echo ($startRow_clientes + 1) ?> al <?php echo min($startRow_clientes + $maxRows_clientes, $totalRows_clientes) ?> de <?php echo $totalRows_clientes ?> </strong></td>
<td width="50%"><div align="right">
<?php if ($pageNum_clientes > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_clientes=%d%s", $currentPage, max(0, $pageNum_clientes - 1), $queryString_clientes); ?>" class="gris11">Anteriores</a>
<?php } // Show if not first page ?>
<?php if ($pageNum_clientes > 0 && $pageNum_clientes < $totalPages_clientes) { ?><span class="gris11">|</span><?php } ?>
<?php if ($pageNum_clientes < $totalPages_clientes) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_clientes=%d%s", $currentPage, min($totalPages_clientes, $pageNum_clientes + 1), $queryString_clientes); ?>" class="gris11">Pr&oacute;ximos</a>
<?php } // Show if not last page ?> </div></td>
</tr>
</table>
<? } ?>
<?php if($id == proyecto) { ?>
<?php $variable = NULL; ?>
<?php do { ?>
<?php if ($row_proyectos['cliente_proyecto'] <> $variable) { ?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="lineahordotgris"><img src="../imagenes/transparente1px.gif" width="1" height="5"></td>
</tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="menusubnegro"><?php echo $row_proyectos['cliente']; ?></td>
</tr>
</table>
<?php } ?>
<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="3" align="center" class="menunegro">&#8226;</td>
<td><span class="menunegro"><?php echo $row_proyectos['proyecto']; ?></span> <span class="gris11">[ </span><a href="proyectoeditar.php?proyecto=<?php echo $row_proyectos['id_proyecto']; ?>&cliente=<?php echo $row_proyectos['id_cliente']; ?>" class="gris11">Editar</a><span class="gris11"> ]</span></td>
</tr>
</table>
<?php $variable = $row_proyectos['cliente_proyecto']; ?>
<?php } while ($row_proyectos = mysql_fetch_assoc($proyectos)); ?>
<? } ?>
<?php if($id == genero) { ?>
<?php do { ?>
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="3" align="center" class="menunegro">&#8226;</td>
<td><span class="menusubnegro"><?php echo $row_generos['genero']; ?></span> <span class="gris11">[ </span><a href="generoeditar.php?genero=<?php echo $row_generos['id_genero']; ?>" class="gris11">Editar</a><span class="gris11"> ]</span></td>
</tr>
</table>
<?php } while ($row_generos = mysql_fetch_assoc($generos)); ?>
<? } ?>
<?php if($id == imagen) { ?>
<?php do { ?>
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="3" align="center" class="menunegro">&#8226;</td>
<td><span class="menusubnegro"><a href="imgsportafolio.php?genero=<?php echo $row_generos_imagen['id_genero']; ?>" class="menusubnegro"><?php echo $row_generos_imagen['genero']; ?></a></span></td>
</tr>
</table>
<?php } while ($row_generos_imagen = mysql_fetch_assoc($generos_imagen)); ?>
<? } ?>
</td>
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
mysql_free_result($proyectos);
mysql_free_result($generos);

mysql_free_result($generos_imagen);
?>
