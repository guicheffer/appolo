<?php

/**
 * Contém todos os caminhos de templates utilizados pela aplicação
 *
 * @package		appolo
 * @subpackage	dgjolero
 */

/*appolo*/
define( "INDEX_URL" , "/" ) ;
	define( "APPOLO_URL" , "appolo.guiatech.com.br" ) ;
	define( "APPOLO_DASHBOARD" , "/dashboard" ) ;
	define( "APPOLO_URLS" , "/urls" ) ;
	define( "APPOLO_LOGIN" , "/login" ) ;
	define( "APPOLO_LOGOUT" , "/logout" ) ;
	define( "APPOLO_ERROR" , "/error" ) ;
	define( "XML_ERRODB", $_SERVER['DOCUMENT_ROOT'] . "/templates/configs/errodb.html.php" ) ;

	//crud configs
	define( "SET_WARN", "/crud/set_warn/" ) ;
	define( "ESQUECEU_SENHA", "/esqueceu_senha" ) ;
	define( "SELECT_CONTRATANTE_LOGIN" , "/crud/select_contratante_login/" ) ;

	//extras
	define( "APPOLO_SITE" , "www.guiatech.com.br/" ) ;
	define( "APPOLO_SITE_STAGING" , "staging.www.guiatech.com.br/gt" ) ;
	define( "APPOLO_SITE_LIVE" , "www.guiatech.com.br/gt" ) ;
	define( "REPOSITORY_LIST" , "//git.guiatech.com.br/live/list.php" ) ;
	define( "PUBLISHER_LIVE" , "//guiatech.com.br/live/publisher.php" ) ;

	//extras
	define( "TWIG_URL" , "http://twig.sensiolabs.org/doc/intro.html" ) ;
	define( "TRELLO_TOOL" , "https://trello.com/" ) ;
	define( "STAGING_TARGET" , str_replace( "//", "/", ( str_replace( APPOLO_URL, "", DOCUMENT_ROOT ) . APPOLO_SITE_STAGING ) ) ) ;
	define( "HOME_TARGET" , "/gt" ) ;
	define( "SLUG_HOME_TARGET" , "~" . HOME_TARGET ) ;
	define( "SLUG_STAGING_TARGET" , "/staging/" . SLUG_HOME_TARGET ) ;
	define( "LIVE_TARGET" , str_replace( "//", "/", ( str_replace( APPOLO_URL, "", DOCUMENT_ROOT ) . APPOLO_SITE_LIVE ) ) ) ;
	define( "SLUG_LIVE_TARGET" , "/live/" . SLUG_HOME_TARGET ) ;
	define( "STAGING_TARGET_SHOW" , "http://staging.www.guiatech.com.br/gt/" ) ;
	define( "LIVE_TARGET_SHOW" , "http://www.guiatech.com.br/gt/" ) ;
	define("APPOLO_ALTERAR_SENHA", "/alterar_senha");
	define("ADMIN_UPDATE_SENHA_URL", "/crud/update_admin_senha");
	define("APPOLO_ALTERAR_DADOS", "/alterar_dados");
	define("ADMIN_UPDATE_DADOS_URL", "/crud/update_admin_dados");
/*appolo-end*/

/*pages*/
define( "PAGES_URL" , "/pages/" ) ;
define( "SECTIONS_PAGES_URL" , PAGES_URL . "sections/" ) ;
define( "PAGES_PAGE_URL" , PAGES_URL . "page/" ) ;
	define( "HASH_PAGE_NEW_PAGE_URL" , "#page-new" ) ;
	define( "HASH_PAGE_NEW_SECTION_URL" , "#section-new" ) ;
	define( "HASH_PAGE_EDIT_PAGE_URL" , "#page-edit" ) ;
	define( "HASH_PAGE_EDIT_SECTION_URL" , "#section-edit" ) ;
	define( "PAGES_NEW_PAGE_URL" , PAGES_URL . "sections/" . HASH_PAGE_NEW_PAGE_URL ) ;
	define( "PAGES_NEW_SECTION_URL" , PAGES_URL . "sections/" . HASH_PAGE_NEW_SECTION_URL ) ;
	define( "PAGES_EDIT_PAGE_URL" , PAGES_URL . "sections/" .  HASH_PAGE_EDIT_PAGE_URL) ;
	define( "PAGES_EDIT_SECTION_URL" , PAGES_URL . "sections/" . HASH_PAGE_EDIT_SECTION_URL ) ;
	define( "TEMPLATES_PAGES_URL" , PAGES_URL . "templates/" ) ;
	define( "FORMS_PAGES_URL" , PAGES_URL . "forms/" ) ;
	define( "DELETE_PAGES_SECTIONS" , "/crud/delete_pages_sections/" ) ;
	define( "SELECT_PAGES_SECTIONS" , "/crud/select_pages_sections/" ) ;
	define( "SELECT_PAGES_SECTIONS_INDIVIDUAL" , "/crud/select_pages_sections_individual/" ) ;
	define( "SELECT_PAGES_SECTION_LAST" , "/crud/select_pages_section_last/" ) ;
	define( "SELECT_PAGES_PAGES_INDIVIDUAL" , "/crud/select_pages_pages_individual/" ) ;
	define( "INSERT_SECTION" , "/crud/insert_section/" ) ;
	define( "INSERT_PAGE" , "/crud/insert_page/" ) ;
	define( "SECTION_PROPERTIES" , "/crud/section_properties/" ) ;
	define( "PAGE_PROPERTIES" , "/crud/page_properties/" ) ;
	define( "XML_TO_JSON" , "/crud/xml_to_json/" ) ;
	define( "VIEW_XML_CONFIG" , "/crud/view_xml_config/" ) ;
	define( "CANCEL_PAGE_GO_BACK" , "/crud/cancel_page/" ) ;
	define( "PUBLISH_PAGE" , "/crud/publish_page/" ) ;
	define( "GO_BACK_SECTION" , "/go_back_section/" ) ;
	define( "LOADING_MESSAGE_ERROR" , "Erro ao carregar o conteúdo. (Por favor contate os administradores.)" ) ;
	define( "PAGE_CREATE_FORM" , "/pages/page/-id-/form/" ) ;
	define( "PAGE_CREATE_FORM_SEND" , "/crud/page_create_form_send/" ) ;
	define( "PAGE_CREATE_TMPL" , "/pages/page/-id-/tmpl/" ) ;
	define( "PAGE_CREATE_TMPL_SEND" , "/crud/page_create_tmpl_send/" ) ;

/*pages-end*/

/*news*/
define( "NEWS_URL" , "/news/" ) ;
define( "SECTIONS_NEWS_URL" , NEWS_URL . "sections/" ) ;
	define( "NEWS_NEW_URL" , NEWS_URL . "new/" ) ;
	define( "NEWS_NEW_SET_URL" , NEWS_NEW_URL . "set/" ) ;
	define( "NEWS_NEW_SECTION_URL" , NEWS_URL . "new/section/" ) ;
	define( "SELECT_NEWS_SECTIONS" , "/crud/select_news_sections/" ) ;
	define( "TEMPLATES_NEWS_URL" , NEWS_URL . "templates/" ) ;
	define( "FORMS_NEWS_URL" , NEWS_URL . "forms/" ) ;
	define( "CANCEL_NEWS_GO_BACK" , "/crud/cancel_new/" ) ;
	define( "NEWS_CREATE_TMPL" , "/news/new/-id-/tmpl/" ) ;
	define( "NEWS_CREATE_TMPL_SEND" , "/crud/news_create_tmpl_send/" ) ;

/*news-end*/

/*images*/
define( "IMAGES_URL" , "/images/" ) ;
	define( "SELECT_IMAGENS_SECAO", "/crud/select_imagem_secao/" ) ;
	define( "SELECT_IMAGENS", "/crud/select_imagem/" ) ;
	define( "HASH_ADMIN_NEW_IMAGE_URL" , "#image_new" ) ;
	define( "ADMIN_NEW_IMAGE_URL" , "/image/" . HASH_ADMIN_NEW_IMAGE_URL ) ;
	define( "HASH_ADMIN_UPDATE_IMAGE_URL" , "#image_update" ) ;
	define( "ADMIN_UPDATE_IMAGE_URL" , "/image/" . HASH_ADMIN_UPDATE_IMAGE_URL ) ;
	define( "INSERT_IMAGE" , "/crud/insert_imagem/" ) ;
	define( "UPDATE_IMAGE_URL" , "/crud/update_image/" ) ;

/*images-end*/

/*tools*/
define( "TOOLS_URL" , "/tools/" ) ;
	define( "GALLERY_TOOLS_URL" , "/tools/gallery/" ) ;
	define( "COMMENTS_TOOLS_URL" , "/tools/comments/" ) ;
	define( "MULTIMEDIA_TOOLS_URL" , "/tools/multimedia/" ) ;
	define( "SOCIALMEDIA_TOOLS_URL" , "/tools/socialmedia/" ) ;
	define( "REPORTS_TOOLS_URL" , "/tools/reports/" ) ;

/*tools-end*/

/*tools*/
define( "RELATORIOS_URL" , "/relatorios/" ) ;
define( "RELATORIOS_SECAO_RESPONSAVEL", "/crud/relatorios_secao_responsavel/");
define( "RELATORIOS_RESPONSAVEL_SECAO", "/crud/relatorios_responsavel_secao/");
define( "RELATORIOS_PUBLICACAO_AUTOR", "/crud/relatorios_publicacao_autor/");
define( "RELATORIOS_PUBLICACAO_PERIODO_DETALHE", "/crud/relatorios_publicacao_periodo_detalhe/");
define( "RELATORIOS_PUBLICACAO_PERIODO", "/crud/relatorios_publicacao_periodo/");
	

/*tools-end*/

/*admin (SET ALL IN EEEENGLISH ! */
define( "ADMIN_URL" , "/admin/" ) ;
	define( "USERS_ADMIN_URL" , "/admin/users/" ) ;
	define( "CHECKPOINT_ADMIN_URL" , "/admin/checkpoint/" ) ;
		define( "AREA_ADMIN_URL" , "/admin/area/" ) ;
			define( "SELECT_ADMIN_AREA" , "/crud/select_admin_area/" ) ;
			define( "INSERT_ADMIN_AREA" , "/crud/insert_admin_area/" ) ;
			define( "HASH_ADMIN_NEW_AREA_URL" , "#area-new" ) ;
			define( "ADMIN_NEW_AREA_URL" , "/admin/area/" . HASH_ADMIN_NEW_AREA_URL ) ;
			define( "EDIT_AREA_ADMIN_URL" , "/admin/area_edit" ) ;
			define( "ADMIN_UPDATE_AREA_URL" , "/crud/update_admin_area/" ) ;
			define( "DELETE_ADMIN_AREA" , "/crud/delete_admin_area/" ) ;
	define( "FUNCIONARIOS_ADMIN_URL" , "/admin/funcionarios/" ) ;
		define( "SELECT_ADMIN_FUNCIONARIOS" , "/crud/select_admin_funcionarios/" ) ;
		define( "SELECT_ADMIN_CONTATO_PESSOA" , "/crud/select_contato_pessoa/" ) ;
		define( "NEW_FUNCIONARIOS_ADMIN_URL" , "/admin/funcionarios/new/" ) ;
		define( "INSERT_ADMIN_FUNCIONARIO" , "/crud/insert_admin_funcionario/" ) ;
		define( "EDIT_FUNCIONARIOS_ADMIN_URL" , "/admin/funcionarios/edit/" ) ;
		define( "ADMIN_UPDATE_FUNCIONARIOS_URL" , "/crud/update_admin_funcionario/" ) ;
		define( "DELETE_ADMIN_FUNCIONARIOS" , "/crud/delete_admin_funcionario/" ) ;
	define( "USUARIOS_ADMIN_URL" , "/admin/usuarios/" ) ;
		define( "SELECT_ADMIN_USUARIOS" , "/crud/select_admin_usuarios/" ) ;
		define( "HASH_ADMIN_NEW_USERS_URL" , "#user-new" ) ;
		define( "ADMIN_EDIT_USERS_URL" , "/admin/usuarios/edit" ) ;
		define( "ADMIN_NEW_USERS_URL" , "/admin/usuarios/" . HASH_ADMIN_NEW_USERS_URL ) ;
		define( "INSERT_ADMIN_USUARIOS" , "/crud/insert_admin_user/" ) ;
		define("SELECT_ADMIN_FUNCIONARIOS_NOUSER", "/crud/select_admin_funcionarios_nouser");
		define("SELECT_ADMIN_ACESSOS_USER", "/crud/select_acesso_acao");
		define("ADMIN_UPDATE_USER_URL", "/crud/update_admin_user");	
	define( "ACTIONS_ADMIN_URL" , "/admin/actions/" ) ;
		define( "NEW_ACTIONS_ADMIN_URL" , "/admin/actions/new/" ) ;

	define( "SELECT_MODULE_ACTION" , "/crud/select_modulo_acao/" ) ;
	

/*admin-end*/

/*Alterar Dados*/
define( "DADOS_URL" , "/session/" ) ;
define( "RESET_PASSWORD" , "/crud/reset_password") ;
/*Alterar Dados*/

?>