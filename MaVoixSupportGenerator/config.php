<?php

//variables de configuration ici ...
$CONFIG=array();

$CONFIG["version"]="6"; //incrémenter pour obliger le navigateur à recharger le js et le css
$CONFIG["page-defaut"]="etape1";
$CONFIG["upload-path"]="tmp/"; // avec un slash à la fin
$CONFIG["mime-type-limit"]= array('image/jpeg','image/png');
$CONFIG["max-size"]= 10; // en Mb
$CONFIG["quota"]= 1000; // en Mb
$CONFIG["max-width"]= 4000; // en px
$CONFIG["max-height"]= 4000; //en px
$CONFIG["expire-tmp-file"] = 5; //en minutes  duree de conservation des fichiers sur le serveur 
