<?php

/**
 * Configuração da área administrativa da aplicação.
 *
 * @package appolo
 * @subpackage dgjolero
 * @author João Guilherme <joaoguilherme@guiatech.com.br>
 * @since  2013-08-30 00:00:00
 */


$CHARSET = "UTF-8" ; /*/CHARSET*/


$GLOBALS[ "util" ] = new util() ; /*/UTIL*/


// set prefix
if ( $context == "prod" ) {

	$util->add_prefix( "//" ) ;

}else if ( $context == "dev" ) {

	$util->add_prefix( $gt_dev, $local ) ;

}else if ( $context == "test" ) {

	$util->add_prefix( $gt_dev, $local ) ; /* need to set gt_dev if its test */
	
}

/*connect db*/
$util->connect_db( $db_username, $db_password, $db_database, $db_host ) ;
$util->set_connected_db ( 1 ) ;
$util->set_site_id_name( $site_id_field ) ;

//session start
if (session_id() == '') {
    session_start();
}
//default config
$SITE_ID = $util->get_session( 'idSite' ) ;
$SITE_NAME = $util->get_session( 'nomeSite' ) ;

$link_view_staging = ( ( $util->get_session( 'linkStage' ) != '' ) ? $util->get_session( 'linkStage' ) : $link_view_staging ) ; /*default*/
$link_view_prod = ( ( $util->get_session( 'linkLive' ) != '' ) ? $util->get_session( 'linkLive' ) : $link_view_prod ) ; /*default*/

//instances
$GLOBALS[ "appolo" ] = new appolo( "Appolo", "Gerenciador de Conteúdo Web", $SITE_NAME, $SITE_ID, ( $util->check_prefix() . APPOLO_URL ), ( $util->check_prefix() . APPOLO_SITE_LIVE ), $CHARSET ) ;
$GLOBALS[ "appolo_gui" ] = new appolo_gui() ;
$GLOBALS[ "appolo_dispatcher" ] = new appolo_dispatcher() ;
$GLOBALS[ "appolo_twig" ] = new appolo_twig() ;

/*default [set variables]*/
define( "DASHBOARD_TITLE" , "Dashboard" ) ;
define( "SYSTEM_NAME" , APP_NAME ) ;
define( "SYSTEM_SLOGAN" , APP_SLOGAN ) ;
define( "SYSTEM_URL" , SYSURL ) ;
define( "SITE_ID" , SYSID ) ;
define( "SITE_NAME" , SITE ) ;
define( "SITE_URL" , URL ) ;
define( "CHARSET" , CSET );
define( "FST_ITEM" , "Home" ) ;
define( "COPYRIGHT" , "&copy; Copyright <a href='" . SITE_URL . "'>Guia Tech</a>. Todos os direitos reservados." ); /* COPYRIGHT */
define( "FAVICON" , "//images.guiatech.com.br/favicon.ico" ) ;
define( "SLUG_SITE" , ( str_replace( "+", "", ( urlencode( strtolower( SITE_NAME ) ) ) ) ) ) ;

/*configs - site%20name*/
$appolo_twig->set_site_configs ( $site_config_staging, $site_config_prod, $site_view_staging, $site_view_prod ) ;
/*/configs - site%20name*/


$actual_link ="";
if($util->get_session( 'mySqlErrno' )=="" || $util->get_session( 'mySqlError' )==""){
	if(!isset($_SESSION) || !isset($_SESSION['idUsuario'])){
		$pageURL = 'http';
		 $zzzzobjjjj = $_SERVER["REQUEST_URI"];
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }

		$actual_link = $_SERVER[ 'REQUEST_URI'];
		if ($actual_link!= "/esqueceu_senha" && $actual_link!="/crud/reset_password" ) {				
			$aux0 = substr( $actual_link , 0 , 30);
			$aux1 = substr( $actual_link , 0 , 6); 
			if ($aux1!= "/login") {								
				$util->set_session( "warn" , "14" );
				header("location:".APPOLO_LOGIN."?url=".$pageURL);
							
			}
		}		
	}
	else{
		$actual_link = $_SERVER[ 'REQUEST_URI'];
		 $zzzzobjjjj = $_SERVER["REQUEST_URI"];
		if ($actual_link== "/esqueceu_senha" || $actual_link=="/crud/reset_password"  || $actual_link=="/login" ) {	
			header("location:".APPOLO_DASHBOARD);
		}
	}
}
	

?>