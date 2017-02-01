<?php

//Config var are there ...
$CONFIG=array();

$CONFIG["url-server"]="http://url-of-the-app.net";
$CONFIG["page-default"]="etape1";
$CONFIG["tmp-folder"]="tmp/"; // with "/" at the end
$CONFIG["mime-type-limit"]= array('image/jpeg','image/png');
$CONFIG["max-size"]= 10; // in Mb
$CONFIG["quota"]= 1000; // in Mb
$CONFIG["max-width"]= 4000; // in px
$CONFIG["max-height"]= 4000; //in px
$CONFIG["expire-tmp-file"] = 5; //in minutes  ( life duration of the files on the tmp folder )
$CONFIG["debug"] = false; //enable debug mode ( write event in log.txt in tmp folder)