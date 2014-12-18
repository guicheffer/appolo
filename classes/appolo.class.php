<?php

/**
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
 */

class accesObj{
	private $idModulo;
	private $idAcao;

	function setIdModulo($idModulo) { $this->idModulo = $idModulo; }
	function getIdModulo() { return $this->idModulo; }
	function setIdAcao($idAcao) { $this->idAcao = $idAcao; }
	function getIdAcao() { return $this->idAcao; }

}
class appolo extends config {

	public function appolo( $app = null, $app_slogan = null, $site = null, $sysid = null, $sysurl = null, $url = null, $cset = null ){

		// Constante que define a versão do GT Model que será utilizada
		define( "GT_MODEL_VERSION" , "2.0" ) ;
		// Usuário padrão utilizado por robôs
		define( "SYSTEM_USER_ID" , 1 ) ;
		// Nome da aplicação
		define( "APP_NAME"  , $app ) ;
		// Slogan da aplicação
		define( "APP_SLOGAN"  , $app_slogan ) ;
		// URL do site
		define( "SYSURL"  , $sysurl ) ;
		// ID do site/sistema
		define( "SYSID"  , $sysid ) ;
		// Nome do site
		define( "SITE" , $site ) ;
		// URL do site
		define( "URL" , $url ) ;
		// Charset
		define( "CSET" , $cset ) ;
		// Date
		define( "TODAY" , date("d/m/Y") ) ;

		return null ;
	}

	/*adiciona texto ao breadcrumb*/
	public function add_text_breadcrumb($value){
		parent::$text_breadcrumb = $value ;
	}

	/*texto breadcrumb*/
	public function get_text_breadcrumb(){
		return parent::$text_breadcrumb ;
	}

	/*montar breadcrumb*/
	public function mount_text_breadcrumb(){
		echo "<ul class='breadcrumb'>
		<li><a href='/'>" . DASHBOARD . "</a> <span class='divider'>/</span></li>
		$this->text_breadcrumb
		</ul>" ;
	}

	/*Verifica a sintaxe e a semântica de uma URL e retorna true ou false indicando se a URL é ou não válida.*/
	public function check_http_url_syntax( $url ){
		return preg_match( "/^(?:https?:\/\/(?:(?:(?:(?:(?:[a-zA-Z\d](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?)\.)*(?:[a-zA-Z](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?))|(?:(?:\d+)(?:\.(?:\d+)){3}))(?::(?:\d+))?)(?:\/(?:(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*)(?:\/(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))*)(?:\?(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))?)?)$/" , $url ) ;
	}

	/*Converte charset*/
	public function convert_charset( $string , $charmap ){
		for ( $i_index = 0 ; $i_index < strlen( $string ) ; $i_index++ ){
			$c = ord( substr( $string , $i_index , 1 ) ) ;

			if ( $c >= 0 && $c <= 31 ){
				if ( $c != 10 && $c != 13 ){
					$string = substr( $string , 0 , $i_index ) . substr( $string , $i_index + 1 ) ;
				}
			}
			else{
				if ( array_key_exists( (string)dechex( $c ) , $charmap ) ){
					$string = substr( $string , 0 , $i_index ) . $charmap{ (string)dechex( $c ) } . substr( $string , $i_index + 1 ) ;
				}
			}
		}
		return $string ;
	}


	public static function getAcessCode( &$module , &$action ){
		$aux = false;
		//$var = new accesObj();// comentar linha
		//$var->setIdModulo($module);// comentar linha
		//$var->setIdAcao($action);// comentar linha
		$codes = $_SESSION['accesRigths']; //descomentar esta linha 
		foreach ($codes as $var){
			$moduleAux = $var->getIdModulo();
			$actionAux = $var->getIdAcao();
			if($moduleAux == $module && $actionAux== $action){
	    		$aux = true;
	    	}
	    }	
	    return $aux;
	}

	public static function getModuleCode( &$module  ){
		$aux = false;
		$codes = $_SESSION['accesRigths']; //descomentar esta linha 
		foreach ($codes as $var){
			$moduleAux = $var->getIdModulo();
			if($moduleAux == $module){
	    		$aux = true;
	    	}
	    }	
	    return $aux;
	}
}

?>