<?php
$aDataPage = array();
$sUrlReturn = "index.php?page=etape1&error=XXXXX";
$nErreur = 1;

//force le format
$_POST[ "format" ]="facebook-profil";

if ( !isset( $_POST[ "format" ] ) ||  trim($_POST[ "format" ] =="")) {
	$sUrlReturn = "index.php?page=etape2&error=noformat";
	$nErreur++;

} else {
	if ( file_exists( $_SESSION[ "uploadfile" ] ) ) {
		
		
		//recadrage carré sur la photo originale
		$img = new abeautifulsite\ SimpleImage( $_SESSION[ "uploadfile" ] );
		$imgSmall = new abeautifulsite\ SimpleImage( $_SESSION[ "uploadfile" ].".crop.png" );
		
		//rotatiion
		$img->rotate($_POST["photocrop-angle"]);
		$imgSmall ->rotate($_POST["photocrop-angle"]);
		
		//ratio
		$nRatioX=$img->get_width()/($imgSmall->get_width()*doubleval($_POST["photocrop-zoom"]));
		$nRatioY=$img->get_height()/($imgSmall->get_height()*doubleval($_POST["photocrop-zoom"]));
		
		
		$img->crop(  $_POST["photocrop-x1"]*$nRatioX, $_POST["photocrop-y1"]*$nRatioY, $_POST["photocrop-x2"]*$nRatioX , $_POST["photocrop-y2"]*$nRatioY );

			
		switch ( $_POST[ "format" ] ) {
			case "affiche":

				//image rectangle 			
				$nWidthOutput=660;
				$nHeightOutput=590;
				$img->fit_to_width( $nWidthOutput );
				$img->crop( 0, 0, $nWidthOutput, $nHeightOutput );
				$img->save( $_SESSION[ "uploadfile" ] . ".output-tmp.png", 100 );				
				
				//image out
				$img = new abeautifulsite\ SimpleImage( "img/mask-affiche-fond.png" );
				$img->overlay( $_SESSION[ "uploadfile" ] . ".output-tmp.png", 'top right', 1, -90, 230 );
				$img->overlay( 'img/mask-affiche-tampon.png', 'top right', 1, 0, 0 );
				$img->save( $_SESSION[ "uploadfile" ] . ".output.png", 100 );
				$sUrlReturn = "index.php?page=etape3";

				break;

			case "facebook-mur":

				//image carré 			
				$nWidthOutput=140;
				$nHeightOutput=140;
				$img->fit_to_width($nWidthOutput );
				$img->save( $_SESSION[ "uploadfile" ] . ".output-tmp.png", 100 );

				$img = new abeautifulsite\ SimpleImage( "img/mask-mur-facebook.png" );
				$img->overlay( $_SESSION[ "uploadfile" ] . ".output-tmp.png", 'top right', 1, -40, 35 );
				$img->save( $_SESSION[ "uploadfile" ] . ".output.png", 100 );
				$sUrlReturn = "index.php?page=etape3";


				break;

			default:
					
				//image rectangle 				
				$nWidthOutput=400;
				$nHeightOutput=350;
				$img->fit_to_width( $nWidthOutput );
				$img->crop( 0, 0, $nWidthOutput, $nHeightOutput );
				$img->save( $_SESSION[ "uploadfile" ] . ".output-tmp.png", 100 );

				$img = new abeautifulsite\ SimpleImage( "img/mask-profil-facebook.png" );
				$img->overlay( $_SESSION[ "uploadfile" ] . ".output-tmp.png", 'top right', 1, -50, 50 );
				$img->save( $_SESSION[ "uploadfile" ] . ".output.png", 100 );
				$sUrlReturn = "index.php?page=etape3";		
				break;

		}


	} else {
		$sUrlReturn = "index.php?page=etape1&error=toolate";
		$nErreur = 1;
	}
}



//echo $sUrlReturn;

header( 'Location: ' . $sUrlReturn );