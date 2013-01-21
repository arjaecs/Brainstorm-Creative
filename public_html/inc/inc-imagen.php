<?php
/////////////////////////////////////////
// Script para imágenes .75             //
// Adaptado del "PHP SNIPLLET"         //
// Necesita ImageMagick                //
// Por Ricardo Olivero                 //
// 2004 --> GPL                        //
// 		                               //
// 2005-01-13                          //
// úsalo<->modifícalo<->cópiatelo      //
/////////////////////////////////////////
//
// INSTRUCCIONES
//
// Desde el file que vayas a llamar el script,
// copia esto y define las variables como desees:
//
// // Llamar el script de imagen
// // define los detalles del file
// $dir = "../fotos/"; // directorio de la imagen
// $file = ""; // nombre del file
// $altext = ""; // alt tag
// $tipo = "";// tipo de redimención: 0 = ancho, 1 = alto y 2 = lado más grande
// $max_size = ""; // tamaño máximo en pixeles
// $ext = ""; // extensión para renombrar la imagen
// $atributos = " border=\"1\""; // atributos adicionales, ejemplo: border=\"0\" align=\"center\" etc..
// $cropear = "0"; // si quieres cropear la imagen: 0 = no, 1 = si
// $crop_dim = ""; // dimensiones del crop. ejem. "230x170+0+0"
// $crop_gravity = ""; // desde donde se cropea. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
// $watermark = "0"; // si deseas tener texto integrado en la imagen. 0 = no (default), 1 = si.
// $watermark_texto = ""; // texto a usarse en el watermark
// $watermark_font = ""; // tipografía Ejem. Helvetica-bold (nota: la tipografía tiene que estar disponible en el servidor)
// $watermark_size = ""; // tamaño de la letra
// $watermark_gravity = ""; // desde donde se intriduce el texto. opciones: NorthWest, North, NorthEast, West, Center, East, SouthWest, South, SouthEast
// include("inc-imagen.php"); // llama al script
//
//////////////////////////////////////////

// saca la info de la imagen
$file_actual = $dir.$file;
$current_size = getimagesize($file_actual);
$current_img_width = $current_size[0];
$current_img_height = $current_size[1];
$detalles_file = explode(".", $file);

// cambia el nombre del file
$nombre_file = $detalles_file[0];
$ext_file = $detalles_file[1];
$nombre_nuevo = $dir.$detalles_file[0].$ext.".".$detalles_file[1];

// si la imagen ya existe, pues no se hace nada
if (!file_exists($nombre_nuevo)) {

// determina si la imagen necesita cambiar el tamaño
// y si lo necesita, cambia el tamaño

// Tipo 0 (ancho)
if ($tipo == "0") {
if ($current_img_width > $max_size) {
$too_big_diff_ratio = $current_img_width/$max_size;
$new_img_width = $max_size;
$new_img_height = round($current_img_height/$too_big_diff_ratio);
} else {
$new_img_width = $current_img_width;
$new_img_height = $current_img_height;
}
}

// Tipo 1 (alto)
if ($tipo == "1") {
if ($current_img_height > $max_size) {
$too_big_diff_ratio = $current_img_height/$max_size;
$new_img_height = $max_size;
$new_img_width = round($current_img_width/$too_big_diff_ratio);
} else {
$new_img_width = $current_img_width;
$new_img_height = $current_img_height;
}
}

// Tipo 2 (lado más grande)
if ($tipo == "2") {
if ($current_img_width > $current_img_height) {
$too_big_diff_ratio = $current_img_width/$max_size;
$new_img_width = $max_size;
$new_img_height = round($current_img_height/$too_big_diff_ratio);
} else if ($current_img_width == $max_size) {
$new_img_width = $current_img_width;
$new_img_height = $current_img_height;
} else if  ($current_img_height == $max_size) {
$new_img_width = $current_img_width;
$new_img_height = $current_img_height;
} else {
$too_big_diff_ratio = $current_img_height/$max_size;
$new_img_height = $max_size;
$new_img_width = round($current_img_width/$too_big_diff_ratio);
}
}

// Tipo 3 (lado más pequeño)
if ($tipo == "3") {
if ($current_img_width < $current_img_height) {
$too_big_diff_ratio = $current_img_width/$max_size;
$new_img_width = $max_size;
$new_img_height = round($current_img_height/$too_big_diff_ratio);
} else if ($current_img_width == $max_size) {
$new_img_width = $current_img_width;
$new_img_height = $current_img_height;
} else if  ($current_img_height == $max_size) {
$new_img_width = $current_img_width;
$new_img_height = $current_img_height;
} else {
$too_big_diff_ratio = $current_img_height/$max_size;
$new_img_height = $max_size;
$new_img_width = round($current_img_width/$too_big_diff_ratio);
}
}

// modifica la imagen con ImageMagick
// redimensiona
$make_magick = passthru("convert -geometry $new_img_width x $new_img_height $file_actual $nombre_nuevo", $retval);

// cropea
if ($cropear == 1) {
$make_magick = passthru("convert -gravity $crop_gravity -crop $crop_dim $nombre_nuevo $nombre_nuevo", $retval);
}

// incluye watermark
if ($watermark == 1) {
$make_magick = passthru("convert -gravity $watermark_gravity -font $watermark_font -pointsize $watermark_size -fill white -draw \"fill black  text 4,3 '$watermark_texto' fill white  text 4,4 '$watermark_texto'\" $nombre_nuevo $nombre_nuevo", $retval);
}
                        
}

// Sacar los tags de alto y ancho de la imagen
$heightwidth_tags = getimagesize($nombre_nuevo);

// Imprime el file nuevo con todos los tags
echo "<img src=\"$nombre_nuevo\" $heightwidth_tags[3] alt=\"$altext\"$atributos />"; 
?>