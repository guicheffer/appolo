<?php

/**
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
 */



class appolo_gui extends appolo {

	public $menu = "" ;

	public function mount_menu_header() {

		$menu_items_header = parent::$menu_items_header ;

		if ( util::check_on() ) {

			$this->menu = "<ul class='nav navbar-nav'>" ;


				$this->menu .= "<li" . ( ( util::check_home() ) ? " class='active'" : "" ) . "><a href='/'>" . FST_ITEM . "</a></li>" ;

				

				foreach ($menu_items_header as $item => $url) {

					if ( ! ( is_array($url) ) ){

						$this->menu .= "<li " . ( ( preg_match( ("/\b(" . str_replace("/","",$url) . ")\b/i"), $_SERVER['REQUEST_URI'], $matches) ) ? " class='active' " : "" ) . ">" ;
							$this->menu .= "<a href='$url'>$item</a>" ;
						$this->menu .= "</li>" ;

					}else{

						$this->menu .= "<li class='dropdown'>" ;

							$this->menu .= "<a class='dropdown-toggle pointer' data-toggle='dropdown'>$item <b class='caret'></b></a>" ;

							$this->menu .= "<ul class='dropdown-menu'>" ;

							foreach ($url as $item => $url) {

								if ( is_array($url) ){

									$this->menu .= "<li class='divider'></li>" ;

									$this->menu .= "<li class='dropdown-header'>$item</li>" ;

									foreach ($url as $item => $url) {



										$this->menu .= "<li><a href='$url'>$item</a></li>" ;



									}

								}else{

									$this->menu .= "<li><a href='$url'>$item</a></li>" ;

								}



							}

							$this->menu .= "</ul>" ;

						$this->menu .= "</li>" ;

					}

				}


			$this->menu .= "</ul>" ;

		}



		return $this->menu ;

	}

	//render message
	public static function render_message( $type = "", $show_button_close = true, $message = "", $classes = null ) {
		$code = "<div class='alert alert-$type fade in " . $classes . "'>" ;
			$code .= ( $show_button_close ) ? "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" : "" ;
			$code .= " $message " ;
		$code .= "</div>" ;
		
		echo $code ;
	}


	public static function render_button( $href = "", $class = "", $icon = "", $text = "", $module = "", $action = ""  ) {
	//render button
		if( $href != "" ){
			$code = "<a href='$href' class='$class'>" ;	
		}else{
			$code = "<a class='$class'>" ;
		}
		if ( $icon != "" ){
			$code .= "<span class='glyphicon glyphicon-$icon icon'></span>" ;
		}
		$code .= " $text </a>" ;
		//chamar a funcao getAcessCode da clase appolo passando o valor da action e do modulo
		if (parent::getAcessCode($module, $action)  ){
			return $code ;	
		}
	}

	public static function render_button_js( $href = "", $class = "", $icon = "", $text = "", $module = "", $action = "", $js="" ) {
	//render button
		if( $href != "" ){
			$code = "<a href='$href' class='$class' onclick='$js'>" ;	
		}else{
			$code = "<a class='$class' onclick='$js'>" ;
		}
		if ( $icon != "" ){
			$code .= "<span class='glyphicon glyphicon-$icon icon'></span>" ;
		}
		$code .= " $text </a>" ;
		//chamar a funcao getAcessCode da clase appolo passando o valor da action e do modulo
		if (parent::getAcessCode($module, $action)  ){
			return $code ;	
		}
	}



	public static function render_item($module = "", $action = ""  ) {
		if (parent::getAcessCode($module, $action)  ){//chamar a funcao getAcessCode da clase appolo passando o valor da action e do modulo
			return true ;	
		}
		else{
			return false;
		}
	}

	public static function render_module($module = "" ) {
		if (parent::getModuleCode($module)  ){//chamar a funcao getAcessCode da clase appolo passando o valor da action e do modulo
			return true ;	
		}
		else{
			return false;
		}
	}

	public function encode_path( $text ){
		return str_replace( " ", "_", strtolower( preg_replace( "/[^A-Za-z0-9[:space:]]/", "", $text ) ) ) ;
	}


	public function appolo_gui() {

		/*main*/

	}

	public function getMsgError(&$cod){
			$xml = simplexml_load_file( XML_ERRODB );
			foreach($xml->error as $error)
			{	
				if ($error->code == $cod){
					if ($error->button == "true"){
						$aux = true;
					}
					else{
						$aux = false;	
					}					
					appolo_gui::render_message( $error->type, $aux, $error->msg, $error->class ) ;
				}					
			}
	}

	public function go_to_this( $go_to ){
		header( 'Location: ' . $go_to ) ;
		
		require ( CLOSE_DB_TEMPLATE ) ;
	}


	public static function printList($list, $id, $name, $idItem, $idDesc, $selected){
		$code = "<select id='$id' class='form-control' name='$name' for'$name'>";
		$code .= "<option value=''></option>";
			 foreach($list as $item)
			 {
			 	$auxId = $item["".$idItem.""];
			 	$auxDesc = $item["".$idDesc.""];
			 	if($auxId == $selected){
			 		$code .= "<option selected value='$auxId'>$auxDesc</option>";	
			 	}
			 	else{
			 		$code .= "<option value='$auxId'>$auxDesc</option>";	
			 	}			 	
			 }	
		$code .= "</select>";
		echo $code;
		
	}

	public static function selected( $value, $selected ){
    	return $value==$selected ? ' selected="selected"' : '';
	}

	
}



?>