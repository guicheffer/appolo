<?php
	global $util ;
	global $appolo_gui ;

	$util->set_home( 1 ) ;
	$session = "crud" ;
	$section = $_POST["section_id"] ;
	$close = isset( $_POST["close"] ) ? $_POST["close"] : '' ;
	$editing = $_POST["editing"] ;
	$section_data = $util->get_section( $section )[0] ;
	$config_tmpl = $util->get_field_xml_config( $section_data[ 'caminhoFisico' ], 'tmpl' ) ;
	$section_tmpl_created = false ;


	if( file_exists( TMPLS_DIR . $config_tmpl ) ){
		$section_tmpl_created = true ;
	}

	$util->save_content_tmpl( $config_tmpl, str_replace( "%/>", "%}", str_replace( "<%", "{%", $editing ) ) ) ;

	require ( CLOSE_DB_TEMPLATE ) ;

	if( ! $section_tmpl_created ){
		$util->set_warn( '11' ) ;
		$util->set_session( 'news_created', $news ) ;
	}else{
		$util->set_warn( '12' ) ;
		$util->set_session( 'news_updated', $news ) ;
	}

	$util->set_session( 'file_saved', $config_tmpl ) ;

	if( $close ){
		$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
	}else{
		$appolo_gui->go_to_this( ( str_replace( '-id-', $section, NEWS_CREATE_TMPL ) ) ) ;
	}

	exit ;

?>