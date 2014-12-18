<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$sections = ( isset( $_POST["sections"] ) ? $_POST["sections"] : "" ) ;
	$pages = ( isset( $_POST["pages"] ) ? $_POST["pages"] : "" ) ;
	$news = ( isset( $_POST["news"] ) ? $_POST["news"] : "" ) ;
	$section_back = ( ( $_POST["section_back"] !== "null" ) ? $_POST["section_back"] : "" ) ;
	$count_sections = $count_pages = $count_news = 0 ;

	if( $sections != "" ){
		foreach ($sections as $i => $idSecao) {
			$util->delete_sections_section( $idSecao ) ;
			$count_sections++ ;
		}	
	}

	if( $pages != "" ){
		foreach ($pages as $j => $idPagina) {
			$util->delete_sections_page( $idPagina ) ;
			$count_pages++ ;
		}
	}

	if( $news != "" ){
		foreach ($news as $j => $idPublicacao) {
			$util->delete_sections_news( $idPublicacao ) ;
			$count_news++ ;
		}
	}

	if( ! $count_news > 0 ){
		render( 'index', [ 'go_to' => ( SECTIONS_PAGES_URL . $section_back ), 'warn' => ( ( ! ( $count_sections > 1 || $count_pages > 1 ) ) ? 1 : 2 ) ], 'redirect') ;
	}else{
		render( 'index', [ 'go_to' => ( SECTIONS_NEWS_URL . $section_back ), 'warn' => ( ( ! ( $count_sections > 1 || $count_news > 1 ) ) ? 1 : 2 ) ], 'redirect') ;
	}

?>

<!--CLOSE_DB-->
<?php require ( CLOSE_DB_TEMPLATE ) ;?>
<!--/CLOSE_DB-->