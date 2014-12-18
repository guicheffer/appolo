<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;

	header( "Content-type: application/json" );

	print json_encode( $util->get_pages_page( $page ) ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>