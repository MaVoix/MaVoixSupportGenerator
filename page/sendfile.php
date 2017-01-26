<?php
$aDataPage = array();
$sUrlReturn = "index.php?page=etape1&error=XXXXX";
$nErreur = 1;

if ( array_key_exists( "fichier", $_FILES ) ) {

	$uploaddir = getConfig( "upload-path" );
	$sCleUnique = time() . md5( $_FILES[ 'fichier' ][ 'name' ] );
	$uploadfile = $uploaddir . $sCleUnique . "@@" . basename( secureFilename( $_FILES[ 'fichier' ][ 'name' ] ) );

	if ( !$_FILES[ 'fichier' ][ 'name' ] ) {
		$sUrlReturn = "index.php?page=etape1&error=emptyfile";
	}


	if ( move_uploaded_file( $_FILES[ 'fichier' ][ 'tmp_name' ], $uploadfile ) ) {

		//verifie les propriétés du fichier 

		//type de fichier
		if ( !in_array( mime_content_type( $uploadfile ), getConfig( "mime-type-limit" ) ) ) {
			$nErreur++;
		} else {
			//poids
			if ( filesize( $uploadfile ) > getConfig( "max-size" ) * 1024 * 1024 ) {
				$sUrlReturn = "index.php?page=etape1&error=bigfile";
				$nErreur++;
			} else {
				//format
				$img = new abeautifulsite\ SimpleImage( $uploadfile );
				if ( $img->get_width() > getConfig( "max-width" ) || $img->get_height() > getConfig( "max-height" ) ) {
					$sUrlReturn = "index.php?page=etape1&error=bigimage";
					$nErreur++;
				} else {
					$nErreur = 0;
					//genere une image plus petite pour le CROP					
					$_SESSION[ "uploadfile" ] = $uploadfile;
					$img->fit_to_width(500);
					$img->save( $_SESSION[ "uploadfile" ] . ".crop.png", 100 );
					$sUrlReturn = "index.php?page=etape2";
				}
			}




		}

		if ( $nErreur > 1 ) {
			//DETRUIT LE FICHIER
			@unlink( $uploadfile );
		}

	}
}
//echo $sUrlReturn;

header( 'Location: ' . $sUrlReturn );