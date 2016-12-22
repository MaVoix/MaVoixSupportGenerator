<?php

$aDataPage = array();

/** NAVIGATION **/
$aDataNavigation = array();
$aDataNavigation[ "etape1-disabled" ] = "";
$aDataNavigation[ "etape2-disabled" ] = "disabled";
$aDataNavigation[ "etape3-disabled" ] = "disabled";

$aDataNavigation[ "etape1-css" ] = "btn-primary";
$aDataNavigation[ "etape2-css" ] = "btn-default";
$aDataNavigation[ "etape3-css" ] = "btn-default";

$aDataNavigation[ "etape1-href" ] = "index.php?page=etape1";
$aDataNavigation[ "etape2-href" ] = "";
$aDataNavigation[ "etape3-href" ] = "";
$aDataPage[ "navigation" ] = display( "template/block/etapes-navigation.html", $aDataNavigation );


/** RETOUR D'ERREUR DE L'UPLOAD **/
if ( isset( $_GET[ "error" ] ) ) {


	$aDataErreur = array();
	switch ( $_GET[ "error" ] ) {
		case "emptyfile":
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "Vous n'avez séléctionné de fichier.";
			break;
		case "toolate":
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "Trop tard. Le fichier envoyé n'est plus disponible. Merci de recommencer.";
			break;
		case "bigfile":
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "Le fichier envoyé est trop lourd !";
			break;
		case "bigimage":
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "L'image est trop grande !";
			break;
		default:
			//message par defaut		
			$aDataErreur[ "titre" ] = "Oops !";
			$aDataErreur[ "message" ] = "Une erreur s'est produite pendant l'envoi du fichier.";
			break;

	}
	$aDataErreur[ "type" ] = "error";
	$aDataContent[ "erreur" ] = display( "template/block/erreur.html", $aDataErreur );
}

//message d'accueil
if(!isset($_SESSION["messageaccueil"]) ){
	/*$_SESSION["messageaccueil"]=1;
	$aDataErreur[ "titre" ] = "Vie privée";
	$aDataErreur[ "message" ] = "Votre photo sera traitée de manière anonyme et ne sera pas conservée sur notre serveur.";
	$aDataErreur[ "type" ] = "info";
	$aDataContent[ "erreur" ] = display( "template/block/erreur.html", $aDataErreur );*/
}

$aDataPage[ "maxfilesize" ] = getConfig( "max-size" ) * 1024 * 1024;

/*** AFFICHAGE **/
$aDataContent[ "js" ] = '<script src="js/upload.js"></script>';
$aDataContent[ "body" ] = display( "template/etape1.html", $aDataPage );