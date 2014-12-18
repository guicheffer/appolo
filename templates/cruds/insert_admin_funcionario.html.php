<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;	
	$nome = htmlspecialchars( $_POST["nome"], ENT_QUOTES ) ;
	$cpf = htmlspecialchars( $_POST["cpf"], ENT_QUOTES ) ;
	$dtNascimento = htmlspecialchars( $_POST["dtNascimento"], ENT_QUOTES ) ;
	$mysqltime = date ("Y-m-d H:i:s", strtotime($dtNascimento));
	$sexo = htmlspecialchars( $_POST["sexo"][0], ENT_QUOTES ) ;
	$cargo = htmlspecialchars( $_POST["cargo"], ENT_QUOTES ) ;
	$contato = $_POST["contato"];
	$idContratante = $util->get_session( 'idContratante' );
	$code = "CALL spAppPessoaInserir ('".$nome."', '".$mysqltime."', '".$cpf."', '".$sexo."', ".$cargo.", ".$idContratante." , @pstatusproc)";
	mysqli_query( $util->configs, $code ) ;
	$code =" SELECT @pstatusproc AS  'pStatusProc'";
	$result = mysqli_query($util->configs, $code ) ;
	if($util->verifyErrorMysql()){// houve erro de MySql?
		while( $r = mysqli_fetch_assoc( $result ) ) {
			$pStatusProc = $r['pStatusProc'];
		}
	}
	if($pStatusProc == "0"){
		$code = "CALL spAppContatoPessoaInserir ('".$contato."', 'e-mail', '".$cpf."', @lasInsertId, @pstatusproc)";
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
header('Location: '.FUNCIONARIOS_ADMIN_URL.'');
?>