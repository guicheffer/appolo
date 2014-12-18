<?php

	global $util ;
	global $appolo_gui ;
	global $appolo_twig ;

	if( ! $appolo_gui->render_module( "1" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
		exit ;
	}

	//session
	$session = "pages" ;

	$section = ( ( isset( $section_id ) ) ? $section_id : "null" ) ;
	$section_name_for_title = ( ( $section !== "null" ) ? ( $util->get_section_name( $section ) ) : "sections" ) ;
	$section_name = $appolo_gui->encode_path( $section_name_for_title ) ;
	$warn = $util->get_session_and_clear( "warn" ) ;
	$page_created = $util->get_session_and_clear( "page_created" ) ;
	$page_canceled = $util->get_session_and_clear( "page_canceled" ) ;
	$page_updated = $util->get_session_and_clear( "page_updated" ) ;
	$page_error = $util->get_session_and_clear( "page_error" ) ;
	$order = ( ( isset( $_GET[ 'order' ] ) ) ? strtolower( $_GET[ 'order' ] ) : "nome" ) ;
	$by = ( ( isset( $_GET[ 'by' ] ) ) ? strtoupper( $_GET[ 'by' ] ) : "ASC" ) ;
	$division_sections_pages = ( ( $order == 'data_criacao' || $order == 'data_atualizacao' ) ? 1 : "" ) ;
	if( $appolo_gui->render_item( "1" , "1" ) ){
		$view_hidden = 1 ;
	}else{
		$view_hidden = 0 ;
	}

	//title with section
	if( $section_name_for_title != 'sections' ){
		$title =  $section_name_for_title . " -" . " Páginas - " . SITE_NAME . " - " . SYSTEM_NAME ;
	}else{
		$title =  "Páginas - " . SITE_NAME . " - " . SYSTEM_NAME ;
	}

	//section_data & section parent
	if( $section != 'null' ){
		$section_data = $util->get_pages_section( $section )[ 0 ] ;

		if( $section_data[ 'secaoHidden' ] == 1){
			if( ! $appolo_gui->render_item( "1" , "1" ) ){
				$util->set_warn( '4' ) ;
				$appolo_gui->go_to_this( SECTIONS_PAGES_URL ) ;
				exit ;
			}
		}	
	}

	switch( $by ){
		case 'ASC':
			$by_inverse_click = "desc" ;
			$caret_span = '<span class="caret"></span>' ;
		break;
		case 'DESC':
			$by_inverse_click = "asc" ;
			$caret_span = '<span class="caret up"></span>' ;
		break;
		default:
			$by = 'ASC' ;
			$by_inverse_click = "desc" ;
			$caret_span = '<span class="caret"></span>' ;
		break;
	}

?>

<?php require ( HEADER_TEMPLATE ) ; ?>

<script type="text/javascript"><!--
	//configs pages
	appolo.configs.pages.currently_open_section = <?=( (int) $section )?> ;
	appolo.configs.pages.currently_open_section_name = '<?=$section_name_for_title?>' ;
	appolo.configs.pages.default_filename = "<?=DEFAULT_FILENAME?>" ;
	appolo.configs.pages.order = "<?=$order?>" ;
	appolo.configs.pages.by = "<?=$by?>" ;
	appolo.configs.pages.division_sections_pages = '<?=$division_sections_pages?>' ;
	appolo.configs.page_created = '<?=$page_created?>' ;
	appolo.configs.page_updated = '<?=$page_updated?>' ;
	appolo.configs.page_canceled = '<?=$page_canceled?>' ;
	appolo.configs.page_error = '<?=$page_error?>' ;
	appolo.configs.view_hidden = <?=$view_hidden?> ;
	appolo.configs.page_create_form = '<?=PAGE_CREATE_FORM?>' ;
	appolo.configs.page_create_tmpl = '<?=PAGE_CREATE_TMPL?>' ;

	//others
	appolo.configs.go_back_section = '<?=GO_BACK_SECTION?>' ;
	appolo.configs.pages_url = '<?=PAGES_URL?>' ;
	appolo.configs.pages_page_url = '<?=PAGES_PAGE_URL?>' ;
	appolo.configs.pages_sections_url = '<?=SECTIONS_PAGES_URL?>' ;
	appolo.configs.delete_pages_sections = '<?=DELETE_PAGES_SECTIONS?>' ;
	appolo.configs.select_pages_sections = '<?=SELECT_PAGES_SECTIONS?>' ;
	appolo.configs.select_pages_section_last = '<?=SELECT_PAGES_SECTION_LAST?>' ;
	appolo.configs.insert_section = '<?=INSERT_SECTION?>' ;
	appolo.configs.insert_page = '<?=INSERT_PAGE?>' ;
	appolo.configs.edit_section = '<?=HASH_PAGE_EDIT_SECTION_URL?>' ;
	appolo.configs.edit_page = '<?=HASH_PAGE_EDIT_PAGE_URL?>' ;
	appolo.configs.section_properties = '<?=SECTION_PROPERTIES?>' ;
	appolo.configs.page_properties = '<?=PAGE_PROPERTIES?>' ;
	appolo.configs.select_section_url = '<?=SELECT_PAGES_SECTIONS_INDIVIDUAL?>' ;
	appolo.configs.select_page_url = '<?=SELECT_PAGES_PAGES_INDIVIDUAL?>' ;
	appolo.configs.status_free = '<?=TEXT_STATUS_FREE?>' ;
	appolo.configs.status_open = '<?=TEXT_STATUS_OPEN?>' ;

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
			<h3>Páginas</h3>

			<ol class="breadcrumb"></ol>
		</div>
	</header>

	<div class="row area-warn">
		<?php	if ( isset( $warn ) ) { ?>
			<!--The rest is in JavaScript!//-->
			<?php switch ( $warn ) {
				case '1': #danger
					$appolo_gui->render_message( "danger", true, "O Item foi deletado!", "animated fadeInRight" ) ;
				break;

				case '2': #danger
					$appolo_gui->render_message( "danger", true, "Os Itens foram deletados!", "animated fadeInRight" ) ;
				break;

				case '3': #danger
					$appolo_gui->render_message( "danger", true, LOADING_MESSAGE_ERROR, "animated fadeInRight" ) ;
				break;

				case '4': #warning
					$appolo_gui->render_message( "warning", true, "Acesso Bloqueado. Você não tem acesso a esta área.", "animated fadeInRight" ) ;
				break;

				case '5': #warning
					$appolo_gui->render_message( "warning", true, "Alterações canceladas.", "animated fadeInRight" ) ;
				break;

				case '6': #warning
					$appolo_gui->render_message( "warning", true, "Arquivo de conteúdo \"<b><i>" . CONTENT_DIRECTORY . $util->get_session_and_clear( 'file_not_exists' ) . "</i></b>\" não existe. Favor contate os administradores.", "animated fadeInRight" ) ;
				break;

				case '7': #danger
					$appolo_gui->render_message( "danger", true, "Arquivo de formulário \"<b><i>" . FORMS_DIRECTORY . $util->get_session_and_clear( 'file_not_exists' ) . "</i></b>\" não existe. <div class='pull-custom edit-now'><a class='btn btn-default' href='" . ( str_replace( '-id-', $page_error, PAGE_CREATE_FORM ) ) . "'>Criar arquivo</a></div>", "animated fadeInRight" ) ;
				break;

				case '8': #danger
					$appolo_gui->render_message( "danger", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_not_exists' ) . "</i></b>\" não existe. <div class='pull-custom edit-now'><a class='btn btn-default' href='" . ( str_replace( '-id-', $page_error, PAGE_CREATE_TMPL ) ) . "'>Criar arquivo</a></div>", "animated fadeInRight" ) ;
				break;

				case '9': #danger
					$appolo_gui->render_message( "success", true, "Arquivo de formulário \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" criado e salvo com sucesso!. <div class='btn-group pull-custom edit-now'><a href='" . ( str_replace( '-id-', $page_created, PAGE_CREATE_FORM ) ) . "' class='btn btn-default'>Editar formulário</a><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'>Outras opções</span></button><ul class='dropdown-menu' role='menu'><li><a href='" . ( str_replace( '-id-', $page_created, PAGE_CREATE_TMPL ) ) . "'>Editar template</a></li></ul></div>", "animated fadeIn" ) ;
				break;

				case '10': #danger
					$appolo_gui->render_message( "info", true, "Arquivo de formulário \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" salvo com sucesso!. <div class='btn-group pull-custom edit-now'><a href='" . ( str_replace( '-id-', $page_updated, PAGE_CREATE_FORM ) ) . "' class='btn btn-default'>Editar formulário</a><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'>Outras opções</span></button><ul class='dropdown-menu' role='menu'><li><a href='" . ( str_replace( '-id-', $page_updated, PAGE_CREATE_TMPL ) ) . "'>Editar template</a></li></ul></div>", "animated fadeIn" ) ;
				break;

				case '11': #danger
					$appolo_gui->render_message( "success", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" criado e salvo com sucesso!. <div class='btn-group pull-custom edit-now'><a href='" . ( str_replace( '-id-', $page_created, PAGE_CREATE_TMPL ) ) . "' class='btn btn-default'>Editar template</a><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'>Outras opções</span></button><ul class='dropdown-menu' role='menu'><li><a href='" . ( str_replace( '-id-', $page_created, PAGE_CREATE_FORM ) ) . "'>Editar formulário</a></li></ul></div>", "animated fadeIn" ) ;
				break;

				case '12': #danger
					$appolo_gui->render_message( "info", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" salvo com sucesso!. <div class='btn-group pull-custom edit-now'><a href='" . ( str_replace( '-id-', $page_updated, PAGE_CREATE_TMPL ) ) . "' class='btn btn-default'>Editar template</a><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'>Outras opções</span></button><ul class='dropdown-menu' role='menu'><li><a href='" . ( str_replace( '-id-', $page_updated, PAGE_CREATE_FORM ) ) . "'>Editar formulário</a></li></ul></div>", "animated fadeIn" ) ;
				break;

				case '13': #danger
					$appolo_gui->render_message( "info", true, "Página gravada com sucesso! <div class='btn-group pull-custom'><a target='_blank' href='" . $util->get_session_and_clear( 'file_published' ) . "' class='btn btn-default'>Visualizar</a></div>", "animated fadeIn" ) ;
				break;

				case '14': #danger
					$appolo_gui->render_message( "success", true, "Página gravada e publicada com sucesso! <div class='btn-group pull-custom'><a target='_blank' href='" . $util->get_session_and_clear( 'file_published' ) . "' class='btn btn-default'>Visualizar</a></div>", "animated fadeIn" ) ;
				break;
				
				default:
					# do nothing
				break;
			} ?>
		<?php } ?>
	</div>

	<div class="content-sections">

		<form action="#" method="post" name="grid_pages_sections">

			<input type="hidden" name="section_back" value="<?=$section?>">

			<div class="row">

				<?php
					if( $section != 'null' ){
						if( $section_data[ 'secaoHidden' ] == 1){ ?>
							<p class="warn-secao-hidden"><span class="glyphicon glyphicon-arrow-right a-icon"></span><span>Atenção</span>: esta seção não está visível para os usuários.</p>
						<?php }
					}
				?>

				<div class="row-fluid section-gap animated fadeIn">
					<p class="title"><p>
				</div>

				<ul class="pagination"></ul>

				<table class="table table-hover table-condensed table-sections" data-limit-per-page="10">
					<thead>
						<tr>
							<?php if( $order == 'type' ) { ?>
								<th class="check"><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>"><?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="check"><a href="?order=type&amp;by=asc">#</a></th>
							<?php } ?>
							
							<?php if( $order == 'nome' ) { ?>
								<th class="name"><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>">Nome<?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="name"><a href="?order=nome&amp;by=asc">Nome</a></th>
							<?php } ?>
							
							<?php if( $order == 'data_criacao' ) { ?>
								<th class="date"><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>">Data de criação<?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="date"><a href="?order=data_criacao&amp;by=asc">Data de criação</a></th>
							<?php } ?>
							
							<?php if( $order == 'data_atualizacao' ) { ?>
								<th class="lastup"><span class="glyphicon glyphicon-open a-icon"></span><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>">Última atualização<?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="lastup"><span class="glyphicon glyphicon-open a-icon"></span><a href="?order=data_atualizacao&amp;by=asc">Última atualização</a></th>
							<?php } ?>
							
							<th class="who"><span class="a-icon">Usuário</span><span class="showask">?</span></th>
							<th class="status">Situação</th>
						</tr>
					</thead>
					<tbody class="back-section"></tbody>
					<tbody class="page page-1 active">
						<script type="text/javascript">
							var render_sections_pages_loading = '<tr class="loading">' ;
								render_sections_pages_loading += '<td colspan="6">' ;
									render_sections_pages_loading += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
									render_sections_pages_loading += '<p class="warn">Carregando...</p>' ;
								render_sections_pages_loading += '</td>' ;
							render_sections_pages_loading += '</tr>' ;

							var render_sections_pages_head = '{{#sections}}' ;
									render_sections_pages_head += '<tr class="levelup">' ;
									render_sections_pages_head += '<td></td>' ;
									render_sections_pages_head += '<td class="up"><a href="/pages/sections/{{idSecao}}" class="plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="Voltar para {{{nomeSecao}}}"><span class="glyphicon glyphicon-chevron-up up-icon"></span>{{nomeSecao}}</a></td>' ;
									render_sections_pages_head += '<td class="date"></td>' ;
									render_sections_pages_head += '<td class="lastup">{{{page}}}</td>' ;
									render_sections_pages_head += '<td class="who"></td>' ;
									render_sections_pages_head += '<td class="status"></td>' ;
								render_sections_pages_head += '</tr>' ;
							render_sections_pages_head += '{{/sections}}' ;

							var render_sections_pages_page = '<tr class="levelup animated fadeInRight indicator-{{icon}}">' ;
								render_sections_pages_page += '<td></td>' ;
								render_sections_pages_page += '<td class="up"><a href="#p-{{page}}"><span class="glyphicon glyphicon-hand-{{icon}} up-icon"></span>pág. {{page}}</a></td>' ;
								render_sections_pages_page += '<td class="date"></td>' ;
								render_sections_pages_page += '<td class="lastup"></td>' ;
								render_sections_pages_page += '<td class="who"></td>' ;
								render_sections_pages_page += '<td class="status"></td>' ;
							render_sections_pages_page += '</tr>' ;


							//grid!
							var render_sections_pages = '{{#sections}}' ;
								render_sections_pages += '<tr class="{{#created}}created{{/created}} {{#updated}}updated{{/updated}} {{#canceled}}canceled{{/canceled}} {{#error}}error{{/error}} tr-{{type}} {{#division_sections_pages}}division-sections{{/division_sections_pages}}">' ;
										render_sections_pages += '<td class="check {{type}}">' ;
											render_sections_pages += '<input type="checkbox" value="{{id_item}}" name="{{type}}[]" {{#updated}}checked="true"{{/updated}}>' ;
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="name">' ;
											render_sections_pages += '<a href="{{url_prefix}}{{id_item}}/" class="section-name {{#addclass}}{{class}} {{/addclass}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{desc_item}}">' ;
												render_sections_pages += '<span class="glyphicon glyphicon-{{icon_item}} a-icon"></span>{{name_item}}' ;
											render_sections_pages += '</a>' ;
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="date">' ;
											render_sections_pages += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="lastup">' ;
											render_sections_pages += '{{#section_dataPublicacao_min}}' ;
												render_sections_pages += '<span class="glyphicon glyphicon-eye-open a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataPublicacao_full}}"></span>{{section_dataPublicacao_min}}' ;
											render_sections_pages += '{{/section_dataPublicacao_min}}' ;
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="who">' ;
											//insert last update
											render_sections_pages += '{{#creator}}' ;
												render_sections_pages += '<span class="glyphicon glyphicon-user user-icon plusinfo" data-toggle="tooltip" data-placement="left" data-original-title="{{creator}}"></span>' ;
											render_sections_pages += '{{/creator}}' ;
											//insert last update - modify...
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="status">' ;
											//insert status pages
											render_sections_pages += '{{status}}' ;
											//insert status pages - modify...
										render_sections_pages += '</td>' ;
								render_sections_pages += '</tr>' ;
							render_sections_pages += '{{/sections}}' ;


							var render_sections_pages_none =  '<tr>' ;
								render_sections_pages_none += '<td></td>' ;
								render_sections_pages_none += '<td colspan="5" class="notexist text-danger"><span class="glyphicon glyphicon-pushpin icon"></span> Esta seção está vazia.</td>' ;
							render_sections_pages_none += '</tr>' ;

							var render_sections_pages_none_no_page_selected =  '<tr>' ;
								render_sections_pages_none_no_page_selected += '<td></td>' ;
								render_sections_pages_none_no_page_selected += '<td colspan="5" class="notexist text-danger"><span class="glyphicon glyphicon-pushpin icon"></span> Este site ainda não possui seções e páginas.</td>' ;
							render_sections_pages_none_no_page_selected += '</tr>' ;
						</script>
					</tbody>
				</table>
			
				<ul class="pagination"></ul>

			</div>

			<div class="row buttons_down">
				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<?=$appolo_gui->render_button( "", "btn btn-default disabled hidden-phone del-checks", "trash", "Remover", "1", "3" );?>
						<?=$appolo_gui->render_button( HASH_PAGE_EDIT_SECTION_URL, "btn btn-default disabled view-checks", "fullscreen", "Propriedades", "1", "2" );?>
						
						<?php if ( isset( $section_id ) ) {?>
							<?=$appolo_gui->render_button( HASH_PAGE_NEW_PAGE_URL, "btn btn-success", "share-alt", " Nova página", "1", "1" );?>
						<?php }?>

						<?=$appolo_gui->render_button( HASH_PAGE_NEW_SECTION_URL, "btn btn-primary", "share-alt", "Nova Seção", "1", "1" );?>
					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</div>

		</form>

	</div>

	<!-- Modal New Section -->
		<?php if( $appolo_gui->render_item( "1" , "1" ) ){
			include ( TEMPLATES_MODALS_DIRECTORY_DIRECT . 'modal_section.html.php' ) ;
		} ?>
	<!-- /Modal New Section -->

	<?php if ( isset( $section_id ) ) {?>
		<!-- Modal New Page -->
			<?php if( $appolo_gui->render_item( "1" , "1" ) ){
				include ( TEMPLATES_MODALS_DIRECTORY_DIRECT . 'modal_pages_page.html.php' ) ;
			} ?>
		<!-- /Modal New Page -->
	<?php }?>

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->