<?php
	global $util ;
	global $appolo_gui ;
	global $appolo_twig ;

	$util->set_home( 1 ) ;

	if( ! $appolo_gui->render_item( "2" , "10" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
		exit ;
	}

	$session = "crud" ;
	$section = ( ( isset( $section_id ) ) ? $section_id : "null" ) ;
	$new = $new_id ;
	date_default_timezone_set("America/Sao_Paulo");
	$creation_date_new = date("Y-m-d H:i:s") ;
	$idUsuario = $util->get_session( 'idUsuario' ) ;
	$action = $_GET["action"] ;

	if( $action == 'approve' ){
		$tipAlt = 'APR' ;
		$num = 16 ;
	}else if( $action == 'disapprove' ){
		$tipAlt = 'REP' ;
		$num = 17 ;
	}
	
	$query = "INSERT INTO tblAppAlteracao (dtAlteracao, descricaoAlteracao, caminhoXmlAlt, idUsuario, idPublicacao, notificacaoEnviada, tpAlteracaoPublicacao ) " ;
	$query .= " VALUES('$creation_date_new','','*.xml',$idUsuario,$new,0,'$tipAlt')" ;
	$result = mysqli_query( $util->configs, $query ) ;
	
	$util->set_warn( $num ) ;
	$util->set_session( 'news_updated', $new ) ;
	$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;


	require ( CLOSE_DB_TEMPLATE ) ;

?>