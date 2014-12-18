<?php

global $util ;
$util->set_home( 1 ) ;


$_UP['pasta'] = $_POST["folder"];
$path = $_POST["path"];


$nome_final = $image_name = $_POST["image_name"] ;
$aux2 = explode('.', $_FILES['input-id']['name']);
$aux = end($aux2);
$extensao = strtolower($aux);
while(!is_dir($_POST["folder"])){
	mkdir($_POST["folder"], 0777, true);
	chmod($_POST["folder"], 0777);
}
if(file_exists($_POST["images_path"].".".$extensao)){
	$util->set_session( "warn", "21" );
	$error = true;
}
else{
	if (move_uploaded_file($_FILES['input-id']['tmp_name'], $_UP['pasta']."/". $nome_final.".".$extensao)) {
		$util->set_session( "warn", "20" );
		$error = false;
	} else {
		$util->set_session( "warn", "22" );
		$error = true;
	}
}
if(!$error){
	$code = "CALL spAppImagensInsert ('".$_POST["image_description"]."', '".$_POST['path'].$nome_final.".".$extensao."', '".$_POST["image_name"]."', '".$_POST["images_tag"]."', ".$_POST['section'].",@pstatusproc)";
	mysqli_query( $util->configs, $code ) ;
	$code =" SELECT @pstatusproc AS  'pStatusProc'";
	$result = mysqli_query($util->configs, $code ) ;
	if($util->verifyErrorMysql()){// houve erro de MySql?
		while( $r = mysqli_fetch_assoc( $result ) ) {
			if($r['pStatusProc']!="0"){
				$util->set_session( "warn", $r['pStatusProc'] );
				unlink($_UP['pasta']."/". $nome_final.".".$extensao);
			}
		}
	}
}

?>
<?php 
require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.IMAGES_URL.$_POST["section"]);
?>