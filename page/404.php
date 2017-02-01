<?php
header("HTTP/1.0 404 Not Found");
$aData=array();

$aDataContent["css"]='<link href="css/404.css" rel="stylesheet">';
$aDataContent["js"]='';
$aDataContent["body"]=display("template/404.html",$aData);