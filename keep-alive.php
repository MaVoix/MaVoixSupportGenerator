<?php

session_start();
if ( file_exists( $_SESSION[ "uploadfile" ]  ) ) {	
	touch ( $_SESSION[ "uploadfile" ] );	
}

if ( file_exists( $_SESSION[ "uploadfile" ] .".output-tmp.png"  ) ) {	
	touch ( $_SESSION[ "uploadfile" ] .".output-tmp.png" );	
}
if ( file_exists( $_SESSION[ "uploadfile" ] .".output.png"  ) ) {	
	touch ( $_SESSION[ "uploadfile" ] .".output.png" );	
}
if ( file_exists( $_SESSION[ "uploadfile" ] .".crop.png"  ) ) {	
	touch ( $_SESSION[ "uploadfile" ] .".crop.png" );	
}