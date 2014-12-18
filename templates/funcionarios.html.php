	<?php

	global $util ;
	global $appolo_gui ;
	if( ! $appolo_gui->render_module( "5" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}
	$title = " Funcionários - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "funcionarios" ;
	$cdStatus = "";
	if (isset($_POST["cdStatus_Busca"])) {
		$cdStatus = $_POST["cdStatus_Busca"];
	}

	?>

	<?php require ( HEADER_TEMPLATE ) ; ?>

	<script type="text/javascript">
	var EDIT_FUNCIONARIOS_ADMIN_URL = "<?php echo EDIT_FUNCIONARIOS_ADMIN_URL; ?>";
	var DELETE_ADMIN_FUNCIONARIOS = "<?php echo DELETE_ADMIN_FUNCIONARIOS; ?>"
	appolo.configs.select_admin_area = '<?=SELECT_ADMIN_AREA?>' ;
	function replaceContentInContainer(matchClass, content) {
		var elems = document.getElementsByTagName('*'), i;
		for (i in elems) {
			if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ')	> -1) {
				elems[i].className = content;
			}
		}
	}
	function validarSelecao(){
		var checkboxes = document.getElementsByName('funcionariosCheck[]');
		var cont =0;
		var listaIds = [];

		for(var i=0,l=checkboxes.length;i<l;i++)
		{
			if(checkboxes[i].checked)
			{
				cont++;
				listaIds.push(checkboxes[i].value) ;
			}
		}
		if(cont==1){
			replaceContentInContainer("btn btn-default view-checks disabled", "btn btn-default view-checks");   	 	
			replaceContentInContainer("btn btn-default hidden-phone del-checks disabled", "btn btn-default hidden-phone del-checks");	

		}
		if(cont>1){
			replaceContentInContainer("btn btn-default hidden-phone del-checks disabled", "btn btn-default hidden-phone del-checks");
			replaceContentInContainer("btn btn-default view-checks", "btn btn-default view-checks disabled");			
		}
		if(cont==0){
			replaceContentInContainer("btn btn-default view-checks", "btn btn-default view-checks disabled");   	 	
			replaceContentInContainer("btn btn-default hidden-phone del-checks", "btn btn-default hidden-phone del-checks disabled");
		}

	}

	function tratarAlteracao(){
		document.grid_funcionarios.action = EDIT_FUNCIONARIOS_ADMIN_URL;
		document.grid_funcionarios.submit();
	}
	function tratarExclusao(){
		document.grid_funcionarios.action = DELETE_ADMIN_FUNCIONARIOS;
		document.grid_funcionarios.submit();
	}


	$(document).ready(function() {
		$("#funcionarios_search_clear").click(function(){
			document.getElementById('nome_Busca').value="";
	  		document.getElementById('cdSexo_Busca').value="";
	  		document.getElementById('cdStatus_Busca').value="";
	  		document.getElementById('cdCargo_Busca').value="";
      		appolo.configs.funcionarios.funcionarios_search();
		});		  
		$("#funcionarios_search").click(function(){
      		appolo.configs.funcionarios.funcionarios_search();
		});	
		  
	});

	</script>

</head>

<body class="<?php echo $session?>">
	<script type="text/javascript"><!--
	appolo.configs.select_admin_funcionarios = '<?=SELECT_ADMIN_FUNCIONARIOS?>' ;
	//--></script>
	<?php require ( MASTHEAD_TEMPLATE ) ; ?>
	<header>
		<div class="row">
			<h3>Funcionários</h3>

			<ol class="breadcrumb"></ol>
		</div>	
	</header>
	<div class="row funcionarios-warn">
		<?php
		if(isset($_SESSION['idUsuario'])){
			$warn = $util->get_session_and_clear( 'warn' );
			if ( isset( $warn ) ) { 			
				$appolo_gui->getMsgError($warn);
			}
		}	
		?>
	</div>
	<form action="#" method="post" name="grid_funcionarios">
	<div class="div_search_bar">
		<div class="search_bar_title">Busca</div>
		<div class="search_bar_items">

			Nome <input type="text" class="form-control form-search form-search-name" id="nome_Busca" name="nome_Busca" maxlength="100" placeholder="Digite o Nome" >
			Sexo <select id="cdSexo_Busca" class="form-control form-search form-search-sex" name="cdSexo_Busca" >
					<option value=""></option>
					<option value="F">Feminino</option>
					<option value="M">Masculino</option>
				 </select>
			Status <select id="cdStatus_Busca"  class="form-control form-search form-search-status" name="cdStatus_Busca" >
					<option value=""></option>
					<option value="0">Inativo</option>
					<option value="1">Ativo</option>
				 </select>
			Cargo	 		 					
			<div class="cargo-select">
				
				 <script type="text/javascript">
					 var render_funcionarios_search_area =  '<select id="cdCargo_Busca" class="form-control form-search form-search-cargo" name="cdCargo_Busca" >';
						 render_funcionarios_search_area += '<option value=""></option>' ;
						 render_funcionarios_search_area += '{{#items}}' ;
						 render_funcionarios_search_area += '<option value="{{idCargo}}">{{descricaoCargo}}</option>' ;
						 render_funcionarios_search_area += '{{/items}}' ;
					 render_funcionarios_search_area += '</select>' ;
				 </script>
			</div>
			
			<div class="funcionarios_search_div">
				<button type="button" class ="btn btn-default funcionarios_search_button" id="funcionarios_search_clear"> 
					<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
				</button>
				<button type="button" class ="btn btn-default funcionarios_search_button" id="funcionarios_search"> 
					<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
				</button>				
	  		</div>		 
		</div>					
	</div>	
	<div class="content-funcionarios">		
			<div class="row-fluid section-gap animated fadeIn">
				<p class="title"><p>
				</div>
				<ul class="pagination"></ul>
				<div class="center">	
					<table class="table table-hover table-condensed table-funcionarios grid" data-limit-per-page="10">
						<thead>
							<tr>
								<th class="check"><!--ADMIN | CHECK--></th>
								<th class="nome">Nome</th>
								<th class="cpf">CPF</th>
								<th class="sexo">Sexo</th>
								<th class="dtNasc">Data Nascimento</th>
								<th class="cargo">Cargo</th>
								<th class="status">Status</th>
							</tr>
						</thead>
						<tbody class="page page-1 active">
							<script type="text/javascript">
							var render_sections_funcionarios_loading = '<tr class="loading">' ;
							render_sections_funcionarios_loading += '<td colspan="6">' ;
							render_sections_funcionarios_loading += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
							render_sections_funcionarios_loading += '<p class="warn">Carregando...</p>' ;
							render_sections_funcionarios_loading += '</td>' ;
							render_sections_funcionarios_loading += '</tr>' ;
							var render_funcionarios_grid = '{{#items}}' ;
							render_funcionarios_grid += '<tr>' ;
							render_funcionarios_grid += '<td class="checkfuncionarios">' ;
							render_funcionarios_grid += '<input type="checkbox" name="funcionariosCheck[]" value="{{cpf}}" onclick="validarSelecao()" class="checkbox_input"';
							render_funcionarios_grid += '</td>' ;
							render_funcionarios_grid += '<td class="nome">' ;
							render_funcionarios_grid += '{{nome}}' ;	
							render_funcionarios_grid += '</td>' ;
							render_funcionarios_grid += '<td class="cpf">' ;
							render_funcionarios_grid += '{{cpf}}' ;	
							render_funcionarios_grid += '</td>' ;
							render_funcionarios_grid += '<td class="sexo">' ;
							render_funcionarios_grid += '{{sexo}}' ;	
							render_funcionarios_grid += '</td>' ;
							render_funcionarios_grid += '<td class="dtNasc">' ;
							render_funcionarios_grid += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;		
							render_funcionarios_grid += '</td>' ;
							render_funcionarios_grid += '<td class="cargo">' ;
							render_funcionarios_grid += '{{cargo}}' ;	
							render_funcionarios_grid += '</td>' ;
							render_funcionarios_grid += '<td class="status">' ;
							render_funcionarios_grid += '{{status}}' ;	
							render_funcionarios_grid += '</td>' ;							
							render_funcionarios_grid += '</tr>' ;
							render_funcionarios_grid += '{{/items}}' ;
							</script>	


						</tbody>
					</table>
				</div>
				<ul class="pagination"></ul>
			</div>
			<!--CONTROL-BUTTONS//-->
			<div class="control-buttons">
				<div class="controls form-actions">


					<?=$appolo_gui->render_button_js( "", "btn btn-default view-checks disabled", "edit", "Alterar Funcionário", "5", "2", "tratarAlteracao()")
						?>
					<?=$appolo_gui->render_button_js( "", "btn btn-default hidden-phone del-checks disabled", "trash", "Desativar / Ativar Funcionário(s)", "5", "3", "tratarExclusao()" )
						?>
					<?=$appolo_gui->render_button( NEW_FUNCIONARIOS_ADMIN_URL, "btn btn-primary", "plus-sign", "Novo Funcionário", "5", "1" );?>
				</div> 
			</div>
			<!--/CONTROL-BUTTONS//-->
		</form>
	</div>	

	<!-- Modal New funcionarios -->
<!-- 	<?php include ( TEMPLATES_MODALS_DIRECTORY . 'modal_new_funcionarios.html.php' ) ; ?>
 -->	<!-- /Modal New funcionarios -->
	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>
	<!--/FOOTER-->