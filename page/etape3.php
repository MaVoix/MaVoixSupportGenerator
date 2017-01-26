<?php

$aDataPage = array();

/** NAVIGATION **/
$aDataNavigation = array();
$aDataNavigation[ "etape1-disabled" ] = "";
$aDataNavigation[ "etape2-disabled" ] = "";
$aDataNavigation[ "etape3-disabled" ] = "";

$aDataNavigation[ "etape1-css" ] = "btn-default";
$aDataNavigation[ "etape2-css" ] = "btn-default";
$aDataNavigation[ "etape3-css" ] = "btn-primary";

$aDataNavigation[ "etape1-href" ] = "index.php?page=etape1";
$aDataNavigation[ "etape2-href" ] = "index.php?page=etape2";
$aDataNavigation[ "etape3-href" ] = "index.php?page=etape3";
$aDataPage[ "navigation" ] = display( "template/block/etapes-navigation.html", $aDataNavigation );



$aName = explode( "@@", $_SESSION[ "uploadfile" ] );
$aDataPage[ "download-name" ] = preg_replace( '/\\.[^.\\s]{3,4}$/', '', $aName[ 1 ] ) . "-MAVOIX.png";
$aDataPage[ "outputfile" ] = $_SESSION[ "uploadfile" ] . ".output.png?rd=" . time();

//si le fichier n'existe plus... RELOAD
if ( !file_exists( $_SESSION[ "uploadfile" ] . ".output.png" ) ) {
	$sUrlReturn = "index.php?page=etape1&error=toolate";
	header( 'Location: ' . $sUrlReturn );
}
/*** AFFICHAGE **/

$aDataContent[ "body" ] = display( "template/etape3.html", $aDataPage );