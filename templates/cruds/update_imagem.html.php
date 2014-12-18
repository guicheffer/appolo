<?php

global $util ;
$util->set_home( 1 ) ;


$_UP['pasta'] = $_POST["folder"];
$path = $_POST["path"];
if ( isset($_POST["status"][0]) ) { 
	$sts = $_POST["status"][0];	
}else{
	$sts = 'null';
}

$nome_final = $image_name = $_POST["image_name_up"] ;
$aux2 = explode('.', $_FILES['input-id_up']['name']);
$aux = end($aux2);
$extensao = strtolower($aux);
$error = false;
$code = "CALL spAppImagensUpdate (".$_POST["idImg"].",'".$_POST["image_description_up"]."', null, '', ".$sts.", '','".$_POST["images_tag_up"]."', null,@pstatusproc)";
mysqli_query( $util->configs, $code ) ;
$code =" SELECT @pstatusproc AS  'pStatusProc'";
$result = mysqli_query($util->configs, $code ) ;
	if($util->verifyErrorMysql()){// houve erro de MySql?
		while( $r = mysqli_fetch_assoc( $result ) ) {
			if($r['pStatusProc']!="0"){
				$util->set_session( "warn", $r['pStatusProc'] );	
				$error = true;		
			}
		}
	}

if(!$error &&  $_POST["trocaImg"] =="1" ){

	if(file_exists($_POST["images_path_up"])){
		unlink($_POST['images_path_up']);		
	}
	if (move_uploaded_file($_FILES['input-id_up']['tmp_name'], $_POST['images_path_up'])) {
		$util->set_session( "warn", "20" );
		$error = false;
	} else {
		$util->set_session( "warn", "22" );
		$error = true;
	}
}
else{
	$util->set_session( "warn", "20" );
}



?>
<?php 
require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.IMAGES_URL.$_POST["section"]);
?>