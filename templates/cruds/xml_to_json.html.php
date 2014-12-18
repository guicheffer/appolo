<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$id = isset( $_GET[ 'id' ] ) ? $_GET[ 'id' ] : 0 ;
	$where = isset( $_GET[ 'where' ] ) ? $_GET[ 'where' ] : 0 ;

	header( "Content-type: application/json" ) ;

	$xml = $util->get_xml_config( $id, $where ) ;

	$xml_config = CONFS_DIR . $xml ;

	if( ( $xml == "" ) || ( ! file_exists( $xml_config ) ) ) {
		echo '{ "error" : "404" } ' ;
		exit ;
	}

	$xmlStr = file_get_contents( $xml_config ) ;

	if (get_magic_quotes_runtime())
	{
	    $xmlStr = stripslashes($xmlStr);
	}

	$xml_to_json = simplexml_load_string( $xmlStr );

	$json = json_encode( $xml_to_json );

	echo $json ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>