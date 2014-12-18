<?php

	
	$db_username = "root" ;
	$db_password = "root" ;
	$db_database = "dgjolero_appolo" ;
	$db_host = "localhost:3306" ;
	$configs = mysqli_connect( $db_host, $db_username, $db_password, $db_database ) or die( mysqli_error($configs) )  ;
   	$result_conn = mysqli_query( $configs, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	$code ='call spAppContratanteSelect ( "" , "" , "" , @statusProc);';

	if (mysqli_multi_query($configs, $code)) {
		if ($r = mysqli_store_result($configs)) {
			while ($row = mysqli_fetch_assoc($r)) {
				$rows[] = $row;
			}
			mysqli_free_result($r);
		}
	}
	$close_db = mysqli_close( $configs ) ;
	
print json_encode( $rows ) ;
?>
