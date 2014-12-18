<?php

/**
 * Funções utilitárias comuns a todos os módulos da aplicação.
 *
 * @package    appolo
 * @subpackage dgjolero
 * @author     João Guilherme <joaoguilherme@guiatech.com.br>
 * @since      2013-08-30 00:00:00
 */



/* =============================================================================

   UTIL [ FUNCTIONS ]

   ========================================================================== */
	class util extends appolo {

		public $configs = "" ;
	   	public $database = "" ;
	   	public $erro_db = 0 ;
	   	public $db_connected = 0 ;
	   	public static $show_rendering_template = "" ;

	   	//set as homepage
	   	public static function set_home( $value = 0 ){

	   		parent::$home = $value ;

	   	}

	   	//check if its home
	   	public static function check_home(){

	   		if( ! ( empty( parent::$home ) ) ){

	   			return true ;

	   		}else{

	   			return false ;

	   		}

	   	}

	   	//set a out of
	   	public static function set_off( $value = 0 ){

	   		parent::$off = $value ;

	   	}


	   	//check if its out of
	   	public static function check_on(){

	   		if( ! ( empty( parent::$off ) ) ){

	   			return false ;

	   		}else{

	   			return true ;

	   		}

	   	}

	   	//set erro db
	   	public function set_erro_db( $value ){

	   		$this->erro_db = $value ;

	   	}



	   	//get erro db (?)
	   	public function get_erro_db(){

	   		if( $this->erro_db == 1 ){

	   			return true ;

	   		}else{

	   			return false ;

	   		}

	   	}

	   	//set connect db
	   	public function set_connected_db( $value ){

	   		$this->db_connected = $value ;

	   	}



	   	//get connect db (?)
	   	public function get_connected_db(){

	   		if( $this->db_connected == 1 ){

	   			return true ;

	   		}else{

	   			return false ;

	   		}

	   	}



	   	//check if its on debug
	   	public static function debug(){

	   		/*linktourls*/
	   		echo "teste" ;

	   	}


	   	//addprefix before assets
	   	public static function add_prefix( $prefix = "", $local = null ){

	   		parent::$addprefix = "$prefix" ;
	   		parent::$addlocal = "$local" ;

	   	}



	   	//addprefix before assets
	   	public static function check_prefix(){

	   		return parent::$addprefix ;

	   	}

	   	//addlocal before assetsmysql_close($link);
	   	public static function check_local(){

	   		return parent::$addlocal ;
	   	}


	   	//set id name (field value) before search fields
	   	public static function set_site_id_name( $field_site_id_name = "" ){

	   		parent::$site_id_name = "$field_site_id_name" ;

	   	}

	   	//get id name (field value) before search fields
	   	public function get_site_id_name(){

	   		return parent::$site_id_name ;

	   	}


	   	//set querystring
	   	public static function set_querystring( $qs = null ){

	   		parent::$querystring = $qs ;

	   	}



	   	//get querystring
	   	public function get_querystring(){

	   		return parent::$querystring ;

	   	}

	   	//mysql_close( $link );
	   	public function close_db( $link = null ){
	   		if ( ! $this->erro_db && isset( $configs ) ) { $close_db = mysqli_close( $link ) or die( mysqli_error($link) ) ; }
	   	}

	    //set session active
	   	public function  set_session( $nameVariable, $valueVar ){
	   		$_SESSION[ $nameVariable ] = $valueVar;
	   	}

	   	//get session active
	   	public function  get_session( $session ){
	   		return ( ( isset( $_SESSION[ $session ] ) ) ? $_SESSION[ $session ] : "" ) ;
	   	}

	   	//get session active and after this clear him
	   	public function  get_session_and_clear( $session ){
	   		$result = ( ( isset( $_SESSION[ $session ] ) ) ? $_SESSION[ $session ] : "" ) ;
	   		$_SESSION[ $session ] = "" ;
	   		return $result ;
	   	}

	    //set warn - after all
	   	public function set_warn( $warn ){
	   		$this->set_session( "warn", $warn ) ;
	   	}

	   	//connect db
	   	public function connect_db( $db_username = "", $db_password = "", $db_database = "", $db_host = ""  ){
	   		try {
	         	//configs (dafault)
	   			$this->configs = mysqli_connect( $db_host, $db_username, $db_password, $db_database ) or die( mysqli_error($this->configs) )  ;

	   			$result_conn = mysqli_query( $this->configs, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

	   			$this->set_connected_db( 1 ) ;

	   		} catch (Exception $e) {
	   			util::errorMysql ("" , "Erro ao se conectar no Banco de Dados");
	   			$this->set_erro_db( 1 ) ;
	   		}

	   	}

		//delete sections section
		public function delete_sections_section( $section ){
			$query = "DELETE FROM tblAppSecao WHERE idSecao = " . $section ;
			$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

			$result = mysqli_query( $this->configs, $query ) ;
		}

		//delete sections page
		public function delete_sections_page( $page ){
			$query = "DELETE FROM tblAppPaginas WHERE idPagina = " . $page ;
			$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

			$result = mysqli_query( $this->configs, $query ) ;
		}

		//delete sections news
		public function delete_sections_news( $new ){
			$query = "UPDATE tblAppPublicacao SET status = 0 WHERE idPublicacao = " . $new ;
			$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

			$result = mysqli_query( $this->configs, $query ) ;

			$query = "DELETE FROM tblAppAlteracao WHERE idPublicacao = " . $new ;
			$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

			$result = mysqli_query( $this->configs, $query ) ;
		}

	   	//get section name
	   	public function get_section_name( $section ){
	   		$section = ( (int) $section ) ;
	   		$query =  "SELECT nomeSecao from tblAppSecao " ;
	   		$query .= "where idSecao = $section " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		return $rows[ 0 ]["nomeSecao"] ;
	   	}

	   	//get page name
	   	public function get_page_name( $page ){
	   		$page = ( (int) $page ) ;
	   		$query =  "SELECT nomePagina from tblAppPaginas " ;
	   		$query .= "where idPagina = $page " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		if( ! count( $rows ) > 0 ){
	   			return "" ;
	   		}

	   		return $rows[ 0 ]["nomePagina"] ;
	   	}


	   	//get pages (sections)
	   	public function get_news_sections( $section, $order = null, $by = null, $context ){
	   		$order_field = $order ;
	   		$order_type = '' ;

	   		if( $section != 0 ){
				$hidden = $this->get_pages_section( $section ) ;
				$result_individual = $hidden[ 0 ][ 'secaoHidden' ] ;

				if( ( ( $result_individual == "1" ) && ( ! appolo_gui::render_item( "1" , "1" ) ) ) ){
					return array() ;
				}	
			}

			switch ( $order_field ){
				case 'type':
					$order_type = 'type' ;
					$order = 'nomeSecao' ;
					$by = 'ASC' ;
				break ;

				case 'nome':
					$order = 'nomeSecao' ;
				break ;

				case 'data_criacao':
					$order = 'dataCriacao' ;
				break ;

				case 'data_atualizacao':
					$by = 'ASC' ;
					$order = 'nomeSecao' ;
				break ;
				
				default:
					$by = 'ASC' ;
					$order = 'nomeSecao' ;
				break ;
			}

			$query_sections =  "SELECT * from tblAppSecao " ;
			//$query_sections .= "where idSecaoPai = $section " ;
			$query_sections .= ' WHERE ' . util::get_site_id_name() . ' = ' . SITE_ID ;
			$query_sections .= ' AND ( tpSecao = 2 OR tpSecao = 4 OR tpSecao = 6 OR tpSecao = 7 ) ' ;
			$query_sections .= " ORDER BY $order $by" ;

			$result_sections = mysqli_query($this->configs, $query_sections ) ;

			$rows_sections = array();

			if( $section == 0 ){
				while( $r_sections = mysqli_fetch_assoc( $result_sections ) ) {
					if( ! ( ( $r_sections[ 'secaoHidden' ] == "1" ) && ( ! appolo_gui::render_item( "1" , "1" ) ) ) ){
						$rows_sections[] = $r_sections ;
					}
				}
			}

			switch ( $order_field ){
				case 'type':
					$order_type = 'type' ;
					$order = 'tituloPublicacao' ;
				break ;

				case 'nome':
					$order = 'tituloPublicacao' ;
				break ;

				/*case 'data_criacao':
					$order = 'datahoraCriacao' ;
				break ;

				case 'data_atualizacao':
					$order = 'datahoraPublicacao' ;
				break ;*/
				
				default:
					$by = 'ASC' ;
					$order = 'tituloPublicacao' ;
				break ;
			}

			
			$query_news =  "SELECT * from tblAppPublicacao " ;
			$query_news .= "where idSecao = $section " ;
			$query_news .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
			$query_news .= ' AND status = 1 ' ;
			$query_news .= " ORDER BY $order $by" ;

			/*else if( $context == 'dev' ){
				$query_news = "CALL spAppPublicacaoSelect( '', '', NULL, NULL, NULL, '', $section, NULL, NULL, NULL, @statusProc )" ;
			}*/

			//print $query_news;

			$result_news = mysqli_query($this->configs, $query_news ) ;

			$rows_news = array();

			while( $r_news = mysqli_fetch_assoc( $result_news ) ) {
				$query_alteracao = "SELECT * FROM tblAppAlteracao AS alteracao WHERE alteracao.idPublicacao = " . $r_news[ 'idPublicacao' ] . " ORDER BY alteracao.dtAlteracao DESC LIMIT 1" ;
				$result_alteracao = mysqli_query( $this->configs, $query_alteracao ) ;
				$rows_alteracao = array();

				while( $r = mysqli_fetch_assoc( $result_alteracao ) ) {
					$rows_alteracao[] = $r;
				}

				//print_r( $rows_alteracao[0] ) ;

				$r_news[ 'textoPublicacao' ] =  substr($r_news[ 'textoPublicacao' ], 0, 50) . '(...)' ;
				if( isset( $rows_alteracao[0] ) ){
					$r_news[ 'status_text' ] =  $rows_alteracao[0]['tpAlteracaoPublicacao'] ;
					$r_news[ 'nicename' ] = $this->get_nicename_user( $rows_alteracao[0][ 'idUsuario' ] ) ;
					$r_news[ 'datahoraAlteracao' ] = $rows_alteracao[0][ 'dtAlteracao' ] ;	
				}
				//$r_news[ 'dtatualizacao' ] = $this->get_nicename_user( $rows_alteracao[0][ 'idUsuario' ] ) ;
				$rows_news[] = $r_news ;
	   		}

	   		$result = array() ;

	   		if( ( $order_type == 'type' ) && ( $by == 'ASC' ) ){
	   			$result = array_merge( $rows_sections, $rows_news ) ;
	   		}else if( ( $order_type == 'type' ) && ( $by == 'DESC' ) ){
	   			$result = array_merge( $rows_news, $rows_sections ) ;
	   		}else{
	   			$result = array_merge( $rows_sections, $rows_news ) ;
	   		}

	   		return $result ;
	   	}


	   	//get pages (sections)
	   	public function get_pages_sections( $section, $order = null, $by = null ){
	   		$order_field = $order ;
	   		$order_type = '' ;

	   		if( $section != 0 ){
				$hidden = $this->get_pages_section( $section ) ;
				$result_individual = $hidden[ 0 ][ 'secaoHidden' ] ;

				if( ( ( $result_individual == "1" ) && ( ! appolo_gui::render_item( "1" , "1" ) ) ) ){
					return array() ;
				}	
			}

			switch ( $order_field ){
				case 'type':
					$order_type = 'type' ;
					$order = 'nomeSecao' ;
					$by = 'ASC' ;
				break ;

				case 'nome':
					$order = 'nomeSecao' ;
				break ;

				case 'data_criacao':
					$order = 'dataCriacao' ;
				break ;

				case 'data_atualizacao':
					$by = 'ASC' ;
					$order = 'nomeSecao' ;
				break ;
				
				default:
					$by = 'ASC' ;
					$order = 'nomeSecao' ;
				break ;
			}

			$query_sections =  "SELECT * from tblAppSecao " ;
			$query_sections .= "where idSecaoPai = $section " ;
			$query_sections .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
			//$query_sections .= ' AND ( tpSecao = 1 OR tpSecao = 4 OR tpSecao = 5 OR tpSecao = 7 ) ' ;
			$query_sections .= " ORDER BY $order $by" ;

			$result_sections = mysqli_query($this->configs, $query_sections ) ;

			$rows_sections = array();

			while( $r_sections = mysqli_fetch_assoc( $result_sections ) ) {
				if( ! ( ( $r_sections[ 'secaoHidden' ] == "1" ) && ( ! appolo_gui::render_item( "1" , "1" ) ) ) ){
					$rows_sections[] = $r_sections ;
				}
			}

			switch ( $order_field ){
				case 'type':
					$order_type = 'type' ;
					$order = 'nomePagina' ;
				break ;

				case 'nome':
					$order = 'nomePagina' ;
				break ;

				case 'data_criacao':
					$order = 'datahoraCriacao' ;
				break ;

				case 'data_atualizacao':
					$order = 'datahoraPublicacao' ;
				break ;
				
				default:
					$by = 'ASC' ;
					$order = 'nomePagina' ;
				break ;
			}

			$query_pages =  "SELECT * from tblAppPaginas " ;
			$query_pages .= "where idSecao = $section " ;
			$query_pages .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
			$query_pages .= " ORDER BY $order $by" ;

			$result_pages = mysqli_query($this->configs, $query_pages ) ;

			$rows_pages = array();

			while( $r_pages = mysqli_fetch_assoc( $result_pages ) ) {
				$r_pages[ 'status' ] = $this->get_field_xml_config( $r_pages[ 'caminhoXmlPagina' ], 'status' ) ;
				$r_pages[ 'status_aeraerer' ] = $this->get_field_xml_config( $r_pages[ 'caminhoXmlPagina' ], 'user' ) ;
				if( $this->get_field_xml_config( $r_pages[ 'caminhoXmlPagina' ], 'user' ) != '' ){
					$r_pages[ 'nicename' ] = $this->get_nicename_user( $this->get_field_xml_config( $r_pages[ 'caminhoXmlPagina' ], 'user' ) ) ;
				}

				if( ! ( ( $r_pages[ 'paginaHidden' ] == "1" ) && ( ! appolo_gui::render_item( "1" , "1" ) ) ) ){
					$rows_pages[] = $r_pages ;
	   			}
	   		}

	   		$result = array() ;

	   		if( ( $order_type == 'type' ) && ( $by == 'ASC' ) ){
	   			$result = array_merge( $rows_sections, $rows_pages ) ;
	   		}else if( ( $order_type == 'type' ) && ( $by == 'DESC' ) ){
	   			$result = array_merge( $rows_pages, $rows_sections ) ;
	   		}else{
	   			$result = array_merge( $rows_sections, $rows_pages ) ;
	   		}

	   		return $result ;
	   	}

	   	//get pages (pages)
	   	public function get_pages_pages( $section ){
	   		$query =  "SELECT * from tblAppPaginas " ;
	   		$query .= "where idSecaoPai = $section " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
	   		$query .= " ORDER BY nomePagina ASC" ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		return $rows ;
	   	}

	   	//get pages (section [individual])
	   	public function get_pages_section( $section ){
	   		$query_sections =  "SELECT * from tblAppSecao " ;
	   		$query_sections .= "where idSecao = $section " ;
	   		$query_sections .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query_sections ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		return $rows ;
	   	}

	   	//get pages (page [individual])
	   	public function get_pages_page( $page ){
	   		$query =  "SELECT * from tblAppPaginas " ;
	   		$query .= "where idPagina = $page " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		return $rows ;
	   	}

	   	//get news (new [individual])
	   	public function get_news_new( $new ){
	   		$query =  "SELECT * from tblAppPublicacao " ;
	   		$query .= "where idPublicacao = $new " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		return $rows ;
	   	}

	   	//get sections (section [individual])
	   	public function get_section( $section ){
	   		$query =  "SELECT * from tblAppSecao " ;
	   		$query .= "where idSecao = $section " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		return $rows ;
	   	}

	   	//get by kind (*where* - XML _ TO _ JSON - [individual])
	   	public function get_xml_config( $id, $where ){

	   		if( $where == 'section' ){
		   		$query =  "SELECT caminhoFisico as path from tblAppSecao " ;
		   		$query .= "where idSecao = $id " ;
		   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
	   		}else if( $where == 'page' ){
		   		$query =  "SELECT caminhoXmlPagina as path from tblAppPaginas " ;
		   		$query .= "where idPagina = $id " ;
		   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
	   		}

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		if( count( $rows ) == 0 ){
	   			return "" ;
	   		}

	   		return $rows[ 0 ][ 'path' ] ;
	   	}

	   	//get field xml - config
	   	public function get_field_xml_config( $xml, $field ){
	   		$xml_config = CONFS_DIR . $xml ;

			if( ( $xml == "" ) || ( ! file_exists( $xml_config ) ) ) {
				return null ;
				exit ;
			}

			$xmlStr = file_get_contents( $xml_config ) ;

			if (get_magic_quotes_runtime())
			{
			    $xmlStr = stripslashes($xmlStr);
			}

			$xml = simplexml_load_string( $xmlStr ) ;

			if( $field == 'name' ){
				$var = array( (string) $xml->name ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'type' ){
				$var = array( (string) $xml->type ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'id' ){
				$var = array( (int) $xml->id ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'user' ){
				$var = array( (int) $xml->user ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'config' ){
				$var = array( (string) $xml->config ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'data' ){
				$var = array( (string) $xml->data ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'form' ){
				$var = array( (string) $xml->form ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'tmpl' ){
				$var = array( (string) $xml->tmpls->file ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'staging' ){
				$var = array( (string) $xml->tmpls->tmpl->outs->out->staging ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'live' ){
				$var = array( (string) $xml->tmpls->tmpl->outs->out->live ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'preview' ){
				$var = array( (string) $xml->preview ) ;
				$var = $var[ 0 ] ;
			}else if( $field == 'status' ){
				$var = array( (int) $xml->status ) ;
				$var = $var[ 0 ] ;
			}else{
				return "Not Found" ;
			}
			
			return $var ;
	   	}

	   	//get sections (only sections)
	   	public function get_only_sections( $section ){
	   		$query_sections =  "SELECT * from tblAppSecao " ;
	   		$query_sections .= "where idSecaoPai = $section " ;
	   		$query_sections .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
	   		$query_sections .= " ORDER BY nomeSecao ASC" ;

	   		$result_sections = mysqli_query($this->configs, $query_sections ) ;


	   		$result = array();

	   		while( $r_sections = mysqli_fetch_assoc( $result_sections ) ) {
	   			$result[] = $r_sections;
	   		}

	   		return $result ;
	   	}

	   	//get sections (only pages)
	   	public function get_only_pages( $page ){
	   		$query_sections =  "SELECT * from tblAppPaginas " ;
	   		$query_sections .= "where idSecao = $section " ;
	   		$query_sections .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;
	   		$query_sections .= " ORDER BY nomePagina ASC" ;

	   		$result_sections = mysqli_query($this->configs, $query_sections ) ;

	   		$result = array();

	   		while( $r_sections = mysqli_fetch_assoc( $result_sections ) ) {
	   			$result[] = $r_sections;
	   		}

	   		return $result ;
	   	}

	   	//get pages section (parent)
	   	public function get_parent_pages_section( $section, $breadcrumb = null ){
	   		$query =  "SELECT idSecaoPai, nomeSecao, descricaoSecao, secaoHidden from tblAppSecao " ;
	   		$query .= "where idSecao = $section " ;
	   		$query .= ' AND ' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query($this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		if( ( $rows[ 0 ][ "idSecaoPai" ] != 0 ) && ( $breadcrumb ) ){
	   			$rows_section_name = util::get_section_name( $rows[ 0 ][ "idSecaoPai" ] ) ;
	   			$rows[ 0 ][ "nomeSecao" ] = $rows_section_name ;   
	   		}

	   		return $rows ;
	   	}


	   	public function util() {

	   		/*__construct*/

	   	}

	   	public function errorMessage (&$cod){

	   	}

	   	public function errorMysql ($cod , $text){
	   		util::set_session( "mySqlErrno", $cod );
	   		util::set_session( "mySqlError", $text );
	   		header("location:/error");
	   	}

	   	public function verifyErrorMysql (){
	   		$aux = false;
	   		$val = mysqli_errno($this->configs); 
	   		if($val==0){
	   			$aux = true;
	   		}
	   		return $aux;
	   	}
	
	    public function urlsafe_b64decode($text)
	   	{
	   		$key = "Apf5912";
	   		$encrypted_data=""; 
	   		$td = mcrypt_module_open('blowfish', '', 'ecb', ''); 
	   		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND); 
	   		$key = substr($key, 0, mcrypt_enc_get_key_size($td)); 
	   		mcrypt_generic_init($td, $key, $iv); 
   			$encrypted_data = mdecrypt_generic($td, $text); 
	   		mcrypt_generic_deinit($td); 
	   		mcrypt_module_close($td); 
	   		return $encrypted_data; 
	   	}	  
	   	public function urlsafe_b64encode($text) 
	   	{ 
	   		$key = "Apf5912";
	   		$encrypted_data=""; 
	   		$td = mcrypt_module_open('blowfish', '', 'ecb', ''); 
	   		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND); 
	   		$key = substr($key, 0, mcrypt_enc_get_key_size($td)); 
	   		mcrypt_generic_init($td, $key, $iv); 
   			$encrypted_data = mcrypt_generic($td, $text); 
	   		mcrypt_generic_deinit($td); 
	   		mcrypt_module_close($td); 
	   		return $encrypted_data; 
	   	}
	   	//get pages (page [individual])
	   	public function get_nicename_user( $id_user ){
	   		$query =  "SELECT nomePessoa from tblAppPessoa " ;
	   		$query .= " INNER JOIN tblAppUsuario ON ( tblAppPessoa.cpfPessoa = tblAppUsuario.cpfPessoa ) " ;
	   		$query .= ' WHERE tblAppUsuario.idUsuario = ' . $id_user . ' AND tblAppUsuario.' . util::get_site_id_name() . ' = ' . SITE_ID ;

	   		$result = mysqli_query( $this->configs, $query ) ;

	   		$rows = array();

	   		while( $r = mysqli_fetch_assoc( $result ) ) {
	   			$rows[] = $r;
	   		}

	   		if( ! count( $rows ) > 0 ){
	   			return "" ;
	   		}

	   		return $rows[ 0 ][ 'nomePessoa' ] ;
	   	}

	   	public function login ( &$user , &$password , &$url , &$chaveContratente){
			$passwordMD5 = $this->urlsafe_b64encode($password);	   		
	   		$code = 'CALL spAppLogin( "'.$user.'","'.$passwordMD5.'", "'.$chaveContratente.'", @pstatusproc )';
	   		// $code = 'call spAppLogin("larissa",  "123456",  "jornalpovo", @pStatusProc)';
	   		$idUsuario = $acessoPadrao = $idSite = $idCargo = $statusProc =  "";
	   		$aux= false;
	   		if (mysqli_multi_query($this->configs, $code)) {
	   			if(mysqli_more_results($this->configs)){
	   				do {
	   					if ($row = mysqli_use_result($this->configs)) {
	   						while ($r = mysqli_fetch_assoc($row)) {
	   							util::set_session( "chaveContratente", $chaveContratente );                   
	   							util::set_session( "idUsuario", $r['idUsuario'] );
	   							$idUsuario = $r['idUsuario'];
	   							util::set_session( "cpfPessoa", $r['cpfPessoa'] );
	   							util::set_session( "idStatus", $r['Status'] );
	   							util::set_session( "idSite", $r['idSite'] );
	   							$idSite = $r['idSite'];
	   							util::set_session( "mantemAcessoPadrao", $r['mantemAcessoPadrao'] );
	   							$acessoPadrao = $r['mantemAcessoPadrao'];
	   							util::set_session( "nomePessoa", $r['nomePessoa'] );
	   							util::set_session( "dtNascimento",  $r['dtNascimento'] );
	   							util::set_session( "contatoPessoa",  $r['contatoPessoa'] );                   
	   							util::set_session( "nomeSite", $r['nomeSite'] );
	   							util::set_session( "linkLive", $r['linkLive'] );
	   							util::set_session( "linkStage", $r['linkStage'] );
	   							util::set_session( "idContratante", $r['idContratante'] );                       
	   							util::set_session( "idCargo", $r['idCargo'] );
	   							$idCargo = $r['idCargo'];
	   							$statusProc = "0";  
	   							$aux = true;
	   						}
	   						mysqli_free_result($row);
	   					}
	   				} while (mysqli_next_result($this->configs) && (mysqli_more_results($this->configs))); 
	   			}           
	   		}
	   		if($statusProc!="0"){            
	   			$code =" SELECT @pstatusproc AS  'pStatusProc'";
	   			$error = mysqli_query($this->configs, $code ) ;
	   			while( $r = mysqli_fetch_assoc( $error ) ) {
	   				$statusProc = $r['pStatusProc'];
	   				util::set_session( "warn", $statusProc);
	   			}  
	   		}
	   		if($aux){
	   			$query ="SELECT  `descricaoCargo` FROM  `tblAppCargoPessoa` WHERE  `idCargo` =".$idCargo.";";   			
	   			$result = mysqli_query( $this->configs, $query ) ;
	   			$rows = array();
	   			while( $r = mysqli_fetch_assoc( $result ) ) {
	   				util::set_session( "descricaoCargo", $r['descricaoCargo'] );
	   			}
	   			util::getAcessosProcedure($idUsuario, $acessoPadrao, $idSite, $idCargo);
	   			header("location:".$url);  
	   		}

	   	}

	   	public function getAcessosProcedure (&$idUsuario, &$acessoPadrao, &$idSite, &$idCargo){
	   		$code = 'CALL spAppPermissao( '.$idUsuario.', '.$idCargo.', '.$acessoPadrao.', '.$idSite.', @pstatusproc )';         
	   		$acessCodes = array();
	   		$i=0;
	   		if (mysqli_multi_query($this->configs, $code)) {
	   			do {
	   				if ($row = mysqli_use_result($this->configs)) {
	   					while ($r = mysqli_fetch_assoc($row)) {
	   						$objAux = new accesObj();
	   						$objAux->setIdModulo($r['idModulo']);
	   						$objAux->setIdAcao($r['idAcao']);
	   						$acessCodes[$i] = $objAux ;
	   						$i++;  
	   					}
	   					mysqli_free_result($row);
	   				}
	   			} while (mysqli_next_result($this->configs) && (mysqli_more_results($this->configs)));
	   		}
	   		util::set_session( "accesRigths", $acessCodes );         
	   	}

	   	public static function InnerJoinArrayAcessos (&$total, &$parcial){
	   		$moduloIgual = false;
	   		$acaoIgual = false;
	   		$listaAcaoParcial= array();
	   		foreach ($total as $itemTotalAux=>&$itemTotal){
	   			$moduloAuxT = $itemTotal["idModulo"];
	   			foreach ($parcial as $itemParcialAux=>&$itemParcial){
	   				$moduloAuxP = $itemParcial["idModulo"];
	   				if($moduloAuxP == $moduloAuxT){
	   					$moduloIgual = true;
	   					$listaAcaoParcial = &$itemParcial['listaAcao'];
	   					break;                     
	   				}     
	   			}
	   			if($moduloIgual){
	   				$itemTotal["checkModulo"]="1";      
	   				$moduloIgual = false;
	   				$listaAcaoTotal = &$itemTotal['listaAcao'];
	   				foreach($listaAcaoTotal as $itemAcaoaux=>&$itemAcaoTotal){
	   					$acaoAuxT = $itemAcaoTotal['idAcao'];
	   					foreach($listaAcaoParcial as $itemAcaoParcialaux=>&$itemAcaoParcial){
	   						$acaoAuxP = $itemAcaoParcial['idAcao'];
	   						if($acaoAuxP == $acaoAuxT){
	   							$acaoIgual = true;
	   							break;
	   						}
	   					}
	   					if($acaoIgual){            
	   						$itemAcaoTotal['check']="1";
	   						$acaoIgual = false;
	   					}
	   				}
	   			}        
	   		}
	   		return $total;
	   	}


	   	public static function SetDisabledActions(&$entrada){
	   		foreach ($entrada as $itemAux=>&$item){
	   			if (!array_key_exists("checkModulo", $item) ){
	   				$listaAcao = &$item['listaAcao'];
	   				foreach($listaAcao as $itemAcaoAux=>&$itemAcao){
	   					$itemAcao['disabled']="1";
	   				}
	   			}
	   		}
	   		return $entrada;
	   	}

	   	public static function SetNumberActions(&$entrada){
	   		foreach ($entrada as $itemAux=>&$item){
	   			$listaAcao = &$item['listaAcao'];   
	   			$cont =count($listaAcao);     
	   			$item["numberActions"]= $cont+1;
	   		}
	   		return $entrada;
	   	}

	   	public function save_xml_config( $format, $config_id, $config_name, $config_file, $data_file, $form_file, $tmpls_files, $staging_file, $live_file, $preview_file, $config_type, $default_status ){
	   		$xml = new DOMDocument() ;
	   		$xml->formatOutput = $format ;

	   		$file = CONFS_DIR . $config_file ;

			$config = $xml->createElement( "config" ) ;
			$xml->appendChild( $config ) ;

			$name = $xml->createElement( "name" ) ;
			$config->appendChild( $name ) ;
			$user = $xml->createElement( "user" ) ;
			$config->appendChild( $user ) ;
			$type = $xml->createElement( "type" ) ;
			$config->appendChild( $type ) ;
			$id = $xml->createElement( "id" ) ;
			$config->appendChild( $id ) ;
			$configtag = $xml->createElement( "config" ) ;
			$config->appendChild( $configtag ) ;
			$data = $xml->createElement( "data" ) ;
			$config->appendChild( $data ) ;
			$form = $xml->createElement( "form" ) ;
			$config->appendChild( $form ) ;

			$tmpls = $xml->createElement( "tmpls" ) ;
			$config->appendChild( $tmpls ) ;
			$tmpl = $xml->createElement( "tmpl" ) ;
			$tmpls->appendChild( $tmpl ) ;
			$tmplfile = $xml->createElement( "file" ) ;
			$tmpls->appendChild( $tmplfile ) ;
			$preview = $xml->createElement( "preview" ) ;
			$config->appendChild( $preview ) ;
			$outs = $xml->createElement( "outs" ) ;
			$tmpl->appendChild( $outs ) ;
			$out = $xml->createElement( "out" ) ;
			$outs->appendChild( $out ) ;
			$staging = $xml->createElement( "staging" ) ;
			$out->appendChild( $staging ) ;
			$live = $xml->createElement( "live" ) ;
			$out->appendChild( $live ) ;

			$status = $xml->createElement( "status" ) ;
			$config->appendChild( $status ) ;

			$user->appendChild( $xml->createTextNode( $this->get_session( 'idUsuario' ) ) ) ;
			$name->appendChild( $xml->createTextNode( $config_name ) ) ;
			$id->appendChild( $xml->createTextNode( $config_id ) ) ;
			$type->appendChild( $xml->createTextNode( $config_type ) ) ;
			$configtag->appendChild( $xml->createTextNode( $config_file ) ) ;
			$data->appendChild( $xml->createTextNode( $data_file ) ) ;
			$form->appendChild( $xml->createTextNode( $form_file ) ) ;
			$tmplfile->appendChild( $xml->createTextNode( $tmpls_files ) ) ;
			$staging->appendChild( $xml->createTextNode( $staging_file ) ) ;
			$live->appendChild( $xml->createTextNode( $live_file ) ) ;
			$preview->appendChild( $xml->createTextNode( $preview_file ) ) ;
			$status->appendChild( $xml->createTextNode( $default_status ) ) ;

			$xml->save( $file ) ;

			return ;
	   	}

	   	public function save_xml_content( $format, $put_type, $put_id, $content_file ){
	   		$xml = new DOMDocument() ;
	   		$xml->formatOutput = $format ;

	   		$file = CONTENT_DIR . $content_file ;

			$content = $xml->createElement( "content" ) ;
			$xml->appendChild( $content ) ;
			$type = $xml->createElement( "type" ) ;
			$content->appendChild( $type ) ;
			$id = $xml->createElement( "id" ) ;
			$content->appendChild( $id ) ;

			$type->appendChild( $xml->createTextNode( $put_type ) ) ;
			$id->appendChild( $xml->createTextNode( $put_id ) ) ;

			$xml->save( $file ) ;

			return ;
	   	}

	   	public function write_xml_form( $config_form ){
	   		$fh = fopen( ( FORMS_DIR . $config_form ), 'r' ) ;

			while ( $line = fgets( $fh ) ) {
			  echo $line ;
			}

			fclose( $fh );
	   	}

	   	public function write_xml_tmpl( $config_tmpl ){
	   		$fh = fopen( ( TMPLS_DIR . $config_tmpl ), 'r' ) ;
	   		$code = '' ;

			while ( $line = fgets( $fh ) ) {
			  $code .= $line ;
			}

			fclose( $fh );

			return $code ;
	   	}

   	public function write_content_page_data( $config_data ){
	   		if( ! file_exists( CONTENT_DIR . $config_data ) ){
	   			return '""' ;
	   		}
	   		$fh = fopen( ( CONTENT_DIR . $config_data ), 'r' ) ;
	   		$code = '' ;

			while ( $line = fgets( $fh ) ) {
			  $code .= $line ;
			}

			fclose( $fh );

			return $code ;
	   	}

	   	public function save_content_form( $config_form, $content ){
	   		$fp = fopen( ( FORMS_DIR . $config_form ), 'wb' ) ;

			fwrite( $fp, $content ) ;

			fclose( $fp );
	   	}

	   	public function save_content_tmpl( $config_tmpl, $content ){
	   		$fp = fopen( ( TMPLS_DIR . $config_tmpl ), 'wb' ) ;

			fwrite( $fp, $content ) ;

			fclose( $fp );
	   	}

	   	public function save_content_page_data( $config_data, $content ){
	   		$fp = fopen( ( CONTENT_DIR . $config_data ), 'wb' ) ;

			fwrite( $fp, $content ) ;

			fclose( $fp );
	   	}

	   	public function save_content_from_template( $file, $content ){
	   		$fp = fopen( $file, 'wb' ) ;

			fwrite( $fp, $content ) ;

			fclose( $fp );

		}

	   	public function printListaAutor(  ){
	   		$opt ="";
	   		$code ="CALL spAppPessoaUsuarioPorIdSiteSelect(".util::get_session( 'idSite' ).");";

	   		if (mysqli_multi_query($this->configs, $code)) {
	   			if(mysqli_more_results($this->configs)){
	   				do {
	   					if ($row = mysqli_use_result($this->configs)) {
	   						while ($r = mysqli_fetch_assoc($row)) {
	   							$opt .= '<option value="'.$r['IdUsuario'].'">'.$r['NomePessoa'].'</option>';
	   						}
	   						mysqli_free_result($row);
	   					}
	   				} while (mysqli_next_result($this->configs) && (mysqli_more_results($this->configs))); 
	   			}           
	   		}




	   		$aux= 'Autores <select class="form-control form-search form-search-cargo" id="idusuario" name="idusuario" style="width: 20%;">';
	   		$aux .= '<option value=""></option>';
	   		$aux .= $opt;
	   		$aux .= '</select>';

	   		return $aux;
	   	}

	}

?>
