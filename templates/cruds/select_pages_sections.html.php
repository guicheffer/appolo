<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$order = ( ( isset( $_GET[ 'order' ] ) ) ? $_GET[ 'order' ] : "nome" ) ;
	$by = ( ( isset( $_GET[ 'by' ] ) ) ? $_GET[ 'by' ] : "ASC" ) ;

	header( "Content-type: application/json" );

	print json_encode( $util->get_pages_sections( $section_parent, $order, $by ) ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>