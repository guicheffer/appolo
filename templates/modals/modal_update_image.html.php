<div class="modal fade modal_appolo modal_image image_update" id="image_update" tabindex="-1" role="dialog" aria-labelledby="new-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content new_image">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<!--FORM-->
				<form name="modal-image" role="form" action="<?=UPDATE_IMAGE_URL?>" method="post" class="image" enctype="multipart/form-data">
					<script type="text/javascript">

						$(document).ready(function() {
							$('#input-id_up').on('fileloaded', function(event, file, previewId) {
							});
						});
					</script>		
					<div class="control-group">
						<label class="control-label not-null minlength" for="image_name_up">Nome Imagem</label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="image_name_up" readOnly name="image_name_up" maxlength="100" placeholder="Nome da Imagem" >
							<p class="error_input"></p>
						</div>
						<label class="control-label not-null minlength" for="image_description_up">Descrição da Imagem</label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="image_description_up" name="image_description_up" maxlength="100" placeholder="Descrição da Imagem" >
							<input type="hidden" id="folder" name="folder">
							<input type="hidden" id="path" name="path">
							<input type="hidden" id="idImg" name="idImg">
							<input type="hidden" id="trocaImg" name="trocaImg">
							<input type="hidden" id="section" name="section" value="<?php echo $section_id ?>">

							<p class="error_input"></p>
						</div>

						<?php
						if( $appolo_gui->render_item( "7", "3" ) ){
						?>	
						<div class="status">
								<label class="control-label not-null" for="status">Status da Imagem:</label>
								Inativo <input type="radio" id="status0" name="status[]" value="0" required="true">
								Ativo <input type="radio" id="status1" name="status[]" value="1">
								<label for="status[]" class="error" style="display:none;">Por favor selecione um status.</label>
						</div>
						<?php
						}
						?>
						<label class="control-label not-null minlength" for="images_tag_up">TAGS da Imagem </label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="images_tag_up" name="images_tag_up" maxlength="100" placeholder="TAGS da Imagem" >
							<p class="error_input"></p>
						</div>
						<label class="control-label not-null minlength" for="images_path_up">Caminho da Imagem</label>

						<div class="controls">
							<input type="text" minlength="5" class="form-control" id="images_path_up" readonly name="images_path_up" maxlength="100"  >
						</div>
						<label class="control-label" for="input-id_up">Upload da nova Imagem</label>

						<div class="controls">
							<input id="input-id_up" name="input-id_up" class="has-error" type="file">
							<p class="error_input"></p>
						</div>
					</div>
				</form>
				<!--/FORM-->

			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default "  data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success send-form "  ></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->