<?php

global $util ;
global $appolo_gui ;

$util->set_home( 1 ) ;
$title = " Relatórios - " . SITE_NAME . " - " . SYSTEM_NAME ;
$session = "home" ;
	//usar em caso de alert
	//$warn = isset( $_GET[ "warn" ] ) ? $_GET[ "warn" ] : '' ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>
<script type="text/javascript">
$(document).ready(function() {

	$(window).load(function() {
		if(window.location.hash) {
			var option = parseInt(window.location.hash.substr(1));
			switch(option) {
			    case 1:
			        $('a[href="#secao_responsavel"]').click();	        
			    break;
			    case 2:
			        $('a[href="#publicacao_autor"]').click();
			    break;
			     case 3:
			        $('a[href="#publicacao_periodo"]').click();
			    break;
			     case 4:
			        $('a[href="#publicacao_periodo_detalhe"]').click();
			    break;
			}
		} 
	});	

	$("#publicacao_periodo_detalhe_search_clear").click(function(){
			$('#mesInicial').val("");			
			$('#anoInicial').val("");			
			$('#mesFinal').val("");			
			$('#anoFinal').val("");	
			$('#anoFinal').val("");			
			$('#statusPubPeriodo').val("");			
      		appolo.configs.relatorios.publicacao_periodo_detalhe();
		});	
	$("#publicacao_periodo_detalhe_search").click(function(){
      	appolo.configs.relatorios.publicacao_periodo_detalhe();
	});	
	$("#publicacao_periodo_search_clear").click(function(){
			$('#anoInicialQtd').val("2014");			
      		appolo.configs.relatorios.publicacao_periodo();
		});	
	$("#publicacao_periodo_search").click(function(){
      	appolo.configs.relatorios.publicacao_periodo();
	});	
	
	$("#publicacao_autor_search").click(function(){
		divP = $(document).find("#publicacao_autor");

		idStatus = divP.find("#statusPub").val();
		idusuario = divP.find("#idusuario").val();

		if(idStatus != "" && idusuario == ""){
			alert("Selecione também um Autor");
			return false;
		}

		if(idusuario != ""){

			appolo.configs.relatorios.publicacao_autor_detalhe(idusuario,idStatus);
		}
		else
		{
			appolo.configs.relatorios.publicacao_periodo();
		}
      	
	});	
	$("#publicacao_autor_search_clear").click(function(){
		divP = $(document).find("#publicacao_autor");
		idStatus = divP.find("#statusPub").val("");
		idusuario = divP.find("#idusuario").val("");
      	appolo.configs.relatorios.publicacao_autor();
	});	

	$("#secao_responsavel_search").click(function(){
		divP = $(document).find("#secao_responsavel");
		idusuario = divP.find("#idusuario").val();
      	appolo.configs.relatorios.secao_responsavel(idusuario);
	});	
	$("#secao_responsavel_search_clear").click(function(){
		divP = $(document).find("#secao_responsavel");
		idusuario = divP.find("#idusuario").val("");
      	appolo.configs.relatorios.responsavel_secao();
	});	

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		appolo.configs.relatorios[e.target.attributes.function.value]();
	});	

	$('#back_button_responsavel_secao').click(function() {
		appolo.configs.relatorios.responsavel_secao();
	});	
	$('#back_button_publicacao_autor').click(function() {
		appolo.configs.relatorios.publicacao_autor();
	});	
	
});
var render_relatorio_loading = '<tr class="loading">' ;
render_relatorio_loading += '<td colspan="9">' ;
render_relatorio_loading += '<img src="/images/icon-loading.gif" alt="Carregando...">' ;
render_relatorio_loading += '<p class="warn">Carregando...</p>' ;
render_relatorio_loading += '</td>' ;
render_relatorio_loading += '</tr>' ;

	


</script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/jquery.enumerable.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/jquery.tufte-graph.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/raphael.js?<?=$util->get_querystring();?>"></script>
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/css/1.0/common/tufte-graph.css?<?=$util->get_querystring();?>">
</head>

<body class="<?php echo $session?> relatorios">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	
	<header>
		<ol class="breadcrumb">

		</ol>
	</header>

	<div class="dashboard">
		<div class="container container-middle relatorios_tabs">

			<ul class="nav nav-tabs relatorios_tabs" role="tablist" id="myTab">
				<?php
					if ($appolo_gui->render_item("8","6")){?>
					<li role="presentation"><a href="#secao_responsavel" role="tab" function="responsavel_secao" data-toggle="tab">Relatório Seções por Responsável</a></li>
				<?php } ?>	
				<?php
					if ($appolo_gui->render_item("8","7")){?>
				<li role="presentation"><a href="#publicacao_autor" role="tab" function="publicacao_autor" data-toggle="tab">Relatório Publicação por Autor</a></li>
				<?php } ?>	
				<?php
					if ($appolo_gui->render_item("8","8")){?>
				<li role="presentation"><a href="#publicacao_periodo" role="tab" function="publicacao_periodo" data-toggle="tab">Relatório Publicação por Período</a></li>
				<?php } ?>	
				<?php
					if ($appolo_gui->render_item("8","9")){?>
				<li role="presentation"><a href="#publicacao_periodo_detalhe" role="tab" function="publicacao_periodo_detalhe" data-toggle="tab">Relatório Publicação detalhada por Período</a></li>
				<?php } ?>	
			</ul>

			<div class="tab-content">
				<?php
					if ($appolo_gui->render_item("8","6")){?>
				<div role="tabpanel" class="tab-pane relatorio_tabela secao_responsavel_content" id="secao_responsavel">
					<div class="div_search_bar secao_responsavel_searchBar">
						<div class="search_bar_title left">Busca</div>
						<div class="search_bar_items">	
							<?php 
								print($util->printListaAutor());
							?>											 
						</div>
						<div class="publicacao_periodo_detalhe_search_div form-search">
							<button type="button" class ="btn btn-default secao_responsavel_search_button" id="secao_responsavel_search_clear"> 
								<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
							</button>
							<button type="button" class ="btn btn-default secao_responsavel_search_button" id="secao_responsavel_search"> 
								<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
							</button>				
						</div>
					</div>
						<p id= "secao_responsavel_graph_title"><b>Gráfico Responsáveis x Seções</b></p>														
						<div id="secao_responsavel_graph" class="graph" style="width: 95%; height: 250px; position: relative;"></div>
						<table class="table table-hover table-condensed grid"  data-limit-per-page="10">
							<thead>
								<tr id="title1">
									<th class="center" colspan="4">Relatório Responsáveis x Quantidade de Seções </th>						
								</tr>
								<tr class="tr_secao1 ">
									<th>Nome </th>
									<th>Email de Contato</th>
									<th class="center">Cargo</th>		
									<th class="center">Seções</th>								
								</tr>
								<tr id="title2">
									<th class="center" colspan="3">Relatório Seções por Responsáveis </th>						
								</tr>
								<tr class="tr_secao2">
									<th class="left">Nome da Seção </th>
									<th class="left">Data Criação</th>
									<th class="right">Nome Responsável (usuario) - email</th>		
								</tr>
							</thead>
						<tbody class="page page-1 active " id="secao_responsavel_content">

						<script type="text/javascript">
								
								appolo.configs.relatorio_secao_responsavel = '<?=RELATORIOS_SECAO_RESPONSAVEL?>' ;
								appolo.configs.relatorio_responsavel_secao = '<?=RELATORIOS_RESPONSAVEL_SECAO?>' ;

								var render_secao_responsavel = '{{#items}}' ;								
								render_secao_responsavel += '<tr>' ;
								render_secao_responsavel += '<td class="left">' ;
								render_secao_responsavel += '<a href="javascript:void(0)" onclick="appolo.configs.relatorios.secao_responsavel({{idusuario}})" class="section-name " data-toggle="tooltip" data-placement="bottom" >';
								render_secao_responsavel += '{{nome}}' ;
								render_secao_responsavel += '</a>' ;
								render_secao_responsavel += '</td>' ;
								render_secao_responsavel += '<td class="left">' ;
								render_secao_responsavel += '{{email}}' ;	
								render_secao_responsavel += '</td>' ;
								render_secao_responsavel += '<td class="center">' ;
								render_secao_responsavel += '{{cargo}}' ;	
								render_secao_responsavel += '</td>' ;
								render_secao_responsavel += '<td class="center">' ;
								render_secao_responsavel += '{{secao}}' ;	
								render_secao_responsavel += '</td>' ;
								render_secao_responsavel += '</tr>' ;
								render_secao_responsavel += '{{/items}}' ;
								
								var render_responsavel_secao = '{{#items}}' ;
								render_responsavel_secao += '<tr>' ;
								render_responsavel_secao += '<td class="left">' ;
								render_responsavel_secao += '<span class="glyphicon glyphicon-folder-open up-icon"></span> {{NomeSecao}}' ;	
								render_responsavel_secao += '</td>' ;
								render_responsavel_secao += '<td class="left">' ;
								render_responsavel_secao += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;	
								render_responsavel_secao += '</td>' ;
								render_responsavel_secao += '<td class="right">' ;
								render_responsavel_secao += '{{Responsavel}}' ;	
								render_responsavel_secao += '</td>' ;													
								render_responsavel_secao += '</tr>' ;
								render_responsavel_secao += '{{/items}}' ;
								
						</script>	


						</tbody>
							<tr><td id="back_button_responsavel_secao" class="tdVoltar" ><span class="glyphicon glyphicon-share-alt buttonVoltar"></span>Voltar</td></tr> 
						
						</table>
						<div class = "right">
							<?=$appolo_gui->render_button_js( "", "btn btn-primary  print_button_responsavel_secao", "print", "Imprimir Relatório", "8", "6", "appolo.configs.relatorios.print_div(&quot;secao_responsavel&quot;)" )
							?>	
						</div>
				</div>
				<?php } ?>	
				<?php
					if ($appolo_gui->render_item("8","7")){?>
				<div role="tabpanel" class="tab-pane relatorio_tabela publicacao_autor_content" id="publicacao_autor">
					<div class="div_search_bar">
						<div class="search_bar_title left">Busca</div>
						<div class="search_bar_items">
							
							Status Publicação
								<select class="form-control form-search form-search-cargo" id="statusPub" name="statusPub" style="width: 20%;">
									<option value=""></option>
									<option value="ALT">Alterado</option>
									<option value="INS">Inserido</option>
									<option value="APR">Aprovado</option>
									<option value="PEN">Pendente de Aprovação</option>								
									<option value="PUB">Publicado</option>								
									<option value="REP">Reprovado</option>								
								</select>	
								<?php 
									print($util->printListaAutor());
								?>			
												 
						</div>
						<div class="publicacao_autor_search_clear_div form-search">
							<button type="button" class ="btn btn-default publicacao_autor_search_button" id="publicacao_autor_search_clear"> 
								<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
							</button>
							<button type="button" class ="btn btn-default publicacao_autor_search_button" id="publicacao_autor_search"> 
								<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
							</button>				
						</div>
					</div>	
					<p id= "pulblicacoes_autor_graph_title"><b>Gráfico publicações por autor</b></p>														
					<div id="pulblicacoes_autor_graph" class="graph" style="width: 95%; height: 250px; position: relative;"></div>
					<table class="table table-hover table-condensed grid"  data-limit-per-page="10">
							<thead>
								<tr id="title3">
									<th class="center" colspan="4">Relatório Autores x Quantidade de Publicações </th>						
								</tr>
								<tr class="tr_secao3 ">
									<th>Nome </th>
									<th>Email de Contato</th>
									<th class="center">Cargo</th>		
									<th class="center">Total de Publicações</th>								
								</tr>
								<tr id="title4">
									<th class="center" colspan="9">Publicações pelo Autor</th>						
								</tr>
								<tr class="tr_secao4 ">
									<th>Nome </th>
									<th>Email de Contato</th>
									<th class="center">Cargo</th>		
									<th class="center">Titulo da Pulblicação</th>		
									<th class="center">Status</th>		
									<th class="center">Tipo Seção</th>		
									<th class="center">Data Criação</th>		
									<th class="center">DeadLine Publicação</th>		
								</tr>
							</thead>
						<tbody class="page page-1 active " id="publicacao_autor_content">
						
						<script type="text/javascript">
								
								appolo.configs.relatorio_publicacao_autor = '<?=RELATORIOS_PUBLICACAO_AUTOR?>' ;

								var render_publicacao_autor = '{{#items}}' ;								
								render_publicacao_autor += '<tr>' ;
								render_publicacao_autor += '<td class="left">' ;
								render_publicacao_autor += '<a href="javascript:void(0)" onclick="appolo.configs.relatorios.publicacao_autor_detalhe({{idUsuario}},null)" class="section-name " data-toggle="tooltip" data-placement="bottom" >';
								render_publicacao_autor += '{{nome}}' ;
								render_publicacao_autor += '</a>' ;
								render_publicacao_autor += '</td>' ;
								render_publicacao_autor += '<td class="left">' ;
								render_publicacao_autor += '{{email}}' ;	
								render_publicacao_autor += '</td>' ;
								render_publicacao_autor += '<td class="center">' ;
								render_publicacao_autor += '{{cargo}}' ;	
								render_publicacao_autor += '</td>' ;
								render_publicacao_autor += '<td class="center">' ;
								render_publicacao_autor += '{{quantidade}}' ;	
								render_publicacao_autor += '</td>' ;
								render_publicacao_autor += '</tr>' ;
								render_publicacao_autor += '{{/items}}' ;

								var render_publicacao_autor_detalhe = '{{#items}}' ;								
								render_publicacao_autor_detalhe += '<tr>' ;
								render_publicacao_autor_detalhe += '<td class="left">' ;
								render_publicacao_autor_detalhe += '{{nome}}' ;
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="left">' ;
								render_publicacao_autor_detalhe += '{{email}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="center">' ;
								render_publicacao_autor_detalhe += '{{cargo}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="center">' ;
								render_publicacao_autor_detalhe += '{{tituloPublicacao}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="center">' ;
								render_publicacao_autor_detalhe += '{{status}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="center">' ;
								render_publicacao_autor_detalhe += '{{tipoSecao}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="center">' ;
								render_publicacao_autor_detalhe += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '<td class="center">' ;
								render_publicacao_autor_detalhe += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_deadline_full}}"></span>{{section_deadline_min}}' ;	
								render_publicacao_autor_detalhe += '</td>' ;
								render_publicacao_autor_detalhe += '</tr>' ;
								render_publicacao_autor_detalhe += '{{/items}}' ;
								
						</script>	


						</tbody>
							<tr><td id="back_button_publicacao_autor" class="tdVoltar"><span class="glyphicon glyphicon-share-alt buttonVoltar"></span>Voltar</td></tr> 
						
						</table>
						<div class = "right">
							<?=$appolo_gui->render_button_js( "", "btn btn-primary  print_button_publicacao_autor", "print", "Imprimir Relatório", "8", "7", "appolo.configs.relatorios.print_div(&quot;publicacao_autor&quot;)" )
							?>	
						</div>
				</div>
				<?php } ?>	
				<?php
					if ($appolo_gui->render_item("8","9")){?>
				<div role="tabpanel" class="tab-pane relatorio_tabela publicacao_periodo_detalhe_content" id="publicacao_periodo_detalhe">
					<!-- <p id= "publicacao_periodo_detalhe_graph_title"><b>Gráfico publicações por autor</b></p>														
					<div id="publicacao_periodo_detalhe_graph" class="graph" style="width: 95%; height: 250px; position: relative;"></div> -->
					<div class="div_search_bar">
						<div class="search_bar_title left">Busca</div>
						<div class="search_bar_items">
							Mes Inicial
								<select class="form-control form-search form-search-cargo" id="mesInicial" name="mesInicial">
									<option value=""></option>
									<option value="1">Janeiro</option>
									<option value="2">Fevereiro</option>
									<option value="3">Março</option>
									<option value="4">Abril</option>
									<option value="5">Maio</option>
									<option value="6">Junho</option>
									<option value="7">Julho</option>
									<option value="8">Agosto</option>
									<option value="9">Setembro</option>
									<option value="10">Outubro</option>
									<option value="11">Novembro</option>
									<option value="12">Dezembro</option>
								</select>
							Ano Inicial
								<select class="form-control form-search form-search-cargo" id="anoInicial" name="anoInicial">
									<option value=""></option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>								
								</select>
							Mes Final
								<select class="form-control form-search form-search-cargo" id="mesFinal" name="mesFinal">
									<option value=""></option>
									<option value="1">Janeiro</option>
									<option value="2">Fevereiro</option>
									<option value="3">Março</option>
									<option value="4">Abril</option>
									<option value="5">Maio</option>
									<option value="6">Junho</option>
									<option value="7">Julho</option>
									<option value="8">Agosto</option>
									<option value="9">Setembro</option>
									<option value="10">Outubro</option>
									<option value="11">Novembro</option>
									<option value="12">Dezembro</option>
								</select>
							Ano Final
								<select class="form-control form-search form-search-cargo" id="anoFinal" name="anoFinal">
									<option value=""></option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>								
								</select>
							Status Publicação
								<select class="form-control form-search form-search-cargo" id="statusPubPeriodo" name="statusPubPeriodo">
									<option value=""></option>
									<option value="ALT">Alterado</option>
									<option value="INS">Inserido</option>
									<option value="APR">Aprovado</option>
									<option value="PEN">Pendente de Aprovação</option>								
									<option value="PUB">Publicado</option>								
									<option value="REP">Reprovado</option>								
								</select>		
						</div>
						<div class="publicacao_periodo_detalhe_search_div form-search">
							<button type="button" class ="btn btn-default publicacao_periodo_detalhe_search_button" id="publicacao_periodo_detalhe_search_clear"> 
								<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
							</button>
							<button type="button" class ="btn btn-default publicacao_periodo_detalhe_search_button" id="publicacao_periodo_detalhe_search"> 
								<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
							</button>				
						</div>
					</div>
					<table class="table table-hover table-condensed grid"  data-limit-per-page="10">
							<thead>
								<tr id="title5">
									<th class="center" colspan="8">Relatório Publicações detalahadas por Período</th>						
								</tr>
								<tr class="tr_secao5 ">
									<th>Titulo</th>
									<th>Autor</th>
									<th class="center">Status</th>	
									<th class="center">Seção</th>
									<th class="center">Data Criação</th>														
									<th class="center">Mes da Publicação</th>								
									<th class="center">Ano da Publicação</th>								
								</tr>
							</thead>
						<tbody class="page page-1 active " id="publicacao_periodo_detalhe_content">
						<script type="text/javascript">
								appolo.configs.relatorio_publicacao_periodo_detalhe = '<?=RELATORIOS_PUBLICACAO_PERIODO_DETALHE?>' ;
								var render_publicacao_periodo_detalhe = '{{#items}}' ;								
								render_publicacao_periodo_detalhe += '<tr>' ;
								render_publicacao_periodo_detalhe += '<td class="left">' ;
								render_publicacao_periodo_detalhe += '{{Titulo}}' ;
								render_publicacao_periodo_detalhe += '</td>' ;
								render_publicacao_periodo_detalhe += '<td class="left">' ;
								render_publicacao_periodo_detalhe += '{{Criador}}' ;	
								render_publicacao_periodo_detalhe += '</td>' ;
								render_publicacao_periodo_detalhe += '<td class="center">' ;
								render_publicacao_periodo_detalhe += '{{Status}}' ;	
								render_publicacao_periodo_detalhe += '</td>' ;
								render_publicacao_periodo_detalhe += '<td class="center">' ;
								render_publicacao_periodo_detalhe += '{{SecaoCategoria}}' ;	
								render_publicacao_periodo_detalhe += '</td>' ;
								render_publicacao_periodo_detalhe += '<td class="center">' ;
								render_publicacao_periodo_detalhe += '<span class="glyphicon glyphicon-cloud-upload a-icon plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="{{section_dataCriacao_full}}"></span>{{section_dataCriacao_min}}' ;	
								render_publicacao_periodo_detalhe += '</td>' ;								
								render_publicacao_periodo_detalhe += '<td class="center">' ;
								render_publicacao_periodo_detalhe += '{{MesPublicacao}}' ;	
								render_publicacao_periodo_detalhe += '</td>' ;
								render_publicacao_periodo_detalhe += '<td class="center">' ;
								render_publicacao_periodo_detalhe += '{{AnoPublicacao}}' ;	
								render_publicacao_periodo_detalhe += '</td>' ;
								render_publicacao_periodo_detalhe += '</tr>' ;
								render_publicacao_periodo_detalhe += '{{/items}}' ;
						</script>	


						</tbody>
							<!-- <tr><td id="back_button_publicacao_periodo_detalhe"><span class="glyphicon glyphicon-share-alt buttonVoltar"></span>Voltar</td></tr>  -->
						
						</table>
						<div class = "right">
							<?=$appolo_gui->render_button_js( "", "btn btn-primary  print_button_publicacao_periodo_detalhe", "print", "Imprimir Relatório", "8", "7", "appolo.configs.relatorios.print_div(&quot;publicacao_periodo_detalhe&quot;)" )
							?>	
						</div>
				</div>
				<?php } ?>	
				<?php
					if ($appolo_gui->render_item("8","8")){?>
				<div role="tabpanel" class="tab-pane relatorio_tabela publicacao_periodo_content" id="publicacao_periodo">
					<!-- <p id= "publicacao_periodo_graph_title"><b>Gráfico publicações por autor</b></p>														
					<div id="publicacao_periodo_graph" class="graph" style="width: 95%; height: 250px; position: relative;"></div> -->
					<div class="div_search_bar">
						<div class="search_bar_title left">Busca</div>
						<div class="search_bar_items">

							Ano 
								<select class="form-control form-search form-search-cargo" id="anoInicialQtd" name="anoInicialQtd">
									<option value=""></option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>								
								</select>
													

						</div>
						<div class="publicacao_periodo_search_div form-search">
							<button type="button" class ="btn btn-default publicacao_periodo_search_button" id="publicacao_periodo_search_clear"> 
								<span class="glyphicon glyphicon-list-alt icon "> <text class="btn-Area">Limpar Valores</text></span>
							</button>
							<button type="button" class ="btn btn-default publicacao_periodo_search_button" id="publicacao_periodo_search"> 
								<span class="glyphicon glyphicon-search icon "> <text class="btn-Area">Buscar</text></span>
							</button>				
						</div>
					</div>
					<p id= "publicacao_periodo_graph_title"><b>Gráfico quantidade de publicações</b></p>														
					<div id="publicacao_periodo_graph" class="graph" style="width: 95%; height: 250px; position: relative;"></div>
					<table class="table table-hover table-condensed grid"  data-limit-per-page="10">
							<thead>
								<tr id="title6">
									<th class="center" colspan="5">Relatório Quantidade de Publicações por Perído</th>						
								</tr>
								<tr class="tr_secao6 ">
									<th>Ano</th>
									<th>Mês</th>
									<th class="center">Publicadas</th>
									<th class="center">Aprovadas</th>	
									<th class="center">Reprovadas</th>
									<th class="center">Pendentes</th>																						
								</tr>
							</thead>
						<tbody class="page page-1 active " id="publicacao_periodo_content">
						
						<script type="text/javascript">
								
								appolo.configs.relatorio_publicacao_periodo = '<?=RELATORIOS_PUBLICACAO_PERIODO?>' ;

								var render_publicacao_periodo = '{{#items}}' ;								
								render_publicacao_periodo += '<tr>' ;
								render_publicacao_periodo += '<td class="left">' ;
								render_publicacao_periodo += '{{ano}}' ;
								render_publicacao_periodo += '</td>' ;
								render_publicacao_periodo += '<td class="left">' ;
								render_publicacao_periodo += '{{mes}}' ;	
								render_publicacao_periodo += '</td>' ;
								render_publicacao_periodo += '<td class="center">' ;
								render_publicacao_periodo += '{{publicadas}}' ;	
								render_publicacao_periodo += '</td>' ;
								render_publicacao_periodo += '<td class="center">' ;
								render_publicacao_periodo += '{{aprovadas}}' ;	
								render_publicacao_periodo += '</td>' ;
								render_publicacao_periodo += '<td class="center">' ;
								render_publicacao_periodo += '{{reprovadas}}' ;	
								render_publicacao_periodo += '<td class="center">' ;
								render_publicacao_periodo += '{{pendentes}}' ;	
								render_publicacao_periodo += '</td>' ;
								render_publicacao_periodo += '</td>' ;
								render_publicacao_periodo += '</tr>' ;
								render_publicacao_periodo += '{{/items}}' ;
								
						</script>	


						</tbody>
							<!-- <tr><td id="back_button_publicacao_periodo"><span class="glyphicon glyphicon-share-alt buttonVoltar"></span>Voltar</td></tr>  -->
						
						</table>
						<div class = "right">
							<?=$appolo_gui->render_button_js( "", "btn btn-primary  print_button_publicacao_periodo", "print", "Imprimir Relatório", "8", "7", "appolo.configs.relatorios.print_div(&quot;publicacao_periodo&quot;)" )
							?>	
						</div>
				</div>
				<?php } ?>	
			</div>
							


		</div>
	</div>

	<!--FOOTER-->
	<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->