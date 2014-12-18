<?php

global $util ;
global $appolo_gui ;

$title = " Alterar Dados Pessoais - " . SITE_NAME . " - " . SYSTEM_NAME ;
$session = "funcionarios_edit" ;

$cdCpf = $util->get_session( 'cpfPessoa' );
$idCargo =  $util->get_session( 'idCargo' );     
$idStatus =  $util->get_session( 'idStatus' );
?>

<?php require ( HEADER_TEMPLATE ) ; ?>

<script type="text/javascript">

appolo.configs.select_admin_funcionarios = '<?=SELECT_ADMIN_FUNCIONARIOS?>' ;
appolo.configs.select_admin_contato_pessoa = '<?=SELECT_ADMIN_CONTATO_PESSOA?>' ;
$(document).ready(function() {
	$("#cdCpf").mask("999.999.999-99");
	$( "#contato" ).blur(
		function() {
			email_error = $(document).find(".email_error");
			email_error.text('');
			email = $("#contato").val();
			if(email != "")
			{
				var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				if(!filtro.test(email))
				{
					$("#contato").val("");
					$("#contato").focus();				
					email_error.append("E-mail Inválido");
					aux =  false;
				}
				aux = true;
			}
		}	
	);
	$( "#dtNascimento" ).blur(
		function() {
			message = $(document).find('.data_input');
			message.text(""); 
			if($( "#dtNascimento" ).val()!=""){
				var data_nasc = $( "#dtNascimento" ).val();  		
		  		var aux= data_nasc.split("-");
				var diaNasc = parseInt(aux[2]);
				var mesNasc = parseInt(aux[1]);
				var anoNasc = parseInt(aux[0]);
				var today = new Date();
				var diaHoje = today.getDate();
				var mesHoje = today.getMonth()+1; //January is 0!
				var anoHoje = today.getFullYear();
				
				if (anoHoje-anoNasc>=18){
					return true;
				}
				else{
				if(anoHoje-anoNasc==17)	{
					if (mesHoje-mesNasc<=0){			
						if (diaHoje-diaNasc<=0){
							return true;	
						}
					}
				}
				$( "#dtNascimento" ).val("");
				$( "#dtNascimento" ).focus();
				message = $(document).find('.data_input');
				message.text("");
				message.text("Usuário tem de ser Maior de Idade");							
				return false;
			}
  				
		}	

	});
});

$(document).submit(function( event ) {
 
  var $this=$(this);
  var breakpoint = false;
  var form  = $( 'form[name=funcionarios_edit]' ) ;
  if( form.find( '.not-null' ).length ){ 
  		breakpoint = appolo.util.treat_not_null_unique( form, breakpoint ) ;
  }
  if(!breakpoint){
		breakpoint = appolo.util.treat_min_length( form, breakpoint);
  } 
  if (!breakpoint){
  		breakpoint = appolo.validate_email($("#contato").val());
  }
  if(breakpoint){ 
	breakpoint = false ;
    return false ;
  }
  // return false ;
});

</script>
</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
		<h3>Alterar Dados Pessoais</h3>

		<ol class="breadcrumb"> 

		</ol>
	</header>
	<div class="row area-warn">
		<?php
		if(isset($_SESSION['idUsuario'])){
			$warn = $util->get_session_and_clear( 'warn' );
			if ( isset( $warn ) ) { 			
				$appolo_gui->getMsgError($warn);
			}
		}?>
	</div>
	<div class="loading">
						<img src="/images/icon-loading.gif" alt="Carregando...">
						<p class="warn">Carregando dados do Funcionário</p>
				</div>
	<div class="content-funcionarios_edit">
		<div class="row">
			<div class="col-md-8">
				<form name="funcionarios_edit" action="<?php echo ADMIN_UPDATE_DADOS_URL?>" method="post" role="form">
					<fieldset id="form">
						<input type="hidden" id="idCargo" name="idCargo" value="<?= $idCargo ?>">
						<input type="hidden" id="idStatus" name="idStatus" value="<?= $idStatus ?>">		
						<div class="control-group">
							
							<div class="nome">
								<label class="control-label not-null minlength" for="nome">Nome do Funcionário</label>
								<div class="controls">
									<input type="text" class="form-control " id="nome" name="nome" placeholder="Digite o Nome do Funcionário"minlength="10" >
									<p class="error_input"></p>
								</div>
							</div>
							<div class="contato">
								<label class="control-label not-null minlength" for="contato">E-mail do Funcionário</label>
								<div class="controls">
									<input type="text" class="form-control " id="contato" name="contato" placeholder="Digite o E-mail do Funcionário"minlength="10" >
									<p class="error_input email_error"></p>
								</div>
							</div>	
							<div class="cpf">
								<label class="control-label" for="cdCpf">CPF:</label>
								<input type="text" readonly class="form-control cdCpf" id="cdCpf" name="cdCpf" placeholder="Digite o CPF" value="<?php echo $cdCpf ?>">
								<p class="error_input cpf_input"></p>
							</div>

							<div class="dtNascimento">
								<label class="control-label not-null" for="dtNascimento">Data de Nascimento:</label>
								<input type="date" data-format="dd/MM/yyyy" class="form-control dtNascimento_input"  id="dtNascimento" name="dtNascimento"  placeholder="Data de Nascimento">
								<p class="error_input data_input"></p>		
							</div>


							<div class="sexo">
								<label class="control-label not-null" for="sexo">Sexo:</label>
								Masculino <input type="radio" id="sexoM" name="sexo[]" value="M" required="true">
								Feminino <input type="radio" id="sexoF" name="sexo[]" value="F">
								<label for="sexo[]" class="error" style="display:none;">Por favor selecione um sexo.</label>
							</div>
							
					</div>
				</fieldset>
				<div class="control-buttons">
					<div class="controls form-actions">	
						<button class ="btn btn-primary send-form" type="submit" >
							<span class="glyphicon glyphicon-ok icon "> <text class="btn-Area">Salvar Alterações</text></span>
						</button>							
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->