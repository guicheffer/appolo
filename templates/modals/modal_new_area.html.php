<div class="modal fade modal_appolo modal_area" id="area" tabindex="-1" role="dialog" aria-labelledby="new-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<!--FORM-->
				<form name="modal-area" role="form" action="#" method="post" class="area">
					<div class="control-group">
						<label class="control-label not-null minlength" for="area_description">Descrição do Cargo</label>

						<div class="controls">
							<input type="text" class="form-control" id="area_description" name="area_description" minlength="5" maxlength="100" placeholder="Descrição do Cargo" >
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