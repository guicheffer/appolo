<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$section_parent = isset( $section_parent ) ? $section_parent : "0" ;
	$breadcrumb = isset( $breadcrumb ) ? $breadcrumb : false ;

	header( "Content-type: application/json" );

	print json_encode( $util->get_parent_pages_section( $section_parent, $breadcrumb ) ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>