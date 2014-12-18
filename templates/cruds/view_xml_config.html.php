<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$id = isset( $_GET[ 'id' ] ) ? $_GET[ 'id' ] : 0 ;
	$where = isset( $_GET[ 'where' ] ) ? $_GET[ 'where' ] : 0 ;

	header('Content-type: text/xml') ;

	$xml = $util->get_xml_config( $id, $where ) ;

	$xml_config = CONFS_DIR . $xml ;

	if( ( $xml == "" ) || ( ! file_exists( $xml_config ) ) ) {
		echo "404" ;
		exit ;
	}

	$xmlStr = file_get_contents( $xml_config ) ;

	if (get_magic_quotes_runtime())
	{
	    $xmlStr = stripslashes($xmlStr);
	}

	echo $xmlStr ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>