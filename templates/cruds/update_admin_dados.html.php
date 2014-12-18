<?php
	global $util ;
	$util->set_home( 1 ) ;
	$idContratante = $util->get_session( 'idContratante' );
	$session = "crud" ;	
	$nome = $_POST["nome"];
	$contato = $_POST["contato"];
	$cpf = $_POST["cdCpf"];
	$dtNascimento = $_POST["dtNascimento"];
	$mysqltime = date ("Y-m-d H:i:s", strtotime($dtNascimento));
	$sexo = $_POST["sexo"][0];
	$status = "'".$_POST["status"]."'";
	if($status == "''" ){
		$status = "null";
	}

	$cargo = $_POST["idCargo"];
	$code = "CALL spAppPessoaUpdate ('".$nome."', '".$mysqltime."', '".$cpf."', '".$sexo."', ".$cargo.", ".$idContratante." , ".$status.", @pstatusproc)";
	mysqli_query( $util->configs, $code ) ;
	$code =" SELECT @pstatusproc AS  'pStatusProc'";
	$result = mysqli_query($util->configs, $code ) ;
	if($util->verifyErrorMysql()){// houve erro de MySql?
		while( $r = mysqli_fetch_assoc( $result ) ) {
			$pStatusProc = $r['pStatusProc'];
		}
	}
	if($pStatusProc == "0"){
		$code = "CALL spAppContatoPessoaUpdate ('".$contato."', 'e-mail', '".$cpf."', @pstatusproc)";
		mysqli_query( $util->configs, $code ) ;
		$code =" SELECT @pstatusproc AS  'pStatusProc'";
		$result = mysqli_query($util->configs, $code ) ;
		if($util->verifyErrorMysql()){// houve erro de MySql?
			while( $r = mysqli_fetch_assoc( $result ) ) {
				$pStatusProc = $r['pStatusProc'];
			}
		}
	}
	$util->set_session( "warn",  $pStatusProc);
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.APPOLO_DASHBOARD.'');
?>