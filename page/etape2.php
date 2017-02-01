<?php

$aDataPage = array();


/** RETOUR D'ERREUR DE L'UPLOAD **/
if (isset($_GET["error"])) {


    $aDataErreur = array();
    switch ($_GET["error"]) {
        case "emptyfile":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Vous n'avez pas séléctionné de fichier.";
            break;
        case "fieldnotset":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Champs requis non présent sur le formulaire.";
            break;
        case "toolate":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Trop tard. Le fichier envoyé n'est plus disponible. Merci de recommencer.";
            break;
        case "bigfile":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Le fichier envoyé est trop lourd !";
            break;
        case "bigimage":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "L'image est trop grande !";
            break;
        default:
            //message par defaut
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Une erreur s'est produite pendant l'envoi du fichier.";
            break;

    }
    $aDataErreur["type"] = "error";
    $aDataContent["erreur"] = display("template/block/erreur.html", $aDataErreur);
}


/*** CONTSRUCTION DU FORMULAIRE ***/
$sPath = "src/" . $_SESSION["format"] . "/";
$sContent = file_get_contents($sPath . "data.json");
$JSON = json_decode($sContent, true);

$aDataPage["format"] = $JSON["title"];
$aDataPage["thumb"] = $sPath . $JSON["thumb"];

$aDataPage["form"] = "";
if (isset($JSON["layers"])) {
    $aLayers = $JSON["layers"];
    ksort($aLayers);
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
                $aDataInput = array();
                $aDataInput["label"] = $aLayer["label"];
                switch ($aLayer["type_input"]) {
                    case "upload" :
                        $aDataInput["inputname"] = "fichier";
                        $aDataInput["maxfilesize"] = getConfig("max-size") * 1024 * 1024;
                        $aDataPage["form"] .= display("template/block/form-upload.html", $aDataInput);
                        break;
                    case "text" :
                        $aDataInput["inputname"] = "textFormLayer" . $nLayer;
                        $aDataInput["placeholder"] = $aLayer["placeholder"];
                        $aDataInput["value"] = $aLayer["default_value"];
                        $aDataPage["form"] .= display("template/block/form-text.html", $aDataInput);
                        break;

                    default:
                        break;
                }

                break;
            default:
                break;
        }

    }
}


/*** AFFICHAGE **/
$aDataContent["js"] = '<script src="js/upload.js"></script>';
$aDataContent["body"] = display("template/etape2.html", $aDataPage);