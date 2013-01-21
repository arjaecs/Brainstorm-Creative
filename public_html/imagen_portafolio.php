<?php require_once('Connections/brainstorm.php'); ?>
<?php
$colname_imagen_portafolio = "1";
if (isset($_GET['imagen'])) {
  $colname_imagen_portafolio = (get_magic_quotes_gpc()) ? $_GET['imagen'] : addslashes($_GET['imagen']);
}
mysql_select_db($database_brainstorm, $brainstorm);
$query_imagen_portafolio = sprintf("SELECT * FROM portafolio, clientes, proyectos, generos WHERE id_imgportafolio = %s AND portafolio.cliente_imgportafolio = clientes.id_cliente AND portafolio.proyecto_imgportafolio = proyectos.id_proyecto AND portafolio.genero_imgportafolio = generos.id_genero", $colname_imagen_portafolio);
$imagen_portafolio = mysql_query($query_imagen_portafolio, $brainstorm) or die(mysql_error());
$row_imagen_portafolio = mysql_fetch_assoc($imagen_portafolio);
$totalRows_imagen_portafolio = mysql_num_rows($imagen_portafolio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>brainstorm-creative.com >> <?php echo $row_imagen_portafolio['cliente']; ?> > <?php echo $row_imagen_portafolio['titulo_imgportafolio']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="inc/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url(imagenes/interface/secciones_01.gif);
}
-->
</style></head>

<body>
<table  border="0">
<tr>
<td valign="top"><?php
// Llamar el script de imagen
// // define los detalles del file
$dir = "portafolio/" . $row_imagen_portafolio['nombrecorto_cliente'] . "/". $row_imagen_portafolio['nombrecorto_proyecto'] ."/"; // directorio de la imagen
$file = $row_imagen_portafolio['imagen_imgportafolio']; // nombre del file
$altext = ""; // alt tag
$tipo = "2";// tipo de redimención: 0 = ancho, 1 = alto y 2 = lado más grande
$max_size = "450"; // tamaño máximo en pixeles
$ext = "img"; // extensión para renombrar la imagen
$atributos = " border=\"1\" align=\"center\""; // atributos adicionales, ejemplo: border=\"0\" align=\"center\" etc..
$cropear = "0"; // si quieres cropear la imagen: 0 = no, 1 = si
$crop_dim = ""; // dimensiones del crop. ejem. "230x170+0+0"
$crop_gravity = ""; // desde donde se cropea. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
$watermark = "0"; // si deseas tener texto integrado en la imagen. 0 = no (default), 1 = si.
$watermark_texto = ""; // texto a usarse en el watermark
$watermark_font = ""; // tipografía Ejem. Helvetica-bold (nota: la tipografía tiene que estar disponible en el servidor)
$watermark_size = ""; // tamaño de la letra
$watermark_gravity = ""; // desde donde se intriduce el texto. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
include("inc/inc-imagen.php"); // llama al script
?></td>
<td width="225"><div align="center">
</div>
<table width="225" height="225"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td valign="top"><div align="center"><img src="imagenes/interface/logobg200.gif" width="200" height="208"></div></td>
</tr>
</table>
<table width="96%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td><span class="menusimple">Cliente: </span><span class="menu"><em><?php echo $row_imagen_portafolio['cliente']; ?></em></span></td>
</tr>
<tr>
<td class="menusimple">
<?php if($row_imagen_portafolio['proyecto_imgportafolio'] <> '0') { ?>
Campa&ntilde;a: <em><?php echo $row_imagen_portafolio['proyecto']; ?></em>
<?php } else { ?>
Título: <em><?php echo $row_imagen_portafolio['titulo_imgportafolio']; ?></em>
<?php } ?>
</td>
</tr>
<tr>
<td class="menusimple">Clasificaci&oacute;n: <em><?php echo $row_imagen_portafolio['genero']; ?></em></td>
</tr>
</table>
<table width="100%"  border="0" align="center">
<tr>
<td height="25" valign="bottom"><div align="center"><a href="javascript:void(window.close())" class="blanco11">cerrar ventana </a></div></td>
</tr>
</table></td></tr>
</table>
</body>
</html>
<?php
mysql_free_result($imagen_portafolio);
?>
