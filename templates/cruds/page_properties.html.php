<?php
	global $util ;
	global $appolo_twig ;

	$util->set_home( 1 ) ;
	$session = "crud" ;
	$page_name = htmlspecialchars( $_POST["page_name"] ) ;
	$page_description = htmlspecialchars( $_POST["page_description"] ) ;
	$page_nv = isset( $_POST["nv_page"][0] ) ? "1" : "0" ;
	$config_file = isset( $_POST["configfile"] ) ? $_POST["configfile"] : "" ;
	$data_file = isset( $_POST["datafile"] ) ? $_POST["datafile"] : "" ;
	$form_file = isset( $_POST["formfile"] ) ? $_POST["formfile"] : "" ;
	$tmpls_file = isset( $_POST["tmplfile"] ) ? $_POST["tmplfile"] : "" ;
	$staging_file = isset( $_POST["target-staging"] ) ? $_POST["target-staging"] : "" ;
	$live_file = isset( $_POST["target-live"] ) ? $_POST["target-live"] : "" ;
	$preview_file = isset( $_POST["target-preview"] ) ? $_POST["target-preview"] : "" ;

	//insert
	$query =  "UPDATE tblAppPaginas SET nomePagina = '$page_name', " ;
	$query .= "descricaoPagina = '$page_description', " ;
	$query .= "caminhoXmlPagina = '$config_file', " ;
	$query .= "paginaHidden = $page_nv " ;
	$query .= "WHERE idPagina = $page AND " . $util->get_site_id_name() . " = " . SITE_ID ;

	$result = mysqli_query( $util->configs, $query ) ;

	$util->save_xml_config( true, $page, $page_name, $config_file, $data_file, $form_file, $tmpls_file, $staging_file, $live_file, $preview_file, "page", 0 ) ;

	print( $page ) ;

	require ( CLOSE_DB_TEMPLATE ) ;

?>