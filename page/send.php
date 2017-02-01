<?php
$aDataPage = array();
$sUrlReturn = "index.php?page=etape2&error=XXXXX";
$nErreur = 0;


//RECUPER LES DONNEES DU FORMULAIRE
$sPath = "src/" . $_SESSION["format"] . "/";
$sContent = file_get_contents($sPath . "data.json");
$JSON = json_decode($sContent, true);

$aLayers = $JSON["layers"];
ksort($aLayers);
$nWidthOut = 0;

//output file default
$uploaddir = getConfig("tmp-folder");
$sCleUnique = time() . md5(session_id());
$uploadfile = $uploaddir . $sCleUnique . "@@" . $_SESSION["format"]. ".png";
$_SESSION["tmpfile"] = $uploadfile;

$isFile = false;
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
                    $isFile = true;
                    $nWidthOut = $aLayer["width"];

                    if (array_key_exists("fichier", $_FILES)) {
                        debug("Upload a file :".basename(secureFilename($_FILES['fichier']['name'])));
                        $uploaddir = getConfig("tmp-folder");
                        $sCleUnique = time() . md5($_FILES['fichier']['name']);
                        $uploadfile = $uploaddir . $sCleUnique . "@@" . basename(secureFilename($_FILES['fichier']['name']));

                        if (!$_FILES['fichier']['name']) {
                            $sUrlReturn = "index.php?page=etape2&error=emptyfile";
                            $nErreur++;
                        }


                        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $uploadfile)) {

                            //type de fichier
                            if (!in_array(mime_content_type($uploadfile), getConfig("mime-type-limit"))) {
                                $nErreur++;
                            } else {
                                //poids
                                if (filesize($uploadfile) > getConfig("max-size") * 1024 * 1024) {
                                    $sUrlReturn = "index.php?page=etape1&error=bigfile";
                                    $nErreur++;
                                } else {
                                    //format
                                    $img = new abeautifulsite\ SimpleImage($uploadfile);
                                    if ($img->get_width() > getConfig("max-width") || $img->get_height() > getConfig("max-height")) {
                                        $sUrlReturn = "index.php?page=etape1&error=bigimage";
                                        $nErreur++;
                                    } else {
                                        $_SESSION["tmpfile"] = $uploadfile;
                                        //genere une image plus petite pour le CROP
                                        $img->fit_to_width(500);
                                        $img->save($_SESSION["tmpfile"] . ".crop.png", 100);
                                        debug("create file preview for croping ".$_SESSION["tmpfile"] . ".crop.png");

                                    }
                                }


                            }

                            if ($nErreur > 1) {
                                @unlink($uploadfile);
                            }

                        }else{
                            debug("Error during moving upload file");
                        }
                    } else {
                        $sUrlReturn = "index.php?page=etape2&error=emptyfile";
                        $nErreur++;
                    }


                    break;
                case "text" :
                    $sField = "textFormLayer" . $nLayer;
                    if (array_key_exists($sField, $_POST)) {
                        $_SESSION[$sField] = $_POST[$sField];
                    } else {
                        $sUrlReturn = "index.php?page=etape2&error=fieldnotset";
                        $nErreur++;
                    }
                    break;

                default:
                    break;
            }

            break;
        default:
            break;
    }

}

if ($nErreur == 0) {
    if ($isFile == "true") {
        $sUrlReturn = "index.php?page=etape3";
    } else {
        debug("No image upload -> redirect to generate without crop");
        $sUrlReturn = "index.php?page=generate";
    }
}

header('Location: ' . $sUrlReturn);