<?php

	global $util ;
	global $appolo_gui ;

	$util->set_off( 1 ) ;

	header( "Content-type: application/json" );
?>

urls ( {
	"items" : [
		{
			"url": "<?php echo APPOLO_URL?>",
			"value": "Appolo",
			"items": [
				{
					"value": "Home",
					"url": "/",
					"short": "<?php echo APPOLO_URL?>"
				},
				{
					"value": "Dashboard",
					"url": "<?php echo  APPOLO_DASHBOARD?>",
					"short": "<?php echo APPOLO_URL . APPOLO_DASHBOARD?>"
				},
				{
					"value": "Dashboard",
					"comment": "first welcome",
					"params": [
					{
						"name": "warn",
						"value": "1"
					}
					],
					"url": "<?php echo  APPOLO_DASHBOARD?>",
					"short": "<?php echo APPOLO_URL . APPOLO_DASHBOARD?>"
				},
				{
					"value": "Dashboard",
					"comment": "welcome back",
					"params": [
					{
						"name": "warn",
						"value": "2"
					}
					],
					"url": "<?php echo  APPOLO_DASHBOARD?>",
					"short": "<?php echo APPOLO_URL . APPOLO_DASHBOARD?>"
				},
				{
					"value": "Commits - Repositório",
					"url": "<?php echo  REPOSITORY_LIST?>",
					"blank": true
				},
				{
					"value": "Publisher - Live",
					"url": "<?php echo  PUBLISHER_LIVE?>",
					"blank": true
				},
				{
					"value": "Trello - Ferramenta de organização",
					"url": "<?php echo  TRELLO_TOOL?>",
					"blank": true
				},
				{
					"value": "Twig - Leitura de templates",
					"url": "<?php echo  TWIG_URL?>",
					"blank": true
				}
			]
		},
		{
			"url": "<?php echo APPOLO_URL?>",
			"value": "Login",
			"items": [
				{
					"value": "Login",
					"url": "<?php echo APPOLO_LOGIN?>",
					"way": "&gt;",
					"short": "<?php echo APPOLO_URL . APPOLO_LOGIN?>",
					"items": [
					{
						"value": "Aviso",
						"comment": "preenchimento",
						"params": [
						{
							"name": "warn",
							"value": "1"
						}
						],
						"url": "<?php echo APPOLO_LOGIN?>",
						"short": "<?php echo APPOLO_URL . APPOLO_LOGIN?>"
					},
					{
						"value": "Aviso",
						"comment": "usuário não cadastrado",
						"params": [
						{
							"name": "warn",
							"value": "2"
						}
						],
						"url": "<?php echo APPOLO_LOGIN?>",
						"short": "<?php echo APPOLO_URL . APPOLO_LOGIN?>"
					},
					{
						"value": "Aviso",
						"comment": "senha incorreta",
						"params": [
						{
							"name": "warn",
							"value": "3"
						}
						],
						"url": "<?php echo APPOLO_LOGIN?>",
						"short": "<?php echo APPOLO_URL . APPOLO_LOGIN?>"
					},
					{
						"value": "Aviso",
						"comment": "sessão expirada",
						"params": [
						{
							"name": "warn",
							"value": "4"
						}
						],
						"url": "<?php echo APPOLO_LOGIN?>",
						"short": "<?php echo APPOLO_URL . APPOLO_LOGIN?>"
					},
					{
						"value": "Aviso",
						"comment": "logout",
						"params": [
						{
							"name": "warn",
							"value": "5"
						}
						],
						"url": "<?php echo APPOLO_LOGIN?>",
						"short": "<?php echo APPOLO_URL . APPOLO_LOGIN?>"
					}
					]
				},
				{
					"value": "Logout",
					"url": "<?php echo APPOLO_LOGOUT?>",
					"way": "&gt;",
					"short": "<?php echo APPOLO_URL . APPOLO_LOGOUT?>"
				}
			]
		},
		{
			"url": "<?php echo APPOLO_URL?>",
			"value": "Páginas",
			"items": [
				{
					"value": "Páginas",
					"url": "<?php echo PAGES_URL?>",
					"way": "&gt;",
					"short": "<?php echo APPOLO_URL . PAGES_URL?>",
					"items": [
					{
						"value": "Seções",
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Raiz",
						"params": [
						{
							"name": "test",
							"value": "1"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Exemplo 1 - raiz",
						"comment": "max 20 resultados",
						"params": [
						{
							"name": "test",
							"value": "1"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Exemplo 2 - nivel",
						"params": [
						{
							"name": "test",
							"value": "2"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Exemplo 3 - pasta c/ paginas",
						"params": [
						{
							"name": "test",
							"value": "3"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Exemplo 4 - páginas c/ status",
						"params": [
						{
							"name": "test",
							"value": "4"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Exemplo 5 - páginas c/ paginação e status",
						"params": [
						{
							"name": "test",
							"value": "5"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					},
					{
						"value": "Exemplo 6 - raiz",
						"comment": "última",
						"params": [
						{
							"name": "test",
							"value": "6"
						}
						],
						"url": "<?php echo  SECTIONS_PAGES_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_PAGES_URL?>"
					}
					]
				}
			]
		},
		{
			"url": "<?php echo APPOLO_URL?>",
			"value": "Notícias",
			"items": [
				{
					"value": "Notícias",
					"url": "<?php echo NEWS_URL?>",
					"way": "&gt;",
					"short": "<?php echo APPOLO_URL . NEWS_URL?>",
					"items": [
					{
						"value": "Seções",
						"url": "<?php echo  SECTIONS_NEWS_URL?>",
						"short": "<?php echo APPOLO_URL . SECTIONS_NEWS_URL?>"
					},
					{
						"value": "Nova Notícia",
						"url": "<?php echo  NEWS_NEW_URL?>",
						"short": "<?php echo APPOLO_URL . NEWS_NEW_URL?>"
					}
					]
				}
			]
		}
	]
} ) ;