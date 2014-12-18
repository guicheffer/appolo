<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$section_name = htmlspecialchars( $_POST["section_name"] ) ;
	$section_description = htmlspecialchars( $_POST["section_description"] ) ;
	date_default_timezone_set("America/Sao_Paulo");
	$creation_date_section = date("Y-m-d H:i:s") ;
	$section_nv = isset( $_POST["nv_section"][0] ) ? "1" : "0" ;
	$config_file = isset( $_POST["configfile"] ) ? $_POST["configfile"] : "" ;
	$idUsuario = $util->get_session( 'idUsuario' ) ;

	$section_verify_item0 = ( isset( $_POST["section_type"][0] ) ) ? ( $_POST["section_type"][0] ) : 0 ;
	$section_verify_item1 = ( isset( $_POST["section_type"][1] ) ) ? ( $_POST["section_type"][1] ) : 0 ;
	$section_verify_item2 = ( isset( $_POST["section_type"][2] ) ) ? ( $_POST["section_type"][2] ) : 0 ;
		
	$section_type_pages = ( ( $section_verify_item0 == 1 ) || ( $section_verify_item1 == 1 ) || ( $section_verify_item2 == 1 ) ) ? 1 : null ;
	$section_type_news = ( ( $section_verify_item0 == 2 ) || ( $section_verify_item1 == 2 ) || ( $section_verify_item2 == 2 ) ) ? 1 : null ;
	$section_type_imgs = ( ( $section_verify_item0 == 3 ) || ( $section_verify_item1 == 3 ) || ( $section_verify_item2 == 3 ) ) ? 1 : null ;

	if( $section_type_pages && $section_type_news && $section_type_imgs ){
		$section_type = "7" ;
	}elseif ( $section_type_news && $section_type_imgs ) {
		$section_type = "6" ;
	}elseif ( $section_type_pages && $section_type_imgs ) {
		$section_type = "5" ;
	}elseif ( $section_type_pages && $section_type_news ) {
		$section_type = "4" ;
	}elseif ( $section_type_imgs ) {
		$section_type = "3" ;
	}elseif ( $section_type_news ) {
		$section_type = "2" ;
	}elseif ( $section_type_pages ) {
		$section_type = "1" ;
	}

	//news selected [ CONFIG, FORM AND TMPL ]...
	if( ( $section_type == "7" ) || ( $section_type == "6" ) || ( $section_type == "4" ) || ( $section_type == "2" ) ){

		//then
		$data_file = isset( $_POST["datafile"] ) ? $_POST["datafile"] : "" ;
		$form_file = isset( $_POST["formfile"] ) ? $_POST["formfile"] : "" ;
		$tmpls_file = isset( $_POST["tmplfile"] ) ? $_POST["tmplfile"] : "" ;
		$staging_file = isset( $_POST["target-staging"] ) ? $_POST["target-staging"] : "" ;
		$live_file = isset( $_POST["target-live"] ) ? $_POST["target-live"] : "" ;
		$preview_file = isset( $_POST["target-preview"] ) ? $_POST["target-preview"] : "" ;
	}

	//insert
	$query = "INSERT INTO tblAppSecao (nomeSecao, descricaoSecao, caminhoFisico, dataCriacao, secaoHidden, tpSecao, idSecaoPai, idUsuario, " . $util->get_site_id_name() . ") VALUES('$section_name','$section_description','$config_file','$creation_date_section',$section_nv,$section_type,'$section_parent', $idUsuario, " . SITE_ID. ")" ;
	$result = mysqli_query( $util->configs, $query ) ;

	//return inserted
	$query = "SELECT idSecao FROM tblAppSecao WHERE nomeSecao = '$section_name' AND idSecaoPai = '$section_parent' AND " . $util->get_site_id_name() . " = " . SITE_ID . " AND secaoHidden = $section_nv AND idUsuario = $idUsuario AND dataCriacao = '$creation_date_section' " ;
	$result = mysqli_fetch_assoc( mysqli_query( $util->configs, $query ) ) ;
	$idsecaotemp = $result[ 'idSecao' ] ;

	//responsavel secao
	$query = "INSERT INTO tblAppResponsavelSecao (idSecao, idUsuario) VALUES( $idsecaotemp, $idUsuario )" ;
	$result = mysqli_query( $util->configs, $query ) ;

	if( ( $section_type == "7" ) || ( $section_type == "6" ) || ( $section_type == "4" ) || ( $section_type == "2" ) ){
		$util->save_xml_config( true, $idsecaotemp, $section_name, $config_file, $data_file, $form_file, $tmpls_file, $staging_file, $live_file, $preview_file, "section", 0 ) ;	
	}

	print( $idsecaotemp ) ;

	require ( CLOSE_DB_TEMPLATE ) ;

?>