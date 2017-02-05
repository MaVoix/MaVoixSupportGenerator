<?php

$dateLegislative= "2017-06-11";

$now = new DateTime();
$dateBdd = new DateTime($dateLegislative);
echo "J-".$dateBdd->diff($now)->days;