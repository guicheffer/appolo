<?php

/**
 * Configuração comum a todos os módulos da aplicação.
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author		João Guilherme <joaoguilherme@guiatech.com.br>
 * @since 		2013-08-30 00:00:00
 */

/*SET LOCAL CONFIG*/
require ( SET_LOCAL_CONFIG_TEMPLATE ) ;
/*/SET LOCAL CONFIG*/

class config {

	public static $home = 0 ;
	public static $off = 0 ;
	public static $site_id_name = "" ;
	public static $querystring = "" ;
	protected static $text_breadcrumb = "" ;
	protected static $addprefix = "" ;
	protected static $addlocal = "" ;
	protected static $menu_items_header = array(
		"Páginas" => PAGES_URL ,
		"Notícias" => NEWS_URL ,
		"Imagens" => IMAGES_URL ,
		"Ferramentas" => array(
			"Galerias" => GALLERY_TOOLS_URL ,
			"Comentários" => COMMENTS_TOOLS_URL ,
			"Multimídia" => MULTIMEDIA_TOOLS_URL ,
			"Mídias Sociais" => SOCIALMEDIA_TOOLS_URL ,
			"Relatórios" => REPORTS_TOOLS_URL
		) ,
		"Administração" => array(
			"Geral" => ADMIN_URL ,
			"*URLs" => APPOLO_URLS,
			"Sistema" => array(
				"Usuários" => USUARIOS_ADMIN_URL
			) ,
			"Páginas/Notícias" => array(
				"Templates" => TEMPLATES_PAGES_URL ,
				"Formulários" => FORMS_PAGES_URL
			)
		)
	) ;

}

?>