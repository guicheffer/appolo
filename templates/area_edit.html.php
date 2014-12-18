<?php

global $util ;
global $appolo_gui ;
if( ! $appolo_gui->render_item( "4" , "2" ) ){
		$util->set_warn( '16' ) ;
		$appolo_gui->go_to_this( INDEX_URL ) ;
		exit ;
}
$title = " Alterar Cargos - " . SITE_NAME . " - " . SYSTEM_NAME ;
$session = "area_edit" ;
?>

<?php require ( HEADER_TEMPLATE ) ; ?>
<script type="text/javascript">


$(document).on( 'change', ':checkbox', function (event) { 
	var trAcoes = $("."+event.target.id);
	if($("#"+event.target.id).is(":checked")){
		trAcoes.find(':checkbox').each (function() {
  			this.disabled = false;              
	 	});
	}
	else{
		trAcoes.find(':checkbox').each (function() {
  			this.disabled = true;  
  			this.checked = false;            
	 	});
	}
});
$(document).submit(function( event ) {
  
  var $this=$(this);
  var breakpoint = false;
  var form  = $( 'form[name=grid_area]' ) ;
  if( form.find( '.not-null' ).length ){ 
  	breakpoint = appolo.util.treat_not_null( form, breakpoint ) ;
  } 
  if(breakpoint){ 
	breakpoint = false ;
    return false ;
  }
});
</script>
</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>
	<script type="text/javascript"><!--
	appolo.configs.select_modulo_acao = '<?=SELECT_MODULE_ACTION?>' ;
	//--></script>

	<header>
		<div class="row">
			<h3>Alterar Cargo </h3>

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
	<div class="loading">
		<img src="/images/icon-loading.gif" alt="Carregando...">
		<p class="warn">Carregando dados do Cargo</p>
	</div>	
	<div class="form_edit_area">
	<div class="content-areas" >
		<form action="<?php echo ADMIN_UPDATE_AREA_URL?>" method="post" name="grid_area">

				<div >

					
					<div class="control-group area_edit ">
						<label class="control-label not-null" for="area_description">Descrição do Cargo</label>
						<div class="controls">
							<input type="text" class="form-control edit_area" id="area_description" name="area_description" maxlength="100" placeholder="Descrição do Cargo"  value="<?=$_POST['nomeCargo']?>">
						</div>
					</div>
					<input type="hidden" id="idCargo" name="idCargo" value="<?=$_POST['cargoCheck']?>">					
					<table class="table table-areas table-hover edit_area_table table-condensed">
						<thead>
							<tr>
								<th class="check">
									<th class="modulo">Módulos</span></th>
									<th class="acoes center" colspan="2">Ações</th>
								</tr>
							</thead>
							<tbody class="page page-1 active" >
								<script type="text/javascript">

								var render_area_grid = '{{#modulos}}' ;
										render_area_grid += '<tr class="moduloTD">' ;
											render_area_grid += '<td style="width:10px; vertical-align: middle;" rowspan="{{numberActions}}" >' ;
												render_area_grid += '<input type="checkbox" value="{{idModulo}}" name="modulosCheck[]"  id="modulo{{idModulo}}"';
												render_area_grid += '{{#checkModulo}} checked="true"{{/checkModulo}}>';
											render_area_grid += '</td>' ;
											render_area_grid += '<td style="width:100px; vertical-align: middle;" rowspan="{{numberActions}}">' ;	
												render_area_grid += '{{nomeModulo}}' ;	
											render_area_grid += '</td>' ;
										render_area_grid += '</tr>' ;



										render_area_grid += '{{#listaAcao}}'
											render_area_grid += '<tr class="modulo{{idModulo}}">' ;											
												render_area_grid += '<td style="width:10px;">'
													render_area_grid += '<input type="checkbox" value="{{idAcao}}" name="modulo{{idModulo}}acao[]" id="modulo{{idModulo}}acao{{idAcao}}"';
													render_area_grid += '{{#check}}checked="true"{{/check}} ';
													render_area_grid += '{{#disabled}}disabled="true" {{/disabled}}';
													render_area_grid += '>';
												render_area_grid += '</td>' ;
												render_area_grid += '<td>' ;	
													render_area_grid += '{{nomeAcao}}' ;	
												render_area_grid += '</td>' ;												
											render_area_grid += '</tr>' ;
											
										render_area_grid += '{{/listaAcao}}';
									render_area_grid += '{{/modulos}}' ;

								</script>	
							</tbody>
						</table>
					</div>

				</div>


				<!--CONTROL-BUTTONS//-->
				<div class="control-buttons">
					<div class="controls form-actions">
						<!-- <?=$appolo_gui->render_button(ADMIN_UPDATE_AREA_URL, "btn btn-primary create", "fullscreen", "Gravar", "4", "2" );?> -->
						<?php
						if ($appolo_gui->render_item("4","2")){?>
							<button class ="btn btn-primary create " type="submit">
								<span class="glyphicon glyphicon-ok-sign icon "> <text class="btn-Area">Gravar</text></span>
							</button>
						<?php } ?>	
					</div>
				</div>
				<!--/CONTROL-BUTTONS//-->
			</form>
		</div>	
		</div>	

		<!-- Modal New Area -->	
		
		<!-- /Modal New Area -->
		<!--FOOTER-->
		<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->