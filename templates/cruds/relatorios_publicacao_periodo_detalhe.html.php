<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
if ( isset( $_POST["mesInicial"])  ) { 
	if ( $_POST["mesInicial"] != ""  ) { 
		$mesInicial = $_POST["mesInicial"];	
	}
	else{
		$mesInicial = '1';
	}	
}else{
	$mesInicial = '1';
}
if ( isset( $_POST["anoInicial"]) ) { 
	if ( $_POST["anoInicial"] != ""  ) { 
		$anoInicial = $_POST["anoInicial"];	
	}
	else{
		$anoInicial = '2010';
	}	
}else{
	$anoInicial = '2010';
}
if ( isset( $_POST["anoFinal"]) ) {
	if ( $_POST["anoFinal"] != ""  ) { 
		$anoFinal = $_POST["anoFinal"];	
	}
	else{
		$anoFinal = '2016';
	}	
}else{
	$anoFinal = '2016';
}
if ( isset( $_POST["mesFinal"]) ) { 
	if ( $_POST["mesFinal"] != ""  ) { 
		$mesFinal = $_POST["mesFinal"];	
	}
	else{
		$mesFinal = '12';
	}
}else{
	$mesFinal = '12';
}

if ( isset( $_POST["statusPub"]) ) { 
	if ( $_POST["statusPub"] != ""  ) { 
		$statusPub =  "'".$_POST["statusPub"]."'";
	}	
	else{
		$statusPub = '""';
	}
}else{
	$statusPub = '""';
}
$idSite = $util->get_session( 'idSite' );
$code = "CALL spAppRelPublicacoesPorPeriodoDetalhado(".$mesInicial.",".$anoInicial.",".$mesFinal.",".$anoFinal.", ".$statusPub." , ".$idSite.")";	
// $code = "CALL spAppRelPublicacoesPorPeriodoDetalhado(".$mesInicial.",".$anoInicial.",".$mesFinal.",".$anoFinal.", 'APR' , ".$idSite.")";	
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