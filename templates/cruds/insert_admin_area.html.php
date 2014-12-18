<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	header( "Content-type: application/json" );
	$area_description = htmlspecialchars( $_POST["area_description"], ENT_QUOTES ) ;
	$rows = array();
	$pStatusProc ="";
	$idContratante = $util->get_session( 'idContratante' );	
	$code = "CALL spAppCargoInserir ('".$area_description."' , '".$area_description."' , ".$idContratante.", @p1 , @p2)";
	mysqli_query($util->configs, $code ) ;
	$code ="SELECT @p1 AS  'pIdInserido' , @p2 AS  'pStatusProc';";
	$result = mysqli_query($util->configs, $code ) ;
		while( $r = mysqli_fetch_assoc( $result ) ) {
			$idInserido = $r['pIdInserido'];
			$pStatusProc =  $r['pStatusProc'];
		}
	if($pStatusProc!="0"){// houve erro de MySql?
		$util->set_session( "warn", $pStatusProc );
	}

	 print json_encode( $idInserido ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>