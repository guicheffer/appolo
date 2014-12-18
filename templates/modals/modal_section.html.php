<div class="modal fade modal_appolo modal_section" id="section" tabindex="-1" role="dialog" aria-labelledby="new-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<!--FORM-->
				<form name="modal-section" role="form" action="#" method="post" class="modalsection">

					<input type="hidden" name="idSecao" data-receive="idSecao" value="">

					<div class="control-group">
						<label class="control-label not-null" for="section_name">Nome</label>

						<div class="controls">
							<input id="section_name" name="section_name" maxlength="100" data-receive="nomeSecao" type="text" placeholder="Nome" class="form-control">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="section_description">Descrição</label>

						<div class="controls">
							<textarea id="section_description" name="section_description" data-receive="descricaoSecao" maxlength="200" placeholder="Descrição" class="form-control description"></textarea>
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group">
						<div class="controls types set-areas">
							<label class="checkbox-inline set-pages">
								<input type="checkbox" value="1" name="section_type[]">
								<span class="glyphicon glyphicon-file a-icon"></span>Páginas
							</label>
							<label class="checkbox-inline set-news">
								<input type="checkbox" value="2" name="section_type[]">
								<span class="glyphicon glyphicon-align-left a-icon"></span>Notícias
							</label>
							<label class="checkbox-inline set-imgs">
								<input type="checkbox" value="3" name="section_type[]">
								<span class="glyphicon glyphicon-camera a-icon"></span>Imagens
							</label>
						</div>
					</div>

					<!--area set news-->
					<div class="row-fluid area-set-news">
						<hr>

						<div class="control-group" data-desc-file="Arquivo de configuração">
							<label class="control-label not-null" for="configfile">Arquivo de configuração das notícias</label>

							<div class="controls file">
								<span class="help-folder"><?=CONFS_DIRECTORY ;?></span>
								<input id="configfile" name="configfile" data-receive="caminhoFisico" type="text" value="" placeholder="<?=SLUG_SITE ;?>-noticias-<?=$section_name;?>-<?=DEFAULT_FILENAME ;?>.<?= str_replace(".", "", CONFS_EXTENSION ) ;?>" class="form-control inline-block file-ext textfile configfile">
								<span class="glyphicon glyphicon-exclamation-sign icon-xml-error plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="Erro de leitura do arquivo de configuração."></span>
								<p class="help-block xml-error"><strong>Cuidado</strong>! O arquivo de configuração foi modificado ou deletado anteriormente!</p>
							</div>
						</div>

						<div class="control-group" data-desc-file="Arquivo de template">
							<label class="control-label not-null" for="tmplfile">Arquivo de template das notícias</label>

							<div class="controls file">
								<span class="help-folder"><?=TMPLS_DIRECTORY ;?></span>
								<input id="tmplfile" name="tmplfile" data-receive="tmpl" type="text" placeholder="<?=SLUG_SITE ;?>-noticias-<?=$section_name;?>-<?=DEFAULT_FILENAME ;?>.<?=str_replace(".", "", TMPLS_EXTENSION ) ;?>" class="form-control inline-block file-ext textfile tmplfile">
								<p class="help-block"></p>
							</div>
						</div>
					</div>
					<!--/area set news-->

					<div class="control-group">
						<div class="checkbox nv">
							<label class="pull-right">
								<input type="checkbox" value="1" name="nv_section[]">
								<span class="glyphicon glyphicon-eye-close a-icon"></span> Não visível
							</label>
						</div>
					</div>

					<button type="reset" class="btn-xs btn-danger hidden">Limpar dados</button>
				</form>
				<!--/FORM-->

			</div>

			<div class="modal-loading">
				<img src="/images/icon-loading.gif" alt="Carregando...">
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-del-file hidden">Remover</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success send-form"></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->