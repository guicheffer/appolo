<?php

global $util ;
global $appolo_gui ;

$title = " Alterar Senha" . SITE_NAME . " - " . SYSTEM_NAME ;
$session = "alterar_senha" ;

?>
<?php require ( HEADER_TEMPLATE ) ; ?>

<script type="text/javascript">
$(document).submit(function( event ) {
 
  var $this=$(this);
  var breakpoint = false;
  var form  = $( 'form[name=alterar_senha]' ) ;
  if( form.find( '.not-null' ).length ){ 
  		breakpoint = appolo.util.treat_not_null_unique( form, breakpoint ) ;
  }
  if(!breakpoint){
		breakpoint = appolo.util.treat_min_length( form, breakpoint);
  }
  if(!breakpoint ){// senha
  	status_senha = form.find('.output').text();
  	if(status_senha=="Fraca" || status_senha=="Média"){
  		input_senha = form.find('#new_password');
  		message =form.find( '.senha_error' );
  		message.text("");
  		message.append("Senha muito fraca");
  		input_senha.parent().addClass( 'has-error' ) ;
  		input_senha.focus()
  		input_senha.change(function(){
  			input_senha.parent().removeClass( 'has-error' ) ;
  			message.text("");
  		});
  		breakpoint = true;
  	}
  } 
  if(!breakpoint ){
  	if(form.find('#new_password').val() != form.find('#confirm_password').val()){
  		input_senha = form.find('#new_password');
  		message =form.find( '.senha_error' );
  		message.text("");
  		message.append("Senhas Diferem");
  		input_senha.parent().addClass( 'has-error' ) ;
  		input_senha.focus()
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
  // return false ;
});
</script>
</head>
<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
		<h3>Alterar Senha</h3>

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
	<div class="content-alterar_senha">
		<div class="row">
			<div class="col-md-8">
				<form name="alterar_senha" action="<?php echo ADMIN_UPDATE_SENHA_URL?>" method="post" role="form">
				<fieldset id="form" class="alterar_senha_box">
					<div class="control-group">
						<label class="control-label not-null" for="old_password">Digite a Senha Atual</label>
						<div class="controls">							
							<input class="form-control inputs password" id="old_password" name="old_password" maxlength="10" type="password">
							<p class="error_input"></p>	
						</div>
					</div>
					<div class="control-group">
						<label class="control-label not-null" for="new_password">Digite a Nova Senha</label>
						<div class="controls">							
							<input type="text" class="form-control inputs password" id="new_password" name="new_password" maxlength="10" placeholder="Digite a senha">
							<a href="javascript:void(0);" class="generate" id="generate">Gerar Senha</a>
							<span id="output" class="output">...</span>
							<script type="text/javascript">
								var $input = $( '#new_password' );
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
							
					</div>
					<div class="control-group">
						<label class="control-label not-null" for="confirm_password">Confirme a Nova Senha</label>
						<div class="controls">							
							<input type="text" class="form-control inputs password" id="confirm_password" name="confirm_password" maxlength="10" placeholder="Digite a senha">
							<p class="error_input"></p>
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