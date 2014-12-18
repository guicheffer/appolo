<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$set_warn = isset( $_GET[ 'set_warn' ] ) ? $_GET[ 'set_warn' ] : 0 ;

	$util->set_warn( ( isset( $set_warn ) ) ? $set_warn : "" ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>