<?php

//bibliothèque de fonction

function getConfig($sChaine){
	global $CONFIG;
	if(!array_key_exists($sChaine,$CONFIG)){
		return null;
	}
	return $CONFIG[$sChaine];
}


function display($sMask,$aData=array()){	
	$sChaine="";				
	if( $fp=@fopen($sMask,r) ){			
		while($sLigne=fgets($fp,8000)){				
			if(strstr($sLigne,"{#")){			
					
				preg_match_all('#{\#(.*)}#isU',$sLigne,$aMatches);
				
				foreach($aMatches as $aMatche){
					$n=0;
					foreach($aMatche as $sBalise){						
						if(!strstr($sBalise,"{#") && strlen($sBalise)<100){
							if(array_key_exists($sBalise,$aData)){
								$sLigne= str_replace("{#".$sBalise."}",$aData[$sBalise],$sLigne);	
							}
						
						}
					}
				}								
			}			
								
			$sChaine.=$sLigne;
		}		
		return $sChaine;		
	} else {
		return "ERREUR : Masque non trouv&eacute; : $sMask";
	}
}


function secureFilename($sFilename){
	$bad = array_merge(
        array_map('chr', range(0,31)),
        array("<", ">", ":", '"', "/", "\\", "|", "?", "*","@@"));
	$sFilename=strtolower(str_replace($bad, "", $sFilename));	
	$sFilename=substr($sFilename,-100);
	return $sFilename;
}

function folderSize ($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
}

function debug($sMsg){
    global $CONFIG;
    if($CONFIG["debug"]){
        $sFile=$CONFIG["tmp-folder"]."log-".session_id().".txt";
        $fp=fopen($sFile,"a");
        fwrite($fp,date("d-m-Y").";".date("H:i:s").";".$sMsg."\n");
        fclose($fp);
    }
}