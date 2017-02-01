<?php

$aDataPage = array();


/** RETOUR D'ERREUR DE SELECT **/
if (isset($_GET["error"])) {


    $aDataErreur = array();
    switch ($_GET["error"]) {
        case "noformat":
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Vous n'avez pas séléctionné de type de visuel à personnaliser.";
            break;

        default:
            //message par defaut
            $aDataErreur["titre"] = "Oops !";
            $aDataErreur["message"] = "Une erreur s'est produite.";
            break;

    }
    $aDataErreur["type"] = "error";
    $aDataContent["erreur"] = display("template/block/erreur.html", $aDataErreur);
}

/**  SELECT FORMAT **/
$aDataPage["list"] = "";
$objects = scandir("src");
sort($objects);
foreach ($objects as $object) {
    if ($object != "." && $object != ".." && is_dir("src/" . $object)) {
        $nErrorRead = 0;
        if (!$sContent = @file_get_contents("src/" . $object . "/data.json")) {
            $nErrorRead++;
        }
        $sTitle = "";
        $sThumb = "";
        if (!$nErrorRead) {
            $JSON = json_decode($sContent, true);
            if(!$JSON){
                debug("Error parsing JSON in src/".$object." folder");
            }
            if (isset($JSON["title"])) {
                $sTitle = $JSON["title"];
            }
            if (isset($JSON["thumb"])) {
                $sThumb = "src/" . $object . "/" . $JSON["thumb"];
            }
        }else{
            debug("Error reading data.json file in src/".$object." folder");
        }
        if ($sTitle) {
            $aDataPage["list"] .= '<option value="' . $object . '" data-thumb="' . $sThumb . '" >' . $sTitle . '</option>';
        }


    }

}


/*** AFFICHAGE **/
$aDataContent["js"] = '';
$aDataContent["body"] = display("template/etape1.html", $aDataPage);