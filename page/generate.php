<?php
$aDataPage = array();
$sUrlReturn = "index.php?page=etape3&error=XXXXX";
$nErreur = 1;
$etapePrev = "etape2";


//GENERATE FROM JSON LAYER
$sPath = "src/" . $_SESSION["format"] . "/";
$sContent = file_get_contents($sPath . "data.json");
$JSON = json_decode($sContent, true);
debug("Read JSON");
$aLayers = $JSON["layers"];
ksort($aLayers);
debug("Layers : ".count($aLayers));
$img = imagecreatetruecolor($JSON["width"], $JSON["height"]);
imagepng($img, $_SESSION["tmpfile"] . ".output.png");


$img = new abeautifulsite\ SimpleImage($_SESSION["tmpfile"] . ".output.png");


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


    debug("LAYER $nLayer : ".$aLayer["type"]);
    switch ($aLayer["type"]) {
        case "image" :
            $img->overlay($sPath . $aLayer["src"], 'top left', $aLayer["opacity"], $aLayer["x"], $aLayer["y"]);
            debug("LAYER $nLayer : overlay ".$aLayer["src"]);
            break;
        case "text" :
            if(!isset($aLayer["text"])){
                $aLayer["text"]="";
            }
            $sText = $aLayer["text"];
            if (!isset($aLayer["anchor"])) $aLayer["anchor"] = "center";
            $img->text($sText, "./" . $sPath . $aLayer["fontfile"], $aLayer["fontsize"], $aLayer["color"], $aLayer["anchor"], $aLayer["x"], $aLayer["y"]);
            debug("LAYER $nLayer : text : ".$sText);
            break;
        case "input";

            switch ($aLayer["type_input"]) {

                case "text" :
                    $sText = $_SESSION["textFormLayer" . $nLayer];
                    if (!isset($aLayer["anchor"])) $aLayer["anchor"] = "center";
                    $img->text($sText, "./" . $sPath . $aLayer["fontfile"], $aLayer["fontsize"], $aLayer["color"], $aLayer["anchor"], $aLayer["x"], $aLayer["y"]);
                    debug("LAYER $nLayer : text_input : ".$sText);
                    break;

                case "upload" :

                    //recadrage carré sur la photo originale
                    $imgUpload = new abeautifulsite\ SimpleImage($_SESSION["tmpfile"]);
                    $imgSmall = new abeautifulsite\ SimpleImage($_SESSION["tmpfile"] . ".crop.png");


                    //if tool croping info
                    if (isset($_POST["photocrop-angle"])) {
                        $etapePrev = "etape3";
                        //rotate
                        $imgUpload->rotate($_POST["photocrop-angle"]);
                        $imgSmall->rotate($_POST["photocrop-angle"]);

                        //ratio
                        $nRatioX = $imgUpload->get_width() / ($imgSmall->get_width() * doubleval($_POST["photocrop-zoom"]));
                        $nRatioY = $imgUpload->get_height() / ($imgSmall->get_height() * doubleval($_POST["photocrop-zoom"]));

                        $croped = $imgUpload->crop($_POST["photocrop-x1"] * $nRatioX, $_POST["photocrop-y1"] * $nRatioY, $_POST["photocrop-x2"] * $nRatioX, $_POST["photocrop-y2"] * $nRatioY);


                        $croped->fit_to_width($aLayer["width"]);
                        $img->overlay($croped, 'top left', $aLayer["opacity"], $aLayer["x"], $aLayer["y"]);
                    }else{
                        $img->overlay( $imgUpload, 'top left', $aLayer["opacity"], $aLayer["x"], $aLayer["y"]);
                    }

                    debug("LAYER $nLayer : overlay upload");
                    break;

                default:
                    break;
            }

            break;
        default:
            break;
    }

}
$img->save($_SESSION["tmpfile"] . ".output.png", 100);
debug("SAVE ".$_SESSION["tmpfile"] . ".output.png");
$sUrlReturn = "index.php?page=etape4&prev=" . $etapePrev;


header('Location: ' . $sUrlReturn);





