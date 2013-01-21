<?php 
// Variables generales
$ftp_servidor = "localhost";
$ftp_usuario = "brainstorm";
$ftp_contrasena = "cerebrito";

if(strlen($extensiones) > 0){
	$extensiones = @explode(",",$extensiones);
} else {
	$extensiones = array();
}
if(!is_uploaded_file($archivo['tmp_name']) && $archivo['error'] == 0){

	echo "<strong>Error.</strong> El file no subio.";
	exit;
	} 
$nombre = $archivo['name'];
$nombre_temp = $archivo['tmp_name'];
$tamano = $archivo['size'];
if($tamano > $tamano_max && $tamano_max > 0){
	echo "<strong>Error.</strong> El archivo es muy grande.";
	exit;
}
$ext = explode(".", $nombre);
$ext = strtolower($ext[count($ext)-1]);
if(!in_array($ext, $extensiones) && count($extensiones) > 0){
	echo "<strong>Error.</strong> Extensión no válida.";
	exit;
}

$nombre_nuevo = $texto_nombre . "." . $ext;

// set up basic ftp connection
$conn_id = ftp_connect($ftp_servidor);
if (!$conn_id) {
	echo "<strong>Error.</strong> La conección FTP ha fallado.";
	exit;
}
// login with username and password
$login_result = ftp_login($conn_id, $ftp_usuario, $ftp_contrasena);
if (!$login_result) {
	echo "<strong>Error.</strong> No se pudo registrar al servidor FTP.";
	exit;
}	

// Upload the temp file
$upload = ftp_put($conn_id, $directorio . "/" . $nombre_nuevo, $nombre_temp, FTP_BINARY);

// check upload status
if (!$upload) {
	echo "<strong>Error.</strong> No se pudo subir el archivo.";
	exit;
} 

// close the FTP stream
ftp_close($conn_id);
?>