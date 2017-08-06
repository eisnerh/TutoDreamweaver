<?php if ( isset( $_POST['submitted'] ) ) {
	$nombreArchivo = $_FILES['archivo']['name'];
	if ( move_uploaded_file( $_FILES['archivo']['tmp_name'], $nombreArchivo ) ) {

		echo "Archivo Subido con Exito!";

	}
} else {

	echo "Ha sucedido un error!";

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Subir Archivo PHP</title>
    <meta name="generator" content="Bluefish 2.2.9">
    <meta name="author" content="Ace">
    <meta name="date" content="2017-08-06T10:49:46-0600">
    <meta name="copyright" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-type"
          content="application/xhtml+xml; charset=UTF-8">
    <meta http-equiv="content-style-type" content="text/css">
    <meta http-equiv="expires" content="0">
</head>

<form method="POST" action="<?php
basename( $_SERVER['PHP_SELF'] ); ?>" method="post" enctype="multipart/form-data">
    Seleccionar Archivo
    <input type="file" name="archivo" id="archivo">
    <input type="submit" name="submitted" value="Subir Archivo"></form>
</form>
</body>
</html>