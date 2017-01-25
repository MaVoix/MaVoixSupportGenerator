<?php

//variables de configuration ici ...
$CONFIG=array();

$CONFIG["url-server"]="http://url-of-the-app.net"; // L'URL publique de l'application, pour la création des URLs des images, des scripts JS et des CSS.
$CONFIG["version"]="7"; //incrémenter pour obliger le navigateur à recharger le js et le css
$CONFIG["page-defaut"]="etape1";
$CONFIG["upload-path"]="tmp/"; // avec un slash à la fin
$CONFIG["mime-type-limit"]= array('image/jpeg','image/png');
$CONFIG["max-size"]= 10; // en Mb
$CONFIG["quota"]= 1000; // en Mb
$CONFIG["max-width"]= 4000; // en px
$CONFIG["max-height"]= 4000; //en px
$CONFIG["expire-tmp-file"] = 5; //en minutes  duree de conservation des fichiers sur le serveur
