<?php

	global $util ;
	global $appolo_gui ;

	$title = " ERROR - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "news" ;
	$mySqlErrno = $util->get_session_and_clear( 'mySqlErrno' );
	$mySqlError = $util->get_session_and_clear( 'mySqlError' );
?>

<?php require ( HEADER_TEMPLATE ) ; ?>
</head>

<body class="<?php echo $session?>">


		<div class="dashboard">
		<div class="container container-middle">
			<div class="item item-pages">
				
					<h1 class="title">Opa aparentemente houve um erro Mysql</h1> 
					<h3 class="title">Envie o código e o texto abaixo aos desenvolvedores do sistema </h3>

					<p>
						<span class="glyphicon glyphicon-align-left a-icon"></span>						
						<?php echo $mySqlErrno;?>
						<?php echo $mySqlError;?>
					</p>
					<hr>
				<ul>
					<li><a href="javascript:history.back()"><span class="glyphicon glyphicon-arrow-right a-icon"></span>Voltar à página anterior</a></li>				
				</ul>
			</div>	

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->