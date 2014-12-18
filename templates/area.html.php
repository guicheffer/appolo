	<?php

	global $util ;
	global $appolo_gui ;
	if( ! $appolo_gui->render_module( "4" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
	}

	$title = " Cargos - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "area" ;
	?>

	<?php require ( HEADER_TEMPLATE ) ; ?>

	<script type="text/javascript">
	jQuery(document).on('click', '.radio_tr', function() {
		validarSelecao();
	});

	var EDIT_AREA_ADMIN_URL = "<?php echo EDIT_AREA_ADMIN_URL; ?>";
	var DELETE_ADMIN_AREA = "<?php echo DELETE_ADMIN_AREA; ?>"


	function replaceContentInContainer(matchClass, content) {
		var elems = document.getElementsByTagName('*'), i;
		for (i in elems) {
			if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ')	> -1) {
				elems[i].className = content;
			}
		}
	}


	function validarSelecao(){
		var radio = document.getElementsByName('cargoCheck');
		var cont =0;
		var nomeCargo = "";	
		for(var i=0,l=radio.length;i<l;i++)
		{
			if(radio[i].checked)
			{
				cont++;
				nomeCargo= radio[i].value;			
			}
		}
		if(cont==1){
			replaceContentInContainer("btn btn-default view-checks disabled", "btn btn-default view-checks");   	 	
			replaceContentInContainer("btn btn-default hidden-phone del-checks disabled", "btn btn-default hidden-phone del-checks");	
			document.getElementById('nomeCargo').value = document.getElementById ( nomeCargo ).innerText;
		}		
		if(cont==0){
			replaceContentInContainer("btn btn-default view-checks", "btn btn-default view-checks disabled");   	 	
			replaceContentInContainer("btn btn-default hidden-phone del-checks", "btn btn-default hidden-phone del-checks disabled");
			document.getElementById('nomeCargo').value = "";
		}
	}

	function tratarAlteracao(){
		document.grid_area.action = EDIT_AREA_ADMIN_URL;
		document.grid_area.submit();
	}
	</script>

</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>
	<script type="text/javascript">
		appolo.configs.select_admin_area = '<?=SELECT_ADMIN_AREA?>' ;
		appolo.configs.new_admin_area = '<?=INSERT_ADMIN_AREA?>' ;
	</script>

	<header>
		<div class="row">
			<h3>Cargos </h3>

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
		}
		?>
	</div>
	<div class="content-areas">
		<form action="<?echo SELECT_ADMIN_AREA?>" method="post" name="grid_area">

				<ul class="pagination"></ul>
				<div class="center">						
					<input type="hidden" id="nomeCargo" name="nomeCargo">
					<table class="table table-hover table-condensed table-areas grid" data-limit-per-page="10">
						<thead>
							<tr>
								<th class="check"><!--ADMIN | CHECK--></th>
								<th class="id">Id</th>
								<th class="descricao">Descrição do Cargo</th>
							</tr>
						</thead>
						<tbody class="page page-1 active">
							<script type="text/javascript">
							var render_sections_area_loading = '<tr class="loading">' ;
							render_sections_area_loading += '<td colspan="6">' ;
							render_sections_area_loading += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
							render_sections_area_loading += '<p class="warn">Carregando...</p>' ;
							render_sections_area_loading += '</td>' ;
							render_sections_area_loading += '</tr>' ;

							var render_area_grid = '{{#items}}' ;
							render_area_grid += '<tr class="radio_tr">' ;
							render_area_grid += '<td class="check">' ;
							render_area_grid += '<input type="radio" class="radio" id="id{{idCargo}}" name="cargoCheck" value="{{idCargo}}"';
							render_area_grid += '</td>' ;
							render_area_grid += '<td>' ;
							render_area_grid += '{{idCargo}}' ;	
							render_area_grid += '</td>' ;
							render_area_grid += '<td id="{{idCargo}}">' ;
							render_area_grid += '{{descricaoCargo}}' ;	
							render_area_grid += '</td>' ;
							render_area_grid += '</tr>' ;
							render_area_grid += '{{/items}}' ;


							</script>	


						</tbody>
					</table>
				</div>
				<ul class="pagination"></ul>
			</div>
			<!--CONTROL-BUTTONS//-->
			<div class="control-buttons">
				<div class="controls form-actions">
					<?php
					if ($appolo_gui->render_item("4","2")){?>
					<button class ="btn btn-default view-checks disabled submit " onclick="tratarAlteracao()">
						<span class="glyphicon glyphicon-edit icon "> <text class="btn-Area">Alterar</text></span>
					</button>
					<?php } ?><?=$appolo_gui->render_button( HASH_ADMIN_NEW_AREA_URL, "btn btn-primary", "plus-sign", "Novo", "4", "1" );?>
				</div>
			</div>
			<!--/CONTROL-BUTTONS//-->
		</form>
	</div>	

	<!-- Modal New Area -->
	<?php
		if( $appolo_gui->render_item( "4", "1" ) ){
			include ( TEMPLATES_MODALS_DIRECTORY_DIRECT . 'modal_new_area.html.php' ) ;
		} 
	?>	
	 
	<!-- /Modal New Area -->
	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>
	<!--/FOOTER-->