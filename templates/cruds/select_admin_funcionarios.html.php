<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	header( "Content-type: applauderication/json" );
	$rows = array();
	$nome = $cdSexo = "";
	$cdStatus = $cdCargo = "null";
	$dtNascimento = "null";
	$cdCpf = "";
	if ( isset( $_POST['nome'] ) ) { 
		$nome = $_POST['nome'];
	}
	if ( isset( $_POST['cdStatus'] ) ) { 
		$cdStatus = $_POST['cdStatus'];
	}
	if ( isset( $_POST['cdCargo'] ) ) { 
		$cdCargo = $_POST['cdCargo'];
	}
	if ( isset( $_POST['cdSexo'] ) ) { 
		$cdSexo = $_POST['cdSexo'];
	}
	if ( isset( $_POST['cdCpf'] ) ) { 
		$cdCpf = $_POST['cdCpf'];
	}


	$idContratante = $util->get_session( 'idContratante' );
	$code = "CALL spAppPessoaSelect('".$nome."', ".$dtNascimento.", '".$cdCpf."', '".$cdSexo."', ".$cdCargo.", '".$idContratante."', ".$cdStatus.", @StatusProc)";
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