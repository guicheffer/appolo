<?php

	global $util ;
	global $appolo_gui ;
	global $appolo_twig ;

	if( ! $appolo_gui->render_module( "2" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
		exit ;
	}

	//session
	$session = "news" ;

	$section = ( ( isset( $section_id ) ) ? $section_id : "null" ) ;
	$section_name_for_title = ( ( $section !== "null" ) ? ( $util->get_section_name( $section ) ) : "sections" ) ;
	$section_name = $appolo_gui->encode_path( $section_name_for_title ) ;
	$warn = $util->get_session_and_clear( "warn" ) ;
	$page_error = $util->get_session_and_clear( "page_error" ) ;
	$news_created = $util->get_session_and_clear( "news_created" ) ;
	$news_canceled = $util->get_session_and_clear( "news_canceled" ) ;
	$news_updated = $util->get_session_and_clear( "news_updated" ) ;
	$news_error = $util->get_session_and_clear( "news_error" ) ;
	$order = ( ( isset( $_GET[ 'order' ] ) ) ? strtolower( $_GET[ 'order' ] ) : "nome" ) ;
	$by = ( ( isset( $_GET[ 'by' ] ) ) ? strtoupper( $_GET[ 'by' ] ) : "ASC" ) ;
	if( $appolo_gui->render_item( "1" , "1" ) ){
		$view_hidden = 1 ;
	}else{
		$view_hidden = 0 ;
	}

	//title with section
	if( $section_name_for_title != 'sections' ){
		$title =  $section_name_for_title . " -" . " Notícias - " . SITE_NAME . " - " . SYSTEM_NAME ;
	}else{
		$title =  "Notícias - " . SITE_NAME . " - " . SYSTEM_NAME ;
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
	appolo.configs.news.currently_open_section = <?=( (int) $section )?> ;
	appolo.configs.news.currently_open_section_name = '<?=$section_name_for_title?>' ;
	appolo.configs.pages.default_filename = "<?=DEFAULT_FILENAME?>" ;
	appolo.configs.news.order = "<?=$order?>" ;
	appolo.configs.news.by = "<?=$by?>" ;
	appolo.configs.view_hidden = <?=$view_hidden?> ;
	appolo.configs.page_create_form = '<?=PAGE_CREATE_FORM?>' ;
	appolo.configs.page_create_tmpl = '<?=PAGE_CREATE_TMPL?>' ;

	//others
	appolo.configs.go_back_section = '<?=GO_BACK_SECTION?>' ;
	appolo.configs.news_url = '<?=NEWS_URL?>' ;
	appolo.configs.news_new_url = '<?=SECTIONS_NEWS_URL?>' ;
	appolo.configs.news_created = '<?=$news_created?>' ;
	appolo.configs.news_updated = '<?=$news_updated?>' ;
	appolo.configs.news_canceled = '<?=$news_canceled?>' ;
	appolo.configs.news_error = '<?=$news_error?>' ;
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
			<h3>Notícias</h3>

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
					if( $appolo_gui->render_item( "1" , "1" ) ){
						$appolo_gui->render_message( "danger", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_not_exists' ) . "</i></b>\" não existe. <div class='pull-custom edit-now'><a class='btn btn-default' href='" . ( str_replace( '-id-', $page_error, NEWS_CREATE_TMPL ) ) . "'>Criar arquivo</a></div>", "animated fadeInRight" ) ;
					}else{
						$appolo_gui->render_message( "danger", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_not_exists' ) . "</i></b>\" não existe.", "animated fadeInRight" ) ;
					}
				break;

				case '9': #danger
					$appolo_gui->render_message( "success", true, "Arquivo de formulário \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" criado e salvo com sucesso!. <div class='btn-group pull-custom edit-now'><a href='" . ( str_replace( '-id-', $section_created, PAGE_CREATE_FORM ) ) . "' class='btn btn-default'>Editar formulário</a><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'>Outras opções</span></button><ul class='dropdown-menu' role='menu'><li><a href='" . ( str_replace( '-id-', $section_created, PAGE_CREATE_TMPL ) ) . "'>Editar template</a></li></ul></div>", "animated fadeIn" ) ;
				break;

				case '10': #danger
					$appolo_gui->render_message( "info", true, "Arquivo de formulário \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" salvo com sucesso!. <div class='btn-group pull-custom edit-now'><a href='" . ( str_replace( '-id-', $news_updated, PAGE_CREATE_FORM ) ) . "' class='btn btn-default'>Editar formulário</a><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'>Outras opções</span></button><ul class='dropdown-menu' role='menu'><li><a href='" . ( str_replace( '-id-', $news_updated, PAGE_CREATE_TMPL ) ) . "'>Editar template</a></li></ul></div>", "animated fadeIn" ) ;
				break;

				case '11': #danger
					$appolo_gui->render_message( "success", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" criado e salvo com sucesso!.", "animated fadeIn" ) ;
				break;

				case '12': #danger
					$appolo_gui->render_message( "info", true, "Arquivo de template \"<b><i>" . TMPLS_DIRECTORY . $util->get_session_and_clear( 'file_saved' ) . "</i></b>\" salvo com sucesso!.", "animated fadeIn" ) ;
				break;

				case '13': #danger
					$appolo_gui->render_message( "info", true, "Notícia atualizada com sucesso! <div class='btn-group pull-custom'><a target='_blank' href='" . $util->get_session_and_clear( 'file_published' ) . "' class='btn btn-default'>Visualizar</a></div>", "animated fadeIn" ) ;
				break;

				case '14': #danger
					$appolo_gui->render_message( "success", true, "Notícia atualizada e publicada com sucesso! <div class='btn-group pull-custom'><a target='_blank' href='" . $util->get_session_and_clear( 'file_published' ) . "' class='btn btn-default'>Visualizar</a></div>", "animated fadeIn" ) ;
				break;

				case '15': #danger
					$appolo_gui->render_message( "danger", true, "<b>Atenção!</b> A notícia está pendente para aprovação, não pode publicar neste momento.", "animated fadeIn" ) ;
				break;

				case '16': #danger
					$appolo_gui->render_message( "info", true, "Notícia foi aprovada!", "animated fadeIn" ) ;
				break;

				case '17': #danger
					$appolo_gui->render_message( "info", true, "Notícia foi reprovada!", "animated fadeIn" ) ;
				break;

				case '18': #danger
					$appolo_gui->render_message( "danger", true, "<b>Atenção!</b> Notícia está reprovada. Edite e/ou atualize analisando o conteúdo novamente.", "animated fadeIn" ) ;
				break;

				case '18': #danger
					$appolo_gui->render_message( "danger", true, "<b>Atenção!</b> Notícia acabou de ser inserida. Aguarde um aviso para encaminhamento de pendência.", "animated fadeIn" ) ;
				break;
				
				default:
					# do nothing
				break;
			} ?>
		<?php } ?>
	</div>

	<div class="content-sections">

		<form action="#" method="post" name="grid_news_sections">

			<input type="hidden" name="section_back" value="<?=$section?>">

			<div class="row">

				<?php
					if( $section != 'null' ){
						if( $section_data[ 'secaoHidden' ] == 1){ ?>
							<p class="warn-secao-hidden"><span class="glyphicon glyphicon-arrow-right a-icon"></span><span>Atenção</span>: esta seção não está visível para os usuários.</p>
						<?php }
					}
				?>

				<div class="row-fluid section-gap animated fadeIn" style="display: none;">
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
								<th class="name"><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>">Seção<?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="name"><a href="?order=nome&amp;by=asc">Seção</a></th>
							<?php } ?>

							<th class="status">Situação</th>
							
							<?php if( $order == 'data_criacao' ) { ?>
								<th class="date"><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>">Data de criação<?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="date"><a href="?order=data_criacao&amp;by=asc">Data de criação</a></th>
							<?php } ?>
							
							<?php if( $order == 'data_atualizacao' ) { ?>
								<th class="lastup"><span class="glyphicon glyphicon-open a-icon"></span><a href="?order=<?=$order?>&amp;by=<?=$by_inverse_click?>">Última atualização<?=( $caret_span )?></a></th>
							<?php }else{ ?>
								<th class="lastup"><span class="glyphicon glyphicon-open a-icon"></span><a href="?order=data_atualizacao&amp;by=asc">Última alteração</a></th>
							<?php } ?>
							
							<th class="who"><span class="a-icon">Usuário</span><span class="showask">?</span></th>
							<th class="options">Opções</th>
							<th class="view"><span class="glyphicon glyphicon-eye-open a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="Visualizar em staging"></span></th>
							<th class="url">URL</th>
							
						</tr>
					</thead>
					<tbody class="back-section"></tbody>
					<tbody class="page page-1 active">
						<script type="text/javascript">
							var render_sections_pages_loading = '<tr class="loading">' ;
								render_sections_pages_loading += '<td colspan="10">' ;
									render_sections_pages_loading += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
									render_sections_pages_loading += '<p class="warn">Carregando...</p>' ;
								render_sections_pages_loading += '</td>' ;
							render_sections_pages_loading += '</tr>' ;

							var render_sections_pages_head = '{{#sections}}' ;
									render_sections_pages_head += '<tr class="levelup">' ;
									render_sections_pages_head += '<td></td>' ;
									render_sections_pages_head += '<td class="up"><a href="/news/sections/{{idSecao}}" class="plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="Voltar para {{{nomeSecao}}}"><span class="glyphicon glyphicon-chevron-up up-icon"></span>{{nomeSecao}}</a></td>' ;
									render_sections_pages_head += '<td class="status"></td>' ;
									render_sections_pages_head += '<td class="date"></td>' ;
									render_sections_pages_head += '<td class="lastup">{{{page}}}</td>' ;
									render_sections_pages_head += '<td class="who"></td>' ;
									render_sections_pages_head += '<td class="options"></td>' ;
									render_sections_pages_head += '<td class="view"></td>' ;
									render_sections_pages_head += '<td class="url"></td>' ;
								render_sections_pages_head += '</tr>' ;
							render_sections_pages_head += '{{/sections}}' ;

							var render_sections_pages_page = '<tr class="levelup animated fadeInRight indicator-{{icon}}">' ;
								render_sections_pages_page += '<td></td>' ;
								render_sections_pages_page += '<td class="up"><a href="#p-{{page}}"><span class="glyphicon glyphicon-hand-{{icon}} up-icon"></span>pág. {{page}}</a></td>' ;
								render_sections_pages_page += '<td class="status"></td>' ;
								render_sections_pages_page += '<td class="date"></td>' ;
								render_sections_pages_page += '<td class="lastup"></td>' ;
								render_sections_pages_page += '<td class="who"></td>' ;
								render_sections_pages_page += '<td class="options"></td>' ;
								render_sections_pages_page += '<td class="view"></td>' ;
								render_sections_pages_page += '<td class="url"></td>' ;
							render_sections_pages_page += '</tr>' ;


							//grid!
							var render_sections_pages = '{{#sections}}' ;
								render_sections_pages += '<tr class="{{#created}}created{{/created}} {{#updated}}updated{{/updated}} {{#canceled}}canceled{{/canceled}} {{#error}}error{{/error}} tr-{{type}} {{#division_sections_pages}}division-sections{{/division_sections_pages}}">' ;
										render_sections_pages += '<td class="check {{type}}" style="vertical-align: middle;">' ;
											render_sections_pages += '<input type="checkbox" value="{{id_item}}" name="{{type}}[]" {{#updated}}checked="true"{{/updated}}>' ;
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="name" style="vertical-align: middle;">' ;
											render_sections_pages += '<a href="{{url_prefix}}{{id_item}}/" class="section-name {{#addclass}}{{class}} {{/addclass}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{desc_item}}">' ;
												render_sections_pages += '<span class="glyphicon glyphicon-{{icon_item}} a-icon"></span>{{name_item}}' ;
											render_sections_pages += '</a>' ;
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="status">' ;
											//insert status pages
											<?php if( isset( $section_id ) ){ ?>
												render_sections_pages += '<span class="label label-{{type_label}}">{{status_text}}</span>' ;
											<?php } ?>
											//insert status pages - modify...
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="date">' ;
											render_sections_pages += '{{#section_dataCriacao_min}}' ;
												render_sections_pages += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;
											render_sections_pages += '{{/section_dataCriacao_min}}' ;
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

										render_sections_pages += '<td class="options">' ;
											//insert options pages
											render_sections_pages += '{{#news}}' ;
												<?php if( isset( $section_id ) ){ ?>
													<?php if( $appolo_gui->render_item( "2" , "10" ) ){ ?>
														render_sections_pages += '<div class="dropdown">' ;
														  render_sections_pages += '<button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">' ;
														    render_sections_pages += 'Opções ' ;
														    render_sections_pages += '<span class="caret"></span>' ;
														  render_sections_pages += '</button>' ;
														  render_sections_pages += '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">' ;
														    render_sections_pages += '<li role="presentation"><a role="menuitem" tabindex="-1" href="/crud/action/<?=$section_id;?>/{{id_item}}/?action=approve"><span class="glyphicon glyphicon-ok a-icon"></span> Aprovar</a></li>' ;
														    render_sections_pages += '<li role="presentation"><a role="menuitem" tabindex="-1" href="/crud/action/<?=$section_id;?>/{{id_item}}/?action=disapprove"><span class="glyphicon glyphicon-remove a-icon"></span> Reprovar</a></li>' ;
														  render_sections_pages += '</ul>' ;
														render_sections_pages += '</div>' ;
													<?php } ?>
												<?php } ?>
											render_sections_pages += '{{/news}}' ;
											//insert options pages - modify...
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="view">' ;
											//insert last update
											render_sections_pages += '{{#creator}}' ;
												<?php
													$tmp_staging = '' ;
													$check_staging = '' ;
													if( $section != 'null' ){
														$tmp_staging = $appolo_twig->get_site_view_staging() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" ;
														//$check_staging = $appolo_twig->get_site_config_staging() //IT CAN'T RIGHT NOW ;/
													}
												?>
												render_sections_pages += '<a target="_blank" href="<?=$tmp_staging?>{{id_item}}.shtml"><span class="glyphicon glyphicon-link plusinfo" data-toggle="tooltip" data-placement="top" data-original-title="Abrir em staging"></span></a>' ;
											render_sections_pages += '{{/creator}}' ;
											//insert last update - modify...
										render_sections_pages += '</td>' ;

										render_sections_pages += '<td class="url">' ;
											//insert last update
											render_sections_pages += '{{#creator}}' ;
												<?php
													$tmp_prod = '' ;
													$check_prod = '' ;
													if( $section != 'null' ){
														$tmp_prod = $appolo_twig->get_site_view_prod() . $appolo_gui->encode_path( $util->get_section_name( $section ) ) . "/" ;
													}
												?>

												render_sections_pages += '<a target="_blank" href="<?=$tmp_prod?>{{id_item}}.shtml"><span class="glyphicon glyphicon-link plusinfo" data-toggle="tooltip" data-placement="top" data-original-title="Abrir original"></span></a>' ;
											render_sections_pages += '{{/creator}}' ;
											//insert last update - modify...
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

						<?php if( $appolo_gui->render_item( "1" , "1" ) && isset( $section_id ) ){ ?>
							<?=$appolo_gui->render_button( '/news/new/' . $section_id . '/tmpl/', "btn btn-info", "edit-template", "<span class='glyphicon glyphicon-pencil icon'></span> Editar template da seção", "1", "1" );?>
						<?php } ?>

						<?php if( ! isset( $section_id ) ) { ?>
							<?=$appolo_gui->render_button( HASH_PAGE_EDIT_SECTION_URL, "btn btn-default disabled view-checks", "fullscreen", "Propriedades", "1", "2" );?>
						<?php }else{ ?>
							<?=$appolo_gui->render_button( ( SECTIONS_NEWS_URL . $section_id . '/set/' ), "btn btn-success", "share-alt", " Nova notícia", "1", "1" );?>
						<?php } ?>

						<?php if( ! isset( $section_id ) ) { ?>
							<?=$appolo_gui->render_button( HASH_PAGE_NEW_SECTION_URL, "btn btn-primary", "share-alt", "Nova Seção", "1", "1" );?>
						<?php } ?>
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

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->