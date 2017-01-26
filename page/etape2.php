<?php

$aDataPage = array();

/** NAVIGATION **/
$aDataNavigation = array();
$aDataNavigation[ "etape1-disabled" ] = "";
$aDataNavigation[ "etape2-disabled" ] = "";
$aDataNavigation[ "etape3-disabled" ] = "disabled";

$aDataNavigation[ "etape1-css" ] = "btn-default";
$aDataNavigation[ "etape2-css" ] = "btn-primary";
$aDataNavigation[ "etape3-css" ] = "btn-default";

$aDataNavigation[ "etape1-href" ] = "index.php?page=etape1";
$aDataNavigation[ "etape2-href" ] = "index.php?page=etape2";
$aDataNavigation[ "etape3-href" ] = "";
$aDataPage[ "navigation" ] = display( "template/block/etapes-navigation.html", $aDataNavigation );


/** RETOUR D'ERREUR DE GENERATION **/
if ( isset( $_GET[ "error" ] ) ) {


	$aDataErreur = array();
	switch ( $_GET[ "error" ] ) {
		case "noformat":
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "Merci de préciser un format.";
			break;

		default:
			//message par defaut		
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "Une erreur s'est produite pendant la génération du fichier.";
			break;

	}
	$aDataErreur[ "type" ] = "error";
	$aDataContent[ "erreur" ] = display( "template/block/erreur.html", $aDataErreur );
}



/*** AFFICHAGE **/
$aDataPage[ "srcfile" ] = $_SESSION[ "uploadfile" ] . ".crop.png?rd=" . time();
$aDataContent[ "body" ] = display( "template/etape2.html", $aDataPage );