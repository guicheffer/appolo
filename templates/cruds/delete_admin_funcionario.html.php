<?php
	global $util ;
	$util->set_home( 1  ) ;
	$session = "crud" ;	
	$listaCpf = $_POST["funcionariosCheck"];
	$pstatus="0";
	foreach ($listaCpf as &$cpf) {
		if ($pstatus == "0"){
			if($util->verifyErrorMysql()){
				$code ="CALL spAppAtivaDesativaPessoa ('".$cpf."',@pstatusproc);";	
				echo $code;
				mysqli_query( $util->configs, $code ) ;
				$code =" SELECT @pstatusproc AS  'pStatusProc'";
				$result = mysqli_query($util->configs, $code ) ;				
				while( $r = mysqli_fetch_assoc( $result ) ) {
					$pstatus =  $r['pStatusProc'] ;
				}
			}				    	
		}
	}
	$util->set_session( "warn", $pstatus );
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.FUNCIONARIOS_ADMIN_URL.'');
?>