<?
$path = "../imagenes/secciones/";
$max_size = 200000;
$message = "";
	
if (is_uploaded_file($HTTP_POST_FILES['imagen1']['tmp_name'])) {

		  $imagen1 = $HTTP_POST_FILES['imagen1']['name'];

            if ($HTTP_POST_FILES['imagen1']['size']>$max_size) {
                echo "La imagen es demasiado pesada.<br>\n"; exit;
            }
            if (($HTTP_POST_FILES['imagen1']['type']=="image/gif") || ($HTTP_POST_FILES['imagen1']['type']=="image/pjpeg") || ($HTTP_POST_FILES['imagen1']['type']=="image/jpeg")) {

                if(move_uploaded_file($HTTP_POST_FILES['imagen1']['tmp_name'], $path . $imagen1)){
                    $message .=  "File Name: ".$HTTP_POST_FILES['imagen1']['name']." \n";
                    $message .=  "File Size: ".$HTTP_POST_FILES['imagen1']['size']." bytes \n";
                    $message .=  "File Type: ".$HTTP_POST_FILES['imagen1']['type']."<br>\n";
                }
                else{
                    $message .=  "¡No subió la imagen! Trata de nuevo.<br>\n"; exit;
                }
            }
        }		
		
if (is_uploaded_file($HTTP_POST_FILES['imagen2']['tmp_name'])) {

		  $imagen2 = $HTTP_POST_FILES['imagen2']['name'];

            if ($HTTP_POST_FILES['imagen2']['size']>$max_size) {
                echo "La imagen es demasiado pesada.<br>\n"; exit;
            }
            if (($HTTP_POST_FILES['imagen2']['type']=="image/gif") || ($HTTP_POST_FILES['imagen2']['type']=="image/pjpeg") || ($HTTP_POST_FILES['imagen2']['type']=="image/jpeg")) {

                if(move_uploaded_file($HTTP_POST_FILES['imagen2']['tmp_name'], $path . $imagen2)){
                    $message .=  "File Name: ".$HTTP_POST_FILES['imagen2']['name']." \n";
                    $message .=  "File Size: ".$HTTP_POST_FILES['imagen2']['size']." bytes \n";
                    $message .=  "File Type: ".$HTTP_POST_FILES['imagen2']['type']."<br>\n";
                }
                else{
                    $message .=  "¡No subió la imagen! Trata de nuevo.<br>\n"; exit;
                }
            }
        }
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO secciones (nombreseccion, imagenseccion, imagencontenudoseccion, textoseccion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombreseccion'], "text"),
                       GetSQLValueString($imagen1, "text"),
                       GetSQLValueString($imagen2, "text"),
                       GetSQLValueString($_POST['textoseccion'], "text"));

  mysql_select_db($database_brainstorm, $brainstorm);
  $Result1 = mysql_query($insertSQL, $brainstorm) or die(mysql_error());
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="150"><div align="right">Nombre de la secci&oacute;n:</div></td>
<td><input name="nombreseccion" type="text" id="nombreseccion" size="55"></td>
</tr>
<tr>
<td><div align="right">Imagen nombre: </div></td>
<td><input name="imagen1" type="file" id="imagen1"></td>
</tr>
<tr>
<td><div align="right">Imagen contenido: </div></td>
<td><input name="imagen2" type="file" id="imagen2"></td>
</tr>
<tr>
<td valign="top"><div align="right">Texto:</div></td>
<td><textarea name="textoseccion" cols="55" rows="5" id="textoseccion"></textarea></td>
</tr>
<tr>
<td><div align="right"></div></td>
<td><input type="submit" name="Submit" value="Entrar"></td>
</tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
