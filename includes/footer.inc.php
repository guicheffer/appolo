			<div class="refresh show_only-phone">
				<a href="" class="refresh"><span class="glyphicon glyphicon-refresh"></span></a>
			</div>

			<footer class="_main" role="contentinfo">
				<div class="container">
					<p class="text-muted credit"><?php echo COPYRIGHT?></p>
				</div>
				<a type="button" href="#top" class="btn top btn-default btn-xs">
				  <span class="glyphicon glyphicon-chevron-up"></span>
				</a>
			</footer>

		</div>
		<!--/CONTAINER-FLUID-->

	</body>

	<?php
		session_write_close() ;
	?>

	<!--CLOSE_DB-->
	<?php require ( CLOSE_DB_TEMPLATE ) ;?>
	<!--/CLOSE_DB-->

</html>