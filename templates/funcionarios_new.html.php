<?php

global $util ;
global $appolo_gui ;

$title = " Nova Funcionário - Funcionários - " . SITE_NAME . " - " . SYSTEM_NAME ;
$session = "funcionarios_new" ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>

<script type="text/javascript">
appolo.configs.select_admin_area = '<?=SELECT_ADMIN_AREA?>' ;

$(document).ready(function() {
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
	$("#cpf").mask("999.999.999-99")
	$( "#cpf" ).change(
		function() {
			message = $(document).find('.cpf_input');
			message.text("");
			var cpfDots = $( "#cpf" ).val();
			var cpfTrace = cpfDots.split('.').join("");
			var cpf = cpfTrace.split('-').join("");
			var aux = true;
			var numeros, digitos, soma, i, resultado, digitos_iguais;
			digitos_iguais = 1;
			if (cpf.length != 11 ||cpf == "00000000000" ||cpf == "11111111111" ||cpf == "22222222222" ||cpf == "33333333333" ||cpf == "44444444444" ||cpf == "55555555555" ||cpf == "66666666666" ||cpf == "77777777777" ||cpf == "88888888888" ||cpf == "99999999999")
			{	
				aux = false;
			}   
			for (i = 0; i < cpf.length - 1; i++)
				if (cpf.charAt(i) != cpf.charAt(i + 1))
				{
					digitos_iguais = 0;
					break;
				}
				if (!digitos_iguais)
				{
					numeros = cpf.substring(0,9);
					digitos = cpf.substring(9);
					soma = 0;
					for (i = 10; i > 1; i--)
						soma += numeros.charAt(10 - i) * i;
					resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
					if (resultado != digitos.charAt(0))
					{
						aux = false;
					}
					numeros = cpf.substring(0,10);
					soma = 0;
					for (i = 11; i > 1; i--)
						soma += numeros.charAt(11 - i) * i;
					resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
					if (resultado != digitos.charAt(1))
					{
						aux = false;
					}
				}
							
			if(!aux){
				$( "#cpf" ).val("");
				$( "#cpf" ).focus();
				message = $(document).find('.cpf_input');
				message.text("");
				message.text("CPF Inválido");							
			}
			});	
	$( "#cpf" ).focus(
		function() {
			message = $(document).find('.cpf_input');
			message.text("");
		});						
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
	var form  = $( 'form[name=funcionarios_new]' ) ;
	if( form.find( '.not-null' ).length ){ 
		breakpoint = appolo.util.treat_not_null_unique( form, breakpoint ) ;
		breakpoint = appolo.util.treat_min_length( form, breakpoint);
	} 
	if (!breakpoint && (!$('#sexoM').prop('checked') && !$('#sexoF').prop('checked'))){
		breakpoint = true;
		message = $(this).find('.sexo_input');
		message.text("");
		message.append("Selecione um sexo");			
		$('#sexoM').change(function(){
			message = $(document).find('.sexo_input');
			message.text("");
		});
		$('#sexoF').change(function(){
			message = $(document).find('.sexo_input');
			message.text("");
		});
	}
	if (!breakpoint){
  		breakpoint = appolo.validate_email($("#contato").val());
  	}
	if(breakpoint){ 
		breakpoint = false ;
		return false ;
	}
	
});





</script>
</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
		<h3>Novo Funcionário</h3>

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
	<div class="content-funcionarios_new">
		<div class="row">
			<div class="col-md-8">
				<form name="funcionarios_new" action="<?php echo INSERT_ADMIN_FUNCIONARIO?>" method="post" role="form">
					<fieldset>
						<div class="control-group">
							<div class="nome">
								<label class="control-label not-null minlength" for="nome">Nome do Funcionário</label>
								<div class="controls">
									<input type="text" class="form-control " id="nome" name="nome" placeholder="Digite o Nome do Funcionário" minlength="10" >
									<p class="error_input"></p>
								</div>
							</div>
							<div class="contato">
								<label class="control-label not-null minlength" for="contato">E-mail do Funcionário</label>
								<div class="controls">
									<input type="text" class="form-control " id="contato" name="contato" placeholder="Digite o E-mail do Funcionário" minlength="6" >
									<p class="error_input email_error"></p>
								</div>
							</div>	
							<div class="cpf">
								<label class="control-label not-null" for="cpf">CPF:</label>
								<input type="text" class="form-control " id="cpf" name="cpf" placeholder="Digite o CPF">
								<p class="error_input cpf_input"></p>
							</div>

							<div class="dtNascimento">
								<label class="control-label not-null" for="dtNascimento">Data de Nascimento:</label>
								<input data-format="dd/MM/yyyy" type="date" class="form-control input-append date dtNascimento_input " id="dtNascimento" name="dtNascimento"  placeholder="Data de Nascimento" >			
								<p class="error_input data_input"></p>					
							</div>
							<div class="sexo">
								<label class="control-label not-null" for="sexo">Sexo:</label>
								Masculino <input type="radio" id="sexoM" name="sexo[]" value="M">
								Feminino <input type="radio" id="sexoF" name="sexo[]" value="F" >
								<p class="error_input sexo_input"></p>
							</div>
							<div class="cargo ">
								<label class="control-label not-null" for="cargo">Cargo:</label>					
								<div class= "div-cargo-select">
									<div class="cargo-select">	
										<script type="text/javascript">
										var render_funcionarios_new_grid =  '<select id="cargo" class="form-control" name="cargo" for"cargo">';
										render_funcionarios_new_grid += '<option value=""></option>' ;
										render_funcionarios_new_grid += '{{#items}}' ;
										render_funcionarios_new_grid += '<option value="{{idCargo}}">{{descricaoCargo}}</option>' ;
										render_funcionarios_new_grid += '{{/items}}' ;
										render_funcionarios_new_grid += '</select>' ;
										render_funcionarios_new_grid += '<p class="error_input"></p>';
										</script>
									</div>	
								</div>	
							</div>
						</div>
					</fieldset>
					<div class="control-buttons">
						<div class="controls form-actions">
							<?php
							if ($appolo_gui->render_item("5","1")){?>
							<button class ="btn btn-primary send-form" type="submit" >
								<span class="glyphicon glyphicon-ok icon "> <text class="btn-Area">Salvar Registro</text></span>
							</button>
							<?php } ?>																			
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