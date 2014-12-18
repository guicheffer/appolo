<?php
	global $util ;
	global $appolo_twig ;

	$util->set_home( 1 ) ;
	$session = "crud" ;
	$page_name = htmlspecialchars( $_POST["page_name"] ) ;
	$page_description = htmlspecialchars( $_POST["page_description"] ) ;
	date_default_timezone_set("America/Sao_Paulo");
	$creation_date_page = date("Y-m-d H:i:s") ;
	$page_nv = isset( $_POST["nv_page"][0] ) ? "1" : "0" ;
	$config_file = isset( $_POST["configfile"] ) ? $_POST["configfile"] : "" ;
	$data_file = isset( $_POST["datafile"] ) ? $_POST["datafile"] : "" ;
	$form_file = isset( $_POST["formfile"] ) ? $_POST["formfile"] : "" ;
	$tmpls_file = isset( $_POST["tmplfile"] ) ? $_POST["tmplfile"] : "" ;
	$staging_file = isset( $_POST["target-staging"] ) ? $_POST["target-staging"] : "" ;
	$live_file = isset( $_POST["target-live"] ) ? $_POST["target-live"] : "" ;
	$preview_file = isset( $_POST["target-preview"] ) ? $_POST["target-preview"] : "" ;

	//insert
	$query = "INSERT INTO tblAppPaginas (nomePagina, descricaoPagina, datahoraCriacao, caminhoXmlPagina, paginaHidden, idSecao, " . $util->get_site_id_name() . ") VALUES('$page_name','$page_description','$creation_date_page','$config_file',$page_nv,'$section_parent', " . SITE_ID. ")" ;
	$result = mysqli_query( $util->configs, $query ) ;

	//return inserted
	$query = "SELECT idPagina FROM tblAppPaginas WHERE nomePagina = '$page_name' AND idSecao = '$section_parent' AND " . $util->get_site_id_name() . " = " . SITE_ID . " AND paginaHidden = $page_nv AND datahoraCriacao = '$creation_date_page' " ;
	$result = mysqli_fetch_assoc( mysqli_query( $util->configs, $query ) ) ;

	$util->save_xml_config( true, $result[ 'idPagina' ], $page_name, $config_file, $data_file, $form_file, $tmpls_file, $staging_file, $live_file, $preview_file, "page", 0 ) ;

	print( $result[ 'idPagina' ] ) ;

	require ( CLOSE_DB_TEMPLATE ) ;

?>