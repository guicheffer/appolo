<div class="modal fade modal_appolo modal_user" id="user" tabindex="-1" role="dialog" aria-labelledby="new-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<!--FORM-->
				<form name="modal-user" role="form" action="#" method="post" class="user">
					<div class="control-group">
						<label class="control-label not-null" for="user_pessoa">Funcionário</label>
						<div class="controls ">
							<div class="select_new_User">
								<script type="text/javascript">
									 var render_funcionarios_search_area =  '<select id="user_pessoa" class="form-control form-search form-search-cargo" name="user_pessoa" >';
										 render_funcionarios_search_area += '<option value=""></option>' ;
										 render_funcionarios_search_area += '{{#items}}' ;
										 render_funcionarios_search_area += '<option value="{{cpfPessoa}}">{{nomePessoa}}</option>' ;
										 render_funcionarios_search_area += '{{/items}}' ;
									 	 render_funcionarios_search_area += '</select>' ;
									 	 render_funcionarios_search_area += '<p class="error_input"></p> ';
								 </script>								
							</div>
							
						</div>

						<label class="control-label not-null minlength" for="user_description">Login do Usuário</label>
						<div class="controls">
							<input type="text" class="form-control inputs" id="user_description" name="user_description" placeholder="Digite o Login" maxlength="15" minlength="4">
							<p class="error_input"></p>
						</div>
						<label class="control-label not-null " for="user_password">Senha Usuário</label>
						<div class="controls">							
							<input type="text" class="form-control inputs password" id="user_password" name="user_password" maxlength="10" placeholder="Digite a senha" >
							<a href="javascript:void(0);" class="generate" id="generate">Gerar Senha</a>
							<span id="output" class="output">...</span>
							<script type="text/javascript">
								var $input = $( '#user_password' );
								var $output = $( '#output' );
								var feedback = [
								    { color: '#c00', text: 'Fraca' },
								    { color: '#c80', text: 'Média' },
								    { color: '#0c0', text: 'Bom' },
								    { color: '#0c0', text: 'Ótima' }
								];
								$input.passy(function(strength, valid) {
							        $output.text(feedback[strength].text);
							        $output.css('background-color', feedback[strength].color);
							    });

								$('#generate').click(function() {
								    $input.passy( 'generate', 8 );
								});
							</script>
							<p class="error_input senha_error"></p>
						</div>
					</div>
					<button type="reset" class="btn-xs btn-danger hidden">Limpar dados</button>
				</form>
				<!--/FORM-->

			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default " disabled="disabled" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success send-form" disabled="disabled"></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->