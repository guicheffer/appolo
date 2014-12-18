<div class="modal fade modal_appolo modal_page" id="page" tabindex="-1" role="dialog" aria-labelledby="new-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<!--FORM-->
				<form name="modal-page" role="form" action="#" method="post" class="modalpage">

					<input type="hidden" name="idPagina" data-receive="idPagina" value="">

					<div class="control-group">
						<label class="control-label not-null" for="page_name">Nome</label>

						<div class="controls">
							<input id="page_name" name="page_name" maxlength="100" data-receive="nomePagina" type="text" value="" placeholder="Nome" class="form-control">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="page_description">Descrição</label>

						<div class="controls">
							<textarea id="page_description" name="page_description" data-receive="descricaoPagina" maxlength="200" placeholder="Descrição" class="form-control description"></textarea>
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group" data-desc-file="Arquivo de configuração">
						<label class="control-label not-null" for="configfile">Arquivo de configuração</label>

						<div class="controls file">
							<span class="help-folder"><?=CONFS_DIRECTORY ;?></span>
							<input id="configfile" name="configfile" data-receive="caminhoXmlPagina" type="text" value="" placeholder="<?=SLUG_SITE ;?>-paginas-<?=$section_name;?>-<?=DEFAULT_FILENAME ;?>.<?= str_replace(".", "", CONFS_EXTENSION ) ;?>" class="form-control inline-block file-ext textfile configfile" pattern="<?=CONFS_EXTENSION?>">
							<span class="glyphicon glyphicon-exclamation-sign icon-xml-error plusinfo" data-toggle="tooltip" data-placement="bottom" data-original-title="Erro de leitura do arquivo de configuração."></span>
							<p class="help-block xml-error"><strong>Cuidado</strong>! O arquivo de configuração foi modificado ou deletado anteriormente!</p>
						</div>
					</div>

					<div class="control-group" data-desc-file="Arquivo de conteúdo">
						<label class="control-label not-null" for="datafile">Arquivo de conteúdo</label>

						<div class="controls file">
							<span class="help-folder"><?=CONTENT_DIRECTORY ;?></span>
							<input id="datafile" name="datafile" data-receive="data" type="text" value="" placeholder="<?=SLUG_SITE ;?>-paginas-<?=$section_name;?>-<?=DEFAULT_FILENAME ;?>.<?= str_replace(".", "", CONTENT_EXTENSION ) ;?>" class="form-control inline-block file-ext textfile datafile" pattern="<?=CONTENT_EXTENSION?>">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group" data-desc-file="Arquivo de formulário">
						<label class="control-label not-null" for="formfile">Arquivo de formulário</label>

						<div class="controls file">
							<span class="help-folder"><?=FORMS_DIRECTORY ;?></span>
							<input id="formfile" name="formfile" data-receive="form" type="text" value="" placeholder="<?=SLUG_SITE ;?>-paginas-<?=$section_name;?>-<?=DEFAULT_FILENAME ;?>.<?=str_replace(".", "", FORMS_EXTENSION ) ;?>" class="form-control inline-block file-ext textfile formfile" pattern="<?=FORMS_EXTENSION?>">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group" data-desc-file="Arquivo de template">
						<label class="control-label not-null" for="tmplfile">Arquivo de template</label>

						<div class="controls file">
							<span class="help-folder"><?=TMPLS_DIRECTORY ;?></span>
							<input id="tmplfile" name="tmplfile" data-receive="tmpl" type="text" value="" placeholder="<?=SLUG_SITE ;?>-paginas-<?=$section_name;?>-<?=DEFAULT_FILENAME ;?>.<?=str_replace(".", "", TMPLS_EXTENSION ) ;?>" class="form-control inline-block file-ext textfile tmplfile" pattern="<?=TMPLS_EXTENSION?>">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="staging">Staging target</label>

						<div class="controls file">
							<span class="help-folder" title="<?=STAGING_TARGET ;?>"><?=SLUG_STAGING_TARGET ;?>/</span>
							<input id="staging" name="target-staging" data-receive="staging" type="text" value="" placeholder="<?=$section_name;?>-<?=DEFAULT_FILENAME ;?><?=DEFAULT_EXTENSION ;?>" class="form-control inline-block file-ext textfile target taget-staging">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="live">Live target</label>

						<div class="controls file">
							<span class="help-folder" title="<?=LIVE_TARGET ;?>"><?=SLUG_LIVE_TARGET ;?>/</span>
							<input id="live" name="target-live" data-receive="live" type="text" value="" placeholder="<?=$section_name;?>-<?=DEFAULT_FILENAME ;?><?=DEFAULT_EXTENSION ;?>" class="form-control inline-block file-ext textfile target taget-live">
							<p class="help-block"></p>
						</div>
					</div>

					<hr>

					<div class="control-group">
						<label class="control-label" for="preview">Preview</label>
						<p class="pre_path"><?=$appolo_twig->get_site_view_staging()?>(...) <b>[staging]</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$appolo_twig->get_site_view_prod()?>(...) <b>[live]</b></p>

						<div class="controls file">
							<input id="preview" name="target-preview" data-receive="preview" type="text" value="" placeholder="<?=$section_name;?>-<?=DEFAULT_FILENAME ;?><?=DEFAULT_EXTENSION_PREVIEW ;?>" class="form-control inline-block file-ext target taget-preview">
							<p class="help-block"></p>
						</div>
					</div>

					<div class="control-group">
						<div class="checkbox nv">
							<label class="pull-right">
								<input type="checkbox" value="1" name="nv_page[]">
								<span class="glyphicon glyphicon-eye-close a-icon"></span> Não visível
							</label>
						</div>
					</div>

					<button type="reset" class="btn-xs btn-danger hidden">Limpar dados</button>
				</form>
				<!--/FORM-->

			</div>
			<div class="modal-footer">
				<div class="btn-group btn-edit-file hidden dropup">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						Editar arquivo <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#" data-type="form" data-item="0">Editar formulário</a></li>
						<li class="divider"></li>
						<li><a href="#" data-type="tmpl" data-item="0">Editar template</a></li>
					</ul>
				</div>
				<button type="button" class="btn btn-danger btn-del-file hidden">Remover</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success send-form"></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->