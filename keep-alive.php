<?php

session_start();
if ( file_exists( $_SESSION[ "tmpfile" ]  ) ) {
	touch ( $_SESSION[ "tmpfile" ] );
}

if ( file_exists( $_SESSION[ "tmpfile" ] .".output-tmp.png"  ) ) {
	touch ( $_SESSION[ "tmpfile" ] .".output-tmp.png" );
}
if ( file_exists( $_SESSION[ "tmpfile" ] .".output.png"  ) ) {
	touch ( $_SESSION[ "tmpfile" ] .".output.png" );
}
if ( file_exists( $_SESSION[ "tmpfile" ] .".crop.png"  ) ) {
	touch ( $_SESSION[ "tmpfile" ] .".crop.png" );
}