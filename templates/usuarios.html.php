	<?php

	global $util ;
	global $appolo_gui ;
	if( ! $appolo_gui->render_module( "6" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}
	$title = " Usuários - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "usuarios" ;
	?>

	<?php require ( HEADER_TEMPLATE ) ; ?>

	<script type="text/javascript">
	var ADMIN_EDIT_USERS_URL = "<?php echo ADMIN_EDIT_USERS_URL; ?>";
	function tratarAlteracao(){
		document.usuario.action = ADMIN_EDIT_USERS_URL;
		document.usuario.submit();
	}
	function replaceContentInContainer(matchClass, content) {
		var elems = document.getElementsByTagName('*'), i;
		for (i in elems) {
			if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ')	> -1) {
				elems[i].className = content;
			}
		}
	}
	function validarSelecao(){
		var radio = document.getElementsByName('usuariosCheck[]');
		var cont =0;
		var listaIds = [];
		console.log("radio");
		for(var i=0,l=radio.length;i<l;i++)
		{
			if(radio[i].checked)
			{
				cont++;
				listaIds.push(radio[i].value) ;
			}
		}
		if(cont==1){
			replaceContentInContainer("btn btn-default disabled", "btn btn-default");   	 	
		}
		
		if(cont==0){
			replaceContentInContainer("btn btn-default", "btn btn-default disabled");   	 	
		}

	}

	$(document).ready(function() {
		$("#usuarios_search_clear").click(function(){
			$('#nome_Pessoa').val("");
			$('#nome_Usuario').val("");
			$('#cdStatus_Busca').val("");
      		appolo.configs.usuarios.usuarios_search();
		});		  
	});
	$(document).ready(function() {
		$("#usuarios_search").click(function(){
      		appolo.configs.usuarios.usuarios_search();
		});		  
	});
	jQuery(document).on('click', '.radio_user', function() {
		validarSelecao();
	});
	</script>

</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>
	<script type="text/javascript">
	appolo.configs.select_admin_usuarios = '<?=SELECT_ADMIN_USUARIOS?>' ;
	appolo.configs.new_admin_user = '<?=INSERT_ADMIN_USUARIOS?>' ;
	appolo.configs.select_admin_funcionarios_NoUser = '<?=SELECT_ADMIN_FUNCIONARIOS_NOUSER?>';
	</script>

	<header>
		<div class="row">
			<h3>Usuários </h3>

			<ol class="breadcrumb"></ol>
		</div>
	</header>
	<div class="row area-warn">
		<?php
		if(isset($_SESSION['idUsuario'])){
			$warn = $util->get_session_and_clear( 'warn' );
			if ( isset( $warn ) ) { 			
				$appolo_gui->getMsgError($warn);
			}
		} ?>
	</div>
	<div class="content-usuarios">
		<form action="#" method="post" name="usuario">
			<div class="div_search_bar">
				<div class="search_bar_title">Busca</div>
				<div class="search_bar_items">
					Nome do Funcionário
					<input type="text" class="form-control form-search search_nomePessoa" id="nome_Pessoa" name="nome_Pessoa" maxlength="100" placeholder="Digite o Nome do Funcionário" >
					Nome de Usuário
					<input type="text" class="form-control form-search search_nomeUsuario" id="nome_Usuario" name="nome_Usuario" maxlength="100" placeholder="Digite o Nome de Usuário" >
					Status 
					<select id="cdStatus_Busca"  class="form-control form-search search_status" name="cdStatus_Busca" >
						<option value=""></option>
						<option value="0">Inativo</option>
						<option value="1">Ativo</option>
					</select>
				
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
	<div class="row-fluid section-gap animated fadeIn">
		<p class="title"><p>
		</div>
		<ul class="pagination"></ul>
		<div >						
			<input type="hidden" id="nomeCargo" name="nomeCargo">
			<table class="table table-hover table-condensed table-usuarios grid" data-limit-per-page="10">
				<thead>
					<tr>
						<th class="check"><!--ADMIN | CHECK--></th>
						<th class="nomeUsuario">Nome de Usuário</th>
						<th class="nomeFuncionario">Nome Funcionário</th>
						<th class="dtCriacao">Data de Criação do usuário</th>
						<th class="tr-left">Status</th>
					</tr>
				</thead>
				<tbody class="page page-1 active">
					<script type="text/javascript">
					var render_sections_usuarios_loading  = '<tr class="loading">' ;
					render_sections_usuarios_loading  += '<td colspan="6">' ;
					render_sections_usuarios_loading  += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
					render_sections_usuarios_loading  += '<p class="warn">Carregando...</p>' ;
					render_sections_usuarios_loading  += '</td>' ;
					render_sections_usuarios_loading  += '</tr>' ;

					var render_usuarios_grid = '{{#items}}' ;
					render_usuarios_grid += '<tr class="radio_user">' ;
					render_usuarios_grid += '<td class="center">' ;
					render_usuarios_grid += '<input type="radio" name="usuariosCheck[]" value="{{cpfPessoa}}" > ';
					render_usuarios_grid += '</td>' ;							
					render_usuarios_grid += '<td class="">' ;
					render_usuarios_grid += '{{nomeusuario}}' ;	
					render_usuarios_grid += '</td>' ;
					render_usuarios_grid += '<td>' ;
					render_usuarios_grid += '{{nomePessoa}}' ;	
					render_usuarios_grid += '</td>' ;
					render_usuarios_grid += '<td>' ;
					render_usuarios_grid += '{{datacriacao}}' ;	
					render_usuarios_grid += '</td>' ;
					render_usuarios_grid += '<td>' ;
					render_usuarios_grid += '{{status}}' ;	
					render_usuarios_grid += '</td>' ;
					render_usuarios_grid += '</tr>' ;
					render_usuarios_grid += '{{/items}}' ;

					</script>	


				</tbody>
			</table>
		</div>
		<ul class="pagination"></ul>
	</div>
	<!--CONTROL-BUTTONS//-->
	<div class="control-buttons">
		<div class="controls form-actions">
			<button type="reset" class="btn-xs btn-danger hidden">Limpar dados</button>
			<?=$appolo_gui->render_button_js( "", "btn btn-default disabled", "pencil", "Alterar Usuário", "6", "2", "tratarAlteracao()" );?>
			<?=$appolo_gui->render_button( HASH_ADMIN_NEW_USERS_URL	, "btn btn-primary", "plus-sign", "Cadastrar Novo Usuário", "6", "1" );?>
		</div>
	</div>
	<!--/CONTROL-BUTTONS//-->
</form>
</div>	

<!-- Modal New Area -->
	<?php
		if( $appolo_gui->render_item( "6", "1" ) ){
			include ( TEMPLATES_MODALS_DIRECTORY_DIRECT . 'modal_new_user.html.php' ) ; 
		}
	?>
<!-- /Modal New Area -->
<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
	<!--/FOOTER-->