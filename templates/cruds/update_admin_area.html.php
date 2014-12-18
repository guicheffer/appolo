<?php
    global $util ;
    $util->set_home( 1 ) ;
    $session = "crud" ;
    header( "Content-type: application/json" );
    $idCargo = $_POST["idCargo"];
    $nomeCargo = $_POST["area_description"];
    $auxError=true;
    $statusProc ="";
    $idContratante = $util->get_session( 'idContratante' );     
    $code = "CALL `spAppCargoUpdate` ('".$idCargo."', '".$nomeCargo."', '".$nomeCargo."', ".$idContratante.",@pStatusProc);";
    mysqli_query($util->configs, $code ) ;  
    $code =" SELECT @pStatusProc AS  'pStatusProc'";
    $error = mysqli_query($util->configs, $code ) ;
    while( $r = mysqli_fetch_assoc( $error ) ) {
        $statusProc = $r['pStatusProc'];          
    }      
    if($statusProc=="0"){
        $code = "CALL `spAppCargoAcaoDelete` (NULL , '".$idCargo."' , NULL , @pStatusProc);";
        mysqli_query($util->configs, $code ) ;  
        $code =" SELECT @pStatusProc AS  'pStatusProc'";
        $error = mysqli_query($util->configs, $code ) ;
        while( $r = mysqli_fetch_assoc( $error ) ) {
            $statusProc = $r['pStatusProc'];               
        } 
        if($statusProc=="0"){
            $modulos = $_POST["modulosCheck"];
            foreach ($modulos as &$modulo) {
                $acoes = $_POST["modulo".$modulo."acao"];
                foreach ($acoes as $acao){
                    if($statusProc==0){
                       $code = "CALL `spAppCargoAcaoInserir` ('".$acao."', '".$idCargo."', '".$modulo."',@pStatusProc);";
                       mysqli_query($util->configs, $code ) ;  
                       $code =" SELECT @pStatusProc AS  'pStatusProc'";
                       $error = mysqli_query($util->configs, $code ) ;
                       while( $r = mysqli_fetch_assoc( $error ) ) {
                        $statusProc = $r['pStatusProc'];               
                       }  
                    }
                    else{
                        break 3;
                    }
                    
                }       
            }
        }
    }
    $util->set_session( "warn", $statusProc );

    

?>

<!--CLOSE_DB-->
<?php require ( CLOSE_DB_TEMPLATE ) ;
header('Location: '.AREA_ADMIN_URL.'');
?>

<!--/CLOSE_DB-->