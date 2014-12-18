/**
 * Common (base) jQuery plugin v1.0
 * http://dev.appolo.guiatech.com.br/
 * Copyright 2014, Guia Tech
 * Author: João Guilherme C. Prado
 * Library: jQuery 1.10.2
 * 
 * Ultilizado para incorporar os ajustes e compilar informações a tela do Appolo
 *
 * Date: Tue Oct 29 2013 10:35:09 GMT-0300
 */

/*
 *Verifica se o navegador possui console
 */
if( typeof console == "undefined" ) {
	window.console = { log: $.noop } ;
}

/*
 * Objeto principal, todas as variavéis, funções, objetos, arrays devem estar dentro do objeto appolo
 */
var appolo = {}, urls = new Array() ; //Globals

// Calendar
appolo.calendar = {

	dayNames: [ "Domingo" , "Segunda" , "Terça" , "Quarta" , "Quinta" , "Sexta" , "Sábado" , "Domingo" ] ,
	dayNamesMin: [ "D" , "S" , "T" , "Q" , "Q" , "S" , "S" , "D" ] ,
	dayNamesShort: [ "Dom" , "Seg" , "Ter" , "Qua" , "Qui" , "Sex" , "Sáb" , "Dom" ] ,
	monthNames: [ "Janeiro" , "Fevereiro" , "Março" , "Abril" , "Maio" , "Junho" , "Julho" , "Agosto" , "Setembro" , "Outubro" , "Novembro" , "Dezembro" ],
	monthNamesShort: [ "Jan" , "Fev" , "Mar" , "Abr" , "Mai" , "Jun" , "Jul" , "Ago" , "Set" , "Out" , "Nov" , "Dez" ] ,

	config: function() {

		var that = this ;

		$.datepicker.regional[ "pt-BR" ] = {
            dateFormat: "dd/mm/yy" ,
            dayNames: that.dayNames ,
            dayNamesMin: that.dayNamesMin ,
            dayNamesShort: that.dayNamesShort ,
            monthNames: that.monthNames ,
            monthNamesShort: that.monthNamesShort ,
            nextText: "Próximo" ,
            prevText: "Anterior"
        };
        $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] ) ;

	} ,

	init: function( elem ) {
		//this.config() ;
		$( elem ).datepicker() ;
	}
} ;


//appolo gui configs
appolo.gui = {

	set_focus_first_field: function(){
		var that = this ;

		$( 'input[type=text]:first-child' ).focus() ;
	},

	//mount li to urls config
	mount_ul_li: function( list, item ){
		var that = this, code = params = aux = "" ;
		if ( item == 0 ) {
			code += "<h3>" + list.value + "</h3>" ;
		} else {
			if ( list.params ) {
				params_list = list.params ;
				for( j = 0; j < params_list.length; j++ ){
					if ( params_list[j].name && params_list[j].value ){
						params += ( j == 0 ) ? "?" : "&" ;
						params += params_list[j].name + "=" + encodeURIComponent(params_list[j].value) ;
					}
				}
			}
			code += "<strong>" + list.value  + "</strong>" + ( ( list.comment ) ? ( " (" + list.comment + ")" ) : "" ) + ( ( list.way ) ? ( " " + list.way + " " ) : ":" ) ;
			code += "<a href='" + list.url + params + ( ( ! list.blank ) ? ( ( ( params == "" ) ? "?feature=urls" : "&feature=urls" ) ) : '' ) ;
			code += "'" + ( ( list.blank ) ? " target='_blank' class='external' " : "" ) + " >" ;
				code += ( ( list.short ) ? list.short : list.url ) + params ;
			code += "</a>" ;
		}
		
		if ( ! ( typeof list.items == "undefined" ) ) {
			code += "<ul>" ;
				for( urls[item] = 0; urls[item] < list.items.length; urls[item]++ ){
					code += "<li>" ;
						code += that.mount_ul_li( list.items[urls[item]], 1 ) ;
					code += "</li>" ;
				}
			code += "</ul>" ;
		}

		return code ;
	},

	//mount urls list
	mount_urls_list: function(list, item){
		var that = this, subitems = code = params = "" ;

		code += "<ul" + ( ( item==0 ) ? " class='main'" : "" ) + ">" ;
			for( i = 0; i < list.length; i++ ){
				code += "<li>" ;
					code += that.mount_ul_li( list[i], item ) ;
				code += "</li>" + ( ( item == 0 ) ? ( "<hr>" )  : "" ) ;
			}
		code += "</ul>" ;

		return code ;

	},

	//render message
	render_message: function( type, show_button_close, message, classes ) {
		var that = this, code = '' ;

		code = "<div class='alert alert-" + type + " fade in " + classes + "'>" ;
			code += ( show_button_close ) ? "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" : "" ;
			code += message ;
		code += "</div>" ;

		return code ;
	},

	//render warn WITH message
	render_warn_message: function( text ){
		var that = this ;
		$( appolo.configs.area_warn ).html( text ) ;
	},

	pagination: {

		pages: null,

		limit: null,

		grid: null,

		//return currently page
		get_currently_page: function(){
			var that = this ;

			return appolo.configs.currently_page ;
		},

		//mount pagination
		mount: function(){
			var that = this, element = $( '.pagination' ), pages = parseInt( that.pages ),
			code = pre_prev = pre_next = '' ;

			//pagination
			if ( pages > 1 ){
				pre_prev = ( ! ( ( parseInt( that.get_currently_page() ) - 1 ) < 1 ) ) ? ( parseInt( that.get_currently_page() ) - 1 ) : 1 ;
				pre_next = ( ! ( ( parseInt( that.get_currently_page() ) + 1 ) > pages ) ) ? ( parseInt( that.get_currently_page() ) + 1 ) : pages ;
				code += '<li class="prev ' + ( ( that.get_currently_page() == 1 ) ? ' disabled ' : '' ) + '"><a href="#p-' + pre_prev + '">«</a></li>' ;
				for ( var i = 1 ; i <= pages ; i++ ) {
					code += '<li class="p p-' + i + ' ' + ( ( that.get_currently_page() == i ) ? ' active' : '' ) + '"><a href="#p-' + i + '">' + i + ' <span class="sr-only">(atual)</span></a></li>' ;
				}
				code += '<li class="next ' + ( ( that.get_currently_page() == pages ) ? ' disabled" ' : '' ) + '""><a href="#p-' + pre_next + '">»</a></li>' ;
				element.show() ;
			}else{
				code = '' ;
				element.hide() ;
			}

			//write pagination
			element.html( code ) ;

			//check
			that.check() ;
		},

		//view page / show page
		view_page: function( page ){
			var that = this, tbody = $( that.grid ) ;

			tbody.find( '.page' ).each( function( i ){
				$( this ).hide() ;
				if( $( this ).hasClass( 'page-' + page ) ){
					$( this ).fadeIn() ;
					$( '.section-gap > .title .page b' ).html( page ) ;
				}
			}) ;
		},

		//prev
		prev_page: function( element ){
			var that = this, element = $( element ) ;
			
			if( ! ( that.get_currently_page() == 1 ) ){
				element.attr( 'href', '#p-' + ( --appolo.configs.currently_page ) ) ;
			}
		},

		//next
		next_page: function( element ){
			var that = this, element = $( element ) ;

			if( ! ( that.get_currently_page() == that.pages ) ){
				element.attr( 'href', '#p-' + ( ++appolo.configs.currently_page ) ) ;
			}
		},

		//check pagination
		check: function(){
			var that = this, element = $( '.pagination' ), prev_button = next_button = '' ;

			if( that.pages != null && that.limit != null ){

				that.view_page( appolo.configs.currently_page ) ;

				prev_button = element.find( '.prev > a' ).unbind() ;
				next_button = element.find( '.next > a' ).unbind() ;

				/*-->clicks prev&next*/
					prev_button.click( function(){
						that.prev_page( this ) ;
					} ) ;

					next_button.click( function(){
						that.next_page( this ) ;
					} ) ;
				/*-->/clicks prev&next*/

				/*-->classes prev&next*/
					if( that.get_currently_page() == 1 ){
						if ( ! ( prev_button.parent().hasClass( 'disabled' ) ) ){
							prev_button.parent().addClass( 'disabled' ) ;
						}
					}else{
						if ( prev_button.parent().hasClass( 'disabled' ) ){
							prev_button.parent().removeClass( 'disabled' ) ;
						}
					}

					if( that.get_currently_page() == that.pages ){
						if ( ! ( next_button.parent().hasClass( 'disabled' ) ) ){
							next_button.parent().addClass( 'disabled' ) ;
						}
					}else{
						if ( next_button.parent().hasClass( 'disabled' ) ){
							next_button.parent().removeClass( 'disabled' ) ;
						}
					}
				/*-->/classes prev&next*/

			}

			//move active on
			element.find( 'li' ).each( function(){
				if ( $( this ).hasClass( 'active' ) ){
					$( this ).removeClass( 'active' ) ;
				}
			} ) ;

			$( '.p-' + that.get_currently_page() ).addClass( 'active' ) ;
		}
	},

	//mount breadcrumb of an array
	mount_breadcrumb: function ( after_ajax_sections ){
		var that = this, nav = appolo.configs.nav, breadcrumb = $( appolo.configs.breadcrumb ), code = a_icon_folder = '', i = j = 0 ;

		a_icon_folder = ' <span class="glyphicon glyphicon-folder-open a-icon"></span>' ;

		//alert( after_ajax_sections ) ;

		for ( i = 0 ; i <= nav.length - 1 ; i++ ) {
			if ( ! Array.isArray( nav[ i ] ) ){
				code += '<li class="' + ( ( nav[ i ][ 'active' ] ) ? ' active' : '' ) + '">' ;
					code +=  ( ( ! nav[ i ][ 'active' ] ) ? '<a href="' + nav[ i ][ 'link' ] + '">' + nav[ i ][ 'title' ] + '</a>' : nav[ i ][ 'title' ] ) ;
				code += '</li>' ;
			}else{
				for ( j = nav[ i ].length - 1 ; j >= 0 ; j-- ) {
					code += '<li class="' + ( ( nav[ i ][ j ][ 'active' ] ) ? ' active' : '' ) + '">' ;
						code +=  ( ( ! nav[ i ][ j ][ 'active' ] ) ? '<a href="' + nav[ i ][ j ][ 'link' ] + '">' + nav[ i ][ j ][ 'title' ] + '</a>' : a_icon_folder + nav[ i ][ j ][ 'title' ] ) ;
					code += '</li>' ;
				}
			}
		}

		breadcrumb.html( code ) ;

		for ( i = 0 ; i <= nav.length - 1 ; i++ ) {
			if( ( after_ajax_sections ) && ( nav[ i ][ 'slug' ] == 'loading' ) ){
				nav.splice( i, 1 ) ;
				$( '.breadcrumb .breadcrumb-loading' ).parent().parent().remove() ;
			}
		}
	},

	//mount dashboard
	mount_dashboard: function( w , h ){
		var that = this,
		item_dashboard = $( '.dashboard .item' ),
		current_item_top = ( -1 ), last_item_top = sameline = valmax = 0 ;

		//adjust height
		if( item_dashboard.length ){
			for( i = 0; i < item_dashboard.length; i++){
				if ( $( item_dashboard[i] ).height() > valmax ) { valmax = $( item_dashboard[i] ).height() ; }
			}
			$( item_dashboard ).css( 'min-height' , valmax ) ;

		}

		//changing items ordering - main dashboard
		$( ".container-middle" ).sortable({
			handle: ".icons .move",
			opacity: 0.6,
			revert: true
		});

		$( ".container-middle" ).disableSelection() ;

	}

} ;

//util functions
appolo.util = {

	//feature when comes
	backurls: '.backurls',

	//render template in mustache.js
	mustache_render_template: function ( template, data ){
		var that = this, html = '' ;
		html = ( ! data == '' ) ? Mustache.render( template, data ) : Mustache.render( template ) ;
		return html ;
	},

	change_status_nav: function ( item, index, status ){
		var that = this, nav = appolo.configs.nav ;

		if( item != '' ){
			for ( var i = 0 ; i <= nav.length - 1 ; i++ ) {
				if ( nav[ i ][ 'slug' ] == item ){
					nav[ i ][ 'active' ] = status ;
				}
			}	
		}else if ( index != '' ){
			nav[ index ][ 'active' ] = status ;
		}
	},

	//show template that's currently rendering
	show_rendering_template: function( template ){
		var that = this ;

		console.info( 'Appolo | Rendering template: "' + template + '"' ) ;
	},

	//add close button
	backurl: function() {
		var that = this,
		backurls = $( that.backurls ) ;

		$( backurls.find( '.close' ) ).click(function(){
			backurls.slideUp() ;
			return false;
		}) ;
	},

	//set zero before a number under 10
	set_zero: function( num ){
		var that = this,
		number = num ;

		if( number.toString().substring(0) != '0' ){
			number = ( ( number < 10 ) ? ( '0' + number ) : number )
		}
		
		return number ;
	},

	//set a hash
	set_hash: function( hash ){
		var that = this ;

		location.href = location.href + hash ;
	},

	//mount full date with a date
	mount_date_full: function( dt ){
		var that = this,
		data = new Date ( dt ) ;

		return appolo.calendar.dayNames[ data.getDay() ] + ', ' + that.set_zero( data.getDate() ) + ' de ' + appolo.calendar.monthNames[ data.getMonth() ] + ' de ' + ( data.getYear() + 1900 ) ;
	},

	//mount a correct date with a date
	mount_date_min: function( dt ){
		var that = this,
		data = new Date ( dt ) ;

		return that.set_zero( data.getDate() ) + '/' + that.set_zero( ( data.getMonth() + 1 ) ) + '/' + ( data.getYear() + 1900 ) ;
	},

	treat_not_null: function( where, bp ){
		var that = this, breakpoint = bp ;
		$( where.find( '.not-null' ) ).each(function(){
			$( '#' + $( this ).attr('for') ).each(function(){
				control_group = "" ;
				if( $( this ).val() == "" ){
					control_group = $( this ).parent().parent() ;
					control_group.addClass( 'has-error' ) ;
					$( this ).focus() ;
					$( this ).unbind( 'change' ) ;
					$( this ).change(function(){
						if ( $( this ) ){
							$( this ).parent().parent().removeClass( 'has-error' ) ;
						}
						$( this ).unbind( 'change' ) ;
					}) ;
					breakpoint = true ;
				}else if( ! breakpoint ){
					breakpoint = false ;
				}
			}) ;
		}) ;
		return breakpoint ;
	}

} ;

//init configs para o appolo
appolo.configs = {

	today: null,

	collection_urls: null,

	//windows size
	w_wi: $( window ).width(),
	w_he: $( window ).height(),

	//context
	context: 'dev',

	//dashboard
	dashboard: '.home .dashboard',

	//navbar
	navbar: '.navbar',

	//container
	container: '.container',

	//breadcrumb
	breadcrumb: '.breadcrumb', nav: new Array(),

	//login
	content_login: '.login .content-login',

	//login
	content_urls: '.urls .content-urls',

	//pages
	pages_content_sections: '.pages .content-sections',

	//news
	news_content_sections: '.news .content-sections',

	//userdetails
	userdetails: '.navbar .userdetails',

	//userdetails_hover
	userdetails_hover: '.navbar .hover',

	//view
	view_userdetails: '.navbar .view',

	//area warn
	area_warn: '.area-warn',

	//clear warn
	clear_warn: 0,

	//currently_page
	currently_page: 1,

	//view_staging
	view_staging : null,

	//pages
	pages: {

		pages_content_sections: null,
		currently_open_section: null,
		currently_open_modal: null,
		currently_open_page: null,
		back_section: null,
		form_grid_pages_sections: 'grid_pages_sections',
		temporary_sections: new Array(),
		default_time_loading: 500,
		round: 0,
		count_round: 0,

		set_parent_pages_section: function( section, pages ){
			var that = this, section_pages_parent = '' ;

			$.ajax({
				dataType: 'json',
				url: appolo.configs.select_pages_section_last + section ,
			}).done( function( sections_parent ){
				if( sections_parent[0]["nomeSecao"] != "" ){
					$( '.section-gap > .title').html( '<span class="glyphicon glyphicon-folder-open a-icon"></span>' + sections_parent[0]["nomeSecao"] + ( ( pages > 1 ) ? ('<span class="page">(página <b>' + appolo.configs.currently_page + '</b>)</span>' ) : '' ) ) ;

					if( sections_parent[0]["secaoHidden"] == 1 ){
						$( '.section-gap > .title').addClass( 'inactive' ) ;
					}

					$( '.section-gap > .title' ).attr( 'data-toggle', 'tooltip' ) ;
					$( '.section-gap > .title' ).attr( 'data-placement', 'bottom' ) ;
					$( '.section-gap > .title' ).attr( 'data-original-title', sections_parent[0]["descricaoSecao"] ) ;
					if ( ! $( '.section-gap > .title' ).hasClass( 'plusinfo' ) ){
						$( '.section-gap > .title' ).addClass( 'plusinfo' ) ;	
					}
				}
			} ).error( function(){
				$( '.section-gap > .title').html( '<span class="glyphicon glyphicon-edit a-icon"></span>Páginas' ) ;
			}) ;

		},

		get_parent_pages_section_breadcrumb: function( section ){
			var that = this, section_pages_parent = last_item_nav_index = '' ;

			that.round++ ;

			$.ajax({
				dataType: 'json',
				url: appolo.configs.select_pages_section_last + ( ( section != null ) ? ( section ) : "0" ) ,
			}).done( function( sections_parent ){
				section_pages_parent = { "sections": [] } ; //array

				section_pages_parent.sections.push( {
					"idSecao": ( ( sections_parent[0]["idSecaoPai"] != 0 ) ? sections_parent[0]["idSecaoPai"] : "" ),
					"nomeSecao": ( ( sections_parent[0]["idSecaoPai"] != 0 ) ? sections_parent[0]["nomeSecao"] : "um nível acima" )
				} ) ;

				that.temporary_sections.push( { "title": sections_parent[0]['nomeSecao'], "slug": section, "active": ( ( section == that.currently_open_section && that.currently_open_page == null ) ? true : false ), "link": ( appolo.configs.pages_sections_url + section ) } ) ;

				if ( sections_parent[0]["idSecaoPai"] != 0 ){
					that.get_parent_pages_section_breadcrumb( sections_parent[0]["idSecaoPai"] ) ;
				}

				that.count_round++ ;

				if( that.round == that.count_round ){
					//mount breadcrumb after ajax sections
					appolo.gui.mount_breadcrumb( true ) ;
				}
				
			} ) ;

		},

		get_parent_pages_section_back: function( section, where ){
			var that = this, section_pages_parent = last_item_nav_index = '' ;

			$.ajax({
				dataType: 'json',
				url: appolo.configs.select_pages_section_last + ( ( section != null ) ? ( section ) : "0" ) + '/true' , /*true*/
			}).done( function( sections_parent ){
				section_pages_parent = { "sections": [] } ; //array

				section_pages_parent.sections.push( {
					"idSecao": ( ( sections_parent[0]["idSecaoPai"] != 0 ) ? sections_parent[0]["idSecaoPai"] : "" ),
					"nomeSecao": ( ( sections_parent[0]["idSecaoPai"] != 0 ) ? sections_parent[0]["nomeSecao"] : "um nível acima" )
				} ) ;

				if ( that.back_section != 1 ){
					where.prepend( appolo.util.mustache_render_template( render_sections_pages_head, section_pages_parent ) ) ;
					++that.back_section ;
				}
				
			} ) ;

		},

		form_check: function( form_to_check, class_check, ask_msg, btn_del_checks, btn_properties ){
			var that = this, breakpoint = 0, form = $( ( 'form[name=' + form_to_check + ']' ) ), form_tr = $( ( 'form[name=' + form_to_check + '] ' + ( ( class_check ) ? class_check : "" ) ) ) ;

			form.attr( 'action', appolo.configs.delete_pages_sections ) ;

			form_tr.find('input[type=checkbox]').unbind() ;
			form_tr.find('input[type=checkbox]').change(function(){
				breakpoint = 0 ;

				form_tr.find('input[type=checkbox]:checked').each(function(){
					breakpoint++ ;
				}) ;

				if ( breakpoint > 0 ){
					$( btn_del_checks ).removeClass( 'disabled' ) ;
					if ( breakpoint <= 1 ){
						$( btn_properties ).removeClass( 'disabled' ) ;
					}else{
						$( btn_properties ).addClass( 'disabled' ) ;
					}
				}else{
					$( btn_del_checks ).addClass( 'disabled' ) ;
					$( btn_properties ).addClass( 'disabled' ) ;
				}
			}) ;

			$( btn_del_checks ).unbind() ; /*default*/
			$( btn_del_checks ).click(function(){
				if( ! $( this ).hasClass('disabled') ){
					if ( confirm( ask_msg ) ){
						form.submit() ;
					}
				}
			}) ;

			$( btn_properties ).unbind() ; /*default*/
			$( btn_properties ).click(function(){
				if( ! $( this ).hasClass('disabled') ){
					console.log( 'view properties' ) ;
				}
			}) ;
		},

		init: function(){
			var that = this,
			pages_content_sections = $( that.pages_content_sections ),
			table_sections = pages_content_sections.find( '.table-sections' ),
			content_table_sections = table_sections.find( 'tbody.active' ),
			content_table_sections_back_section = table_sections.find( 'tbody.back-section' ),
			data_limit_per_page = table_sections.attr( 'data-limit-per-page' ),
			currently_open_section = that.currently_open_section,
			currently_open_modal = that.currently_open_modal,
			render = { "template": {}, "data": {} }, sn = 0, live_count = section_dataCriacao = section_dataCriacao_min = section_dataCriacao_full = section_datahoraPublicacao = section_datahoraPublicacao_min = section_datahoraPublicacao_full = section_pages_parent = section_pages = '', content_table_sections_per_page = new Array() ;

			content_table_sections.html( appolo.util.mustache_render_template( render_sections_pages_loading ) ) ;

			$.ajax({
				dataType: 'json',
				url: appolo.configs.select_pages_sections + ( ( currently_open_section != null ) ? ( currently_open_section ) : "0" )
				}).done(function( sections ){

				if ( Array.isArray( appolo.configs.nav[ appolo.configs.nav.length - 1 ] ) ) { appolo.configs.nav.pop() ; }

				if ( currently_open_section ){
					appolo.util.change_status_nav( 'sections', 0, false ) ;
					appolo.configs.pages.temporary_sections = new Array() ;
					appolo.configs.nav.push( { "title": "<img src=\"/images/icon-loading.gif\" alt=\"Carregando...\" class=\"breadcrumb-loading\">", "slug": "loading", "active": false, "link": "" } ) ;
					that.get_parent_pages_section_breadcrumb( currently_open_section ) ;
					appolo.configs.nav.push( appolo.configs.pages.temporary_sections ) ;
					that.get_parent_pages_section_back( currently_open_section, content_table_sections_back_section ) ; //back section
				}

				section_pages = { "sections": [] } ;

				$.each( sections, function( i, section ) {
					if( section.idSecao ){ //it its a true page
						section_dataCriacao = new Date ( section.dataCriacao ) ;
						section_dataCriacao_min = appolo.util.mount_date_min ( section_dataCriacao ) ;
						section_dataCriacao_full = appolo.util.mount_date_full( section_dataCriacao ) ;

						section_pages.sections.push( {
							"id_item": section.idSecao,
							"icon_item": "folder-close",
							"type": "sections",
							"url_prefix": appolo.configs.pages_sections_url,
							"name_item": section.nomeSecao,
							"desc_item": section.descricaoSecao,
							"created": ( ( section.idSecao == appolo.configs.section_created ) ? "yes" : "" ),
							"section_dataCriacao_min": section_dataCriacao_min,
							"section_dataCriacao_full": section_dataCriacao_full,
							"addclass": [
								{ "class": ( ( section.secaoHidden == 1 ) ? 'non-visible' : '' ) },
								{ "class": ( ( section.descricaoSecao != '' ) ? 'plusinfo' : '' ) }
							]
						 } ) ;
					}else if( section.idPagina ){ //if its a true page
						section_datahoraCriacao = new Date ( section.datahoraCriacao ) ;
						section_datahoraCriacao_min = appolo.util.mount_date_min ( section_datahoraCriacao ) ;
						section_datahoraCriacao_full = appolo.util.mount_date_full( section_datahoraCriacao ) ;

						section_datahoraPublicacao = new Date ( section.datahoraPublicacao ) ;
						section_datahoraPublicacao_min = ( section.datahoraPublicacao ) ? appolo.util.mount_date_min ( section_datahoraPublicacao ) : "" ;
						section_datahoraPublicacao_full = ( section.datahoraPublicacao ) ? appolo.util.mount_date_full( section_datahoraPublicacao ) : "" ;

						section_pages.sections.push( {
							"id_item": section.idPagina,
							"icon_item": "file",
							"type": "pages",
							"url_prefix": appolo.configs.pages_page_url,
							"name_item": section.nomePagina,
							"desc_item": section.descricaoPagina,
							"created": ( ( section.idPagina == appolo.configs.page_created ) ? "yes" : "" ),
							"section_dataCriacao_min": section_datahoraCriacao_min,
							"section_dataCriacao_full": section_datahoraCriacao_full,
							"section_dataPublicacao_min": section_datahoraPublicacao_min,
							"section_dataPublicacao_full": section_datahoraPublicacao_full,
							"addclass": [
								{ "class": ( ( section.paginaHidden == 1 ) ? 'non-visible' : '' ) },
								{ "class": ( ( section.descricaoPagina != '' ) ? 'plusinfo' : '' ) }
							]
						 } ) ;
					}

				}) ;


				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( section_pages.sections.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_sections ;

				that.set_parent_pages_section( currently_open_section, appolo.gui.pagination.pages ) ;

				render['template'] = render_sections_pages ;
				render['data'] = section_pages ;

				if( sections.length == 0 ){ //if theres is no result, render a page with "none"
					render['template'] = render_sections_pages_none ;
					render['data'] = '' ;
				}

				content_table_sections.find( 'img' ).fadeOut( that.default_time_loading ) ;

				if( appolo.configs.clear_warn ){
					appolo.gui.render_warn_message( '' ) ;
					appolo.configs.clear_warn = 0 ;
				}

				setTimeout( function() {
					content_table_sections.find( 'tr.loading' ).remove() ;

					appolo.configs.section_created = '' ;
					appolo.configs.page_created = '' ;
					if ( $( that.area_warn ).html() == '' ) {
						appolo.configs.clear_warn = 1 ;
					}

					if( ! ( appolo.gui.pagination.pages > 1 ) ){
						content_table_sections.append(
							appolo.util.mustache_render_template( render['template'], render['data'] )
						) ;
					}else{
						var section_pages_per_page = new Array() ; //sections per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							section_pages_per_page[ i ] = { "sections": [] } ;
							if( ( i != 1 ) && ( ! table_sections.find( 'tbody.page-' + i ).length ) ) {
								table_sections.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_sections.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_sections_per_page[ i ] = table_sections.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].sections[ sn ] != 'undefined'){
									section_pages_per_page[ i ].sections[ j ] = render['data'].sections[ sn ] ;
								}
								sn++ ;
							}

							if ( i > 1 ){
								if( ( content_table_sections_per_page[ i ].find( '.indicator-up' ).length == 0 ) ){
									content_table_sections_per_page[ i ].prepend( appolo.util.mustache_render_template( render_sections_pages_page, { "icon": "up", "page": ( i - 1 ) } ) ) ;
								}
							}

							content_table_sections_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], section_pages_per_page[ i ] )
							) ;

							if ( i < appolo.gui.pagination.pages ){
								if( ( content_table_sections_per_page[ i ].find( '.indicator-down' ).length == 0 ) ){
									content_table_sections_per_page[ i ].append( appolo.util.mustache_render_template( render_sections_pages_page, { "icon": "down", "page": ( i + 1 ) } ) ) ;
								}
							}
						}
					}
					
					appolo.gui.pagination.mount() ;

					that.form_check( that.form_grid_pages_sections, '.check', 'Tem certeza que deseja deletar ?', '.del-checks', '.view-properties' ) ;

					appolo.configs.set_functions_pos_ajax() ;

				}, that.default_time_loading ) ;

			}) ;

		}


	},

	//news
	news: function(){
		var that = this,
		news_content_sections = $( that.news_content_sections ), btn_submit = "" ;

		if ( $( 'form[name=news_new]' ).length ) {
			frm_news_new = $('form[name=news_new]') ;
			frm_news_new.on('submit',function(event){
				event.preventDefault() ;
				data = $( this ).serialize() ;

				$.ajax({
					type: "POST", /*update insert_news_news*/
					url: "/crud/insert_news_news",
					data: data
				}).done(function(){
					location.href = '/news/sections/?warn=1' ;
				}) ;
			});
		}

		if ( $( '.view_staging' ).length ){
			$( '.view_staging' ).click(function(){
				event.preventDefault() ;
				var data = ( $(this).attr('name') ).replace(/view-/, '') ;

				$.ajax({
					type: "GET",
					url: "/news/view?p=" + data
				}).done(function(){
					location.href = appolo.configs.view_staging + data + '.html' ;
				}) ;
			}) ;
		}

	},

	//show modal passing an id
	show_modal: function ( modal ){
		var that = this,
		controls = '.controls', control_group = "", aux_verify_modals = true, breakpoint = false, treat = appolo.treat, lock = 0 ;

		if( $( '#' + modal ).length > 0 ){

			$( '.modal' ).each( function(){
				if ( ( ! ( $( this ).css( 'display' ) == 'none' ) && ( ! ( $( this ).hasClass( modal ) ) ) ) ) {
					aux_verify_modals = false ;
				}
			} ) ;

			if ( aux_verify_modals ) {

				//this modal
				this_modal = $( '#' + modal ) ;
				this_modal.modal() ;

				//modal new section - pages
				if ( modal == 'section' ){
					$( '#section' ).on( 'shown.bs.modal' , function () { //on shown

						//first input focus
						appolo.gui.set_focus_first_field() ;

						//set send form
						$( '.send-form' ).unbind( 'click' ) ;
						$( '.send-form' ).click(function(){
							//submit button
							$( this_modal.find( 'form' ) ).submit() ;
						}) ;


						$( this_modal.find( 'form' ) ).unbind( 'submit' ) ;
						$( this_modal.find( 'form' ).find( 'button[type=reset]' ) ).trigger( 'click' ) ;
						$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;

						//->submit form
						$( this_modal.find( 'form' ) ).submit(function(){ //on submit
							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null( this_modal, breakpoint ) ;
								}

								if( breakpoint || lock != 0 ){ /*se houver algum erro*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}
							//->/validacoes

							//form's data
							data = $( this ).serialize() ;

							//->new
							if ( appolo.configs.currently_open_modal == 'new' ){
								$.ajax({
									type: "POST", /*update insert_section*/
									url: appolo.configs.insert_section + ( ( appolo.configs.pages.currently_open_section ) ? appolo.configs.pages.currently_open_section : "0" ),
									data: data
								}).done(function( id ){
									appolo.configs.pages.init() ;
									this_modal.modal( 'hide' ) ;
									appolo.configs.section_created = id ;
									appolo.gui.render_warn_message( appolo.gui.render_message( "success", true, "Seção criada com sucesso !", "animated fadeInRight" ) ) ;
								}) ;
							}
							//->/new

							return false;
						}) ;
						//->/submit form

					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;

						history.pushState( '', document.title, window.location.pathname ) ;

						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

						$( '#section' ).unbind() ;
					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
					}) ;  ;
				}

				//modal page - pages
				if ( modal == 'page' ){
					$('#page').on('shown.bs.modal', function () {
						//first input focus
						$( this_modal.find( '.controls #name_page' ) ).focus() ;
						
						//keyup register val(name)
						$( this_modal.find( '.controls #name_page' ) ).keyup(function(){
							this_field_keydown = $( this ) ;
							value_include = treat.encode_path( this_field_keydown.val() ) ;

							//extensao pull name
							$( this_modal.find( '.controls > .file-ext' ) ).each(function(){
								this_textfile = $( this ) ;
								if ( value_include != '' ){
									value_this = ( this_textfile.attr('placeholder') ).replace(/example/g, value_include ) ;
									this_textfile.attr('value', value_this ) ;
								}else{
									this_textfile.attr('value', this_field_keydown.val() ) ;
								}
							}) ;

						}) ;
					}) ;
				}

			}

		}

	},

	//urls function
	urls: function(){
		var that = this,
		content_urls = $( that.content_urls ), code = "" ;

		$.ajax( {
			url: '/configs/urls_json',
			dataType: 'jsonp',
			crossDomain: true,
			jsonp: true,
			jsonpCallback: 'urls',
			success: function(data) {
				items = ( data.items ) ? data.items : '' ;
				if ( items.length ) {

					for( i = 0; i < items.length; i++ ){
						code += appolo.gui.mount_urls_list(items, 0) ;
					}

					content_urls.html( code ) ;
					
				}
			}
		} );
	},

	//set funcions pos ajax
	set_functions_pos_ajax: function(){
		var that = this, checkboxes = $( '.check input[type=checkbox]' ), lastchecked = "" ;

		//tooltip "plusinfo"
		$( '.plusinfo' ).tooltip() ;

		//select multiply checkboxes
		checkboxes.click(function( e ) {
			if( ! lastchecked ){
				lastchecked = this ;
				return ;
			}
			if( e.shiftKey ){
				var start = checkboxes.index( this );
				var end = checkboxes.index( lastchecked );
				checkboxes.slice( Math.min( start, end ), Math.max( start, end ) + 1 ).attr( 'checked', lastchecked.checked ) ;
			}
			lastchecked = this;
		});

		//select check when click on the row
		if( $( 'tbody > tr' ).length ){
			$( 'tbody > tr' ).each(function( item ){
				$( this ).find( 'a, span' ).click(function( e ){
					e.stopPropagation() ;
				}) ;
				$( this ).add( $( this ).find( 'input[type=checkbox]' ).parent() ).click(function(){
					$( this ).find( 'input[type=checkbox]' ).click() ;
				}) ;
			}) ;
		}

		//mount breadcrumb
		appolo.gui.mount_breadcrumb() ;

	},

	//get hashs and show modal
	get_hashs: function(){
		var that = this, gethash = split_modal = '' ;

		if( location.hash.substring( 1 ).toLowerCase() != "" ){
			gethash = location.hash.toLowerCase().substring( 1 ) ;

			split_modal = gethash.split('-') ;

			if ( ( split_modal[0] != null || split_modal[0] != '' ) && split_modal[0] == 'p' ){
				that.currently_page = split_modal[ 1 ] ;
				appolo.gui.pagination.check() ;
			}

			if ( split_modal[1] != null || split_modal[1] != '' ){
				appolo.configs.currently_open_modal = split_modal[1] ;
				that.show_modal( split_modal[ 0 ] ) ;
			}else{
				that.show_modal( gethash ) ;
			}
		}

	},

	adjust: function(){
		var that = this,
		context = that.context ;

		//focus first field
		appolo.gui.set_focus_first_field() ;

		that.nav.push( { "title": "Dashboard", "slug": "dashboard", "active": false, "link": appolo.configs.dashboard_url } ) ;

		//button up
		$( 'a[href=#top]' ).click(function () {
			$('html, body').animate({scrollTop:0}, 450, function(){ });
			return false;
		});

		//resize dashboard and others
		$( window ).resize(function(){
			that.w_wi = $( window ).width() ;
			that.w_he = $( window ).height() ;
		}) ;

		//class no-link
		if ( $( 'a[href=#]').length ) {
			$( 'a[href=#]').click(function(){
				return false;
			}) ;
		}

		//refresh button (iphone)
		if ( $( 'a.refresh').length ) {
			$( 'a.refresh').click(function(){
				location.href = location.href ;
			}) ;
		}

		//campos not null
		if ( $( 'label.not-null' ).length ) {
			$( 'label.not-null' ).each(function(){
				$( this ).attr( 'data-toggle', 'tooltip' ) ;
				$( this ).attr( 'data-placement', 'right' ) ;
				$( this ).attr( 'data-original-title', 'Campo obrigatório.' ) ;
				if ( ! $( this ).hasClass( 'plusinfo' ) ){
					$( this ).addClass( 'plusinfo' ) ;	
				}
				$( this ).append( ' <span class="glyphicon glyphicon-flash a-icon not-null-icon"></span>' ) ;
			}) ;
		}

		//cancel buttons - advanced context
		if ( $( 'a.cancel').length ) {
			$( 'a.cancel').click(function(){
				if ( confirm( 'Tem certeza que deseja cancelar ?' )){
					location.href = $( this ).attr( 'href' ) ;
				}else{
					return false ;
				}
			}) ;
		}

		//user details ( head )
		if ( $( that.userdetails ).length ){
			view_userdetails = $( that.view_userdetails ) ;

			$( $( that.userdetails ).find('.more-infobutton') ).click(function(e){
				if ( view_userdetails.css('display') == 'none' ){			
					view_userdetails.fadeIn() ;
					view_userdetails.css( 'left', ( e.clientX - ( view_userdetails.height() + 2 ) ) ) ;
				}else{
					view_userdetails.fadeOut() ;
				}
			}) ;

			$( that.userdetails_hover ).click(function(e){
				if ( view_userdetails.css('display') == 'none' ){	
					view_userdetails.fadeIn(500) ;
					view_userdetails.css( 'left', ( e.clientX - ( view_userdetails.height() - 1 ) ) ) ;
				}else{
					view_userdetails.fadeOut() ;
				}
			}) ;

			if ( $( '.details' ).length ){
				$( $( '.details' ).find('.close, .link a') ).click(function(e){
					view_userdetails.fadeOut() ;
				}) ;
				$( '.details' ).click(function(e){
					e.stopPropagation() ;
				}) ;
				$( '.hover' ).click(function(e){
					e.stopPropagation() ;
				}) ;
			}

			$('body').click(function(){
				view_userdetails.fadeOut() ;
			}) ;

			$( window ).resize(function(){
				view_userdetails.fadeOut() ;
			}) ;

		}

		/*wireframes*/

			/*configs*/
			if ( ( context == "test" ) || ( context == "dev" ) ){
				$( 'body' ).addClass( that.context ) ;
				appolo.util.show_rendering_template( appolo.util.rendering_template ) ;
			}

			/*home - dashboard*/
			if ( $( 'body.home').length ) {
				that.nav.push( { "title": "Home", "slug": "home", "active": true, "link": "#" } ) ;
				appolo.gui.mount_dashboard( that.w_wi, that.w_he ) ;
			}
			
			/*pages*/
			if ( $('body.pages').length ) {
				that.nav.push( { "title": "Páginas", "slug": "pages", "active": false, "link": that.pages_url } ) ;
				that.nav.push( { "title": "Seções", "slug": "sections", "active": true, "link": that.pages_sections_url } ) ;
				that.pages.pages_content_sections = that.pages_content_sections ;
				that.pages.init() ;
			}
			
			/*news*/
			if ( $('body.news').length ) {
				that.nav.push( { "title": "Notícias", "slug": "sections", "active": false, "link": that.news_url } ) ;
				that.nav.push( { "title": "Seções", "slug": "sections", "active": true, "link": that.news_sections_url } ) ;
				that.news() ;
			}

			/*urls*/
			if ( $( 'body.urls').length ) {
				that.urls() ;
			}

			//hash change!
			$( window ).bind('hashchange', function() {
				that.get_hashs() ;
			}) ;

			//execute hashs
			that.get_hashs() ;

			//mount breadcrumb
			appolo.gui.mount_breadcrumb() ;

		/*/wireframes*/

	},

	init: function(){

		var that = this ;

		that.adjust() ; //init all those functions [adjusts-appolo]

	}
} ;

//treat functions
appolo.treat = {

	encodes: null,

	encode_path: function ( text ){
		var that = this,
		varString = new String(text),
		stringAcentos = new String('àâêôûãõáéíóúçüÀÂÊÔÛÃÕÁÉÍÓÚÇÜ'),
		stringSemAcento = new String('aaeouaoaeioucuAAEOUAOAEIOUCU'),
		i = j = new Number(),
		cSintrg = new String(),
		varRes = '' ;

		for (i = 0; i < varString.length; i++) {
			cString = varString.substring(i, i + 1);
			for (j = 0; j < stringAcentos.length; j++) {
				if (stringAcentos.substring(j, j + 1) == cString){
					cString = stringSemAcento.substring(j, j + 1);
				}
			}
			varRes += cString;
		}
		text = varRes;

		return ( text.replace(/ /g, '_') ).toLowerCase() ;
	},

	init: function(){
		//do init
	}
} ;


/**
 * Loader
 * Carrega funções padrões
 */
appolo.loader = {
	init: function() {
		appolo.configs.init() ;
	}
} ;


// Handler para loader ( main )
$( function () {
	appolo.loader.init() ;
} ) ;
