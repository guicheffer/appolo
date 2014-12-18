<?php

	global $util ;
	global $appolo_gui ;

	if( ! $appolo_gui->render_item( "1" , "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
		exit ;
	}

	//session
	$session = "new tmpl" ;
	$section = ( ( isset( $section_id ) ) ? $section_id : "null" ) ;

	//page title
	$section_data = $util->get_section( $section )[0] ;
	$section_name_for_title = $section_data['nomeSecao'] ;
	if( $section_name_for_title == '' ){
		$util->set_warn( '4' ) ;
		$appolo_gui->go_to_this( SECTIONS_PAGES_URL ) ;
		exit ;
	}
	$new_name = $appolo_gui->encode_path( $section_name_for_title ) ;

	//page_data & section parent
	$section_data = $util->get_section( $section )[0] ;
	$this_is_hidden = 0 ;

	$config_type = 'page' ;
	$config_id = $section ;

	//XML views ( appform, appcontent, apptmpl )
	$config_tmpl = $util->get_field_xml_config( $section_data[ 'caminhoFisico' ], 'tmpl' ) ;
	
	//set warn
	if( ! file_exists( TMPLS_DIR . $config_tmpl ) ){
		$util->set_warn( 2 ) ;
	}

	//warn
	$warn = $util->get_session_and_clear( "warn" ) ;

	//title with section
	$title =  $section_name_for_title . " [template] -" . " Notícias - " . SITE_NAME . " - " . SYSTEM_NAME ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>

<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/lib/codemirror.css?<?=$util->get_querystring();?>">
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/theme/eclipse.css?<?=$util->get_querystring();?>">

<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/lib/codemirror.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/mode/xml/xml.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/mode/javascript/javascript.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/mode/css/css.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/codemirror/mode/overlay/overlay.js"></script>

<script type="text/javascript"><!--
	//configs pages page
	appolo.configs.news.set.currently_open_section = <?=( (int) $section )?> ;
	appolo.configs.news.set.currently_section_parent_name = '<?=$util->get_section_name( $section ) ;?>' ;
	appolo.configs.news.set.currently_open_page_name = '<?=$section_name_for_title?>' ;
	appolo.configs.news.default_filename = "<?=DEFAULT_FILENAME?>" ;

	//others
	appolo.configs.go_back_section = '<?=GO_BACK_SECTION?>' ;
	appolo.configs.news_url = '<?=NEWS_URL?>' ;
	appolo.configs.news_new_url = '<?=SECTIONS_NEWS_URL?>' ;
	appolo.configs.news_new_set_url = '<?=NEWS_NEW_SET_URL?>' ;
	appolo.configs.delete_pages_sections = '<?=DELETE_PAGES_SECTIONS?>' ;
	appolo.configs.select_news_sections = '<?=SELECT_NEWS_SECTIONS?>' ;
	appolo.configs.select_pages_section_last = '<?=SELECT_PAGES_SECTION_LAST?>' ;
	appolo.configs.insert_section = '<?=INSERT_SECTION?>' ;
	appolo.configs.insert_page = '<?=INSERT_PAGE?>' ;
	appolo.configs.edit_section = '<?=HASH_PAGE_EDIT_SECTION_URL?>' ;
	appolo.configs.edit_page = '<?=HASH_PAGE_EDIT_PAGE_URL?>' ;
	appolo.configs.section_properties = '<?=SECTION_PROPERTIES?>' ;
	appolo.configs.page_properties = '<?=PAGE_PROPERTIES?>' ;
	appolo.configs.select_section_url = '<?=SELECT_PAGES_SECTIONS_INDIVIDUAL?>' ;
	appolo.configs.select_page_url = '<?=SELECT_PAGES_PAGES_INDIVIDUAL?>' ;

	//gui
	appolo.gui.default_ext_config = '<?=str_replace(".", "", CONFS_EXTENSION ) ;?>' ;
	appolo.gui.default_ext_tmpl = '<?=str_replace(".", "", TMPLS_EXTENSION ) ;?>' ;
	appolo.gui.message_error_loading_sections = "<?=LOADING_MESSAGE_ERROR?>" ;
	appolo.gui.xml_to_json = '<?=XML_TO_JSON?>' ;
	appolo.gui.set_warn = '<?=SET_WARN?>' ;
//--></script>

</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
		<div class="row">
			<h3>Template de "<?=$section_name_for_title?>"</h3>

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

				case '2': #warning
					$appolo_gui->render_message( "warning", true, "<strong>Atenção: </strong> Este é um arquivo novo, favor atentar-se nas inclusões!", "animated fadeInRight" ) ;
				break;

				case '11': #danger
					$appolo_gui->render_message( "success", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" criado e salvo com sucesso!.", "animated fadeIn" ) ;
				break;

				case '12': #danger
					$appolo_gui->render_message( "info", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" salvo com sucesso!.", "animated fadeIn" ) ;
				break;
				
				default:
					# do nothing
				break;
			} ?>
		<?php } ?>
	</div>

	<div class="content-form-page">

		<form action="<?=( NEWS_CREATE_TMPL_SEND )?>" method="post" name="main-form_form" role="form">

			<input type="hidden" name="section_id" value="<?=$section?>">

			<div class="row buttons_up">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_NEWS_GO_BACK . $section )?>" class="btn btn-default go-back">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary save-file">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Salvar
						</button>
						<button type="submit" class="btn btn-success" name="close" value="true">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Salvar e fechar
						</button>
					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</div>

			<div class="row code-editing">
				<textarea id="editing" type="tmpl" name="editing"><?php if( file_exists( TMPLS_DIR . $config_tmpl ) ){ $code = $util->write_xml_tmpl( $config_tmpl ) ; echo str_replace( "%}", "%/>", str_replace( "{%", "<%", $code ) ) ; }else{ ?><p><u>Título</u>: {{titulo}}</p>

<p><i>Texto</i>: {{texto | raw}} <!--Encode "raw" para obter o HTML do texto//--></p>

<p><b>Seção</b>: {{section}}</p>

<!--//--><?php } ?></textarea>
			</div>

			<div class="row buttons_down">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_NEWS_GO_BACK . $section )?>" class="btn btn-default go-back">
							Cancelar
						</a>

						<button type="submit" class="btn btn-primary save-file">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Salvar
						</button>
						<button type="submit" class="btn btn-success" name="close" value="true">
							<span class="glyphicon glyphicon-floppy-disk icon"></span> Salvar e fechar
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