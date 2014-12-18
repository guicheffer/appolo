<?php

global $util ;
global $appolo_gui ;

$util->set_off( 1 ) ;
$title = " Login - " . "Guia Tech" . " - " . SYSTEM_NAME ;
$session = "login" ;
$request = $_SERVER['REQUEST_METHOD'];
if(isset( $_POST[ "user" ]) ){
	$user = $_POST[ "user" ] ;
}
else{
	$user="";
}
if(isset( $_POST[ "chaveContratante" ]) ){
	$chaveContratante = $_POST[ "chaveContratante" ] ;
}
else{
	$chaveContratante="";
}
if( isset($_POST[ "password" ]) ) 	{
	$password = $_POST[ "password" ] ;
}
else{
	$password="";
}
if( isset($_GET[ "url" ]) ) 	{
	$url = $_GET[ "url" ] ;
}
else{
	$url=APPOLO_DASHBOARD;
}
if ($user!="" && $password!=""){

	$util->login( $user , $password , $url , $chaveContratante);
}
?>

<?php require ( HEADER_TEMPLATE ) ; ?>
<script type="text/javascript">

$(document).submit(function( event ) {
	var breakpoint = false;
	if( $( document).find( '.not-null' ).length ){ 			
		if( appolo.util.treat_not_null( $( document), breakpoint )  ){ 
			breakpoint = false ;
			return false ;
		}
	}	
}) ;

appolo.configs.select_contratante = '<?=SELECT_CONTRATANTE_LOGIN?>' ;
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
		<h1>Login</h1>
		<form role="form" class="form-login" method="POST" name="formlogin" >


			<div class="control-group">
				<label for="chaveContratante" class="control-label not-null">Chave do site</label>
				<div class="controls">
					<input type="text" class="form-control" id="chaveContratante" name="chaveContratante" placeholder="Informe a chave do site">
				</div>
			</div>
			<div class="control-group">
				<label for="user" class="control-label not-null">Usuário </label>
				<div class="controls">
					<input type="text" class="form-control" id="user" name="user" placeholder="Seu usuário ">
				</div>
			</div>
			<div class="control-group">
				<label for="password" class="control-label not-null">Senha</label>
				<div class="controls">
					<input type="password" class="form-control" id="password" name="password" placeholder="Senha">
				</div>
				<a href="<?php echo ESQUECEU_SENHA?>" class="fgt"><span class="glyphicon glyphicon-wrench a-icon"></span>Esqueci minha senha</a>
<!-- 				<div class="form-group">
					<label class="checkbox"><input type="checkbox" checked=""> Lembrar senha</label>
				</div> -->
			</div>
			<button type="submit" class="btn btn-primary btn-entrar send-form">Entrar</button>
		</form>

	</div>
	
	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->