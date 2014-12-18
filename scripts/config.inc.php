<?php

/**
 * Configuração da área administrativa da aplicação.
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
 * @since 	2013-08-30 00:00:00
 */

//files & data structure
define( "INCLUDES_DIRECTORY" , DOCUMENT_ROOT . "/includes" ) ;
define( "SCRIPTS_DIRECTORY" , DOCUMENT_ROOT . "/scripts" ) ;
define( "CLASSES_DIRECTORY" , DOCUMENT_ROOT . "/classes" ) ;
define( "TEMPLATES_DIRECTORY" , DOCUMENT_ROOT . "/templates" ) ;
define( "TEMPLATES_CONFIGS_DIRECTORY" , /*templates(...) . */ "/configs/" ) ;
define( "TEMPLATES_MODALS_DIRECTORY" , /*templates(...) . */ "/modals/" ) ;
define( "TEMPLATES_CRUDS_DIRECTORY" , /*templates(...) . */ "/cruds/" ) ;
define( "TEMPLATES_CONFIGS_DIRECTORY_DIRECT" , TEMPLATES_DIRECTORY . "/configs/" ) ;
define( "TEMPLATES_MODALS_DIRECTORY_DIRECT" , TEMPLATES_DIRECTORY . "/modals/" ) ;
define( "TEMPLATES_CRUDS_DIRECTORY_DIRECT" , TEMPLATES_DIRECTORY . "/cruds/" ) ;
define( "TEMPLATES_TWIG_DIRECTORY" , TEMPLATES_DIRECTORY . "/twig/" ) ;
define( "TWIG_VENDOR_DIRECTORY" , DOCUMENT_ROOT . "/vendor" ) ;

//confs, forms & tmpls
define( "FILES_DIRECTORY" , "data" ) ;
define( "CONFS_DIRECTORY" , FILES_DIRECTORY . "/confs/" ) ;
define( "CONFS_DIR" , TEMPLATES_CONFIGS_DIRECTORY_DIRECT . CONFS_DIRECTORY ) ;
define( "CONFS_EXTENSION" , ".appconf" ) ;
define( "CONTENT_DIRECTORY" , FILES_DIRECTORY . "/content/" ) ;
define( "CONTENT_DIR" , TEMPLATES_CONFIGS_DIRECTORY_DIRECT . CONTENT_DIRECTORY ) ;
define( "CONTENT_EXTENSION" , ".appcontent" ) ;
define( "FORMS_DIRECTORY" , FILES_DIRECTORY . "/forms/" ) ;
define( "FORMS_DIR" , TEMPLATES_CONFIGS_DIRECTORY_DIRECT . FORMS_DIRECTORY ) ;
define( "FORMS_EXTENSION" , ".appform" ) ;
define( "TMPLS_DIRECTORY" , FILES_DIRECTORY . "/tmpls/" ) ;
define( "TMPLS_DIR" , TEMPLATES_CONFIGS_DIRECTORY_DIRECT . TMPLS_DIRECTORY ) ;
define( "TMPLS_EXTENSION" , ".apptmpl" ) ;

//*default* per modal-page
define( "DEFAULT_EXTENSION" , ".inc" ) ;
define( "DEFAULT_EXTENSION_PREVIEW" , ".shtml" ) ;
define( "DEFAULT_FILENAME" , "exemplo" ) ;
define( "TEXT_STATUS_FREE" , "Livre" ) ;
define( "TEXT_STATUS_OPEN" , "Em edição" ) ;

//boilerplate | bootstrap version
define( "BOOTSTRAP_VERSION" , "3.0" ) ;
define( "BOILERPLATE_VERSION" , "2.8" ) ;

//default includes
require ( SCRIPTS_DIRECTORY . '/context.inc.php' /*dev, prod, test*/ ) ;
require ( SCRIPTS_DIRECTORY . '/urls.inc.php' ) ;
require ( SCRIPTS_DIRECTORY . '/includes.inc.php' ) ;
require ( SCRIPTS_DIRECTORY . '/classes.inc.php' ) ;

?>