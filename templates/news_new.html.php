<?php

	global $util ;
	global $appolo_gui ;

	$title = " Nova Notícia - Notícias - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "news" ;
	$test = isset( $_GET[ "test" ] ) ? $_GET[ "test" ] : "" ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>
</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
	     <h3>Nova Notícia</h3>

		<ol class="breadcrumb"> <!--AJUSTAR EM BREADCRUMB.INC.PHP//-->
        	<li><a href="/">Dashboard</a></li>
        	<li><a href="<?php echo NEWS_URL?>">Notícias</a></li>
        	<li><a href="<?php echo SECTIONS_NEWS_URL?>">Seções</a></li>
        	<li class="active">Nova Notícia</li>
     	</ol> <!--/AJUSTAR EM BREADCRUMB.INC.PHP//-->
	</header>
	
		<div class="content-sections">
			<div class="row">
				<div class="col-md-8">
					<form name="news_new" class="news_new" action="/crud/insert_news_new" method="post" role="form">
						<fieldset>
							<div class="form-group">
								<label for="id">ID (only numbs):</label>
								<input type="text" pattern="\d*" class="form-control id" id="id" name="id" placeholder="Ex: 123456" required>
							</div>
							<div class="form-group">
								<label for="title">Título:</label>
								<input type="text" class="form-control title" id="title" name="title" placeholder="Título" required>
							</div>
							<div class="form-group">
								<label for="text">Texto:</label>
								<textarea class="form-control text" id="text" name="text" placeholder="Conteúdo" required></textarea>
							</div>
							<p><strong>Obs</strong>: ID's (primary &amp; string) estão sendo inseridos aleatoriamente. (1,1,1)</p>
							<div class="clearfix"></div>
							<a href="<?=NEWS_URL?>" class="btn btn-danger cancel">Cancelar</a>
							<button type="submit" class="btn btn-primary create">Gravar</button>
							<!--<button type="submit" class="btn btn-success create">Visualizar</button>//-->
						</fieldset>
					</form>
				</div>
			</div>
		</div>

<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->