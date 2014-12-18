<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
$idContratante = $util->get_session( 'idContratante' );	
$code = "CALL spAppCargoSelect( null,'', ".$idContratante.", 1, @pStatusProc);";
$aux = false;
	if (mysqli_multi_query($util->configs, $code)) {	
		do {
			if ($r = mysqli_store_result($util->configs)) {
				while ($row = mysqli_fetch_assoc($r)) {
					$rows[] = $row;
					$aux = true;
				}
				mysqli_free_result($r);

			}
		} while (mysqli_next_result($util->configs) && (mysqli_more_results($util->configs)));
	}
	if(!$aux){            
		$code =" SELECT @pstatusproc AS  'pStatusProc'";
		$error = mysqli_query($util->configs, $code ) ;
		while( $r = mysqli_fetch_assoc( $error ) ) {
			$statusProc = $r['pStatusProc'];
			if($statusProc!="0"){      
				$util->set_session( "warn", $statusProc);
			}				
		}  
	}

print json_encode( $rows ) ;
?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>