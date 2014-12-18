<?php

	global $util ;
	global $appolo_gui ;

	if( ! $appolo_gui->render_module( "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}

	//session
	$session = "page" ;

	//page title
	$page_name_for_title = ( ( $page !== "null" ) ? ( $util->get_page_name( $page ) ) : "page" ) ;
	if( $page_name_for_title == '' ){
		$util->set_warn( '4' ) ;
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL ) ;
		exit ;
	}
	$page_name = $appolo_gui->encode_path( $page_name_for_title ) ;

	//page_data & section parent
	$page_data = $util->get_pages_page( $page )[ 0 ] ;
	$section = $page_data[ 'idSecao' ] ;

	if( $page_data[ 'paginaHidden' ] == 1){
		if( ! $appolo_gui->render_item( "1" , "1" ) ){
			$util->set_warn( '4' ) ;
			$appolo_gui->go_to_this( SECTIONS_PAGES_URL ) ;
			exit ;
		}
	}


	//XML views ( appform, appcontent, apptmpl )
	$config_type = 'page' ;
	$config_id = $page ;
	$config_user = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'user' ) ;
	$config_name = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'name' ) ;
	$config_file = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'config' ) ;
	$config_data = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'data' ) ;
	$config_form = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'form' ) ;
	$config_tmpls = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'tmpl' ) ;
	$config_staging = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'staging' ) ;
	$config_live = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'live' ) ;
	$config_preview = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'preview' ) ;
	$config_status = 0 ; //HERE

	$util->save_xml_config( true, $config_id, $config_name, $config_file, $config_data, $config_form, $config_tmpls, $config_staging, $config_live, $config_preview, $config_type, $config_status ) ;


	$util->set_warn( '5' ) ;
	$util->set_session( 'page_canceled', $page ) ;
	$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
	exit ;
?>
