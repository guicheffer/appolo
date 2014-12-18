	<?php

	global $util ;
	global $appolo_gui ;
	
	if( ! $appolo_gui->render_module( "7" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( APPOLO_DASHBOARD ) ;
		exit ;
	}
	$title = " Imagens - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "imagens" ;	
	?>

	<?php require ( HEADER_TEMPLATE ) ; ?>

	<script type="text/javascript">
		appolo.configs.select_imagens_secao = '<?=SELECT_IMAGENS_SECAO?>' ;
		appolo.configs.image_section_url = '<?=IMAGES_URL?>' 
		$(document).ready(function() {
		$("#usuarios_search_clear").click(function(){
			$('#nome_secao').val("");
			$('#descricao_secao').val("");
      		appolo.configs.imagens.imagens_search();
		});	
		$("#usuarios_search").click(function(){
      		appolo.configs.imagens.imagens_search();
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
					Nome da Seção
					<input type="text" class="form-control form-search search_nomePessoa" id="nome_secao" name="nome_secao" maxlength="100" placeholder="Digite o Nome da Seção" >
					Descrição
					<input type="text" class="form-control form-search search_nomeUsuario" id="descricao_secao" name="descricao_secao" maxlength="100" placeholder="Digite a Descrição" >						 
				</div>
				<div class="usuarios_search_div form-search">
					<button type="button" class ="btn btn-default usuarios_search_button" id="usuarios_search_clear"> 
						<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
					</button>
					<button type="button" class ="btn btn-default usuarios_search_button" id="usuarios_search"> 
						<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
					</button>				
				</div>
			</div>
	<div class="content-imagens">		
			<div class="row-fluid section-gap animated fadeIn">
				<p class="title"><p>
				</div>
				<ul class="pagination"></ul>
				<div >	
					<table class="table table-hover table-condensed table-imagens grid" data-limit-per-page="10">
						<thead>
							<tr>
								<th class="nome">Nome Secao</th>
								<th class="descricao ">Descrição</th>
								<th class="data right">Data de Criação</th>								
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

								var render_imagens_secao = '{{#items}}' ;
								render_imagens_secao += '<tr>' ;
								render_imagens_secao += '<td class="nome">' ;
								render_imagens_secao += '<a href="{{url_prefix}}{{id_item}}/" class="section-name " data-toggle="tooltip" data-placement="bottom" >';
								render_imagens_secao += '<span class="glyphicon glyphicon-folder-open up-icon"></span>{{nomeSecao}}' ;	
								render_imagens_secao += '</a>' ;
								render_imagens_secao += '</td>' ;
								render_imagens_secao += '<td class="descricao ">' ;
								render_imagens_secao += '{{descricaoSecao}}' ;	
								render_imagens_secao += '</td>' ;
								render_imagens_secao += '<td class="data right">' ;
								render_imagens_secao += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;	
								render_imagens_secao += '</td>' ;													
								render_imagens_secao += '</tr>' ;
								render_imagens_secao += '{{/items}}' ;
							
							</script>	


						</tbody>
					</table>
				</div>
				<ul class="pagination"></ul>
			</div>
		</form>
	</div>	


	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>
	<!--/FOOTER-->