<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
$rows = array();
$retornoAcoes=array();	
$moduloAntigo=false;
$modulos =array();
$modulosaux= array();
$acoesaux= array();
$acoes = array();
$code = "CALL `spAppModuloAcaoSelect` (null , null , @p3)";
$idCargo = $_POST['cargoId'];
//$idCargo = "13";
if (mysqli_multi_query($util->configs, $code)) {

	do {
		if ($r = mysqli_store_result($util->configs)) {
			while ($row = mysqli_fetch_assoc($r)) {
				if (!$moduloAntigo){
					$moduloAntigo = $row['idModulo'];	
					$modulosaux['idModulo'] = $row['idModulo'];
					$modulosaux['nomeModulo'] = $row['nomeModulo'];							 
				}
				if($moduloAntigo == $row['idModulo']){
					$acoesaux['idAcao'] = $row['idAcesso'];
					$acoesaux['nomeAcao'] =  $row['nomeAcao'];
					$acoes[] = $acoesaux;
				}
				else{
					$modulosaux['listaAcao'] = $acoes;
					$modulos[]=$modulosaux;
					$modulosaux= array();
					$acoesaux = array();
					$acoes = array();
					$moduloAntigo = $row['idModulo'];
					$modulosaux['idModulo'] = $row['idModulo'];
					$modulosaux['nomeModulo'] = $row['nomeModulo'];
					$acoesaux['idAcao'] = $row['idAcesso'];
					$acoesaux['nomeAcao'] =  $row['nomeAcao'];
					$acoes[] = $acoesaux;
				}
			}
			$modulosaux['listaAcao'] = $acoes;
			$modulos[]=$modulosaux;
			mysqli_free_result($r);

		}
	} while (mysqli_next_result($util->configs) && (mysqli_more_results($util->configs)));
}

$moduloAntigo=false;
$modulosAtivo =array();
$modulosauxAtivo= array();
$acoesauxAtivo= array();
$acoesAtivo = array();

$code = "CALL `spAppCargoAcaoSelect` (null , '".$idCargo."' , null , @pstatusProc)";
$aux = true;
if (mysqli_multi_query($util->configs, $code)) {
	do {
		if ($r = mysqli_store_result($util->configs)) {
			while ($row = mysqli_fetch_assoc($r)) {
				if (!$moduloAntigo){
					$aux = false;
					$moduloAntigo = $row['idModulo'];	
					$modulosauxAtivo['idModulo'] = $row['idModulo'];
				}
				if($moduloAntigo == $row['idModulo']){
					$acoesauxAtivo['idAcao'] = $row['idAcao'];
					$acoesAtivo[] = $acoesauxAtivo;
				}
				else{
					$modulosauxAtivo['listaAcao'] = $acoesAtivo;
					$modulosAtivo[]=$modulosauxAtivo;
					$modulosauxAtivo= array();
					$acoesauxAtivo = array();
					$acoesAtivo = array();
					$moduloAntigo = $row['idModulo'];
					$modulosauxAtivo['idModulo'] = $row['idModulo'];
					$acoesauxAtivo['idAcao'] = $row['idAcao'];
					$acoesAtivo[] = $acoesauxAtivo;
				}

			}
			if(!$aux){
				$modulosauxAtivo['listaAcao'] = $acoesAtivo;
				$modulosAtivo[]=$modulosauxAtivo;	            	
			}
		}
	} while (mysqli_next_result($util->configs) && (mysqli_more_results($util->configs)));
}
if(!$aux){
	$modulosFim= $util->InnerJoinArrayAcessos($modulos, $modulosAtivo);
	$modulosFinal = $util->SetDisabledActions($modulosFim);	
}
else{
	$modulosFinal = $util->SetDisabledActions($modulos);	
}
	$modulosFinal = $util->SetNumberActions($modulosFinal);

print json_encode( $modulosFinal ) ;




?>

<?php require ( CLOSE_DB_TEMPLATE ) ;?>