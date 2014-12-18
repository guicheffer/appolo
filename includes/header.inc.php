<?php

	$util->set_querystring( "2014021601" ) ; //always yyyy-mm-dd-vv (where 'v', is the version)
	global $context ; /*non-function static --assume-unchanged*/
	global $appolo_twig ; /*appolo_twig*/
	
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="pt-BR"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="pt-BR"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="pt-BR"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-BR"> <!--<![endif]-->

<head>

<title><?=$title?></title>

<meta http-equiv="Content-Type" charset="<?=CHARSET?>">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Jan 1970 00:00:00 GMT">
<meta http-equiv="Cache-Control" content="no-store">
<meta name="robots" content="noindex,noarchive">
<meta name="author" content="<?=SITE_NAME?>">
<meta name="description" content="<?=SYSTEM_NAME?> [ <?=SITE_NAME?> ]">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="shortcut icon" href="<?=FAVICON?>">
<link rel="stylesheet" href="/includes/bootstrap/<?=BOOTSTRAP_VERSION?>/css/bootstrap.css"><!--BUG FONT VERSÃO: CHROME 37.0.1.4.3-->
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/library/jqueryui/1.8.23/css/aristo/aristo.min.css">
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/css/1.0/common/base.css?<?=$util->get_querystring();?>">
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/css/1.0/common/fileinput.css?<?=$util->get_querystring();?>">
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/library/buttons/buttons.css?<?=$util->get_querystring();?>">
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/library/animate/1.0/animate.css?<?=$util->get_querystring();?>">
<link rel="stylesheet" href="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/css/1.0/common/prettyPhoto.css?<?=$util->get_querystring();?>">

<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/jquery/1.11/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/jqueryui/1.10.3/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/modernizr/2.6.2/modernizr.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/library/bootstrap/<?=BOOTSTRAP_VERSION?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/plugins.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/fileinput.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/jquery-passy.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/common.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/jquery.maskedinput.min.js?<?=$util->get_querystring();?>"></script>
<script type="text/javascript" src="<?=$util->check_prefix();?>static.guiatech.com.br/appolo/js/1.0/common/jquery.prettyPhoto.js?<?=$util->get_querystring();?>"></script>



<script type="text/javascript"><!--
	appolo.configs.today = '<?=TODAY?>' ;
	appolo.configs.context = '<?=$context?>' ;
	appolo.configs.view_staging = '<?=$appolo_twig->get_site_view_staging()?>' ;
	appolo.configs.view_prod = '<?=$appolo_twig->get_site_view_prod()?>' ;
	appolo.configs.dashboard_url = '<?=APPOLO_DASHBOARD?>' ;
	appolo.util.rendering_template = '<?=TEMPLATES_DIRECTORY . "/" . util::$show_rendering_template . ".html.php" ;?>' ;
//--></script>
