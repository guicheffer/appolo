<?php

	global $util ;
	global $appolo_gui ;

	if( ! $appolo_gui->render_module( "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}

	//session
	$session = "page" ;
	$page = ( ( isset( $page_id ) ) ? $page_id : "null" ) ;

	//page title
	$page_name_for_title = ( ( $page !== "null" ) ? ( $util->get_page_name( $page ) ) : "page" ) ;
	if( $page_name_for_title == '' ){
		$util->set_warn( '4' ) ;
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL ) ;
		exit ;
	}
	$page_name = $appolo_gui->encode_path( $page_name_for_title ) ;

	//page_data & section parent
	$page_data = $util->get_pages_page( $page )[ 0 ] ;
	$section = $page_data[ 'idSecao' ] ;
	$datetimePublicacao = $page_data[ 'datahoraPublicacao' ] ;
	$section_name = $util->get_section_name( $section ) ;
	$this_is_hidden = 0 ;

	if( $page_data[ 'paginaHidden' ] == 1){
		if( ! $appolo_gui->render_item( "1" , "1" ) ){
			$util->set_warn( '4' ) ;
			$appolo_gui->go_to_this( SECTIONS_PAGES_URL ) ;
			exit ;
		}else{
			$this_is_hidden = 1 ;
		}
	}

	$config_type = 'page' ;
	$config_id = $page ;
	$config_user = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'user' ) ;
	$config_name = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'name' ) ;
	$currently_status = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'status' ) ;
	$currently_user = $util->get_session( 'idUsuario' ) ;
	$only_view = ( ( ( $currently_status == 1 ) && ( $currently_user != $config_user ) ) ? 'true' : 'false' ) ;
	if( $appolo_gui->render_item( "1" , "1" ) ){
		$view_hidden = 1 ;
	}else{
		$view_hidden = 0 ;
	}
	
	$last_user_nicename = $util->get_nicename_user( $config_user ) ;

	//errors
	$error_config_file = 'false' ;
	$error_config_data = 'false' ;
	$error_config_form = 'false' ;
	$error_config_tmpls = 'false' ;
	$error_config_staging = 'false' ;
	$error_config_live = 'false' ;
	$error_config_preview = 'false' ;
	$breakpoint = false ;

	//XML views ( appform, appcontent, apptmpl )
	$config_file = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'config' ) ;
	$config_data = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'data' ) ;
	$config_form = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'form' ) ;
	$config_tmpls = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'tmpl' ) ;
	$config_staging = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'staging' ) ;
	$config_live = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'live' ) ;
	$config_preview = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'preview' ) ;
	$config_status = 1 ;

	//view file exists
	if( ! file_exists( CONFS_DIR . $config_file ) && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 6 ) ;
		$util->set_session( 'file_not_exists', $config_file ) ;
		$error_config_file = 'true' ;
		$util->set_session( 'page_error', $page ) ;
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
		exit;
	}
	if( ! file_exists( CONTENT_DIR . $config_data ) && ( ! $breakpoint ) ){
		//$util->save_xml_content( true, $config_type, $page, $config_data ) ;
		$error_config_data = 'true' ;
	}
	if( ! file_exists( FORMS_DIR . $config_form ) && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 7 ) ;
		$util->set_session( 'file_not_exists', $config_form ) ;
		$error_config_form = 'true' ;
		$util->set_session( 'page_error', $page ) ;
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
		exit;
	}
	if( ! file_exists( TMPLS_DIR . $config_tmpls ) && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 8 ) ;
		$util->set_session( 'file_not_exists', $config_tmpls ) ;
		$error_config_tmpls = 'true' ;
		$util->set_session( 'page_error', $page ) ;
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL . $section ) ;
		exit;
	}
	if( $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'staging' ) == '' && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 6 ) ;
		$error_config_staging = 'true' ;
	}
	if( $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'live' ) == '' && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 7 ) ;
		$error_config_live = 'true' ;
	}
	if( $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'preview' ) == '' && ( ! $breakpoint ) ){
		$breakpoint = true ;
		$util->set_warn( 8 ) ;
		$error_config_preview = 'true' ;
	}

	if( $only_view !== 'true' ){
		//save new one with status
		$util->save_xml_config( true, $config_id, $config_name, $config_file, $config_data, $config_form, $config_tmpls, $config_staging, $config_live, $config_preview, $config_type, $config_status ) ;	
	}

	//warn
	$warn = $util->get_session_and_clear( "warn" ) ;

	//title with section
	$title =  $page_name_for_title . " -" . " Páginas - " . SITE_NAME . " - " . SYSTEM_NAME ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>

<script type="text/javascript"><!--
	//configs pages page
	appolo.configs.pages.page.currently_section_parent = <?=( (int) $section )?> ;
	appolo.configs.pages.page.currently_section_parent_name = '<?=$section_name?>' ;
	appolo.configs.pages.page.currently_open_page = <?=( (int) $page )?> ;
	appolo.configs.pages.page.currently_open_page_name = '<?=$page_name_for_title?>' ;
	appolo.configs.pages.page.config_type = '<?=$config_type?>' ;
	appolo.configs.pages.page.config_id = '<?=$config_id?>' ;
	appolo.configs.pages.page.config_user = '<?=$config_user?>' ;
	appolo.configs.pages.page.config_name = '<?=$config_name?>' ;
	appolo.configs.pages.page.config_file = '<?=$config_file?>' ;
	appolo.configs.pages.page.config_data = '<?=$config_data?>' ;
	appolo.configs.pages.page.config_form = '<?=$config_form?>' ;
	appolo.configs.pages.page.config_tmpls = '<?=$config_tmpls?>' ;
	appolo.configs.pages.page.config_staging = '<?=$config_staging?>' ;
	appolo.configs.pages.page.config_live = '<?=$config_live?>' ;
	appolo.configs.pages.page.config_preview = '<?=$config_preview?>' ;
	appolo.configs.pages.page.config_status = '<?=$config_status?>' ;
	appolo.configs.pages.page.cancel_page_go_back = '<?=( CANCEL_PAGE_GO_BACK . $section )?>' ;
	appolo.configs.pages.page.last_user_nicename = '<?=$last_user_nicename ?>' ;
	appolo.configs.pages.page.datetimePublicacao = '<?=$datetimePublicacao ?>' ;
	appolo.configs.pages.page.data_form = <?= $util->write_content_page_data( $config_data ) ?> ;
	appolo.configs.pages.page.only_view = <?=$only_view ?> ;
	appolo.configs.pages.page.can_view_admin = <?=$appolo_gui->render_item( "1" , "1" ) ;?> ;
	appolo.configs.pages.page.view_content = '<?="/templates" . TEMPLATES_CONFIGS_DIRECTORY . CONTENT_DIRECTORY?>' ;
	appolo.configs.pages.page.error_config_file = <?=$error_config_file ?> ;
	appolo.configs.pages.page.error_config_data = <?=$error_config_data ?> ;
	appolo.configs.pages.page.error_config_form = <?=$error_config_form ?> ;
	appolo.configs.pages.page.error_config_tmpls = <?=$error_config_tmpls ?> ;
	appolo.configs.pages.page.error_config_staging = <?=$error_config_staging ?> ;
	appolo.configs.pages.page.error_config_live = <?=$error_config_live ?> ;
	appolo.configs.pages.page.error_config_preview = <?=$error_config_preview ?> ;
	appolo.configs.pages.page.editing_something = false ;
	appolo.configs.view_hidden = <?=$view_hidden?> ;
	appolo.configs.this_is_hidden = <?=$this_is_hidden?> ;

	//others
	appolo.configs.go_back = '<?=GO_BACK_SECTION?>' ;
	appolo.configs.pages_url = '<?=PAGES_URL?>' ;
	appolo.configs.pages_page_url = '<?=PAGES_PAGE_URL?>' ;
	appolo.configs.pages_sections_url = '<?=SECTIONS_PAGES_URL?>' ;
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
	<div class="warningmsg-form"><strong><img src="/images/icon-loading.gif" alt="Carregando..."> Carregando dados do formulário...</strong></div>

	<header>
		<div class="row">
			<h3><?=$page_name_for_title?></h3>

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
					$appolo_gui->render_message( "info", true, "Página gravada com sucesso! <div class='btn-group pull-custom'><a target='_blank' href='" . $appolo_twig->get_site_view_staging() . $config_preview . "' class='btn btn-default'>Visualizar</a></a>", "animated fadeIn" ) ;
					echo "<script type='text/javascript'>" ;
						echo "appolo.configs.pages.page.open_preview = '" . $appolo_twig->get_site_view_staging() . $config_preview . "' ;" ;
					echo "</script>" ;
				break;
				
				default:
					# do nothing
				break;
			} ?>
		<?php } ?>
	</div>

	<div class="content-form-page">

		<form action="<?=( PUBLISH_PAGE . $page )?>" method="post" name="main-form_form" role="form">

			<div class="row buttons_up">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_PAGE_GO_BACK . $page )?>" class="btn btn-default go-back">
							Cancelar
						</a>
						<?php if( $appolo_gui->render_item( "1" , "1" ) ){ ?>
						<div class="btn-group hidden-phone">
							<a href="/pages/page/<?=$page?>/form/" class="btn btn-default no-margin">Editar formulário</a>
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Outras opções</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/pages/page/<?=$page?>/tmpl/">Editar template</a></li>
							</ul>
						</div>
						<?php } ?>

						<button class="btn btn-warning" type="submit" value="view">
							<span class="glyphicon glyphicon-eye-open icon"></span> Visualizar
						</button>
						<button class="btn btn-primary hidden-phone" type="submit" style="margin-left: 5px;" value="save" name="publish-page">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Gravar
						</button>
						<button class="btn btn-success" type="submit" value="publish" name="publish-page">
							<span class="glyphicon glyphicon-open icon"></span> Publicar
						</button>

					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</div>

			<input type="hidden" name="section_back" value="<?=$section?>">

			<div class="row">

				<div class="main-form">
					<div id="inject" class="eject">
						<p class="msg-loading-form">Carregando... <img src="/images/icon-loading.gif" alt="Carregando..." class="breadcrumb-loading"></p>
					</div>
					<fieldset id="form-properties"><legend>Propriedades</legend></fieldset>
				</div>

				<div class="form-code">
					<?=$util->write_xml_form( $config_form ) ;?>
					<file><?=$config_form;?></file>
				</div>

			</div>

			<div class="row buttons_down">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_PAGE_GO_BACK . $page )?>" class="btn btn-default go-back">
							Cancelar
						</a>
						<?php if( $appolo_gui->render_item( "1" , "1" ) ){ ?>
						
						<div class="btn-group hidden-phone">
							<a href="/pages/page/<?=$page?>/form/" class="btn btn-default no-margin">Editar formulário</a>
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Outras opções</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/pages/page/<?=$page?>/tmpl/">Editar template</a></li>
							</ul>
						</div>
						<?php } ?>

						<button class="btn btn-warning" type="submit" value="view">
							<span class="glyphicon glyphicon-eye-open icon"></span> Visualizar
						</button>
						<button class="btn btn-primary hidden-phone" type="submit" style="margin-left: 5px;" value="save" name="publish-page">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Gravar
						</button>
						<button class="btn btn-success" type="submit" value="publish" name="publish-page">
							<span class="glyphicon glyphicon-open icon"></span> Publicar
						</button>
					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</div>

		</form>

	</div>

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->