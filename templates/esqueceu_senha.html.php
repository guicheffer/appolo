<?php

global $util ;
global $appolo_gui ;

$util->set_off( 1 ) ;
$title = " Recuperar Dados  de Acesso - " . "Appolo" . " - " . SYSTEM_NAME ;
$session = "login" ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>
<script type="text/javascript">

$(document).ready(function() {
	$("#user").change(function(){
		$("#email").val("");
		$(".has_error2").removeClass( 'has-error' ) ;
		message = $(document).find('#error2');
		message.text("");
		$(".has_error3").removeClass( 'has-error' ) ;
		message = $(document).find('#error3');
		message.text("");	
	});	
	$("#email").change(function(){
		$("#user").val("");	
		$(".has_error2").removeClass( 'has-error' ) ;
		message = $(document).find('#error2');
		message.text("");	
		$(".has_error3").removeClass( 'has-error' ) ;
		message = $(document).find('#error3');
		message.text("");
			email = $("#email").val();
			if(email != "")
			{
				var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				if(!filtro.test(email))
				{
					$("#email").val("");
					$("#email").focus();	
					$(".has_error3").addClass( 'has-error' ) ;			
					message.append("E-mail Inválido");
				}
			}
			
	});	
	$("#chaveContratante").change(function(){
		$(".has_error1").removeClass( 'has-error' ) ;
		message = $(document).find('#error1');
		message.text("");		
	});	  	  
});
$(document).submit(function( event ) {
	if($("#chaveContratante").val()==""){
		$(".has_error1").addClass( 'has-error' ) ;
		message = $(document).find('#error1');
		message.text("");
		message.append("Campo obrigatório");
		return false;
	}
	if($("#email").val()=="" && $("#user").val()==""){
		$(".has_error2").addClass( 'has-error' ) ;
		message = $(document).find('#error2');
		message.text("");
		message.append("Digite ao menos um dos Campos");
		$(".has_error3").addClass( 'has-error' ) ;
		message = $(document).find('#error3');
		message.text("");
		message.append("Digite ao menos um dos Campos");
		return false;
	}
	
	return true;
}) ;


</script>
</head>

<body class="<?php echo $session?>" >

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>
	<?php
	$warn = $util->get_session_and_clear( 'warn' );

	if ( isset( $warn ) ) { 			
		$appolo_gui->getMsgError($warn);
	} ?>
	<div class="container content-login animated ">
		<h4>Recuperar Dados de Acesso</h1>
		<h6>Será enviado um e-mail com dados de acesso no contato previamente cadastrado</h1>
		<form role="form" class="form-login" method="POST" name="formlogin" action="<?php echo RESET_PASSWORD ?>" >
			<div class="control-group has_error1">
				<label for="chaveContratante" class="control-label not-null">Chave do site</label>
				<div class="controls">
					<input type="text" class="form-control" id="chaveContratante" name="chaveContratante" placeholder="Informe a chave do site">
					<p class="error_input" id="error1"></p>
				</div>
			</div>
			<h5><b>Atenção digite somente um dos dados abaixo</b></h5>
			<div class="control-group has_error2">
				<label for="user" class="control-label not-null">Usuário </label>
				<div class="controls">
					<input type="text" class="form-control " id="user" name="user" placeholder="Seu usuário ">
					<p id="error2" class="error_input"></p>
				</div>
			</div>
			<div class="control-group final has_error3">
				<label for="user" class="control-label not-null">E-mail cadastrado </label>
				<div class="controls">
					<input type="text" class="form-control" id="email" name="email" placeholder="Seu e-mail cadastrado">
					<p id="error3" class="error_input"></p>
				</div>
			</div>
			
			<button type="submit" class="btn btn-primary btn-entrar send-form">Enviar e-mail</button>
		</form>

	</div>
	
	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->