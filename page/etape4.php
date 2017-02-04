<?php

$aDataPage = array();

$aName = explode("@@", $_SESSION["tmpfile"]);
if(substr( $aName[1] ,0,3)=="src"){
    $aDataPage["download-name"] = $_SESSION["format"]."-".date("dmY").".png";
}else{
    $aDataPage["download-name"] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $aName[1]) . ".png";
}
$aDataPage["outputfile"] = $_SESSION["tmpfile"] . ".output.png?rd=" . time();

//si le fichier n'existe plus... RELOAD
if (!file_exists($_SESSION["tmpfile"] . ".output.png")) {
    $sUrlReturn = "index.php?page=etape1&error=toolate";
    header('Location: ' . $sUrlReturn);
}
/*** AFFICHAGE **/
$aDataPage["etape-prev"] = "etape3";
if ($_GET["prev"] == "etape2") {
    $aDataPage["etape-prev"] = "etape2";
}
$aDataContent["body"] = display("template/etape4.html", $aDataPage);