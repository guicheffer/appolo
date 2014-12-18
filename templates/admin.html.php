<?php

	global $util ;
	global $appolo_gui ;

	$util->set_home( 1 ) ;
	$title = " Administração - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "home" ;
	//usar em caso de alert
	//$warn = isset( $_GET[ "warn" ] ) ? $_GET[ "warn" ] : '' ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>
</head>

<body class="<?php echo $session?> admin">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	
	<header>
		<ol class="breadcrumb">
 
     	</ol>
	</header>

	<div class="dashboard">
		<div class="container container-middle">
		<?php
		if ($appolo_gui->render_module("4")){?>
			<div class="item adm-item">
				<a href="<?php echo AREA_ADMIN_URL?>" class="item-title">
					<h3 class="title">Cargos e Permisões</h3>
				</a>				
				<span class="icons">

				</span>
				<article class="article-area">
					<p><a href="<?php echo AREA_ADMIN_URL?>">
						<span class="glyphicon glyphicon-lock a-icon"></span>						
						Administre os cargos  e suas permissões dentro do Appolo</a>
					</p>
					<hr>
				</article>
				<ul>
					<?php
					if ($appolo_gui->render_item("4","1")){?>

					<li><a href="<?php echo ADMIN_NEW_AREA_URL?>"><span class="glyphicon glyphicon-plus-sign a-icon"></span>Criar Novo Cargo</a></li>
					<?php
					}
					?>	
				</ul>

			</div>
		<?php
		}
		?>	
		<?php
		if ($appolo_gui->render_module("5")){?>
			<div class="item adm-item">
				<a href="<?php echo FUNCIONARIOS_ADMIN_URL?>" class="item-title">
					<h3 class="title">Funcionários</h3>
				</a>				
				<span class="icons">

				</span>
				<article class="article-area">
					<p><a href="<?php echo FUNCIONARIOS_ADMIN_URL?>">
						<span class="glyphicon glyphicon-user a-icon"></span>						
						Administre os funcionários e seus dados utilizados dentro do Appolo</a>
					</p>
					<hr>
				</article>
				<ul>
					<?php
					if ($appolo_gui->render_item("5","1")){?>

					<li><a href="<?php echo NEW_FUNCIONARIOS_ADMIN_URL?>"><span class="glyphicon glyphicon-plus-sign a-icon"></span>Criar Novo Funcionário</a></li>
					<?php
					}
					?>	
				</ul>

			</div>
		<?php
		}
		?>	

		<?php
		if ($appolo_gui->render_module("6")){?>
			<div class="item adm-item">
				<a href="<?php echo USUARIOS_ADMIN_URL?>" class="item-title">
					<h3 class="title">Usuários</h3>
				</a>				
				<span class="icons">

				</span>
				<article class="article-area">
					<p>
						<a href="<?php echo USUARIOS_ADMIN_URL?>">
						<span class="glyphicon glyphicon-list-alt a-icon"></span>						
						Administre os usuários para que acessem ao Appolo</a>
					</p>
					<hr>
				</article>
				<ul>
					<?php
					if ($appolo_gui->render_item("6","1")){?>

					<li><a href="<?php echo ADMIN_NEW_USERS_URL?>"><span class="glyphicon glyphicon-plus-sign a-icon"></span>Criar Novo Usuário</a></li>
					<?php
					}
					?>	
				</ul>

			</div>
		<?php
		}
		?>			

			

			<!-- <div class="item item-frame">&nbsp;</div> -->

		</div>
	</div>

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->