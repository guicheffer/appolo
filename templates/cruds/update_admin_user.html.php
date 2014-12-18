<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
if ( isset( $_POST['mantemAcessoPadrao'] ) ) { 
    $mantemAcessoPadrao = "1";
}else{
    $mantemAcessoPadrao = "0";
}
$cdCpf = $_POST['cdCpf'];
$idUsuario = $_POST['idUsuario'];
$user_description = $_POST['user_description'];
$user_password = $util->urlsafe_b64encode($_POST['user_password']);

$idSite = $util->get_session( 'idSite' );     
$code = "CALL `spAppUsuarioUpdate` (".$idUsuario.", '".$user_description."', '".$user_password."', ".$mantemAcessoPadrao.",@pStatusProc);";
mysqli_query($util->configs, $code ) ;  
$code =" SELECT @pStatusProc AS  'pStatusProc'";
$error = mysqli_query($util->configs, $code ) ;
while( $r = mysqli_fetch_assoc( $error ) ) {
    $statusProc = $r['pStatusProc'];          
} 
if($statusProc == "0" || $statusProc == null){
    
        $code = "CALL `spAppAcessoDelete` (".$idUsuario.",@pStatusProc);";
        mysqli_query($util->configs, $code ) ;  
        $code =" SELECT @pStatusProc AS  'pStatusProc'";
        $error = mysqli_query($util->configs, $code ) ;
        while( $r = mysqli_fetch_assoc( $error ) ) {
            $statusProc = $r['pStatusProc'];          
        } 
    if($mantemAcessoPadrao == "0" && $statusProc=="0"){
        $modulos = $_POST["modulosCheck"];
        foreach ($modulos as &$modulo) {
            $acoes = $_POST["modulo".$modulo."acao"];
            foreach ($acoes as $acao){
                if($statusProc=="0"){
                    $code = "CALL `spAppAcessoInserir` (".$acao.", ".$idUsuario.", ".$modulo.", @pIdInserido ,@pStatusProc);";
                    mysqli_query($util->configs, $code ) ;  
                    $code =" SELECT @pStatusProc AS  'pStatusProc'";
                    $error = mysqli_query($util->configs, $code ) ;
                    while( $r = mysqli_fetch_assoc( $error ) ) {
                        $statusProc = $r['pStatusProc'];               
                    }  
                }
                else{
                    break 2;
                }

            }       
        }
    }
}
$util->set_session( "warn", $statusProc );




?>

<!--CLOSE_DB-->
<?php require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.USUARIOS_ADMIN_URL.'');
?>

<!--/CLOSE_DB-->