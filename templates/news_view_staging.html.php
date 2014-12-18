<?php

	global $util ;
	global $appolo_twig ;

	$title = " Notícias - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "news" ;
	$test = isset( $_GET[ "test" ] ) ? $_GET[ "test" ] : "" ;
	$id = isset( $_GET[ "p" ] ) ? $_GET[ "p" ] : "" ;
	$fileextension = ".html" ;
	$filename = $appolo_twig->get_site_config_staging() . $id . $fileextension ;
	$permission = "w+" ;

	if ( ! $id ){
		header('Location: /news/');
	}else{

		$query = "SELECT idPublicacao,tituloPublicacao,textoPublicacao from tblAppPublicacao where idPublicacao = '" . $id . "'" ;
		$result = mysqli_query( $util->configs, $query ) ;

		require_once TWIG_VENDOR_DIRECTORY . '/autoload.php';
		Twig_Autoloader::register() ;
		$loader = new Twig_Loader_Filesystem( TEMPLATES_TWIG_DIRECTORY . 'guia_tech/' ) ;
		$twig = new Twig_Environment( $loader ) ;
		$template = $twig->loadTemplate( 'gt-noticia-2014.html' ) ;

		while( $news = mysqli_fetch_array( $result ) ) {
			//fields (sql)
			$wt = $template->render( array( 'site_name' => SITE_NAME, 'titulo' => $news["tituloPublicacao"], 'texto' => $news["textoPublicacao"] ) ) ;
		}

		//$wt = TEMPLATES_TWIG_DIRECTORY . 'guia_tech/' ;

		$fp = fopen( $filename, $permission );
		fwrite( $fp, $wt );
		fclose( $fp );

		echo "<p>### Escrito com sucesso ! ###</p>" ;
		/**/

	}

?>

<!--FOOTER-->
<?php require ( CLOSE_DB_TEMPLATE ) ;?>
<!--/FOOTER-->