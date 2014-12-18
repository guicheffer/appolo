<?php

	global $util ;
	global $appolo_gui ;

	if( ! $appolo_gui->render_item( "1" , "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
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

	$config_type = 'page' ;
	$config_id = $page ;
	$config_file = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'config' ) ;
	$config_user = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'user' ) ;
	$config_name = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'name' ) ;
	$currently_status = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'status' ) ;
	$currently_user = $util->get_session( 'idUsuario' ) ;
	$last_user_nicename = $util->get_nicename_user( $config_user ) ;

	//XML views ( appform, appcontent, apptmpl )
	$config_tmpl = $util->get_field_xml_config( $page_data[ 'caminhoXmlPagina' ], 'tmpl' ) ;

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
	
	//set warn
	if( ! file_exists( TMPLS_DIR . $config_tmpl ) ){
		$util->set_warn( 2 ) ;
	}

	//warn
	$warn = $util->get_session_and_clear( "warn" ) ;

	//title with section
	$title =  $page_name_for_title . " [template] -" . " Páginas - " . SITE_NAME . " - " . SYSTEM_NAME ;

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
	appolo.configs.pages.page.currently_section_parent = <?=( (int) $section )?> ;
	appolo.configs.pages.page.currently_section_parent_name = '<?=$section_name?>' ;
	appolo.configs.pages.page.currently_open_page = <?=( (int) $page )?> ;
	appolo.configs.pages.page.currently_open_page_name = '<?=$page_name_for_title?>' ;
	appolo.configs.pages.page.config_type = '<?=$config_type?>' ;
	appolo.configs.pages.page.config_id = '<?=$config_id?>' ;
	appolo.configs.pages.page.config_user = '<?=$config_user?>' ;
	appolo.configs.pages.page.config_tmpl = '<?=$config_tmpl?>' ;
	appolo.configs.pages.page.cancel_page_go_back = '<?=( CANCEL_PAGE_GO_BACK . $section )?>' ;
	appolo.configs.pages.page.last_user_nicename = '<?=$last_user_nicename ?>' ;
	appolo.configs.pages.page.datetimePublicacao = '<?=$datetimePublicacao ?>' ;
	appolo.configs.pages.page.editing_something = 'tmpl' ;
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

	<header>
		<div class="row">
			<h3>Template de "<?=$page_name_for_title?>"</h3>

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

		<form action="<?=( PAGE_CREATE_TMPL_SEND )?>" method="post" name="main-form_form" role="form">

			<input type="hidden" name="idPagina" value="<?=$page?>">

			<div class="row buttons_up">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_PAGE_GO_BACK . $page )?>" class="btn btn-default go-back">
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
				<textarea id="editing" type="tmpl" name="editing"><?php if( file_exists( TMPLS_DIR . $config_tmpl ) ){ $code = $util->write_xml_tmpl( $config_tmpl ) ; echo str_replace( "%}", "%/>", str_replace( "{%", "<%", $code ) ) ; }else{ ?><% for item in group_name %/>

	<b>Seu template: { { } }</b>

<% endfor %/>

<!--//--><?php } ?></textarea>
			</div>

			<div class="row buttons_down">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<a href="<?=( CANCEL_PAGE_GO_BACK . $page )?>" class="btn btn-default go-back">
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