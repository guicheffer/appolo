<?php
/**
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
 */
?>
<?php if (isset($home)){?>
	<?
		$appolo->add_text_breadcrumb($breadcrumb) ;
		$appolo->mount_text_breadcrumb() ;
	?>
<?php }else{?>
	<!--//-->
<?php }?>