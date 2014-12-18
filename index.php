<?php

/**
 * Configuração da área administrativa da aplicação.
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
	 * @since 	2013-08-19 12:51:03
 */

//ERRORS | WARNINGS | STRICT STANDARDS
ini_set( "display_errors", -1 ) ;
ob_start() ;
error_reporting( E_ALL ^ E_DEPRECATED ) ;
setlocale( LC_ALL , "pt_BR.iso88591" ) ;
header( "Access-Control-Allow-Origin: *" );
///ERRORS | WARNINGS | STRICT STANDARDS

/*root (instructions only on this page):
	|
	-> scripts/init.inc.php
		|
		-> scripts/config.inc.php
			|
			-> scripts/context.inc.php ( dev / prod / test )
			-> scripts/urls.inc.php ( URL'S )
			-> scripts/includes.inc.php ( TEMPLATES )
			-> scripts/classes.inc.php ( CLASSES )
				|
				-> classes/config.inc.php ( CONFIG STATIC CLASSES )
				-> classes/appolo.class.php [ APPOLO FUNCTIONS (BASIC) ]
				-> classes/util.class.php ( UTILITY FUNCTIONS )
				-> classes/appolo_gui.class.php ( APPOLO GUI )
				-> classes/appolo_dispatcher.class.php ( APPOLO DISPATCHER )
					|
					classes/dispatch.inc.php
				-> classes/appolo_twig.class.php ( APPOLO (INTEGRATION W/ TWIG) )
			<-
		<-

		-> includes/init.inc.php ( CREATE OBJECTS )
		<-
	<-
*/

define( "DOCUMENT_ROOT", ( $_SERVER["DOCUMENT_ROOT"] ) ) ;

require ( DOCUMENT_ROOT . "/scripts/init.inc.php" ) ;

/* * Declare Routes --> */
	/*###HOME###*/
	on( ["GET", "POST"], "/", function () {	
		
			render( 'index', [ 'go_to' => '/dashboard' ], 'redirect');
		
	} );

	on( ["GET", "POST"], "/dashboard", function () {	
		render( 'index', [], 'dashboard') ;
	} );
	/*###/HOME###*/

	/*###GENERAL###*/

	//urls
	on(	  "*" , "/urls", function () {
		render( 'index', [], 'appolo_urls' ) ;
	} );

	//error
	on( ["GET", "POST"], "/error", function () {				
		render( 'index', [], 'error') ;			
	} );

	//go_back_sections
	on( ["GET", "POST"], "/go_back_section", function () {
		render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'go_back_section' ) ) ;
	} );

	/*###/GENERAL


	/*###LOGIN###*/
	on( ["GET", "POST"], "/login", function () {
		render( 'index', [], 'login' ) ;
	} );
	on( ["GET", "POST"], "/logout", function () {
		render( 'index', [], 'logout' ) ;
	} );
	/*###/LOGIN###*/
	on( ["GET", "POST"], "/error", function () {
		render( 'index', [], 'error' ) ;
	} );
	on( ["GET", "POST"], "/error", function () {
		render( 'index', [], 'error' ) ;
	} );
	on( ["GET", "POST"], "/alterar_senha", function () {
		render( 'index', [], 'alterar_senha' ) ;
	} );
	on( ["GET", "POST"], "/alterar_dados", function () {
		render( 'index', [], 'alterar_dados' ) ;
	} );
	on( ["GET", "POST"], "/esqueceu_senha", function () {
		render( 'index', [], 'esqueceu_senha' ) ;
	} );


	/*###PAGES###*/
	resource( "/pages", function () {

		on( ["GET", "POST"], "/", function () {
			render( 'index', [ 'go_to' => '/pages/sections' ], 'redirect' ) ;
		} );

		on( ["GET", "POST"], "/sections/", function () {
			render( 'index', [], 'pages' ) ;
		} );

		on( ["GET", "POST"], "/page/", function () {
			render( 'index', [ 'go_to' => '/pages/sections' ], 'redirect' ) ;
		} );

		on( ["GET", "POST"], "/sections/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_id' => $section_id ], 'pages' ) ;
		} );

		on( ["GET", "POST"], "/page/:page_id", function ( $page_id ) {
			render( 'index', [ 'page_id' => $page_id ], 'page' ) ;
		} );

		on( ["GET", "POST"], "/page/:page_id/form/", function ( $page_id ) {
			render( 'index', [ 'page_id' => $page_id ], 'page_create_form' ) ;
		} );

		on( ["GET", "POST"], "/page/:page_id/tmpl/", function ( $page_id ) {
			render( 'index', [ 'page_id' => $page_id ], 'page_create_tmpl' ) ;
		} );

	}) ;
	/*###/PAGES###*/


	/*###NEWS###*/
	resource( "/news", function () {

		on( ["GET", "POST"], "/", function () {
			render( 'index', [ 'go_to' => '/news/sections' ], 'redirect' ) ;
		} );

		on( ["GET", "POST"], "/sections", function () {
			render( 'index', [], 'news' ) ;
		} );

		on( ["GET", "POST"], "/sections/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_id' => $section_id ], 'news' ) ;
		} );

		on( ["GET", "POST"], "/sections/:section_id/set", function ( $section_id ) {
			render( 'index', [ 'section_id' => $section_id ], 'new' ) ;
		} );

		on( ["GET", "POST"], "/sections/:section_id/set/:new_id", function ( $section_id, $new_id ) {
			render( 'index', [ 'section_id' => $section_id, 'new_id' => $new_id ], 'new' ) ;
		} );

		on( ["GET", "POST"], "/new/:section_id/tmpl/", function ( $section_id ) {
			render( 'index', [ 'section_id' => $section_id ], 'news_create_tmpl' ) ;
		} );

		on( ["GET", "POST"], "/new", function () {
			render( 'index', [], 'news_new' ) ;
		} );

		on( ["GET", "POST"], "/view", function () {
			render( 'index', [], 'news_view_staging' ) ;
		} );

	}) ;
	/*###/NEWS###*/
	
	/*###/IMAGENS###*/	
	resource( "/images", function () {
		on( ["GET", "POST"], "/", function () {
			render( 'index', [], 'images' ) ;
		} );
		on( ["GET", "POST"], "/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_id' => $section_id ], 'images_section' ) ;
		} );
	
	});
	/*###/IMAGENS###*/	
	
	/*###CONFIGS###*/
	resource( "/configs", function () {


		on( ["GET", "POST"], "/", function () {
			render( 'index', [ 'go_to' => '/dashboard' ], 'redirect');
		} );

		/*JSON URLS*/
		on( ["GET", "POST"], "/urls_json", function () {
			render( 'index', [], ( TEMPLATES_CONFIGS_DIRECTORY . 'appolo_urls-json' ) ) ;
		} );

		/*JSON URLS*/
		on( ["GET", "POST"], "/errodb.xml", function () {
			render( 'index', [], ( TEMPLATES_CONFIGS_DIRECTORY . 'errodb' ) ) ;
		} );

	}) ;
	/*###/CONFIGS###*/



	/*###CRUDS###*/
	resource( "/crud", function () {

		on( ["GET", "POST"], "/", function () {
			render( 'index', [ 'go_to' => '/dashboard' ], 'redirect') ;
		} );

		on( ["GET", "POST"], "update_admin_senha", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'update_admin_senha' ) ) ; 
		} );

		on( ["GET", "POST"], "update_admin_dados", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'update_admin_dados' ) ) ; 
		} );

		on( ["GET", "POST"], "reset_password", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'reset_password' ) ) ; 
		} );
		/*CRUDS URLS*/

		//SET WARNING!
		on( ["GET"], "/set_warn/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'set_warn' ) ) ;
		} );

		//Pages - Seções
		on( ["GET", "POST"], "/select_pages_sections/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_parent' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'select_pages_sections' ) ) ;
		} );
		on( ["GET", "POST"], "/select_pages_section_last/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_parent' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'select_pages_section_last' ) ) ;
		} );
		on( ["GET", "POST"], "/select_pages_section_last/:section_id/:breadcrumb", function ( $section_id, $breadcrumb ) {
			render( 'index', [ 'section_parent' => $section_id, 'breadcrumb' => $breadcrumb ], ( TEMPLATES_CRUDS_DIRECTORY . 'select_pages_section_last' ) ) ;
		} );
		on( ["GET", "POST"], "/insert_section/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_parent' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_section' ) ) ;
		} );
		on( ["GET", "POST"], "/insert_page/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_parent' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_page' ) ) ;
		} );
		on( ["GET", "POST"], "/section_properties/:section_id", function ( $section_id ) {
			render( 'index', [ 'section' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'section_properties' ) ) ;
		} );
		on( ["GET", "POST"], "/page_properties/:page_id", function ( $page_id ) {
			render( 'index', [ 'page' => $page_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'page_properties' ) ) ;
		} );
		on( ["GET", "POST"], "/select_pages_sections_individual/:section_id", function ( $section_id ) {
			render( 'index', [ 'section' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'select_pages_sections_individual' ) ) ;
		} );
		on( ["GET", "POST"], "/select_pages_pages_individual/:page_id", function ( $page_id ) {
			render( 'index', [ 'page' => $page_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'select_pages_pages_individual' ) ) ;
		} );
		on( ["GET", "POST"], "/delete_pages_sections/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'delete_pages_sections' ) ) ; 
		} );
		on( ["GET", "POST"], "/select_news_sections/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_parent' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'select_news_sections' ) ) ;
		} );
		on( ["GET", "POST"], "/cancel_page/:page_id", function ( $page_id ) {
			render( 'index', [ 'page' => $page_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'cancel_page' ) ) ;
		} );
		on( ["GET", "POST"], "/publish_page/:page_id", function ( $page_id ) {
			render( 'index', [ 'page' => $page_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'publish_page' ) ) ;
		} );
		on( ["GET", "POST"], "/page_create_form_send/", function ( ) {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'page_create_form_send' ) ) ;
		} );
		on( ["GET", "POST"], "/page_create_tmpl_send/", function ( ) {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'page_create_tmpl_send' ) ) ;
		} );
		on( ["GET", "POST"], "/news_create_tmpl_send/", function ( ) {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'news_create_tmpl_send' ) ) ;
		} );

		//news
		on( ["GET", "POST"], "/cancel_new/:section", function ( $section ) {
			render( 'index', [ 'section' => $section ], ( TEMPLATES_CRUDS_DIRECTORY . 'cancel_new' ) ) ;
		} );
		on( ["GET", "POST"], "/new_save/:section_id", function ( $section_id ) {
			render( 'index', [ 'section_id' => $section_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'new_save' ) ) ;
		} );
		on( ["GET", "POST"], "/action/:section_id/:new_id", function ( $section_id, $new_id ) {
			render( 'index', [ 'section_id' => $section_id, 'new_id' => $new_id ], ( TEMPLATES_CRUDS_DIRECTORY . 'action_new' ) ) ;
		} );


		//Xml & Xml parse to JSON
		on( ["GET"], "/xml_to_json/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'xml_to_json' ) ) ;
		} );
		on( ["GET"], "/view_xml_config/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'view_xml_config' ) ) ;
		} );

		//News
		on( ["GET", "POST"], "/insert_news_news", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_news_news' ) ) ;
		} );

		//funcionarios
		on( ["GET", "POST"], "/select_admin_funcionarios/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_admin_funcionarios' ) ) ; 
		} );
		on( ["GET", "POST"], "/insert_admin_funcionario/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_admin_funcionario' ) ) ; 
		} );
		on( ["GET", "POST"], "/update_admin_funcionario/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'update_admin_funcionario' ) ) ; 
		} );
		on( ["GET", "POST"], "/delete_admin_funcionario/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'delete_admin_funcionario' ) ) ; 
		} );
		on( ["GET", "POST"], "/select_contato_pessoa/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_contato_pessoa' ) ) ; 
		} );

		//usuarios
		on( ["GET", "POST"], "/select_admin_usuarios/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_admin_usuarios' ) ) ; 
		} );
		on( ["GET", "POST"], "/select_admin_funcionarios_nouser", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_admin_funcionarios_nouser' ) ) ;
		} );
		on( ["GET", "POST"], "/insert_admin_user/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_admin_user' ) ) ; 
		} );
		on( ["GET", "POST"], "/update_admin_user/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'update_admin_user' ) ) ; 
		} );
		on( ["GET", "POST"], "/select_acesso_acao/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_acesso_acao' ) ) ; 
		} );

		//Area
		on( ["GET", "POST"], "/select_admin_area/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_admin_area' ) ) ; 
		} );
		on( ["GET", "POST"], "/insert_admin_area/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_admin_area' ) ) ; 
		} );
		on( ["GET", "POST"], "/delete_admin_area/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'delete_admin_area' ) ) ; 
		} );
		on( ["GET", "POST"], "/update_admin_area/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'update_admin_area' ) ) ; 
		} );
		//Modulo Ação
		on( ["GET", "POST"], "/select_modulo_acao/", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_modulo_acao' ) ) ; 
		} );
		on( ["GET", "POST"], "/select_contratante_login", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_contratante_login' ) ) ;
		} );

		// IMAGENS
		on( ["GET", "POST"], "/select_imagem_secao", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_imagem_secao' ) ) ;
		} );
		on( ["GET", "POST"], "/insert_imagem", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'insert_imagem' ) ) ;
		} );
		on( ["GET", "POST"], "/update_image", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'update_imagem' ) ) ;
		} );
		on( ["GET", "POST"], "/select_imagem", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'select_imagem' ) ) ;
		} );
		// RELATORIOS
		on( ["GET", "POST"], "/relatorios_secao_responsavel", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'relatorios_secao_responsavel' ) ) ;
		} );
		on( ["GET", "POST"], "/relatorios_responsavel_secao", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'relatorios_responsavel_secao' ) ) ;
		} );
		on( ["GET", "POST"], "/relatorios_publicacao_autor", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'relatorios_publicacao_autor' ) ) ;
		} );
		on( ["GET", "POST"], "/relatorios_publicacao_periodo_detalhe", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'relatorios_publicacao_periodo_detalhe' ) ) ;
		} );
		on( ["GET", "POST"], "/relatorios_publicacao_periodo", function () {
			render( 'index', [], ( TEMPLATES_CRUDS_DIRECTORY . 'relatorios_publicacao_periodo' ) ) ;
		} );



		
	}) ;
	/*###/CRUDS###*/


	/*###ADMINISTRATION###*/
	resource( "/admin", function () {

		on( ["GET", "POST"], "/", function () {
			render( 'index', [], 'admin' ) ;
		} );
		on( ["GET", "POST"], "/area", function () {
			render( 'index', [], 'area' ) ; 
		} );
		on( ["GET", "POST"], "/area_edit", function () {
			render( 'index', [], 'area_edit' ) ; 
		} );
		on( ["GET", "POST"], "/funcionarios", function () {
			render( 'index', [], 'funcionarios' ) ; 
		} );
		on( ["GET", "POST"], "/funcionarios/new", function () {
			render( 'index', [], 'funcionarios_new' ) ; 
		} );
		on( ["GET", "POST"], "/funcionarios/edit", function () {
			render( 'index', [], 'funcionarios_edit' ) ; 
		} );		
		on( ["GET", "POST"], "/usuarios", function () {
			render( 'index', [], 'usuarios' ) ; 
		} );
		on( ["GET", "POST"], "/usuarios/edit", function () {
			render( 'index', [], 'usuarios_edit' ) ; 
		} );
	}) ;



	/*###/ADMINISTRATION###*/

	/*###RELATORIOS###*/
	resource( "/relatorios", function () {

		on( ["GET", "POST"], "/", function () {
			render( 'index', [], 'relatorios' ) ;
		} );
		
	}) ;



	/*###/RELATORIOS###*/
	/*###ERRORS###*/
		error(404, function () {
				echo "Oops ! [ 404 ]\n";
		});

		error(500, function () {
  			echo "Oops ! [ 500 ]\n";
		});
	/*###/ERRORS###*/



/* / <-- Finish Declare Routes* */

$appolo_dispatcher -> dispatch() ;

?>