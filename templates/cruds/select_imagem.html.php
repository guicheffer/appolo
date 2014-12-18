<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
$idSite = $util->get_session( 'idSite' );	

if ( isset( $_POST["section"]) ) { 
	$section = $_POST["section"];	
}else{
	$section = 'null';
}
if ( isset( $_POST["idImagem"]) ) { 
	$idImagem = $_POST["idImagem"];	
}else{
	$idImagem = 'null';
}
if ( isset( $_POST["name_img"]) ) { 
	$name_img = "'".$_POST["name_img"]."'";	
}else{
	$name_img = "''";
}

if ( isset( $_POST["tag_img"]) ) { 
	$tag_img = "'".$_POST["tag_img"]."'";	
}else{
	$tag_img = "''";
}

if ( isset( $_POST["descricao_img"]) ) { 
	$descricao_img = "'".$_POST["descricao_img"]."'";	
}else{
	$descricao_img = "''";
}


$code = "call spAppImagensSelect(".$descricao_img.",".$name_img.",".$tag_img.",".$section.", ".$idImagem.",@out);";	
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