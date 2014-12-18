<h1>Appolo (prototype) - CMS</h1>

Known as CMS, Appolo came to make its users comfortable to post, create, approve and edit: pages & news in a website as portal of 'something', e-commerce, blogs, videologs, etc. Among those else, it's also possible to create some templates and forms which are possible to describe exactly what the final user is going to fill and see how it's going on the website. /using pure php w frameworks and so much html, js and css, and this is also totally responsive for the final user (: ;

root (instructions only on this page):
	|
	 scripts/init.inc.php
		|
		 scripts/config.inc.php
			|
			 scripts/context.inc.php ( dev / prod / test )
			 scripts/urls.inc.php ( URL'S )
			 scripts/includes.inc.php ( TEMPLATES )
			 scripts/classes.inc.php ( CLASSES )
				|
				 classes/config.inc.php ( CONFIG STATIC CLASSES )
				 classes/appolo.class.php [ APPOLO FUNCTIONS (BASIC) ]
				 classes/util.class.php ( UTILITY FUNCTIONS )
				 classes/appolo_gui.class.php ( APPOLO GUI )
				 classes/appolo_dispatcher.class.php ( APPOLO DISPATCHER )
					|
					classes/dispatch.inc.php
				 classes/appolo_twig.class.php ( APPOLO (INTEGRATION W/ TWIG) )
			
		
		 includes/init.inc.php ( CREATE OBJECTS )
		
	
