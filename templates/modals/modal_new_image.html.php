<div class="modal fade modal_appolo modal_image" id="image_new" tabindex="-1" role="dialog" aria-labelledby="new-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content new_image">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<!--FORM-->
				<form name="modal-image" role="form" action="<?=INSERT_IMAGE?>" method="post" class="image" enctype="multipart/form-data">
					<script type="text/javascript">

						$(document).ready(function() {

							var find = ' ', re = new RegExp(find, 'g');
						  	$( "#image_name" ).keyup(
								function() {
									aux = path+idSite+"_"+nomeSite+"/"+section+"/";
									this_modal.find( '#images_path' ).val(aux.replace(re, '_'));
									$( "#images_path" ).val($( "#images_path" ).val()+$( "#image_name" ).val());
								}	
							);
							$('#input-id').on('fileloaded', function(event, file, previewId) {
							});
						});
					</script>		
					<div class="control-group">
						<label class="control-label not-null minlength" for="image_name">Nome Imagem</label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="image_name" name="image_name" maxlength="100" placeholder="Nome da Imagem" >
							<p class="error_input"></p>
						</div>
						<label class="control-label not-null minlength" for="image_description">Descrição da Imagem</label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="image_description" name="image_description" maxlength="100" placeholder="Descrição da Imagem" >
							<input type="hidden" id="folder" name="folder">
							<input type="hidden" id="path" name="path">
							<input type="hidden" id="section" name="section" value="<?php echo $section_id ?>">

							<p class="error_input"></p>
						</div>
						<label class="control-label not-null minlength" for="images_tag">TAGS da Imagem </label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="images_tag" name="images_tag" maxlength="100" placeholder="TAGS da Imagem" >
							<p class="error_input"></p>
						</div>

						<label class="control-label not-null minlength" for="images_path">Caminho da Imagem</label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="images_path" readonly name="images_path" maxlength="100"  >
						</div>

						<label class="control-label" for="input-id">Upload da Imagem</label>

						<div class="controls">
							<input id="input-id" name="input-id" class="has-error" type="file">
							<p class="error_input"></p>
						</div>
					</div>
					<button type="reset" class="btn-xs btn-danger hidden">Limpar dados</button>
				</form>
				<!--/FORM-->

			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success send-form"></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->