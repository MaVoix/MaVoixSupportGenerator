<?php

$aDataPage = array();


/** RETOUR D'ERREUR DE GENERATION **/
if (isset($_GET["error"])) {


    $aDataErreur = array();
    switch ($_GET["error"]) {
        case "noformat":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Merci de préciser un format.";
            break;

        default:
            //message par defaut
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Une erreur s'est produite pendant la génération du fichier.";
            break;

    }
    $aDataErreur["type"] = "error";
    $aDataContent["erreur"] = display("template/block/erreur.html", $aDataErreur);
}


/*** AFFICHAGE **/

/** RATIO CROP */
$sPath = "src/" . $_SESSION["format"] . "/";
$sContent = file_get_contents($sPath . "data.json");
$JSON = json_decode($sContent, true);

$aLayers = $JSON["layers"];
ksort($aLayers);
$aDataPage["heightcrop"] = 0;
$aDataPage["widthcrop"] = 0;

foreach ($aLayers as $nLayer => $aLayer) {

    if (!isset($aLayer["type"])) {
        $aLayer["type"] = "";
    }
    if (!isset($aLayer["label"])) {
        $aLayer["label"] = "";
    }
    if (!isset($aLayer["placeholder"])) {
        $aLayer["placeholder"] = "";
    }
    if (!isset($aLayer["default_value"])) {
        $aLayer["default_value"] = "";
    }
    if (!isset($aLayer["x"])) {
        $aLayer["x"] = "0";
    }
    if (!isset($aLayer["y"])) {
        $aLayer["y"] = "0";
    }
    if (!isset($aLayer["opacity"])) {
        $aLayer["opacity"] = "1";
    }

    switch ($aLayer["type"]) {
        case "input";
            switch ($aLayer["type_input"]) {
                case "upload" :
                    $nRatio = $aLayer["width"] / $aLayer["height"];
                    $aDataPage["widthcrop"] = round(100);
                    $aDataPage["heightcrop"] = round(100 / $nRatio);
                    break;
                default:
                    break;
            }
            break;
        default:
            break;
    }

}


$aDataPage["srcfile"] = $_SESSION["tmpfile"] . ".crop.png?rd=" . time();
$aDataContent["body"] = display("template/etape3.html", $aDataPage);