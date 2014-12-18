<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	header( "Content-type: application/json" );
	$user_description = $_POST["user_description"];
	$user_pessoa = $_POST["user_pessoa"] ;
	$user_password = $util->urlsafe_b64encode( $_POST["user_password"]) ;
	$pStatusProc ="";
	$idSite = $util->get_session( 'idSite' );	
	$code = "CALL spAppUsuarioInserir ('".$user_description."' , '".$user_password."' , '".$user_pessoa."',  ".$idSite.", @idInserido, @pStatusProc)";
	mysqli_query($util->configs, $code ) ;
	$code ="SELECT @pIdInserido AS  'pIdInserido', @pStatusProc AS  'pStatusProc';";
	$result = mysqli_query($util->configs, $code ) ;
		while( $r = mysqli_fetch_assoc( $result ) ) {
			$idInserido = $r['pIdInserido'];
			$pStatusProc =  $r['pStatusProc'];
		}
	if($pStatusProc!="0"){// houve erro de MySql?
		$util->set_session( "warn", $pStatusProc );
		$idInserido= "error";
	}

	 print json_encode( $idInserido ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>