<?php
$aDataPage = array();
$sUrlReturn = "index.php?page=etape1&error=XXXXX";
$nErreur = 1;


if (!isset($_POST["format"]) || trim($_POST["format"] == "")) {
    $sUrlReturn = "index.php?page=etape1&error=noformat";
    $nErreur++;

} else {
    debug("select format :".$_POST["format"]);
    $_SESSION["format"] = $_POST["format"];
    $sUrlReturn = "index.php?page=etape2";
}


//echo $sUrlReturn;

header('Location: ' . $sUrlReturn);