<?php

global $util ;
global $appolo_gui ;
if( ! $appolo_gui->render_item( "6" , "2" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
}
$title = " Alterar Usuários - " . SITE_NAME . " - " . SYSTEM_NAME ;
$session = "usuario_alterar" ;
$cdCpf = $_POST['usuariosCheck'][0];
?>

<?php require ( HEADER_TEMPLATE ) ; ?>
<script type="text/javascript">

$(document).on( 'change', ':checkbox', function (event) { 
	if(event.target.id == "mantemAcessoPadrao"){
		if(!$('#mantemAcessoPadrao').is(":checked")){
			$('.table_acessos').slideDown();	
		}
		else{
			$('.table_acessos').slideUp();
		}	
	}
	var trAcoes = $("."+event.target.id);
	if($("#"+event.target.id).is(":checked")){
		trAcoes.find(':checkbox').each (function() {
  			this.disabled = false;              
	 	});
	}
	else{
		trAcoes.find(':checkbox').each (function() {
  			this.disabled = true;  
  			this.checked = false;            
	 	});
	}
});
$(document).submit(function( event ) {
  
  var $this=$(this);
  var breakpoint = false;
  var form  = $( 'form[name=grid_user]' ) ;
  if( form.find( '.not-null' ).length ){ 
  	breakpoint = appolo.util.treat_not_null_unique( form, breakpoint ) ;

  } 
  if(!breakpoint){// min length
  	breakpoint = appolo.util.treat_min_length( form, breakpoint ) ;
  }
  if(!breakpoint ){// senha
  	status_senha = form.find('.output').text();
  	if(status_senha=="Fraca" || status_senha=="Média"){
  		input_senha = form.find('.password');
  		message =form.find( '.senha_error' );
  		message.text("");
  		message.append("Senha muito fraca");
  		input_senha.parent().addClass( 'has-error' ) ;
  		input_senha.focus()
  		console.log(input_senha);
  		input_senha.change(function(){
  			input_senha.parent().removeClass( 'has-error' ) ;
  			message.text("");
  		});
  		breakpoint = true;
  	}
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
	<script type="text/javascript"><!--
	appolo.configs.select_modulo_acao = '<?=SELECT_MODULE_ACTION?>' ;
	appolo.configs.select_admin_usuarios = '<?=SELECT_ADMIN_USUARIOS?>' ;
	appolo.configs.select_acesso_acao = '<?=SELECT_ADMIN_ACESSOS_USER?>' ;
	//--></script>

	<header>
		<div class="row">
			<h3>Alterar Usuário </h3>

			<ol class="breadcrumb"></ol>
		</div>
	</header>
	<div class="row area-warn">
		<?php
		if(isset($_SESSION['idUsuario'])){
			$warn = $util->get_session_and_clear( 'warn' );
			if ( isset( $warn ) ) { 			
				$appolo_gui->getMsgError($warn);
			}
		} ?>
	</div>
	<div class="loading">
		<img src="/images/icon-loading.gif" alt="Carregando...">
		<p class="warn">Carregando dados do Usuário</p>
	</div>	
	<div class="form_edit_user">
	<div class="usuarios_edit">
		<form action="<?php echo ADMIN_UPDATE_USER_URL?>" method="post" name="grid_user">

				<div >

					<input type="hidden" id="cdCpf" name="cdCpf" value="<?php echo $cdCpf ?>">
					<input type="hidden" id="idCargo" name="idCargo" >
					<input type="hidden" id="idUsuario" name="idUsuario" >	
					
						<label class="control-label not-null minlength" for="user_description">Login do Usuário</label>
						<div class="controls">
							<input type="text" class="form-control inputs" id="user_description" name="user_description" placeholder="Digite o Login" maxlength="15" minlength="4">
							<p class="error_input"></p>
						</div>
						<label class="control-label " for="user_password">Resetar a Senha do Usuário</label>
						<div class="controls">							
							<input type="text" class="form-control inputs password" id="user_password" name="user_password" maxlength="10" placeholder="Digite a senha">
							<a href="javascript:void(0);" class="generate" id="generate">Gerar Senha</a>
							<span id="output" class="output">...</span>
							<script type="text/javascript">
								var $input = $( '#user_password' );
								var $output = $( '#output' );
								var feedback = [
								    { color: '#c00', text: 'Fraca' },
								    { color: '#c80', text: 'Média' },
								    { color: '#0c0', text: 'Bom' },
								    { color: '#0c0', text: 'Ótima' }
								];
								$input.passy(function(strength, valid) {
							        $output.text(feedback[strength].text);
							        $output.css('background-color', feedback[strength].color);
							    });

								$('#generate').click(function() {
								    $input.passy( 'generate', 8 );
								});
							</script>
							<p class="error_input senha_error"></p>
						</div>
						
						<div class="controls">
							<input type="checkbox" class="" id="mantemAcessoPadrao" name="mantemAcessoPadrao" placeholder="Digite o Login"> <label class="control-label" for="mantemAcessoPadrao">Manter o acesso padrão do Usuário a partir do Cargo?</label>
							
						</div>
					</div>
					<div class="table_acessos">				
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th class="check">
										<th class="modulo">Módulos</span></th>
										<th class="acoes center" colspan="2">Ações</th>
									</tr>
								</thead>
								<tbody class="page page-1 active table-user_acessos" >
									<script type="text/javascript">

									var render_usuarios_edit_acessos = '{{#modulos}}' ;
											render_usuarios_edit_acessos += '<tr>' ;
												render_usuarios_edit_acessos += '<td style="width:10px; vertical-align: middle;" rowspan="{{numberActions}}" >' ;
													render_usuarios_edit_acessos += '<input type="checkbox" value="{{idModulo}}" name="modulosCheck[]" id="modulo{{idModulo}}"';
													render_usuarios_edit_acessos += '{{#checkModulo}} checked="true"{{/checkModulo}}>';
												render_usuarios_edit_acessos += '</td>' ;
												render_usuarios_edit_acessos += '<td style="width:100px; vertical-align: middle;" rowspan="{{numberActions}}">' ;	
													render_usuarios_edit_acessos += '{{nomeModulo}}' ;	
												render_usuarios_edit_acessos += '</td>' ;
											render_usuarios_edit_acessos += '</tr>' ;



											render_usuarios_edit_acessos += '{{#listaAcao}}'
												render_usuarios_edit_acessos += '<tr class="modulo{{idModulo}}">'  ;											
													render_usuarios_edit_acessos += '<td style="width:10px;">'
														render_usuarios_edit_acessos += '<input type="checkbox" value="{{idAcao}}" name="modulo{{idModulo}}acao[]" id="modulo{{idModulo}}acao{{idAcao}}"';
														render_usuarios_edit_acessos += '{{#check}}checked="true"{{/check}} ';
														render_usuarios_edit_acessos += '{{#disabled}}disabled="true" {{/disabled}}';
														render_usuarios_edit_acessos += '>';
													render_usuarios_edit_acessos += '</td>' ;
													render_usuarios_edit_acessos += '<td>' ;	
														render_usuarios_edit_acessos += '{{nomeAcao}}' ;	
													render_usuarios_edit_acessos += '</td>' ;												
												render_usuarios_edit_acessos += '</tr>' ;
												
											render_usuarios_edit_acessos += '{{/listaAcao}}';
										render_usuarios_edit_acessos += '{{/modulos}}' ;

									</script>	
								</tbody>
							</table>
					</div>

				


				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<!-- <?=$appolo_gui->render_button(ADMIN_UPDATE_AREA_URL, "btn btn-primary create", "fullscreen", "Gravar", "4", "2" );?> -->
						<?php
						if ($appolo_gui->render_item("4","2")){?>
							<button class ="btn btn-primary create " type="submit">
								<span class="glyphicon glyphicon-ok-sign icon "> <text class="btn-Area">Gravar</text></span>
							</button>
						<?php } ?>	
					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</form>
			</div>
		</div>	
		</div>	

		
		<!--FOOTER-->
		<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->