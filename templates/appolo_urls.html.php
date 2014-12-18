<?php

	global $util ;
	global $appolo_gui ;

	$util->set_off( 1 ) ;
	$title = " URLs - " . SITE_NAME . " - " . SYSTEM_NAME ;
	$session = "urls" ;

?>

<?php require ( HEADER_TEMPLATE ) ; ?>
</head>

<body class="<?php echo $session?>">

	<?php require ( MASTHEAD_TEMPLATE ) ; ?>

	<header>
		<h1>URLs</h1>
	</header>

	<!--SCRIPT WRITES JSON (configs/urls_json)//-->
	<div class="content-urls"></div>
	
<!--FOOTER-->
<?php require ( FOOTER_TEMPLATE ) ;?>
<!--/FOOTER-->