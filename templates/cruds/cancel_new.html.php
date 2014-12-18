<?php

	global $util ;
	global $appolo_gui ;

	if( ! $appolo_gui->render_module( "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}

	//session
	$session = "news" ;

	$section = ( ( isset( $section ) ) ? $section : "null" ) ;

	//section_data & section parent
	$section_data = $util->get_section( $section )[ 0 ] ;


	$util->set_warn( '5' ) ;
	$util->set_session( 'news_canceled', $section ) ;
	$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
	exit ;
?>
