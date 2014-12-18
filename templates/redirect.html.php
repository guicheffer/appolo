<?php
	global $util ;
	global $appolo_gui ;
	
	$util->set_home( 1 ) ;
	$session = "redirect" ;

	$util->set_warn( ( isset( $warn ) ) ? $warn : "" ) ;
	$appolo_gui->go_to_this( $go_to ) ;
	
?>

<!--CLOSE_DB-->
<?php require ( CLOSE_DB_TEMPLATE ) ;?>
<!--/CLOSE_DB-->