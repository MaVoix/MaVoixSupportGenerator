<?php
session_start();

//fichier executé à chaque chargement
include "config.php";
include "lib.php";
include "class/simpleImage.class.php";

if(!isset($_GET["page"])){
	$_GET["page"]=getConfig("page-default");
}

$aDataContent=array();
$bIsAJAX=false;

$aDataContent["body"]='';
$aDataContent["erreur"]='';
$aDataContent["css"]='';
$aDataContent["js"]='';

//LOG
$sError="";
if(isset($_GET["error"])){
    $sError=" with ERROR : ".debug("open page ".$_GET["page"]);
}
debug("open page ".$_GET["page"].$sError);

switch($_GET["page"]){
	case "etape1" :				
		if( folderSize( getConfig("tmp-folder") ) > ( getConfig("quota")  * 1024 * 1024) ){
			include "page/quota.php";
            debug("QUOTA exceed");
		}else{
			include "page/etape1.php";	
		}				
	break;
	case "send" :
		if( folderSize( getConfig("tmp-folder") ) > ( getConfig("quota")  * 1024 * 1024) ){
			include "page/quota.php";
            debug("QUOTA exceed");
		}else{
			include "page/send.php";
		}					
	break;
	case "etape2" :
		include "page/etape2.php";	 	
	break;
	case "quota" :
		include "page/quota.php";	 	
	break;
	case "generate" :
		include "page/generate.php";	 	
	break;
	case "etape3" :
		include "page/etape3.php";		
	break;
    case "etape4" :
        include "page/etape4.php";
        break;
    case "select" :
        include "page/select.php";
        break;
	default:
		include "page/404.php";		
	break;
		
}

//si la page à charger n'est pas un JSON/XML on affiche le template de base HTML
if(!$bIsAJAX){
	header('Content-type: text/html; charset=utf-8');
    $nVersion=0;

    $objects = scandir("css");
    foreach ($objects as $object) {
        $nVersion+=fileatime ("css/".$object);
    }
    $objects = scandir("js");
    foreach ($objects as $object) {
        $nVersion+=fileatime ("js/".$object);
    }

            $aDataContent["version"]=$nVersion;
	$aDataContent["url-server"]=getConfig("url-server");

	echo display("template/base.html",$aDataContent);
}else{
	//sinon on affiche juste le $aDataContent["body"]
	echo $aDataContent["body"];
}


//nettoyage du dossier temporaire
$objects = scandir(getConfig("tmp-folder"));
foreach ($objects as $object) { 
	if (!is_dir(getConfig("tmp-folder").$object)) {
		   if( fileatime ( getConfig("tmp-folder").$object ) < strtotime("now -".getConfig("expire-tmp-file")." minutes")
                && $object!=".gitignore"
                && $object!=".gitkeep"
                && !(substr($object,0,4)=="log-" && substr($object,-4)==".txt")
                && !is_dir(getConfig("tmp-folder").$object)
           ){
			   @unlink(getConfig("tmp-folder").$object );
               debug("UNLINK '$object' because too old");
		   }

	}
}
