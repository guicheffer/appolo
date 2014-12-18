<?php

	global $util ;
	global $appolo_gui ;

	if( ! $appolo_gui->render_item( "2" , "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
		exit ;
	}

	//session
	$session = "new" ;
	$section = ( ( isset( $section_id ) ) ? $section_id : "null" ) ;
	$new = ( ( isset( $new_id ) ) ? $new_id : "null" ) ;
	$text = '' ;
	$titulo = '' ;

	//page title
	if( $new == 'null' ){
		$section_name_for_title = "Nova notícia" ;
	}else{
		$section_name_for_title = $util->get_news_new( $new )[0]['tituloPublicacao'] ;
		$text = $util->get_news_new( $new )[0]['textoPublicacao'] ;
		$titulo = $section_name_for_title ;
	}
	$new_name = $appolo_gui->encode_path( $section_name_for_title ) ;

	//section_data & section parent
	$section_data = $util->get_section( $section )[ 0 ] ;

	$config_type = 'page' ;
	$config_id = $section ;
	$currently_user = $util->get_session( 'idUsuario' ) ;

	//errors
	$error_config_form = 'false' ;
	$error_config_tmpls = 'false' ;
	$error_config_staging = 'false' ;
	$error_config_live = 'false' ;
	$error_config_preview = 'false' ;
	$breakpoint = false ;

	//XML views ( appform, appcontent, apptmpl )
	$config_file = $util->get_field_xml_config( $section_data[ 'caminhoFisico' ], 'config' ) ;
	//$config_form = 'guiatech_form.appform' ;
	$config_tmpls = $util->get_field_xml_config( $section_data[ 'caminhoFisico' ], 'tmpl' ) ;


	if( ! file_exists( TMPLS_DIR . $config_tmpls ) && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 8 ) ;
		$util->set_session( 'file_not_exists', $config_tmpls ) ;
		$error_config_tmpls = 'true' ;
		$util->set_session( 'page_error', $section ) ;
		$appolo_gui->go_to_this( SECTIONS_NEWS_URL . $section ) ;
		exit;
	}

	//warn
	$warn = $util->get_session_and_clear( "warn" ) ;

	//title with section
	$title =  $section_name_for_title . " -" . " Notícias - " . SITE_NAME . " - " . SYSTEM_NAME ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>

<script type="text/javascript"><!--
	//configs pages page
	appolo.configs.news.set.currently_open_section = <?=( (int) $section )?> ;
	appolo.configs.news.set.currently_section_parent_name = '<?=$util->get_section_name( $section ) ;?>' ;
	appolo.configs.news.set.currently_open_page_name = '<?=$section_name_for_title?>' ;
	appolo.configs.pages.page.config_type = '<?=$config_type?>' ;
	appolo.configs.pages.page.config_id = '<?=$config_id?>' ;
	appolo.configs.pages.page.config_file = '<?=$config_file?>' ;
	appolo.configs.pages.page.config_tmpls = '<?=$config_tmpls?>' ;
	appolo.configs.pages.page.cancel_page_go_back = '<?=( CANCEL_PAGE_GO_BACK . $section )?>' ;
	appolo.configs.pages.page.view_content = '<?="/templates" . TEMPLATES_CONFIGS_DIRECTORY . CONTENT_DIRECTORY?>' ;
	appolo.configs.pages.page.editing_something = false ;

	//others
	appolo.configs.go_back = '<?=GO_BACK_SECTION?>' ;
	appolo.configs.news_url = '<?=NEWS_URL?>' ;
	appolo.configs.news_new_url = '<?=SECTIONS_NEWS_URL?>' ;
	appolo.configs.news_new_set_url = '<?=NEWS_NEW_SET_URL?>' ;
	appolo.configs.delete_pages_sections = '<?=DELETE_PAGES_SECTIONS?>' ;
	appolo.configs.select_pages_section_last = '<?=SELECT_PAGES_SECTION_LAST?>' ;
	appolo.configs.select_section_url = '<?=SELECT_PAGES_SECTIONS_INDIVIDUAL?>' ;
	appolo.configs.select_page_url = '<?=SELECT_PAGES_PAGES_INDIVIDUAL?>' ;

	//gui
	appolo.gui.default_ext_config = '<?=str_replace(".", "", CONFS_EXTENSION ) ;?>' ;
	appolo.gui.default_ext_data = '<?=str_replace(".", "", CONTENT_EXTENSION ) ;?>' ;
	appolo.gui.default_ext_form = '<?=str_replace(".", "", FORMS_EXTENSION ) ;?>' ;
	appolo.gui.default_ext_tmpl = '<?=str_replace(".", "", TMPLS_EXTENSION ) ;?>' ;
	appolo.gui.message_error_loading_sections = "<?=LOADING_MESSAGE_ERROR?>" ;
	appolo.gui.xml_to_json = '<?=XML_TO_JSON?>' ;
	appolo.gui.set_warn = '<?=SET_WARN?>' ;
//--></script>

</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<div class="overlay"></div>
	<!--<div class="warningmsg-form"><strong><img src="/images/icon-loading.gif" alt="Carregando..."> Carregando dados do formulário...</strong></div>//-->

	<header>
		<div class="row">
			<h3><?=$section_name_for_title?></h3>

			<ol class="breadcrumb"></ol>
		</div>
	</header>

	<div class="row area-warn">
		<?php	if ( isset( $warn ) ) { ?>
			<!--The rest is in JavaScript!//-->
			<?php switch ( $warn ) {
				case '1': #danger
					$appolo_gui->render_message( "danger", true, "<strong>Atenção: </strong> Erro ao carregar o conteúdo.", "animated fadeInRight" ) ;
				break;

				case '2': #danger
					$appolo_gui->render_message( "danger", true, "Arquivo de configuração \"<b><i>" . CONFS_DIRECTORY . $config_file . "</i></b>\" não existe.", "animated fadeInRight" ) ;
				break;

				case '3': #warning
					$appolo_gui->render_message( "warning", true, "Arquivo de conteúdo \"<b><i>" . CONTENT_DIRECTORY . $config_data . "</i></b>\" não existe.", "animated fadeInRight" ) ;
				break;

				case '4': #danger
					$appolo_gui->render_message( "danger", true, "Arquivo de formulário \"<b><i>" . FORMS_DIRECTORY . $config_form . "</i></b>\" não existe.", "animated fadeInRight" ) ;
				break;

				case '5': #danger
					$appolo_gui->render_message( "danger", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $config_tmpls . "</i></b>\" não existe.", "animated fadeInRight" ) ;
				break;

				case '6': #warning
					$appolo_gui->render_message( "warning", true, "<strong>Atenção: </strong> Arquivo em staging não foi definido!", "animated fadeInRight" ) ;
				break;

				case '7': #warning
					$appolo_gui->render_message( "warning", true, "<strong>Atenção: </strong> Arquivo em live não foi definido!", "animated fadeInRight" ) ;
				break;

				case '8': #warning
					$appolo_gui->render_message( "warning", true, "<strong>Atenção: </strong> Arquivo de preview não foi definido!", "animated fadeInRight" ) ;
				break;

				case '9': #warning
					$appolo_gui->render_message( "info", true, "Notícia gravada com sucesso! <div class='btn-group pull-custom'><a target='_blank' href='" . $appolo_twig->get_site_view_staging() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $new . ".shtml" . "' class='btn btn-default'>Visualizar</a></div>", "animated fadeIn" ) ;
					echo "<script type='text/javascript'>" ;
						echo "appolo.configs.pages.page.open_preview = '" . $appolo_twig->get_site_view_staging() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" . $new . ".shtml" . "' ;" ;
					echo "</script>" ;
				break;
				
				default:
					# do nothing
				break;
			} ?>
		<?php } ?>
	</div>

	<div class="content-form-new">

		<form action="" method="post" name="main-new" role="form">

			<div class="row buttons_up">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_NEWS_GO_BACK . $section )?>" onclick="if( confirm('Deseja mesmo cancelar?')){ return true; }else{ return false; }" class="btn btn-default go-back">
							Cancelar
						</a>

						<button class="btn btn-warning btn-view-news" type="submit" value="view">
							<span class="glyphicon glyphicon-eye-open icon"></span> Visualizar
						</button>
						<button class="btn btn-primary hidden-phone btn-save-news" type="submit" style="margin-left: 5px;" value="save" name="publish-page">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Gravar
						</button>
						<?php if( $appolo_gui->render_item( "2" , "5" ) ){ ?>
						<button class="btn btn-success btn-publish-news" type="submit" value="publish" name="publish-page">
							<span class="glyphicon glyphicon-open icon"></span> Publicar
						</button>
						<?php } ?>

					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</div>

			<div class="row">

				<div class="main-new">
					<div class="form-group form-create-new">
						<input type="hidden" name="id" value="<?=$new?>">

						<!--TITULO-->
						<div class="control-group text">
							<label class="control-label not-null plusinfo" data-toggle="tooltip" data-placement="right" data-original-title="Campo obrigatório.">
								Título
							</label>
							<div class="controls">
								<input id="titulo-item-0" name="name" maxlength="200" value="<?=$titulo?>" data-realname="titulo" type="text" placeholder="Preencha o campo título" class="form-control">
							</div>
						</div>
						<!--/TITULO-->

						<hr>

						<!--TEXTO-->
						<div class="insert_html">
							<div class="control-group text" style="width: 75%; float: left; margin-bottom: 20px;">
								<label class="control-label not-null plusinfo" data-toggle="tooltip" data-placement="right" data-original-title="Campo obrigatório.">
									Texto
								</label>
								<div class="controls">
									<textarea rows="30" name="text" id="body_text" class="text-html html form-control" placeholder="Utilize HTML ou o texto puro para o preenchimento"><?=$text?></textarea>
								</div>
							</div>

							<div class="column left box_view hidden">
								<h4>Opções do texto</h4>
								<button class="btn btn-warning toggle see_html" style="margin-right: 2px;" type="button" data-toggle="button">Editar HTML</button>
							</div>
						</div>
						<!--/TEXTO-->

					</div>
				</div>

			</div>

			<div class="row buttons_down">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_NEWS_GO_BACK . $page )?>" onclick="if( confirm('Deseja mesmo cancelar?')){ return true; }else{ return false; }" class="btn btn-default go-back">
							Cancelar
						</a>

						<button class="btn btn-warning btn-view-news" type="submit" value="view">
							<span class="glyphicon glyphicon-eye-open icon"></span> Visualizar
						</button>
						<button class="btn btn-primary hidden-phone btn-save-news" type="submit" style="margin-left: 5px;" value="save" name="publish-page">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Gravar
						</button>
						<?php if( $appolo_gui->render_item( "2" , "5" ) ){ ?>
						<button class="btn btn-success btn-publish-news" type="submit" value="publish" name="publish-page">
							<span class="glyphicon glyphicon-open icon"></span> Publicar
						</button>
						<?php } ?>
					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</div>

		</form>

	</div>

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->