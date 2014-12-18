<?php

	global $util ;
	global $appolo_gui ;
	global $appolo_twig ;

	//session
	$session = "page" ;

	//page_data & section parent
	$page_data = $util->get_pages_page( $page )[ 0 ] ;
	$section = $page_data[ 'idSecao' ] ;

	//page_type & document
	$page_type = $_POST[ 'page-type' ] ;
	$document = json_decode( str_replace( "'", "\"", $_POST[ 'page-document'] ), true ) ;

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


	/*twig*/
	require_once TWIG_VENDOR_DIRECTORY . '/autoload.php';
	Twig_Autoloader::register() ;
	$loader = new Twig_Loader_Filesystem( TMPLS_DIR ) ;
	$twig = new Twig_Environment( $loader ) ;
	$template = $twig->loadTemplate( $config_tmpls ) ;
	$wt = $template->render( $document ) ; /*render*/
	/*/twig*/

	//save content in data
	$util->save_content_page_data( $config_data, json_encode( $document, JSON_PRETTY_PRINT ) ) ;

	//alter status
	$util->save_xml_config( true, $config_id, $config_name, $config_file, $config_data, $config_form, $config_tmpls, $config_staging, $config_live, $config_preview, $config_type, $config_status ) ;

	//change date last update
	date_default_timezone_set("America/Sao_Paulo");
	$change_date_page = date("Y-m-d H:i:s") ;
	$query =  "UPDATE tblAppPaginas SET datahoraPublicacao = '$change_date_page' " ;
	$query .= "WHERE idPagina = $page AND " . $util->get_site_id_name() . " = " . SITE_ID ;

	$result = mysqli_query( $util->configs, $query ) ;

	switch ( $page_type ) {
		case 'save':
			$util->save_xml_config( true, $config_id, $config_name, $config_file, $config_data, $config_form, $config_tmpls, $config_staging, $config_live, $config_preview, $config_type, $config_status ) ;
			$util->save_content_from_template( ( $appolo_twig->get_site_config_staging() . $config_staging ), $wt ) ;
			$util->set_warn( '13' ) ;
			$util->set_session( 'page_updated', $page ) ;
			$util->set_session( 'file_published', $appolo_twig->get_site_view_staging() . $config_preview ) ;
			$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
		break;

		case 'view':
			$util->save_content_from_template( ( $appolo_twig->get_site_config_staging() . $config_staging ), $wt ) ;
			$util->set_warn( '9' ) ;
			$appolo_gui->go_to_this( PAGES_PAGE_URL . $page ) ;
		break;

		case 'publish':
			$util->save_xml_config( true, $config_id, $config_name, $config_file, $config_data, $config_form, $config_tmpls, $config_staging, $config_live, $config_preview, $config_type, $config_status ) ;
			$util->save_content_from_template( ( $appolo_twig->get_site_config_prod() . $config_live ), $wt ) ;
			$util->set_warn( '14' ) ;
			$util->set_session( 'page_created', $page ) ;
			$util->set_session( 'file_published', $appolo_twig->get_site_view_prod() . $config_preview ) ;
			$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
		break;
		
		default:
			# code...
		break;
	}

	exit ;
?>
