<?php

	global $util ;
	global $appolo_gui ;

	$util->set_home( 1 ) ;
	$title = " Dashboard - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "home" ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>
</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
		<div class="row">
			<ol class="breadcrumb"></ol>
		</div>
	</header>
	<?php
		if(isset($_SESSION['idUsuario'])){
			$warn = $util->get_session_and_clear( 'warn' );
			if ( isset( $warn ) ) {
				$appolo_gui->getMsgError($warn);
			}
		} ?>	
	<div class="row">
			<div class="dashboard">
				<div class="container container-middle">
					<?php
						if ($appolo_gui->render_module("1")){?>
							<div class="item item-pages">
							<a href="<?php echo PAGES_URL?>" class="item-title">
								<h3 class="title">Páginas</h3>
							</a>

							<span class="icons">
								<a href="#" class="glyphicon glyphicon-chevron-down dropdown">
									<ul class="dropdown-menu">
										<li>teste1</li>
										<li>teste2</li>
									</ul>
								</a>
								<a href="#" class="glyphicon glyphicon-move move"></a>
							</span>

							<article>
								<p>
									<span class="glyphicon glyphicon-file a-icon"></span>
									<a href="<?php echo PAGES_URL?>">Crie, visualize, edite e publique as páginas do <?php echo SITE_NAME?></a>
								</p>
								<hr>
							</article>

							<ul>
								<li><a href="<?php echo PAGES_URL?>"><span class="glyphicon glyphicon-arrow-right a-icon"></span>Ir para páginas</a></li>
								<li><a href="<?php echo PAGES_NEW_SECTION_URL?>"><span class="glyphicon glyphicon-folder-open a-icon"></span>Criar seção</a></li>
								<li><a href="<?php echo PAGES_NEW_PAGE_URL?>"><span class="glyphicon glyphicon-edit a-icon"></span>Criar página</a></li>
								<!--<li><a href="<?php echo TEMPLATES_PAGES_URL?>"><span class="glyphicon glyphicon-indent-right a-icon"></span>Criar template</a></li>
								<li><a href="<?php echo FORMS_PAGES_URL?>"><span class="glyphicon glyphicon-list-alt a-icon"></span>Criar formulário</a></li>//-->
							</ul>
						</div>
					<?php
						}
					?>
					<?php
						if ($appolo_gui->render_module("2")){?>
					<div class="item item-news">
						<a href="<?php echo NEWS_URL?>" class="item-title">
							<h3 class="title">Notícias</h3>
						</a>

						<span class="icons">
							<a href="#" class="glyphicon glyphicon-chevron-down"></a>
							<a href="#" class="glyphicon glyphicon-move move"></a>
						</span>

						<article>
							<p>
								<span class="glyphicon glyphicon-align-left a-icon"></span>
								<a href="<?php echo NEWS_URL?>">Crie, visualize, aprove e edite as notícias do <?php echo SITE_NAME?></a>
							</p>
							<hr>
						</article>

						<ul>
							<li><a href="<?php echo NEWS_URL?>"><span class="glyphicon glyphicon-arrow-right a-icon"></span>Ir para notícias</a></li>
							<!--<li><a href="<?php echo NEWS_NEW_SECTION_URL?>"><span class="glyphicon glyphicon-folder-open a-icon"></span>Criar seção</a></li>
							<li><a href="<?php echo TEMPLATES_NEWS_URL?>"><span class="glyphicon glyphicon-indent-right a-icon"></span>Criar template</a></li>
							<li><a href="<?php echo FORMS_NEWS_URL?>"><span class="glyphicon glyphicon-list-alt a-icon"></span>Criar formulário</a></li>//-->
						</ul>
					</div>
					<?php
						}
					?>
					<?php
						if ($appolo_gui->render_module("7")){?>
					<div class="item item-imgs">
						<a href="<?php echo IMAGES_URL?>" class="item-title">
							<h3 class="title">Imagens</h3>
						</a>

						<span class="icons">
							<a href="#" class="glyphicon glyphicon-move move"></a>
						</span>

						<article>
							<p>
								<span class="glyphicon glyphicon-camera a-icon"></span>
								<a href="<?php echo IMAGES_URL?>">Crie, visualize e edite as imagens do <?php echo SITE_NAME?></a>
							</p>
							<hr>
						</article>
						
					</div>
					<?php
						}
					?>
					<?php
						if ($appolo_gui->render_module("2")){?>
					<div class="item item-reports">
						<a href="<?php echo SOCIALMEDIA_TOOLS_URL?>" class="item-title">
							<h3 class="title">Mídias Sociais</h3>
						</a>

						<span class="icons">
							<a href="#" class="glyphicon glyphicon-chevron-down"></a>
							<a href="#" class="glyphicon glyphicon-move move"></a>
						</span>

						<article>
							<p>
								<span class="glyphicon glyphicon-send a-icon"></span>
								<a href="<?php echo SOCIALMEDIA_TOOLS_URL?>">Visualize e publique seus posts no twitter, facebook e/ou Google Plus do <?php echo SITE_NAME?></a>
							</p>
							<hr>
						</article>

						<ul>
							<li><a href="<?php echo SOCIALMEDIA_TOOLS_URL?>"><span class="glyphicon glyphicon-arrow-right a-icon"></span>Ir para mídias sociais</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-bullhorn a-icon"></span>Publicar no Facebook</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-bullhorn a-icon"></span>Publicar no Twitter</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-bullhorn a-icon"></span>Publicar no Google Plus</a></li>
						</ul>
					</div>
					<?php
						}
					?>
					<?php
						if ($appolo_gui->render_module("8")){?>
					<div class="item item-tools">
						<a href="<?php echo RELATORIOS_URL?>" class="item-title">
							<h3 class="title">Relatórios</h3>
						</a>

						<span class="icons">
							<a href="#" class="glyphicon glyphicon-move move"></a>
						</span>

						<article>
							<p>
								<span class="glyphicon glyphicon-briefcase a-icon"></span>
								<a href="<?php echo RELATORIOS_URL?>">Visualize os relatórios de publicações e seções dentro do <?php echo SITE_NAME?></a>
							</p>
							<hr>
						</article>

						<ul>
							<ul>
							<?php
								if ($appolo_gui->render_item("8","6")){?>

								<li><a href="<?php echo RELATORIOS_URL."#1" ?>"><span class="glyphicon glyphicon-list-alt a-icon"></span>Relatório Seções por Responsável</a></li>
							<?php } ?>
							<?php
								if ($appolo_gui->render_item("8","7")){?>

								<li><a href="<?php echo RELATORIOS_URL."#2" ?>"><span class="glyphicon glyphicon-list-alt a-icon"></span>Relatório Publicações por Autor</a></li>
							<?php } ?>
							<?php
								if ($appolo_gui->render_item("8","8")){?>

								<li><a href="<?php echo RELATORIOS_URL."#3" ?>"><span class="glyphicon glyphicon-list-alt a-icon"></span>Relatório Publicações por Período</a></li>
							<?php }	?>
							<?php
								if ($appolo_gui->render_item("8","9")){?>

								<li><a href="<?php echo RELATORIOS_URL."#4" ?>"><span class="glyphicon glyphicon-list-alt a-icon"></span>Relatório Publicações detalhadas por Período</a></li>
							<?php }	?>
						</ul> 
						</ul>
					</div>
					<?php
						}
					?>
					<?php
						if ($appolo_gui->render_module("4") || $appolo_gui->render_module("5") || $appolo_gui->render_module("6")){?>
					<div class="item item-admin">
						<a href="<?php echo ADMIN_URL?>" class="item-title">
							<h3 class="title">Administração</h3>
						</a>

						<span class="icons">
							<a href="#" class="glyphicon glyphicon-move move"></a>
						</span>

						<article>
							<p>
								<span class="glyphicon glyphicon-cog a-icon"></span>
								<a href="<?php echo ADMIN_URL?>">Administre os acessos, usuários, e cargos do Appolo </a>
							</p>
							<hr>
						</article>

						<ul>
							<?php
								if ($appolo_gui->render_item("4","1")){?>

								<li><a href="<?php echo ADMIN_NEW_AREA_URL?>"><span class="glyphicon glyphicon-plus-sign a-icon"></span>Criar Novo Cargo</a></li>
							<?php } ?>
							<?php
								if ($appolo_gui->render_item("5","1")){?>

								<li><a href="<?php echo NEW_FUNCIONARIOS_ADMIN_URL?>"><span class="glyphicon glyphicon-plus-sign a-icon"></span>Criar Novo Funcionário</a></li>
							<?php } ?>
							<?php
								if ($appolo_gui->render_item("6","1")){?>

								<li><a href="<?php echo ADMIN_NEW_USERS_URL?>"><span class="glyphicon glyphicon-plus-sign a-icon"></span>Criar Novo Usuário</a></li>
							<?php }	?>
						</ul> 
					</div>
					<?php
						}
					?>
					

					<!-- <div class="item item-frame">&nbsp;</div> -->

				</div>
			</div>
		</div>

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->