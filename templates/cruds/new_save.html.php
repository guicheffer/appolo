<?php
	global $util ;
	global $appolo_gui ;
	global $appolo_twig ;

	$util->set_home( 1 ) ;

	$session = "crud" ;
	$section = ( ( isset( $section_id ) ) ? $section_id : "null" ) ;
	$titulo_new = htmlspecialchars( $_POST["name"] ) ;
	$text_new = htmlspecialchars( $_POST["text"] ) ;
	$new = $_POST["id"] ;
	date_default_timezone_set("America/Sao_Paulo");
	$creation_date_new = date("Y-m-d H:i:s") ;
	$idUsuario = $util->get_session( 'idUsuario' ) ;
	$id_rand = mt_rand( 8 , '0123456789') ;
	$action = $_GET["action"] ;

	if( $new == 'null' ){
		$idpub = $id_rand ;
	}else{
		$idpub = $new ;
	}

	//insert
	if( $new == 'null' ){
		$query = "INSERT INTO tblAppPublicacao (idPublicacao, tituloPublicacao, textoPublicacao, status, idSecao, idTpPublicacao, idFormulario, idUsuarioCriador, " . $util->get_site_id_name() . ", dtHoraCriacao) " ;
		$query .= " VALUES(" . $idpub . ",'$titulo_new','$text_new',1,'$section',1,0,$idUsuario, " . SITE_ID. ", '$creation_date_new')" ;
		$result = mysqli_query( $util->configs, $query ) ;	
	}else{
		$query = "UPDATE tblAppPublicacao SET tituloPublicacao = '$titulo_new', textoPublicacao = '$text_new' WHERE idPublicacao = $new " ;
		$result = mysqli_query( $util->configs, $query ) ;	
	}

	//return inserted
	if( $new == 'null' ){
		$tipAlt = 'INS' ;
	}else{
		$tipAlt = 'ALT' ;
	}

	//SAVE STATUS PUB
	if( $new != 'null' ){
		$query = "SELECT * FROM tblAppAlteracao AS alteracao WHERE alteracao.idPublicacao = $new ORDER BY alteracao.dtAlteracao DESC LIMIT 1" ;
		$result = mysqli_query( $util->configs, $query ) ;
		$rows = array();
		while( $r = mysqli_fetch_assoc( $result ) ) {
			$rows[] = $r;
		}
	}

	$section_data = $util->get_section( $section )[ 0 ] ;
	$config_tmpls = $util->get_field_xml_config( $section_data[ 'caminhoFisico' ], 'tmpl' ) ;


	/*twig*/
	require_once TWIG_VENDOR_DIRECTORY . '/autoload.php';
	Twig_Autoloader::register() ;
	$loader = new Twig_Loader_Filesystem( TMPLS_DIR ) ;
	$twig = new Twig_Environment( $loader ) ;
	$template = $twig->loadTemplate( $config_tmpls ) ;
	$wt = $template->render(
		array(
			"section" => $util->get_section_name( $section ),
			"titulo" => $titulo_new,
			"texto" => htmlspecialchars_decode( $text_new ),
			"autor" => $util->get_nicename_user( $idUsuario ) )
		) ; /*render*/
	/*/twig*/ ;

	//echo "Montar em: " . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $idpub . ".shtml<br>" ;

	//print( $result[ 'idPagina' ] ) ;


	switch ($action) {
		case 'save':
			$query = "INSERT INTO tblAppAlteracao (dtAlteracao, descricaoAlteracao, caminhoXmlAlt, idUsuario, idPublicacao, notificacaoEnviada, tpAlteracaoPublicacao ) " ;
			$query .= " VALUES('$creation_date_new','','',$idUsuario,$idpub,0,'$tipAlt')" ;
			$result = mysqli_query( $util->configs, $query ) ;

			$util->save_content_from_template( ( $appolo_twig->get_site_config_staging() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $idpub . ".shtml" ), $wt ) ;
			$util->set_warn( '13' ) ;
			$util->set_session( 'news_updated', $new ) ;
			$util->set_session( 'file_published', $appolo_twig->get_site_view_staging() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $idpub . ".shtml" ) ;
			$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
			break;

		case 'view':
			if( $new == 'null' ){
				$query = "INSERT INTO tblAppAlteracao (dtAlteracao, descricaoAlteracao, caminhoXmlAlt, idUsuario, idPublicacao, notificacaoEnviada, tpAlteracaoPublicacao ) " ;
				$query .= " VALUES('$creation_date_new','','',$idUsuario,$idpub,0,'$tipAlt')" ;
				$result = mysqli_query( $util->configs, $query ) ;
			}

			$util->save_content_from_template( ( $appolo_twig->get_site_config_staging() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $idpub . ".shtml" ), $wt ) ;
			$util->set_warn( '9' ) ;
			$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section . '/set/' . $idpub ) ;
			break;

		case 'publish':

			if( $rows[0]['tpAlteracaoPublicacao'] != 'APR' ){
				if( $rows[0]['tpAlteracaoPublicacao'] == 'PEN' || $rows[0]['tpAlteracaoPublicacao'] == 'ALT' ){
					$util->set_warn( '15' ) ;
					$util->set_session( 'news_error', $new ) ;
					$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
				}else if( $rows[0]['tpAlteracaoPublicacao'] == 'REP' ){
					$util->set_warn( '18' ) ;
					$util->set_session( 'news_error', $new ) ;
					$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
				}else if( $rows[0]['tpAlteracaoPublicacao'] == 'INS' ){
					$util->set_warn( '19' ) ;
					$util->set_session( 'news_error', $new ) ;
					$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
				}
			}else{
				$query = "INSERT INTO tblAppAlteracao (dtAlteracao, descricaoAlteracao, caminhoXmlAlt, idUsuario, idPublicacao, notificacaoEnviada, tpAlteracaoPublicacao ) " ;
				$query .= " VALUES('$creation_date_new','','',$idUsuario,$idpub,0,'PUB')" ;
				$result = mysqli_query( $util->configs, $query ) ;

				$util->save_content_from_template( ( $appolo_twig->get_site_config_prod() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $idpub . ".shtml" ), $wt ) ;
				$util->set_warn( '14' ) ;
				$util->set_session( 'news_created', $new ) ;
				$util->set_session( 'file_published', $appolo_twig->get_site_view_prod() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $idpub . ".shtml" ) ;
				$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
			}
			break;
		
		default:
			# code...
			break;
	}

	require ( CLOSE_DB_TEMPLATE ) ;

?>