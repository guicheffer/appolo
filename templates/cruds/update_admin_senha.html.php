<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$old_password = $util->urlsafe_b64encode($_POST['old_password']);
$new_password = $util->urlsafe_b64encode($_POST['new_password']);
$idUsuario = $util->get_session( 'idUsuario' );     
$code = "CALL `spAppUsuarioAlterarSenha` (".$idUsuario.", '".$old_password."', '".$new_password."',@pStatusProc);";
// $code = "CALL `spAppUsuarioAlterarSenha` (".$idUsuario.", '123456', '".$new_password."',@pStatusProc);";
mysqli_query($util->configs, $code ) ;  
$code =" SELECT @pStatusProc AS  'pStatusProc'";
$error = mysqli_query($util->configs, $code ) ;
while( $r = mysqli_fetch_assoc( $error ) ) {
    $statusProc = $r['pStatusProc'];          
} 
$util->set_session( "warn", $statusProc );
?>

<!-- // CLOSE_DB -->
<?php require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.APPOLO_DASHBOARD.'');
?>

<!--/CLOSE_DB-->