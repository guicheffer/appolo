<?php

/**
 * Configuração comum a todos os módulos da aplicação [ CONFIGURAÇÃO LOCAL ].
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author		João Guilherme <joaoguilherme@guiatech.com.br>
 * @since 		2013-08-30 00:00:00
 */	

	// Configurações para cada ambiente [PDO]
	$site_id_field = "idSite" ;

	//paths
	$site_staging_path = "/home4/dgjolero/public_html/staging/www.guiatech.com.br/gt/" ; /*prod site view*/
	$site_prod_path = "/home4/dgjolero/public_html/gt/" ; /*prod site view*/

	$site_view_staging = "http://staging.guiatech.com.br/gt/" ;
	$site_view_prod = "http://www.guiatech.com.br/gt/" ;

	$link_view_staging = "http://staging.guiatech.com.br/gt/" ; /*default*/
	$link_view_prod = "http://www.guiatech.com.br/gt/" ; /*default*/

	if ( $context == "test" ) {
		include "setlocalconfig_nochanges.inc.php" ;
		$site_view_prod = $site_view_staging ;
		$site_view_staging = $site_view_staging . 'gt/' ;
	} else if ( $context == "dev" ) {
		$db_username = "dgjolero" ;
		$db_password = "Alpha2013gT" ;
		$db_database = "dgjolero_appolo" ;
		$db_host = "localhost" ;
		$debug = true ;
		$site_config_staging = $site_staging_path ;
		$site_config_prod = $site_prod_path ;
		$dir_images = "/home4/dgjolero/public_html/staging/dev/live/appolo.guiatech.com.br/images.appolo/";
	}
	else if ( $context == "prod" ) {
		$db_username = "dgjolero" ;
		$db_password = "Alpha2013gT" ;
		$db_database = "dgjolero_appolo" ;
		$db_host = "localhost" ;
		$site_config_staging = $site_staging_path ;
		$site_config_prod = $site_prod_path ;
		$dir_images = "/home4/dgjolero/public_html/staging/dev/live/appolo.guiatech.com.br/images.appolo/";
	}

?>