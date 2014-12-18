<?php
	global $util ;
	global $appolo_gui ;

	$util->set_home( 1 ) ;
	$session = "crud" ;
	$page = $_POST["idPagina"] ;
	$editing = $_POST["editing"] ;
	$close = isset( $_POST["close"] ) ? $_POST["close"] : '' ;
	$page_data = $util->get_pages_page( $page )[ 0 ] ;
	$config_tmpl = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'tmpl' ) ;
	$page_data = $util->get_pages_page( $page )[ 0 ] ;
	$section = $page_data[ 'idSecao' ] ;
	$new_created = false ;

	if( file_exists( TMPLS_DIR . $config_tmpl ) ){
		$new_created = true ;
	}

	$util->save_content_tmpl( $config_tmpl, str_replace( "%/>", "%}", str_replace( "<%", "{%", $editing ) ) ) ;

	require ( CLOSE_DB_TEMPLATE ) ;

	if( ! $new_created ){
		$util->set_warn( '11' ) ;
		$util->set_session( 'page_created', $page ) ;
	}else{
		$util->set_warn( '12' ) ;
		$util->set_session( 'page_updated', $page ) ;
	}

	$util->set_session( 'file_saved', $config_tmpl ) ;

	if( $close ){
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
	}else{
		$appolo_gui->go_to_this( ( str_replace( '-id-', $page, PAGE_CREATE_TMPL ) ) ) ;
	}

	exit ;

?>