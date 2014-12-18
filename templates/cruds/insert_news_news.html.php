<?php
	global $util ;
	$util->set_home( 1 ) ;
	$session = "crud" ;
	$id = $_POST["id"] ;
	$title = $_POST["title"] ;
	$text = $_POST["text"] ;

	$query = "INSERT INTO tblAppPublicacao (idPublicacao,tituloPublicacao,textoPublicacao) VALUES('$id','$title','$text')" ;
	$result = mysqli_query( $util->configs, $query ) ;

?>

<!--CLOSE_DB-->
<?php require ( CLOSE_DB_TEMPLATE ) ;?>
<!--/CLOSE_DB-->