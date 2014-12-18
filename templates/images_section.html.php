	<?php

	global $util ;
	global $appolo_gui ;
	if( ! $appolo_gui->render_module( "7" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}
	$title = " Imagens - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "galeria_imagem" ;
	$aux =  $appolo_gui->render_item( "7", "2" ); 
	?>

	<?php require ( HEADER_TEMPLATE ) ; ?>

	<script type="text/javascript">
		appolo.configs.select_imagens_secao = '<?=SELECT_IMAGENS_SECAO?>' ;
		appolo.configs.select_imagens = '<?=SELECT_IMAGENS?>' ;
		appolo.configs.image_section_url = '<?=IMAGES_URL?>' ;
		appolo.configs.image_update_url = '<?=UPDATE_IMAGE_URL?>' ;
		appolo.configs.new_insert_image = '<?=INSERT_IMAGE?>';
		idSite = '<?= $util->get_session( "idSite" )?>';
		nomeSite = '<?= $util->get_session( "nomeSite" )?>';
		path = '<?= $GLOBALS["dir_images"] ?>';
		section ="<?php echo $section_id ?>";
		aux = "<?php echo $aux ?>";
		if(aux){
			buttonUpdate = '<a href="#image_update-{{idImagem}}" class="btn btn-warning"><span class="glyphicon glyphicon-edit icon"></span> Alterar Imagem </a>';
		}
		else{
			buttonUpdate = '';
		}
		$(document).ready(function() {
		$("#usuarios_search_clear").click(function(){
			$('#tag_img').val("");
			$('#descricao_img').val("");
			$('#name_img').val("");
      		appolo.configs.imagens.galeria_imagem_search();
		});	
		$("#usuarios_search").click(function(){
      		appolo.configs.imagens.galeria_imagem_search();
		});


	});

	</script>

</head>

<body class="<?php echo $session?>">
	<script type="text/javascript"><!--
	
	</script>
	<?php require ( MASTHEAD_TEMPLATE ) ; ?>
	<header>
		<div class="row">
			<h3>Imagens</h3>

			<ol class="breadcrumb"></ol>
		</div>	
	</header>
	<div class="row imagens-warn">
		<?php
		if(isset($_SESSION['idUsuario'])){
			$warn = $util->get_session_and_clear( 'warn' );
			if ( isset( $warn ) ) { 			
				$appolo_gui->getMsgError($warn);
			}
		}	
		?>
	</div>
	<form action="#" method="post" name="grid_imagens">
	<div class="div_search_bar">
				<div class="search_bar_title">Busca</div>
				<div class="search_bar_items">
					Nome
					<input type="text" class="form-control form-search search_nomePessoa" id="name_img" name="name_img" maxlength="100" placeholder="Digite o Nome" >
					Tag
					<input type="text" class="form-control form-search search_nomePessoa" id="tag_img" name="tag_img" maxlength="100" placeholder="Digite uma Tag" >
					Descrição
					<input type="text" class="form-control form-search search_nomeUsuario" id="descricao_img" name="descricao_img" maxlength="100" placeholder="Digite a Descrição" >
					<div class="usuarios_search_div form-search">
					<button type="button" class ="btn btn-default usuarios_search_button" id="usuarios_search_clear"> 
								<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
						</button>
						<button type="button" class ="btn btn-default usuarios_search_button" id="usuarios_search"> 
							<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
						</button>				
					</div>		 
				</div>
	</div>
	<input type="hidden" id="section" name="section" value="<?php echo $section_id ?>">
	<div class="content-imagens">		
			<div class="row-fluid section-gap animated fadeIn">
				<p class="title"><p>
				</div>
				<ul class="pagination"></ul>
				<div >	

					<table class="table table-hover table-condensed table-imagens grid" data-limit-per-page="3">
						<thead>
							<tr>
								<th>Imagem</th>
								<th class="nomeTr">Nome</th>
								<th class="descTr">Descrição</th>
								<th>Tags</th>
								<th class="center">Link</th>
								<th class="center">Status</th>
								<th></th>
							</tr>
						</thead>	
						<tbody class="page page-1 active">

							<script type="text/javascript">

								var render_sections_imagens_loading = '<tr class="loading">' ;
								render_sections_imagens_loading += '<td colspan="6">' ;
								render_sections_imagens_loading += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
								render_sections_imagens_loading += '<p class="warn">Carregando...</p>' ;
								render_sections_imagens_loading += '</td>' ;
								render_sections_imagens_loading += '</tr>' ;
										
								var render_imagens = '{{#items}}' ;
								render_imagens += '<tr>' ;
								render_imagens += '<td class="img_view">' ;
								render_imagens += '<a class="images_galery" href="javaScript:0;" title="{{nomeImagem}}" caption="{{descricaoImagem}}" >';
								render_imagens += '<img class="img" src="{{caminhoImagem}}" href="{{caminhoImagem}}" title="{{nomeImagem}}" alt="{{descricaoImagem}}" onclick="return appolo.configs.imagens.showImage(this)" /></a>' ;	
								render_imagens += '</td>' ;																			
								render_imagens += '<td  class="line" >{{nomeImagem}}' ;
								render_imagens += '</td>' ;
								render_imagens += '<td  class="line" >{{descricaoImagem}}' ;
								render_imagens += '</td>' ;
								render_imagens += '<td  class="line link center" ><span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{tagImagem}}"></span>' ;
								render_imagens += '</td>' ;
								render_imagens += '<td  class="line link center ">' ;
								render_imagens += '{{^imgAtiva}}'
								render_imagens += '<span class="glyphicon glyphicon-remove up-icon black"></span>' ;		
								render_imagens += '{{/imgAtiva}}'							
								render_imagens += '{{#imgAtiva}}'
								render_imagens += '<a  href="{{caminhoImagemNoBuster}}" target="_blank">' ;	
								render_imagens += '<span class="glyphicon glyphicon-picture up-icon black"></span></a>' ;	
								render_imagens += '{{/imgAtiva}}'
								render_imagens += '</td>' ;	
								render_imagens += '</td>' ;																			
								render_imagens += '<td  class="line" >{{statusImg}}' ;
								render_imagens += '</td>'
								render_imagens += '<td  class="line link center">' ;
								render_imagens += buttonUpdate ;
								render_imagens += '</td>' ;	
								render_imagens += '</tr>' ;
								render_imagens += '{{/items}}' ;

					
							</script>	
						</tbody>
					</table>
					<ul class="pagination"></ul>
				</div>
				
			</div>
			<!--CONTROL-BUTTONS//-->
			<div class="control-buttons buttons_galeria">
				<div class="controls form-actions right">
					<?=$appolo_gui->render_button( HASH_ADMIN_NEW_IMAGE_URL, "btn btn-primary", "plus-sign", "Nova Imagem", "7", "1" );?>
				</div>
			</div>

			<!--/CONTROL-BUTTONS//-->
		</form>
	</div>	

	<!-- Modal New Image -->

	<?php
		if( $appolo_gui->render_item( "7", "1" ) ){
			include ( TEMPLATES_MODALS_DIRECTORY_DIRECT . 'modal_new_image.html.php' );
		} 
	?>	

	<?php
		if( $appolo_gui->render_item( "7", "2" ) ){
			include ( TEMPLATES_MODALS_DIRECTORY_DIRECT . 'modal_update_image.html.php' );
		} 
	?>	
	 
	<!-- /Modal New Image -->
	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>

	<!--/FOOTER-->