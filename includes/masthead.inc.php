<a class="sr-only" href="#content">Pular navegação</a> 

<a class="sr-only" name="top">Topo</a>

<div class="row">

	<div class="navbar navbar-default navbar-static-top">

		<div class="container container-header">

			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

				</button>

				<a class="navbar-brand" href="/"><?php echo SYSTEM_NAME?><span><?php echo SYSTEM_SLOGAN?></span></a>

			</div>
			<?php
				if ( util::check_on() ) {
			?>
			<div class="navbar-collapse collapse">

				<ul class="nav navbar-nav">
					<li >
						<a href="/">Home</a>
					</li>
					<?php
					if ($appolo_gui->render_module("1")){?>
					<li class="paginas">
						<a href="/pages/">Páginas</a>
					</li>
					<?php
					}
					?>	
					<?php
					if ($appolo_gui->render_module("2")){?>
					<li class="noticias">
						<a href="/news/">Notícias</a>
					</li>
					<?php
					}
					?>	
					<?php
					if ($appolo_gui->render_module("7")){?>
					<li class="images">
						<a href="/images/">Imagens</a>
					</li>
					<?php
					}
					?>	
					<?php
						if ($appolo_gui->render_module("2") || $appolo_gui->render_module("5") || $appolo_gui->render_module("6")){?>
							<li class="dropdown admin">
								<a class="dropdown-toggle pointer" data-toggle="dropdown">Administração 
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<?php
									if ($appolo_gui->render_module("4")){?>
									<li>
										<a href="<?php echo AREA_ADMIN_URL?>">Cargos e Permissões</a>
									</li>
									<?php
									}
									?>
									<?php
									if ($appolo_gui->render_module("5")){?>
									<li>
										<a href="<?php echo FUNCIONARIOS_ADMIN_URL?>">Funcionários</a>
									</li>
									<?php
									}
									?>
									<?php
									if ($appolo_gui->render_module("6")){?>
										<li>
											<a href="<?php echo USUARIOS_ADMIN_URL?>">Usuários</a>
										</li>
									<?php
									}
									?>										
								</ul>
							</li>
					<?php
						}
					?>
					<?php
						if ($appolo_gui->render_module("8")){?>
							<li class="dropdown reports">
								<a class="dropdown-toggle pointer" data-toggle="dropdown">Relatórios 
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<?php
									if ($appolo_gui->render_item("8","6")){?>
										<li><a href="<?php echo RELATORIOS_URL."#1" ?>">Relatório Seções por Responsável</a></li>
									<?php
									}
									?>
									<?php
									if ($appolo_gui->render_item("8","7")){?>
										<li><a href="<?php echo RELATORIOS_URL."#2" ?>">Relatório Publicações por Autor</a></li>
									<?php
									}
									?>
									<?php
									if ($appolo_gui->render_item("8","8")){?>
										<li><a href="<?php echo RELATORIOS_URL."#3" ?>">Relatório Publicações por Período</a></li>
									<?php
									}
									?>	
									<?php
									if ($appolo_gui->render_item("8","9")){?>
										<li><a href="<?php echo RELATORIOS_URL."#4" ?>">Relatório Publicações detalhadas por Período</a></li>
									<?php
									}
									?>										
								</ul>
							</li>
					<?php
						}
					?>
				</ul>
				<?php
						}
					?>
				<!-- <?php echo $appolo_gui -> mount_menu_header(); ?> -->
				<?php if ( ! ( util::check_on() ) ) {
					//remove button from iphone if is not in
					?>
					<script type="text/javascript"><!--
					$('.navbar-toggle').remove() ;
					//--></script>
					<?php } ?>

				</div>

				<!--USER DETAILS-->
				<?php if ( util::check_on() ) { ?>
				<div class="userdetails" draggable="true">
					<span class="glyphicon glyphicon-user user"></span>
					<span class="glyphicon glyphicon-chevron-left arrow-left"></span>
					<span class="glyphicon glyphicon-chevron-right arrow-right"></span>
					<span class="caret down"></span>
					<span class="info name"><?php echo $util->get_session( 'nomePessoa' );?></span>
					<a href="#" class="viewdetails" title="Clique para expandir"><span class="glyphicon glyphicon-list more-infobutton"></span></a>
				</div>
				<div class="hover">
					<span class="glyphicon glyphicon-user user"></span>
					<span class="caret down"></span>
				</div>
				<div class="view">
					<div class="details">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" title="Esconder detalhes">×</button>
						<p class="info">
							<span class="title">Nome</span>
							<span class="text"><?php echo $util->get_session( 'nomePessoa' );?></span>
						</p>
						<p class="info">
							<span class="title">Cargo</span>
							<span class="text"><?php echo $util->get_session( 'descricaoCargo' );?></span>
						</p>
						<p class="info">
							<span class="title">E-mail</span>
							<span class="text"><?php echo $util->get_session( 'contatoPessoa' );?></span>
						</p>
						<p class="info">
							<span class="title">Site</span>
							<span class="text"><?=SITE_NAME?></span>
						</p>
						 <!-- <p class="info">
							<span class="title">Último logon</span>
							<span class="text"><span class="monit-date">09-08-2014</span>  --><!--Rodolpho, acho melhor ter isso aqui//</span>
						<!-- </p> --> 	
						<p class="info links">
							<span class="link"><a href="<?php echo APPOLO_ALTERAR_DADOS ;?>" title="Alterar os seus dados do appolo"><span class="glyphicon glyphicon-wrench a-icon"></span>Alterar dados</a></span>
							<span class="link"><a href="<?php echo APPOLO_ALTERAR_SENHA ;?>" title="Alterar a sua senha do appolo"><span class="glyphicon glyphicon-star-empty a-icon"></span>Alterar senha</a></span>
							<span class="link"><a href="<?php echo APPOLO_LOGOUT ;?>" class="Sair do appolo" title="Efetuar Logoff no appolo"><span class="glyphicon glyphicon-log-out a-icon"></span>Sair</a></span>
						</p>
					</div>
				</div>
				<?php } ?>
				<!--/USER DETAILS-->
			</div>
		</div>

	</div>
</div>

<?php
	if ( isset( $_GET['feature'] ) ) {
		if ( ( $_GET['feature'] == 'urls' ) ) {
?>
	<div class="backurls">
		<a class="text" href="<?php echo APPOLO_URLS?>"><span class="arrow">&lt;</span> <span class="title">URL's</span></a>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	</div>
	<script type="text/javascript"><!--
		$(function(){ appolo.util.backurl() ; } ) ;
	//--></script>
<?php
		}
	}
?>

<!--CONTAINER-->

<div id="content" class="container content">