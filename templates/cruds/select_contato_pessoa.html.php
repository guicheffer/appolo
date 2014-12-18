<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
$cdCpf = "";
if ( isset( $_POST['cdCpf'] ) ) { 
	$cdCpf = $_POST['cdCpf'];
}

$idSite = $util->get_session( 'idSite' );
$code = "CALL spAppContatoPessoaSelect('',  '' , '".$cdCpf."', @statusProc)";	
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