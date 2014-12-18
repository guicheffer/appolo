<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
$nome_Pessoa = $nome_Usuario = "";
$cdStatus = "null";
$cdCpf = "";
if ( isset( $_POST['nome_Pessoa'] ) ) { 
	$nome_Pessoa = $_POST['nome_Pessoa'];
}
if ( isset( $_POST['cdStatus'] ) && $_POST['cdStatus'] != "" ) { 
	$cdStatus = $_POST['cdStatus'];
}
if ( isset( $_POST['nome_Usuario'] ) ) { 
	$nome_Usuario = $_POST['nome_Usuario'];
}
if ( isset( $_POST['cdCpf'] ) ) { 
	$cdCpf = $_POST['cdCpf'];
}

$idSite = $util->get_session( 'idSite' );
$code = "CALL spAppUsuarioSelect('".$nome_Pessoa."',  '".$nome_Usuario."',  '', NULL ,  '".$cdCpf."',  ".$cdStatus.", ".$idSite.", @statusProc)";	
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