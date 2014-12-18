<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
if ( isset( $_POST["idusuario"]) ) { 
	if ( $_POST["idusuario"] != ""  ) { 
		$idusuario = $_POST["idusuario"];
	}
	else{
		$idusuario = 'null';
	}
		
}else{
	$idusuario = 'null';
}
if ( isset( $_POST["statusPub"]) ) { 
	if ( $_POST["statusPub"] != ""  ) { 
		$statusPub = "'".$_POST["statusPub"]."'";
	}
	else
	{
		$statusPub = '""';
	}	
}else{
	$statusPub = '""';
}
$idSite = $util->get_session( 'idSite' );
$code = "CALL spAppRelPublicacoesPorAutor(".$idusuario.", ".$statusPub." , ".$idSite.")";	
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