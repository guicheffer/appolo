<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
if ( isset( $_POST["anoInicial"]) ) { 
	if ( $_POST["anoInicial"] != ""  ) { 
		$anoInicial = $_POST["anoInicial"];	
	}
	else{
		$anoInicial = "2014";
	}	
}else{
	$anoInicial = "2014";
}
if ( isset( $_POST["anoFinal"]) ) {
	if ( $_POST["anoFinal"] != ""  ) { 
		$anoFinal = $_POST["anoFinal"];	
	}
	else{
		$anoFinal = "2014";
	}	
}else{
	$anoFinal = "2014";
}

$idSite = $util->get_session( 'idSite' );
$code = "CALL spAppRelPublicacoesPorPeriodoQtd(".$anoInicial.",".$anoFinal.", ".$idSite.")";	
if (mysqli_multi_query($util->configs, $code)) {
		do {
			if ($r = mysqli_store_result($util->configs)) {
				while ($row = mysqli_fetch_assoc($r)) {
					$rows[] = $row;
				}
				mysqli_free_result($r);

			}
		} while (mysqli_next_result($util->configs) && (mysqli_more_results($util->configs)));
	}

print json_encode( $rows ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>