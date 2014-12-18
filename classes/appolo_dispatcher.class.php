<?php

/**
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
 */

require_once ( CLASSES_DIRECTORY . '/dispatch.inc.php' ) ;

class appolo_dispatcher extends appolo {


	/**
	 * Número de versão da classe.
	 * A variável é pública devido à herança do appolo.
	 *
	 * @var	string
	 */

	public $_version = "1.0" ;
	public static $router = "index.php" ;
	public static $flash_cookie = "_F" ;



	public static function dispatch(){
		dispatch() ;
	}



	public function appolo_dispatcher(){

		config([
			'dispatch.views' => TEMPLATES_DIRECTORY, /*tmpls dir*/
			'dispatch.layout' => TEMPLATES_DIRECTORY, /*tmpls dir*/
			'dispatch.flash_cookie' => self::$flash_cookie,
			'dispatch.url' => APPOLO_URL,
			'dispatch.router' => self::$router
		]) ;

	}



}