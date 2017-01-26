<?php
session_start();

//fichier executé à chaque chargement
include "config.php";
include "lib.php";
include "class/simpleImage.class.php";

if(!isset($_GET["page"])){
	$_GET["page"]=getConfig("page-defaut");
}

$aDataContent=array();
$bIsAJAX=false;

$aDataContent["body"]='';
$aDataContent["erreur"]='';
$aDataContent["css"]='';
$aDataContent["js"]='';


switch($_GET["page"]){
	case "etape1" :				
		if( folderSize( getConfig("upload-path") ) > ( getConfig("quota")  * 1024 * 1024) ){
			include "page/quota.php";	
		}else{
			include "page/etape1.php";	
		}				
	break;
	case "sendfile" :
		if( folderSize( getConfig("upload-path") ) > ( getConfig("quota")  * 1024 * 1024) ){
			include "page/quota.php";	
		}else{
			include "page/sendfile.php";	
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
	default:
		include "page/404.php";		
	break;
		
}

//si la page à charger n'est pas un JSON/XML on affiche le template de base HTML
if(!$bIsAJAX){
	header('Content-type: text/html; charset=utf-8');
	$aDataContent["version"]=getConfig("version");

    $aDataContent["url-server"]=getConfig("url-server");
	
	echo display("template/base.html",$aDataContent);
}else{
	//sinon on affiche juste le $aDataContent["body"]
	echo $aDataContent["body"];
}


//nettoyage du dossier temporaire
$objects = scandir(getConfig("upload-path")); 
foreach ($objects as $object) { 
	if (!is_dir(getConfig("upload-path").$object)) { 
		   if(fileatime ( getConfig("upload-path").$object ) < strtotime("now -".getConfig("expire-tmp-file")." minutes")){
			   @unlink(getConfig("upload-path").$object );
		   }
	}
}
