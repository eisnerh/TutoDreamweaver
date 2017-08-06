<?php

try {

	if ( isset( $_POST['submitted'] ) ) {
		$nombreArchivo = $_FILES['archivo']['name'];

		// Undefined | Multiple Files | $_FILES Corruption Attack
		// If this request falls under any of them, treat it invalid.

		if (
			! isset( $_FILES['archivo']['error'] ) ||
			is_array( $_FILES['archivo']['error'] )
		) {
			throw new RuntimeException( 'Invalid parameters.' );
		}

		// Check $_FILES['upfile']['error'] value.
		switch ( $_FILES['archivo']['error'] ) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				throw new RuntimeException( 'No file sent.' );
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				throw new RuntimeException( 'Exceeded filesize limit.' );
			default:
				throw new RuntimeException( 'Unknown errors.' );
		}

		// DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
		// Check MIME Type by yourself.
		$finfo = new finfo( FILEINFO_MIME_TYPE );
		if ( FALSE === $ext = array_search(
				$finfo->file( $_FILES['archivo']['tmp_name'] ),
				[
					'jpg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif',
				],
				TRUE
			) ) {
			throw new RuntimeException( 'Invalid file format.' );
		}


		// You should name it uniquely.
		// DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
		// On this example, obtain safe unique name from its binary data.
		/** @var TYPE_NAME $_FILES */
		if ( ! move_uploaded_file(
			$_FILES['archivo']['tmp_name'],
			sprintf( '%s.%s',
				sha1_file( $_FILES['archivo']['tmp_name'] ),
				$ext
			)
		) ) {
			throw new RuntimeException( 'Failed to move uploaded file.' );
		}

		$para      = 'eisner.lopez@gmail.com';
		$titulo  = 'archivo subido';
		$mensaje = 'Archivo subido. <br />' . "Nombre: " . $_FILES['archivo']['name'] . "<br />Pesa: " . $_FILES['archivo']['size'];
		$cabecera = 'From: webmaster@example.com' . "\r\n" .
		            'Reply-To: webmaster@example.com' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();

		mail($para, $titulo, $mensaje, $cabecera);

		echo 'File is uploaded successfully.';
	}
}
catch ( RuntimeException $e ) {

	echo $e->getMessage();
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
basename( $_SERVER['PHP_SELF'] ); ?>" method="post"
      enctype="multipart/form-data">
    Seleccionar Archivo
    <input type="file" name="archivo" id="archivo">
    <input type="submit" name="submitted" value="Subir Archivo"></form>
</form>
</body>
</html>