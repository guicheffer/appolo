<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
$idSite = $util->get_session( 'idSite' );	
if ( isset( $_POST["nome_secao"]) ) { 
	$name = "'".$_POST["nome_secao"]."'";
}else{
	$name = "''";
}
if ( isset( $_POST["descricao_secao"]) ) { 
	$description = "'".$_POST["descricao_secao"]."'";	
}else{
	$description = "''";
}

$code = "CALL spAppSecaoSelect (null, ".$name.", null, 3, null, null, ".$idSite.", ".$description.");";
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
$code = "CALL spAppSecaoSelect (null, ".$name.", null, 5, null, null, ".$idSite.", ".$description.");";
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
$code = "CALL spAppSecaoSelect (null, ".$name.", null, 7, null, null, ".$idSite.", ".$description.");";
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