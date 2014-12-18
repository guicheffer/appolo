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


/*
 *Serialize object fieldset
 */
$.fn.serializeField = function() {
    var result = {};
    
    this.each(function() {
        
        $( $(this).find(" > fieldset, > .text input, > .select select, > .textarea textarea").not( '.hide-toggle' ) ).each( function( i ) {
			var $this = $(this), name = $this.data("realname"), groupby = false, item_obj = {} ;

			if( typeof result[name] == 'undefined' ){
				result[name] = {} ;
			}
			if( typeof result[name][ i ] == 'undefined' ){
				result[name][ i ] = {} ;
			}

			if( this.localName != 'fieldset' ){
				result[name] = this.value ;
			}

			$.each( $( $this.find(' > fieldset, > .text input, > .select select, > .textarea textarea').not( '.hide-toggle' ) ), function( j ) {

				if( typeof result[name][ i ][this.dataset.realname] == 'undefined' ){
					result[name][ i ][this.dataset.realname] = {} ;
				}
				if( typeof result[name][ i ][this.dataset.realname][ j ] == 'undefined' ){
					result[name][ i ][this.dataset.realname][ j ] = {} ;
				}

				if( this.localName == 'fieldset' ){
					result[name][ i ][this.dataset.realname][ j ] = $( this ).serializeField() ;
				}

				if( this.localName == 'input' || this.localName == 'select' || this.localName == 'textarea' ){
					result[name][ i ][this.dataset.realname] = this.value ;
				}

			} ) ;

        });
        
    });
    	
    //return result
    return result;
};



// Calendar
appolo.calendar = {

	dayNames: [ "Domingo" , "Segunda" , "Terça" , "Quarta" , "Quinta" , "Sexta" , "Sábado" , "Domingo" ] ,
	dayNamesWFeira: [ "Domingo" , "Segunda-feira" , "Terça-feira" , "Quarta-feira" , "Quinta-feira" , "Sexta-feira" , "Sábado" , "Domingo" ] ,
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

	set_focus_first_field: function( input ){
		var that = this ;

		$( ( 'input[type=text]' + ( ( input == '' ) ? ':first-child' : input ) ) ).focus() ;
	},

	/*forms*/

		check_qty_group_form: function( control, name ){
			var that = this, parent = $( control.parent().parent() ), group = $( control.parent() ) ;

			return $( parent.find( ' > .group[name=' + name + ']' ) ).length ;
		},

		get_limits: function( group, limit ){
			var that = this ;

			return group.data( limit ) ;
		},

		get_max: function( group ){
			var that = this ;

			return that.get_limits( group, 'max' ) ;
		},

		get_min: function( group ){
			var that = this ;

			return that.get_limits( group, 'min' ) ;
		},

		organize_controls_forms: function(){
			var that = this ;

			appolo.configs.pages.page.just_took_out = true ;
			$( appolo.configs.pages.page.control_group_form_page ).each( function( i ) {
				that.set_control_form( $( this ) ) ;
			}) ;
		},

		organize_group_form: function( parent, group, item ){
			var that = this, name = group.attr( 'name' ) ;

			$( parent.find( ' > .group[name=' + name + ']' ) ).each( function( i ){
				$( this ).attr( 'data-item', i ) ;
				this_group = $( this ) ;
				$( $( this ).find( ' > legend > .legend-order' ) ).html( '(' + ( i + 1 ) + ')' ) ;

				//get old name
				old_name = new RegExp( ( '-' + i ), 'g' ) ;

				//fix their groups
				$( $( new_object.find( ' > .group, input, select, textarea' ) ) ).each( function(){
					/*FIX RADIO!*/
					if( $( this )[ 0 ].localName != 'fieldset' ){
						if( $( this )[ 0 ].localName == 'input' ){
							if( $( this )[ 0 ].type == 'radio' ){
								slash =  $( $( this )[ 0 ] ).attr( 'name' ).split( '-' ) ;
								$( $( this )[ 0 ] ).attr( 'name', ( ( $( $( this )[ 0 ] ).attr( 'name' ) ).replace( ( '-' + slash[ ( slash.length - 1 ) ] ), ( '-' + ( appolo.configs.pages.page.i_organize_group ) ) ) ) ) ;
								$( $( this )[ 0 ] ).attr( 'id', ( ( $( $( this )[ 0 ] ).attr( 'id' ) ).replace( ( '-' + slash[ ( slash.length - 1 ) ] ), ( '-' + ( appolo.configs.pages.page.i_organize_group ) ) ) ) ) ;
								if( ! $( $( $( this )[ 0 ] ).parent().next() ).hasClass( 'radio-inline' ) ){
									appolo.configs.pages.page.i_organize_group++ ;	
								}
								if( ! appolo.configs.pages.page.just_inverted ){
									if( typeof $( this ).data( 'check-it-by-default' ) != 'undefined' ){
										$( this ).prop( 'checked', true ) ;
									}	
								}
								return ;
							}
						}
					}
					/*FINISH->FIX RADIO!*/
					$( this ).attr( 'name', $( this ).attr( 'name' ).replace( old_name, ( '-' + ( appolo.configs.pages.page.i_organize_group ) ) ) ) ;
					$( this ).attr( 'id', $( this ).attr( 'id' ).replace( old_name, ( '-' + ( appolo.configs.pages.page.i_organize_group ) ) ) ) ;
					if( ! appolo.configs.pages.page.just_inverted ){
						if( typeof $( this ).data( 'check-it-by-default' ) != 'undefined' ){
							$( this ).prop( 'checked', true ) ;
						}
					}
				}) ;

				//sum
				appolo.configs.pages.page.i_organize_group++ ;
			}) ;
	
			//revoke just inverted
			appolo.configs.pages.page.just_inverted = false ;
		},

		invert_position: function( control, type ){
			var that = this, group1 = group2 = '', parent = $( control.parent().parent() ), group = $( control.parent() ), currently_item = group.data( 'item' ) ;

			if( type == 'up' ){
				group1 = group ;
				group2 = ( ( $( group.prev() ).attr( 'name' ) == group.attr( 'name' ) && $( group.prev() ).hasClass( 'group' ) ) ? $( group.prev() ) : false ) ;
				if( typeof group1 == 'undefined' || typeof group2 == 'undefined' || !group1 || !group2 ){
					$( control.find( '.btn-up-group' ) ).addClass( 'disabled' ) ;
					return false ;
				}
				if( typeof group1.data( 'item' ) == 'undefined' || typeof group2.data( 'item' ) == 'undefined' ){
					$( control.find( '.btn-up-group' ) ).addClass( 'disabled' ) ;
					return false ;
				}
				group1.attr( 'data-item', ( currently_item - 1 ) ) ;
				group2.attr( 'data-item', ( currently_item + 1 ) ) ;

				//change it
				group2.before( group1 ) ;

				$( control.find( '.btn-up-group' ) ).removeClass( 'disabled' ) ;
			}else if( type == 'down' ){
				group1 = group ;
				group2 = ( ( $( group.next() ).attr( 'name' ) == group.attr( 'name' ) && $( group.next() ).hasClass( 'group' ) ) ? $( group.next() ) : false ) ;
				if( typeof group1 == 'undefined' || typeof group2 == 'undefined' || !group1 || !group2 ){
					$( control.find( '.btn-down-group' ) ).addClass( 'disabled' ) ;
					return false ;
				}
				if( typeof group1.data( 'item' ) == 'undefined' || typeof group2.data( 'item' ) == 'undefined' ){
					$( control.find( '.btn-down-group' ) ).addClass( 'disabled' ) ;
					return false ;
				}
				group1.attr( 'data-item', ( currently_item + 1 ) ) ;
				group2.attr( 'data-item', ( currently_item - 1 ) ) ;

				//change it
				group1.before( group2 ) ;

				$( control.find( '.btn-down-group' ) ).removeClass( 'disabled' ) ;
			}

			if(	! appolo.configs.pages.page.just_scrolled_out ){
				group1.addClass( 'animated fadeInLeft' ) ;
				group2.addClass( 'animated fadeInRight' ) ;
				$( $( group1.find( ' > div > div input[type=text], > div > div > textarea' ) )[ 0 ] ).focus() ;
			}

			//just scrolled
			appolo.configs.pages.page.just_scrolled_out = false ;

			//inverted
			appolo.configs.pages.page.just_inverted = true ;

			//after it
			that.organize_group_form( parent, group ) ;

			//config children buttons
			that.organize_controls_forms() ;

			//ajax (functions - post)
			appolo.configs.set_functions_pos_ajax() ;
			setTimeout( function(){
				group1.removeClass( 'animated fadeInLeft' ) ;
				group2.removeClass( 'animated fadeInRight' ) ;
			}, 1000 ) ;
		},

		add_group_form: function( parent, group ){
			var that = this, code = '', new_name_radio = '', new_item = ( group.data( 'item' ) + 1 ), control = $( $( parent.find( '.group[name=' + group.attr( 'name' ) + ']' ) ) ).find( appolo.configs.pages.page.control_group_form_page ), qty_group = that.check_qty_group_form( control, group.attr( 'name' ) ) ;

			//check if is last
			if( qty_group == 1 && that.get_min( group ) == 0 && group.hasClass( 'hide-toggle' ) ){
				group.removeClass( 'hide-toggle' ) ;
				$( $( group.find( ' > div > div input[type=text], > div > div > textarea' ) )[ 0 ] ).focus() ;
				$( group.find( ' > legend > .legend-order' ) ).html( '(' + 1 + ')' ) ;
				$( $( control.find( '.btn-rmv-group' ) )[ 0 ] ).removeClass( 'disabled' ) ;
				return false ;
			}

			//just began
			appolo.configs.pages.page.begin = true ;

			clone = group.clone().attr( 'data-item', new_item ) ;
			$( '.control-group.radio', clone ).each( function(){
				if( ! $( 'input[type=radio][data-check-it-by-default=true]' , $( this ) ).length ){
					$( 'input[type=radio]:checked' , $( this ) ).attr( 'data-check-it-by-default', true ) ;
				}
			}) ;
			$( '.control-group.checkbox', clone ).each( function(){
				if( ! $( 'input[type=checkbox][data-check-it-by-default=true]' , $( this ) ).length ){
					$( 'input[type=checkbox]:checked' , $( this ) ).attr( 'data-check-it-by-default', true ) ;
				}
			}) ;
			$( 'input[type=radio]' , clone ).removeAttr( 'checked' ) ;
			$( 'input[type=checkbox]' , clone ).removeAttr( 'checked' ) ;

			//clone it
			group.after( clone ) ;

			//declare it
			new_object = $( group.next() ) ;

			//new one
			if(	! appolo.configs.pages.page.just_scrolled_out ){
				new_object.addClass( 'selected' ) ;
			}
			$( new_object.find( 'input[type=text], input[type=number], textarea' ) ).each( function(){
				$( this ).val( '' ) ;
			}) ;
			if(	! appolo.configs.pages.page.just_scrolled_out ){
				$( $( new_object.find( ' > div > div input[type=text], > div > div > textarea' ) )[ 0 ] ).focus() ;
			}

			//move to
			if(	! appolo.configs.pages.page.just_scrolled_out ){
				$( 'html, body' ).animate( {
					scrollTop: ( new_object.offset().top - ( new_object.height() / 2 ) )
				}, 200 ) ;
			}

			//just scrolled
			appolo.configs.pages.page.just_scrolled_out = false ;

			//after it
			that.organize_group_form( parent, group ) ;

			//config children buttons
			that.organize_controls_forms() ;

			//ajax (functions - post)
			appolo.configs.set_functions_pos_ajax() ;
		},

		rmv_group_form: function( parent, group ){
			var that = this, new_item = ( group.data( 'item' ) + 1 ), control = $( parent.find( '.group[name=' + group.attr( 'name' ) + ']' ) ).find( appolo.configs.pages.page.control_group_form_page ), qty_group = ( that.check_qty_group_form( control, group.attr( 'name' ) ) ) ;

			//just took out
			appolo.configs.pages.page.just_took_out = true ;

			//check if is last
			if( qty_group <= 1 && that.get_min( group ) == 0 && ! group.hasClass( 'hide-toggle' ) ){
				group.addClass( 'hide-toggle' ) ;
				$( group.find( ' > legend > .legend-order' ) ).html( '(' + 0 + ')' ) ;
				$( $( control.find( '.btn-rmv-group' ) )[ 0 ] ).addClass( 'disabled' ) ;
				return false ;
			}

			//efect
			group.slideUp( 300 ) ;

			//stop effect n' remove
			setTimeout( function(){
				group.remove() ;

				//parent groups
				$( parent.find( '.group[name=' + group.attr( 'name' ) + ']' ) ).each( function( i ) {
					appolo.gui.set_control_form( $( $( this ).find( appolo.configs.pages.page.control_group_form_page ) ) ) ;
				}) ;

				//after it
				that.organize_group_form( parent, group ) ;

				//config children buttons
				that.organize_controls_forms( parent ) ;
			}, 300 ) ;

		},

		set_control_form: function( control ){
			var that = this, parent = $( control.parent().parent() ), group = $( control.parent() ), group_name = group.attr( 'name' ), qty_group = that.check_qty_group_form( control, group.attr( 'name' ) ) ;

			//control's btns
			$( control.find( '.btn' ) ).each( function( i ) {
				this_btn = $( this ) ;
				$( this ).unbind() ;
				this_btn.unbind() ;

				//click on buttons
				this_btn.click( function(){
					//fix all selected groups
					$( $( appolo.configs.pages.page.main_form ).find( '.group' ) ).each( function(){
						$( this ).removeClass( 'selected' ) ;
					}) ;

					//fi add
					if( $( this ).hasClass( 'btn-add-group' ) ){
						appolo.configs.pages.page.i_organize_group++ ;
						that.add_group_form( parent, group ) ;
					}

					//fi rmv
					if( $( this ).hasClass( 'btn-rmv-group' ) ){
						if( confirm( 'Você realmente deseja remover este grupo ?') ){
							appolo.configs.pages.page.i_organize_group-- ;
							that.rmv_group_form( parent, group ) ;
						}
					}

					//fi up
					if( $( this ).hasClass( 'btn-up-group' ) ){
						that.invert_position( control, 'up' ) ;
					}

					//fi down
					if( $( this ).hasClass( 'btn-down-group' ) ){
						that.invert_position( control, 'down' ) ;
					}
				}) ;

				//enable buttons
				if( this_btn.hasClass( 'disabled' ) ){
					this_btn.removeClass( 'disabled' ) ;
				}
			}) ;

			//control [individual]
			if( qty_group == 1 ){
				if( that.get_min( group ) != 0 ){
					$( control.find( '.btn-rmv-group' ) ).addClass( 'disabled' ) ;
				}else{
					if( ! appolo.configs.pages.page.just_took_out ){
						$( control.find( '.btn-rmv-group' ) ).addClass( 'disabled' ) ;
						$( group ).addClass( 'hide-toggle' ) ;	
					}
				}
				if( that.get_min( group ) > 1 && appolo.configs.pages.page.begin ){
					for( click = 0; click < ( that.get_min( group ) - 1 ); click++ ){
						appolo.configs.pages.page.just_scrolled_out = true ;
						that.add_group_form( parent, group ) ;
					}
					that.organize_group_form( parent, group ) ;
					appolo.configs.pages.page.begin = false ;
				}
			}

			//disable first and last buttons
			if( $( group.prev() ).attr( 'name' ) != group.attr( 'name' ) || ! $( group.prev() ).hasClass( 'group' ) ){
				$( control.find( '.btn-up-group' ) ).addClass( 'disabled' ) ;
			}
			if( $( group.next() ).attr( 'name' ) != group.attr( 'name' ) || ! $( group.next() ).hasClass( 'group' ) ){
				$( control.find( '.btn-down-group' ) ).addClass( 'disabled' ) ;
			}

			//fix disabled
			if( that.check_qty_group_form( control, group.attr( 'name' ) ) == 1 && group.hasClass( 'hide-toggle' ) ){
				$( control.find( '.btn-rmv-group' ) ).addClass( 'disabled' ) ;
				return false ;
			}

			//total equals min
			if( qty_group <= that.get_min( group ) ){
				$( control.find( '.btn-rmv-group' ) ).addClass( 'disabled' ) ;
			}

			//total equals max
			if( qty_group >= that.get_max( group ) ){
				$( control.find( '.btn-add-group' ) ).addClass( 'disabled' ) ;
			}

		},

		set_error_page: function( errors, type, main_form ){
			var that = this, code = '', type = ( ( type == 'form' ) ? 'formulário' : 'template' ) ;

			if( errors.length ){
				code =	'<ul>' ;
				for( i = 0; i < errors.length; i ++ ){
					code += '<li>' + errors[ i ] + '</li>' ;
				}
				code += '</ul>' ;
			}

			appolo.configs.pages.page.can = false ;

			main_form.html( '<p class="msg-loading-form">Erro de ' + type + '</p>' ) ;
			main_form.slideDown( appolo.configs.pages.page.default_time_loading ) ;

			that.render_warn_message( appolo.gui.render_message( "danger", true, ( "<strong>Atenção</strong>: Erro no carregamento do " + type + ". <br><br> <strong>Problemas</strong>: " + code ), "animated fadeInRight" ) ) ;

			return false ;
		},

		set_warning_page: function( errors, type, main_form ){
			var that = this, code = '', type = ( ( type == 'form' ) ? 'formulário' : 'template' ) ;

			if( errors.length ){
				code =	'<ul>' ;
				for( i = 0; i < errors.length; i ++ ){
					code += '<li>' + errors[ i ] + '</li>' ;
				}
				code += '</ul>' ;
			}

			that.render_warn_message( appolo.gui.render_message( "warning", true, ( "<strong>Atenção</strong>: Falha no carregamento do " + type + ". <br><br> <strong>Problemas</strong>: " + code ), "animated fadeInRight" ) ) ;

			return true ;
		},

	/*/forms*/

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
	mount_urls_list: function( list, item ){
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

	//reset form
	reset_form_on_container: function( container ){
		var that = this ;

		//add class hidden for deleting button
		$( $( this_modal ).find( '.btn-del-file' ) ).addClass( 'hidden' ) ;
		$( $( this_modal ).find( '.btn-del-file' ) ).unbind() ;
		$( $( this_modal ).find( '.btn-del-file' ) ).click(function(){
			$( '.form-actions > .del-checks' ).click() ;
		}) ;

		//set send form
		$( container.find( '.send-form' ) ).unbind( 'click' ) ;
		$( container.find( '.send-form' ) ).click(function(){
			//submit button
			container.find( 'form' ).submit() ;
		}) ;

		//icons
		$( '.icon-xml-error, .xml-error' ).hide() ;

		//form submit
		container.find( 'form' ).unbind( 'submit' ) ; /*take submit out*/
		$( container.find( 'form' ).find( 'button[type=reset]' ) ).trigger( 'click' ) ;
		$( container.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
		$( container.find( '.control-group' ) ).removeClass( 'has-error' ) ;
	},

	//set modal title type [ form, (new, edit, view), (f,m), "" ]
	set_modal_title_type: function( form, currently_open_type_modal, gen, subtitle ){
		var that = this, title = type_button = '' ;

		$( form.find( '.send-form' ) ).show() ;

		switch( currently_open_type_modal ){

			//new
			case 'new':
				if ( gen == 'f' ){
					title = 'Nova' ;
				}else if ( gen == 'm' ){
					title = 'Novo'
				}
				type_button = 'Criar' ;
			break;

			//edit
			case 'edit':
				title = 'Propriedades' ;
				type_button = 'Editar' ;
			break;

			//view
			case 'view':
				title = 'Visualizar' ;
				$( form.find( '.send-form' ) ).hide() ;
			break;

			default:
			//whatever
			break;
		}

		//set title and type button
		$( form.find( '.modal-title' ) ).html( title + " " + subtitle ) ;
		$( form.find( '.send-form' ) ).html( type_button ) ;
	},

	//config modal sections: pages, news & images
	section_pages_news_images: function( modal ){
		var that = this ;

		//first all
		$( '.set-areas > input[type=checkbox]' ).removeProp( 'checked' ) ;

		//after only one selected
		if( typeof appolo.configs.pages_url !== 'undefined' ){
			$( '.set-areas .set-pages input[type=checkbox]' ).prop( 'checked', true ) ;
			$( '.area-set-news' ).fadeOut() ;
		}else if( typeof appolo.configs.news_url !== 'undefined' ){
			$( '.set-areas .set-news input[type=checkbox]' ).prop( 'checked', true ) ;
			$( '.area-set-news' ).slideDown( 200 ) ;
		}else if( typeof appolo.configs.imgs_url !== 'undefined' ){
			$( '.set-areas .set-imgs input[type=checkbox]' ).prop( 'checked', true ) ;
			$( '.area-set-news' ).fadeOut() ;
		}
	},

	//set_modal key up files
	set_modal_key_up_files: function( modal, field, to_replace, regex ){
		var that = this ;

		//unbind
		$( this_modal.find( '.controls ' + field ) ).unbind() ;

		//set
		$( this_modal.find( '.controls ' + field ) ).keyup(function(){
			this_field_keydown = $( this ) ;
			value_include = appolo.treat.encode_path( this_field_keydown.val() ) ;
				//extensao pull name
				$( this_modal.find( '.controls > ' + to_replace ) ).each(function(){
					this_textfile = $( this ) ;
					if ( value_include != '' ){
						value_this = ( this_textfile.attr('placeholder') ).replace( regex, value_include ) ;
						this_textfile.attr( 'value', value_this ) ;
					}else{
						this_textfile.attr( 'value', '' ) ;
					}
			}) ;
		}) ;
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

	//select specific text
	select_specific_text: function( field, text ){
		var that = this, start = field.val().indexOf( text ) ;

		if( start != -1 ){
			field.focus() ;
			field.selectionStart = start ;
			field.selectionEnd = start + text.length ;
		}
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
			
			element.hide() ;

			//pagination
			if ( pages > 1 ){
				pre_prev = ( ! ( ( parseInt( that.get_currently_page() ) - 1 ) < 1 ) ) ? ( parseInt( that.get_currently_page() ) - 1 ) : 1 ;
				pre_next = ( ! ( ( parseInt( that.get_currently_page() ) + 1 ) > pages ) ) ? ( parseInt( that.get_currently_page() ) + 1 ) : pages ;
				code += '<li class="prev ' + ( ( that.get_currently_page() == 1 ) ? ' disabled ' : '' ) + '"><a id="prev" href="#p-' + pre_prev + '">«</a></li>' ;
				for ( var i = 1 ; i <= pages ; i++ ) {
					code += '<li class="p p-' + i + ' ' + ( ( that.get_currently_page() == i ) ? ' active' : '' ) + '"><a href="#p-' + i + '">' + i + ' <span class="sr-only">(atual)</span></a></li>' ;
				}
				code += '<li class="next ' + ( ( that.get_currently_page() == pages ) ? ' disabled" ' : '' ) + '""><a href="#p-' + pre_next + '">»</a></li>' ;
			}else{
				code = '' ;
			}

			//write pagination
			element.html( code ) ;
			element.fadeIn() ;

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
		//next
		first_page: function(that){
			var that = this, element = $( '.pagination' ), pages = parseInt( that.pages ),
			code = pre_prev = pre_next = '' ;
			
			element.hide() ;

			//pagination
				pre_prev = ( ! ( ( parseInt( that.get_currently_page() ) - 1 ) < 1 ) ) ? ( parseInt( that.get_currently_page() ) - 1 ) : 1 ;
				pre_next = ( ! ( ( parseInt( that.get_currently_page() ) + 1 ) > pages ) ) ? ( parseInt( that.get_currently_page() ) + 1 ) : pages ;
				code += '<li class="prev ' + ( ( that.get_currently_page() == 1 ) ? ' disabled ' : '' ) + '"><a id="prev" href="#p-' + pre_prev + '">«</a></li>' ;
				for ( var i = 1 ; i <= pages ; i++ ) {
					code += '<li class="p p-' + i + ' ' + ( ( that.get_currently_page() == i ) ? ' active' : '' ) + '"><a href="#p-' + i + '">' + i + ' <span class="sr-only">(atual)</span></a></li>' ;
				}
				code += '<li class="next ' + ( ( that.get_currently_page() == pages ) ? ' disabled" ' : '' ) + '""><a href="#p-' + pre_next + '">»</a></li>' ;


			//write pagination
			element.html( code ) ;
			element.hide() ;

			//check
			that.check() ;
			// goto first page
			first_page = element.find( '.p-1' )[0].firstChild.click();
			if ( pages <= 1 ){
				element.html( "" ) ;
			}
			else{
				element.fadeIn();
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

		for ( i = 0 ; i <= nav.length - 1 ; i++ ) {
			if ( ! Array.isArray( nav[ i ] ) ){
				code += '<li class="' + ( ( nav[ i ][ 'active' ] ) ? ' active' : '' ) + '' + ( ( typeof nav[ i ][ 'class' ] != 'undefined' ) ? ( ' ' + nav[ i ][ 'class' ] ) : '' ) + '">' ;
					code +=  ( ( ! nav[ i ][ 'active' ] ) ? '<a href="' + nav[ i ][ 'link' ] + '">' + nav[ i ][ 'title' ] + '</a>' : nav[ i ][ 'title' ] ) ;
				code += '</li>' ;
			}else{
				for ( j = nav[ i ].length - 1 ; j >= 0 ; j-- ) {
					code += '<li class="' + ( ( nav[ i ][ j ][ 'active' ] ) ? ' active' : '' ) + '' + ( ( typeof nav[ i ][ j ][ 'class' ] != 'undefined' ) ? ( ' ' + nav[ i ][ j ][ 'class' ] ) : '' ) + '">' ;
						code +=  ( ( ! nav[ i ][ j ][ 'active' ] ) ? '<a href="' + nav[ i ][ j ][ 'link' ] + '">' + nav[ i ][ j ][ 'title' ] + '</a>' : a_icon_folder + nav[ i ][ j ][ 'title' ] ) ;
					code += '</li>' ;
				}
			}
		}

		breadcrumb.html( code ) ;

		if( $( breadcrumb.find( '.access-hidden' ) ).length && appolo.configs.view_hidden != 1 ){
			$( 'body' ).html( '' ) ;
			location.href = appolo.configs.go_back ;
		}

		if( appolo.configs.this_is_hidden == 1 ){
			$( breadcrumb.find( '.inv' ) ).show() ;
		}

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

	},

	//close modal
	close_modal: function( modal ){
		var that = this ;

		history.pushState( '', document.title, window.location.pathname ) ;
		modal.modal( 'hide' ) ;
		return false ;
	},

	//set modal loading
	set_modal_loading: function( modal, set ){
		var that = this, modal_body = modal.find( '.modal-body' ), modal_loading = modal.find( '.modal-loading' ) ;

		if( set ){
			if( ! modal_body.hasClass( 'loading' ) ) {
				modal_body.addClass( 'loading' ) ;	
			}
			modal_loading.show() ;
		}else{
			if( modal_body.hasClass( 'loading' ) ) {
				modal_body.removeClass( 'loading' ) ;	
			}
			modal_loading.hide() ;
		}
	},

	//get grid and check the form
	form_set_checks_grid: function( form_to_check, action_to_the_check, class_check, ask_msg, btn_del_checks, btn_view_checks ){
		var that = this, breakpoint = 0, form = $( ( 'form[name=' + form_to_check + ']' ) ), form_tr = $( ( 'form[name=' + form_to_check + '] ' + ( ( class_check ) ? class_check : "" ) ) ) ;

		appolo.configs.currently_selected_item_grid = 0 ;

		$( btn_del_checks ).addClass( 'disabled' ) ;
		$( btn_view_checks ).addClass( 'disabled' ) ;

		form_tr.find('input[type=checkbox]:checked').each(function(){
			$( this ).prop( 'checked', false ) ;
		}) ;

		form.attr( 'action', action_to_the_check ) ;

		form_tr.find('input[type=checkbox]').unbind() ;
		form_tr.find('input[type=checkbox]').change(function(){
			breakpoint = 0 ;

			form_tr.find('input[type=checkbox]:checked').each(function(){
				breakpoint++ ;
			}) ;

			if ( breakpoint > 0 ){
				$( btn_del_checks ).removeClass( 'disabled' ) ;
				if ( breakpoint == 1 ){
					if( form_tr.find('input[type=checkbox]:checked').parent().parent().hasClass( 'tr-sections' ) ){
						$( btn_view_checks ).attr( 'href', appolo.configs.edit_section ) ;
					}else if( form_tr.find('input[type=checkbox]:checked').parent().parent().hasClass( 'tr-pages' ) ){
						$( btn_view_checks ).attr( 'href', appolo.configs.edit_page ) ;
					}
					$( btn_view_checks ).removeClass( 'disabled' ) ;
					appolo.configs.currently_selected_item_grid = form_tr.find('input[type=checkbox]:checked').val() ;
				}else{
					appolo.configs.currently_selected_item_grid = 0 ;
					$( btn_view_checks ).addClass( 'disabled' ) ;
				}
			}else{
				$( btn_del_checks ).addClass( 'disabled' ) ;
				$( btn_view_checks ).addClass( 'disabled' ) ;
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
	},

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
			return false ;
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

	//mount full date with a date [ FEIRA ]
	mount_date_full_w_feira: function( dt ){
		var that = this,
		data = new Date ( dt ) ;

		return appolo.calendar.dayNamesWFeira[ data.getDay() ] + ', ' + that.set_zero( data.getDate() ) + ' de ' + appolo.calendar.monthNames[ data.getMonth() ] + ' de ' + ( data.getYear() + 1900 ) ;
	},

	//mount a correct date with a date
	mount_date_min: function( dt ){
		var that = this,
		data = new Date ( dt ) ;

		return that.set_zero( data.getDate() ) + '/' + that.set_zero( ( data.getMonth() + 1 ) ) + '/' + ( data.getYear() + 1900 ) ;
	},

	//treat not null fields
	treat_not_null: function( where, bp ){
		var that = this, breakpoint = bp ;
		$( where.find( '.not-null' ) ).each(function(){
			$( where.find( '#' + $( this ).attr('for') ) ).each(function(){
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
	},
	treat_not_null_unique: function( where, bp ){
		var that = this, breakpoint = bp ;
		bp = false;
		$( where.find( '.not-null' ) ).each(function(){
			$( where.find( '#' + $( this ).attr('for') ) ).each(function(){
				if(!bp){
					control_group = "" ;
					if( $( this ).val() == ""){
						control_group = $( this ).parent();
						control_group.addClass( 'has-error' ) ;
						message = control_group.find('.error_input');
						message.text("");
						message.append("Campo obrigatório");
						$( this ).focus();
						$( this ).unbind( 'change' ) ;
						$( this ).change(function(){
							if ( $( this ) ){
								$( this ).parent().removeClass( 'has-error' ) ;
								aux = $( this ).parent().find('.error_input');
								aux.text("");
							}
							$( this ).unbind( 'change' ) ;
						}) ;
						bp = true;
						breakpoint = true ;
					}else if( ! breakpoint ){
						breakpoint = false ;
					}
				}
			}) ;
		}) ;
		return breakpoint ;
	},
	validate_email: function (email){
		if(email != "")
		{
			var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if(!filtro.test(email))
			{				
				return true;
			}
			return false;
		}	
		return true		
	},
	 
	treat_min_length: function (where, bp){
		var that = this, breakpoint = bp ;

		$( where.find( '.minlength' ) ).each(function(){
			$( where.find( '#' + $( this ).attr('for') ) ).each(function(){
				if(!bp){
					control_group = "" ;			
					min = parseInt($( this ).attr("minlength"));	
					if( $( this ).val().length < min) {
						control_group = $( this ).parent() ;
						control_group.addClass( 'has-error' ) ;
						control_group.find( 'has-error' ) ;
						message = control_group.find('.error_input');
						message.text("");
						message.append("Digite ao menos "+min+" caracteres");
						$( this ).focus() ;
						$( this ).unbind( 'change' ) ;
						$( this ).change(function(){
							if ( $( this ) ){
								$( this ).parent().removeClass( 'has-error' ) ;
								aux = $( this ).parent().find('.error_input');
								aux.text("");
							}
							$( this ).unbind( 'change' ) ;
						}) ;
						bp = breakpoint = true ;
						return breakpoint ;
					}else if( ! breakpoint ){
						breakpoint = false ;
					}
				}	
			}) ;
		}) ;
		return breakpoint ;
	},

	//check extension -- get field value
	check_ext_file: function( group_of_fields ){
		var that = this, val = ext = "", breakpoint = false ;

		$.each( group_of_fields, function( i, field ) {

			if( ! breakpoint ){

				//details field
				objfield = field[ 0 ] ;
				val = objfield.val() ;
				ext = field[ 1 ] ;

				if( ! ( val.substr( val.lastIndexOf( '.' ) + 1 ) == ext ) ){

					//if its different extension as it has asked
					$( objfield.parent().parent() ).addClass( 'has-error' ) ;
					alert( "O " + $( objfield.parent().parent() ).data( 'desc-file' ) + ' deve terminar com a extensão "' + ext + '" (sem aspas).' ) ;
					appolo.gui.select_specific_text( objfield, ( val.substr( val.lastIndexOf( '.' ) + 1 ) ) ) ;

					breakpoint = true ;
					return false ;
				}
			}

		} ) ;

		return breakpoint ;
	},

	//set fields via db
	set_fields_via_db: function( modal, item, url_search, set_warn ){
		var that = this ;

		$.ajax({
			dataType: 'json',
			url: url_search + ( ( item != null ) ? ( item ) : "0" )
		}).done( function( fields ){
			modal.triggerHandler( 'data-received', [ fields ] );
		} ).error( function(){
			appolo.gui.render_warn_message( appolo.gui.render_message( "warning", true, "Erro ao carregar o conteúdo.", "animated fadeInRight" ) ) ;
		} ) ;
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

	//areas
	area_content_sections: '.area .content-areas',
	//areas edit
	area_edit_content_sections: '.area_edit .content-areas',
	//funcionarios
	funcionarios_content_sections: '.funcionarios .content-funcionarios',
	funcionarios_search_bar: '.funcionarios .div_search_bar',
	//funcionarios new
	funcionarios_new_content_sections: '.funcionarios_new .content-funcionarios_new',
	//funcionarios edit
	funcionarios_edit_content_sections: '.funcionarios_edit .content-funcionarios_edit',
	//usuarios
	usuarios_content_sections: '.usuarios .content-usuarios',
	usuarios_edit_content_sections: '.usuarios_edit',

	imagens_content_sections: '.imagens .content-imagens',
	galeria_imagem_sections: '.galeria_imagem .content-imagens',

	relatorios: {	
		print_div: function (divID){
			var that = $(document);
			var divElements = document.getElementById(divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";
            window.print();
            document.body.innerHTML = oldPage;
		},
		secao_responsavel: function (idusuario){
			var that = $(document);
			$(document).find("#back_button_responsavel_secao").hide();
			$(document).find(".tr_secao1").hide();
			$(document).find("#title1").hide();
			$(document).find(".tr_secao2").show();
			$(document).find("#title2").show();
			$(document).find("#secao_responsavel_graph_title").hide();
			$(document).find("#secao_responsavel_graph").hide();
			table_relatorio = $(document).find("#secao_responsavel_content");
			render = { "template": {}, "data": {} };
			table_relatorio.html( appolo.util.mustache_render_template( render_relatorio_loading));
			table_relatorio.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.relatorio_responsavel_secao ,	
				data: {idusuario: idusuario},			
				dataType: 'json'
			}).done(function( resultados ){
				relatorios = { "items": [] } ;					
				$.each( resultados, function( i, itemsAux ) {
					relatorios.items.push( {						
						"IdSecao": itemsAux.IdSecao,						
						"NomeSecao": itemsAux.NomeSecao,						
						"Responsavel": itemsAux.Responsavel,
						"section_dataCriacao_min" : appolo.util.mount_date_min ( itemsAux.Criacao ) ,
						"section_dataCriacao_full" : appolo.util.mount_date_full_w_feira( itemsAux.Criacao ) 
					});
				});	
				
				render['template'] = render_responsavel_secao ;
				render['data'] = relatorios ;
				table_relatorio.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				table_relatorio.show();								
				appolo.configs.set_functions_pos_ajax() ;
				$(document).find("#back_button_responsavel_secao").show();
				$(document).find("#print_button_responsavel_secao").show();	
			


			}) ;

		},
		responsavel_secao: function (){
			var that = $(document);
			$(document).find("#back_button_responsavel_secao").hide();
			$(document).find("#print_button_responsavel_secao").hide();
			$(document).find(".tr_secao2").hide();
			$(document).find("#title2").hide();
			$(document).find(".tr_secao1").show();
			$(document).find("#title1").show();
			$(document).find("#secao_responsavel_graph_title").hide();
			$(document).find("#secao_responsavel_graph").hide();
			table_relatorio = $(document).find("#secao_responsavel_content");
			render = { "template": {}, "data": {} };
			table_relatorio.html( appolo.util.mustache_render_template( render_relatorio_loading));
			table_relatorio.show();
			relatoriosAux = []	;
			$.ajax({
				type: "POST", 
				url: appolo.configs.relatorio_secao_responsavel,				
				dataType: 'json'
			}).done(function( resultados ){
				relatorios = { "items": [] } ;					
				$.each( resultados, function( i, itemsAux ) {
					relatorios.items.push( {						
						"idusuario": itemsAux.IdUsuario,						
						"nome": itemsAux.Responsavel,						
						"email": itemsAux.EmailContato,
						"cargo": itemsAux.Cargo,
						"secao": itemsAux.QtdeSecaoGerenciada
					});
				});	
				
				$.each( relatorios.items, function( i, itemsAux ) {
					
					relatoriosAux.push([parseInt(itemsAux.secao), {label: itemsAux.nome}]);
					
				});	
				if(!jQuery.isEmptyObject(relatoriosAux)){
					that.find('#secao_responsavel_graph').tufteBar({
						data: relatoriosAux,
				          barWidth: 0.8,
				          axisLabel: function(index) { return this[1].label },
				          barLabel:  function(index) { return this[0] + ' Seções' },
				          color:     function(index) { return ['#CED8F6','#ECF6CE','#F5A9A9','#F7BE81','#81F79F','#D358F7','#2E2E2E','#0B6138','#380B61','#610B4B','#0040FF','#2EFE64','#FA5882','#D358F7','#58FAAC','#9F81F7','#9FF781','#F7BE81'][index % 20] }
					});
					$(document).find("#print_button_responsavel_secao").show();	
					$(document).find("#secao_responsavel_graph_title").show();
					$(document).find("#secao_responsavel_graph").fadeIn();
				}
				render['template'] = render_secao_responsavel ;
				render['data'] = relatorios ;
				table_relatorio.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				table_relatorio.show();								
				appolo.configs.set_functions_pos_ajax() ;
				
			}) ;
		},
		publicacao_autor: function (){
			var that = $(document), auxNome = "";
			$(document).find("#pulblicacoes_autor_graph").hide();
			$(document).find("#pulblicacoes_autor_graph_title").hide();
			$(document).find("#back_button_publicacao_autor").hide();
			$(document).find(".tr_secao4").hide();
			$(document).find("#title4").hide();

			$(document).find(".tr_secao3").show();
			$(document).find("#title3").show()
			table_relatorio = $(document).find("#publicacao_autor_content");
			render = { "template": {}, "data": {} };
			table_relatorio.html( appolo.util.mustache_render_template( render_relatorio_loading));
			table_relatorio.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.relatorio_publicacao_autor ,	
				dataType: 'json'
			}).done(function( resultados ){				
				idAux =  "";
				relatorios = { "items": [] } ;
				relatoriosAux = []	;
				$.each( resultados, function( i, itemsAux ) {
					if(idAux != itemsAux.IdUsuario ){
						relatorios.items.push( {						
							"cargo": itemsAux.Cargo,						
							"email": itemsAux.Email,						
							"nome": itemsAux.Nome,
							"idUsuario": itemsAux.IdUsuario,
							"quantidade" : itemsAux.Quantidade			
						});	
						idAux = itemsAux.IdUsuario;
					}
				});
				
				$.each( relatorios.items, function( i, itemsAux ) {
					relatoriosAux.push([parseInt(itemsAux.quantidade), {label: itemsAux.nome}]);

				});	

				render['template'] = render_publicacao_autor ;
				render['data'] = relatorios ;
				table_relatorio.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				table_relatorio.show();								
				appolo.configs.set_functions_pos_ajax() ;
				console.log(relatoriosAux);
				if(!jQuery.isEmptyObject(relatoriosAux)){

					that.find(".print_button_publicacao_autor").show();
					that.find('#pulblicacoes_autor_graph').tufteBar({
						data: relatoriosAux,
				          barWidth: 0.8,
				          axisLabel: function(index) { return this[1].label },
				          barLabel:  function(index) { return this[0] + ' Publicações' },
				          color:     function(index) { return ['#CED8F6','#ECF6CE','#F5A9A9','#F7BE81','#81F79F','#D358F7','#2E2E2E','#0B6138','#380B61','#610B4B','#0040FF','#2EFE64','#FA5882','#D358F7','#58FAAC','#9F81F7','#9FF781','#F7BE81'][index % 20] }

					});
					$(document).find("#pulblicacoes_autor_graph_title").show();
					$(document).find("#pulblicacoes_autor_graph").fadeIn();
				}	

			}) ;
			

		},
		publicacao_autor_detalhe: function (idusuario, idStatus){
			var that = $(document);
			$(document).find("#pulblicacoes_autor_graph").hide();
			$(document).find("#pulblicacoes_autor_graph_title").hide();
			$(document).find("#back_button_publicacao_autor").hide();
			$(document).find(".tr_secao3").hide();
			$(document).find("#title3").hide();
			$(document).find(".tr_secao4").show();
			$(document).find("#title4").show()
			$(document).find("#pulblicacoes_autor_graph_title").hide();
			$(document).find("#pulblicacoes_autor_graph").hide();
			
			table_relatorio = $(document).find("#publicacao_autor_content");
			render = { "template": {}, "data": {} };
			table_relatorio.html( appolo.util.mustache_render_template( render_relatorio_loading));
			table_relatorio.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.relatorio_publicacao_autor ,
				data: {idusuario: idusuario, statusPub: idStatus},		
				dataType: 'json'
			}).done(function( resultados ){
				idAux =  "";
				relatorios = { "items": [] } ;
				relatoriosAux = []	;
				$.each( resultados, function( i, itemsAux ) {
						relatorios.items.push( {						
							"cargo": itemsAux.Cargo,						
							"email": itemsAux.Email,						
							"nome": itemsAux.Nome,
							"idUsuario": itemsAux.IdUsuario,
							"section_dataCriacao_min" : appolo.util.mount_date_min ( itemsAux.Criacao ) ,
							"section_dataCriacao_full" : appolo.util.mount_date_full_w_feira( itemsAux.Criacao ) ,
							"section_deadline_min" : appolo.util.mount_date_min ( itemsAux.DeadlinePublicacao ) ,
							"section_deadline_full" : appolo.util.mount_date_full_w_feira( itemsAux.DeadlinePublicacao ) ,
							"tituloPublicacao": itemsAux.TituloPublicacao,
							"status": itemsAux.DescricaoUltimaAcao,
							"tipoSecao": itemsAux.SecaoCategoria,
							"quantidade" : itemsAux.Quantidade			
						});	
			
				});
				

				render['template'] = render_publicacao_autor_detalhe ;
				render['data'] = relatorios ;
				table_relatorio.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				table_relatorio.show();								
				appolo.configs.set_functions_pos_ajax() ;
				
				
				// $(document).find("#title4").addClass("hidden");
				$(document).find("#back_button_publicacao_autor").show();


			}) 
		},
			
		publicacao_periodo: function (){
			var that = $(document);
			$(document).find("#publicacao_periodo_graph").hide();
			$(document).find("#publicacao_periodo_graph_title").hide();
			table_relatorio = $(document).find("#publicacao_periodo_content");
			render = { "template": {}, "data": {} };
			table_relatorio.html( appolo.util.mustache_render_template( render_relatorio_loading));
			table_relatorio.show();
			ano = $('#anoInicialQtd').val(); 
			if (ano ==""){
				ano="2014"
				$('#anoInicialQtd').val("2014");
			}
			$.ajax({
				type: "POST", 
				url: appolo.configs.relatorio_publicacao_periodo ,
				data: {anoInicial: $('#anoInicialQtd').val(), anoFinal: $('#anoInicialQtd').val()},		
				dataType: 'json'
			}).done(function( resultados ){
				idAux =  "";
				relatorios = { "items": [] } ;
				relatoriosAux = []	;
				$.each( resultados, function( i, itemsAux ) {
						if(parseInt(itemsAux.QtdReprovadas)!= 0 || parseInt(itemsAux.QtdAprovadas)!=0 || parseInt(itemsAux.QtdPendentes)!=0 || parseInt(itemsAux.QtdPublicadas)!=0){
							relatorios.items.push( {						
								"mes": itemsAux.NomeMes,
								"ano": ano,						
								"aprovadas": itemsAux.QtdAprovadas,
								"reprovadas": itemsAux.QtdReprovadas,
								"publicadas": itemsAux.QtdPublicadas,
								"pendentes": itemsAux.QtdPendentes
							});	
						}				
				});
				$.each( relatorios.items, function( i, itemsAux ) {
					if (itemsAux.aprovadas != "0"){
						relatoriosAux.push([parseInt(itemsAux.aprovadas), {label: itemsAux.mes+" - Aprovadas"}]);
						// relatoriosAux.push([parseInt(itemsAux.aprovadas), {label: label: itemsAux.ano+" / "+itemsAux.mes+" - Aprovadas"}]);
					}
					if (itemsAux.reprovadas != "0"){
						relatoriosAux.push([parseInt(itemsAux.reprovadas), {label: itemsAux.mes+" - Reprovadas"}]);
						// relatoriosAux.push([parseInt(itemsAux.reprovadas), {label: label: itemsAux.ano+" / "+itemsAux.mes+" - Reprovadas"}]);
					}
					if (itemsAux.pendentes != "0"){
						relatoriosAux.push([parseInt(itemsAux.pendentes), {label: itemsAux.mes+" - Pendentes"}]);
						// relatoriosAux.push([parseInt(itemsAux.pendentes), {label: label: itemsAux.ano+" / "+itemsAux.mes+" - Pendentes"}]);
					}
					if (itemsAux.publicadas != "0"){
						relatoriosAux.push([parseInt(itemsAux.publicadas), {label: itemsAux.mes+" - Publicadas"}]);
						// relatoriosAux.push([parseInt(itemsAux.publicadas), {label: label: itemsAux.ano+" / "+itemsAux.mes+" - Pendentes"}]);
					}
				});
				
				if(!jQuery.isEmptyObject(relatoriosAux)){
					that.find('#publicacao_periodo_graph').tufteBar({
						data: relatoriosAux,
				          barWidth: 0.8,
				          axisLabel: function(index) { return this[1].label },
				          barLabel:  function(index) { return this[0] + ' Publicações' },
				          color:     function(index) { return ['#CED8F6','#ECF6CE','#F5A9A9','#F7BE81','#81F79F','#D358F7','#2E2E2E','#0B6138','#380B61','#610B4B','#0040FF','#2EFE64','#FA5882','#D358F7','#58FAAC','#9F81F7','#9FF781','#F7BE81'][index % 20] }
					});
					$(document).find("#publicacao_periodo_graph_title").show();
					$(document).find("#publicacao_periodo_graph").fadeIn();
					$(document).find("#print_button_publicacao_periodo").show();
				}
				
				

				render['template'] = render_publicacao_periodo ;
				render['data'] = relatorios ;
				table_relatorio.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				table_relatorio.show();								
				appolo.configs.set_functions_pos_ajax() ;
					

				
				// $(document).find("#title4").addClass("hidden");


				}) 
			},
			
		publicacao_periodo_detalhe: function (){
			var that = $(document);


			table_relatorio = $(document).find("#publicacao_periodo_detalhe_content");
			render = { "template": {}, "data": {} };
			table_relatorio.html( appolo.util.mustache_render_template( render_relatorio_loading));
			table_relatorio.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.relatorio_publicacao_periodo_detalhe ,
				data: {mesInicial: $('#mesInicial').val(), anoInicial: $('#anoInicial').val(), anoFinal: $('#anoFinal').val(), mesFinal: $('#mesFinal').val(), statusPub: $('#statusPubPeriodo').val()},		
				dataType: 'json'
			}).done(function( resultados ){
				idAux =  "";
				relatorios = { "items": [] } ;
				relatoriosAux = []	;
				$.each( resultados, function( i, itemsAux ) {
						relatorios.items.push( {						
							"AnoPublicacao": itemsAux.AnoPublicacao,						
							"MesPublicacao": itemsAux.MesPublicacao,						
							"Titulo": itemsAux.Titulo,						
							"Criador": itemsAux.Criador,
							"Status": itemsAux.Status,
							"section_dataCriacao_min" : appolo.util.mount_date_min ( itemsAux.HoraCriacao ) ,
							"section_dataCriacao_full" : appolo.util.mount_date_full_w_feira( itemsAux.HoraCriacao ) ,
							"SecaoCategoria": itemsAux.SecaoCategoria,
						});	
			
				});
				

				render['template'] = render_publicacao_periodo_detalhe ;
				render['data'] = relatorios ;
				table_relatorio.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				table_relatorio.show();								
				appolo.configs.set_functions_pos_ajax() ;
				$(document).find("#print_button_publicacao_periodo_detalhe").show();	

				
				// $(document).find("#title4").addClass("hidden");


				}) 
			},	
	},
	imagens: {
		imagens_content_sections: null,
		init: function (){
			var that = this,
			secao_imagens = '' ,
			imagens_content_sections = $( that.imagens_content_sections ),
			table_imagens = imagens_content_sections.find( '.table-imagens' ),
			content_table_imagens = table_imagens.find( 'tbody.active' ),
			data_limit_per_page = table_imagens.attr( 'data-limit-per-page' ),
			content_table_imagens_per_page = new Array(), sn=0,
			nome_secao = $('#nome_secao').val(),	
			descricao_secao = $('#descricao_secao').val(),
			render = { "template": {}, "data": {} };
			content_table_imagens.html( appolo.util.mustache_render_template( render_sections_imagens_loading));
			content_table_imagens.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_imagens_secao,
				dataType: 'json'
			}).done(function( resultado ){			
				secao_imagens = { "items": [] } ;					
				$.each( resultado, function( i, item ) {
					 secao_imagens.items.push( {
					 	"id_item": item.idSecao,
						"url_prefix": appolo.configs.image_section_url,
						"section_dataCriacao_min" : appolo.util.mount_date_min ( item.dataCriacao ) ,
						"section_dataCriacao_full" : appolo.util.mount_date_full_w_feira( item.dataCriacao ) ,
						"descricaoSecao": item.descricaoSecao,
						"nomeSecao": item.nomeSecao
					}); 
				});
				render['template'] = render_imagens_secao ;
				render['data'] = secao_imagens ;
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( secao_imagens.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_imagens ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
					content_table_imagens.html(appolo.util.mustache_render_template( render['template'], render['data'] )) ;
				}else{
						var imagens_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							imagens_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_imagens.find( 'tbody.page-' + i ).length ) ) {
								table_imagens.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_imagens.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_imagens_per_page[ i ] = table_imagens.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									imagens_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_imagens_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], imagens_per_page[ i ] )
								) ;
						}
					}
					appolo.gui.pagination.mount() ;
					appolo.configs.set_functions_pos_ajax() ;
			});		
		},
		imagens_search: function (){
			var that = this,
			secao_imagens = '' ,
			imagens_content_sections = $( that.imagens_content_sections ),
			table_imagens = imagens_content_sections.find( '.table-imagens' ),
			content_table_imagens = table_imagens.find( 'tbody.active' ),
			data_limit_per_page = table_imagens.attr( 'data-limit-per-page' ),
			content_table_imagens_per_page = new Array(), sn=0,
			nome_secao = $('#nome_secao').val(),	
			descricao_secao = $('#descricao_secao').val(),
			render = { "template": {}, "data": {} };
			content_table_imagens.html( appolo.util.mustache_render_template( render_sections_imagens_loading));
			content_table_imagens.show();
			$( table_imagens.find('tbody') ).each(function(){
				if( ! $( this ).hasClass( 'active' ) ){
					$( this ).html('') ;
				}
			}) ;
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_imagens_secao,
				data:  {descricao_secao: descricao_secao, nome_secao: nome_secao},
				dataType: 'json'
			}).done(function( resultado ){			
				secao_imagens = { "items": [] } ;					
				$.each( resultado, function( i, item ) {
					 secao_imagens.items.push( {
						"descricaoSecao": item.descricaoSecao,
						"nomeSecao": item.nomeSecao,
						"section_dataCriacao_min" : appolo.util.mount_date_min ( item.dataCriacao ) ,
						"section_dataCriacao_full" : appolo.util.mount_date_full_w_feira( item.dataCriacao ) 
					}); 
				});
				render['template'] = render_imagens_secao ;
				render['data'] = secao_imagens ;
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( secao_imagens.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_imagens ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
					content_table_imagens.html(appolo.util.mustache_render_template( render['template'], render['data'] )) ;
				}else{
						var imagens_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							imagens_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_imagens.find( 'tbody.page-' + i ).length ) ) {
								table_imagens.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_imagens.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_imagens_per_page[ i ] = table_imagens.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									imagens_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_imagens_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], imagens_per_page[ i ] )
								) ;
						}
					}
					appolo.gui.pagination.mount() ;
					appolo.configs.set_functions_pos_ajax() ;
			});		
		},
		galeria_imagem: function (){
			var that = this,
			secao_imagens = '' ,
			galeria_imagem_sections = $( that.galeria_imagem_sections ),
			table_imagens = galeria_imagem_sections.find( '.table-imagens' ),
			content_table_imagens = table_imagens.find( 'tbody.active' ),
			data_limit_per_page = table_imagens.attr( 'data-limit-per-page' ),
			content_table_imagens_per_page = new Array(), sn=0,
			section = $('#section').val(),
			render = { "template": {}, "data": {} };
			content_table_imagens.html( appolo.util.mustache_render_template( render_sections_imagens_loading));
			content_table_imagens.show();
			random = "?buster"+Math.random();
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_imagens,
				data:  {section: section},
				dataType: 'json'
			}).done(function( resultado ){			
				secao_imagens = { "items": [] } ;					
				$.each( resultado, function( i, item ) {
					 secao_imagens.items.push( {
					 	"descricaoImagem": item.descricaoImagem,
						"dtUploadImagem": item.dtUploadImagem,
						"caminhoImagem" : item.caminhoImagem+random,
						"caminhoImagemNoBuster" : item.caminhoImagem,
						"nomeImagem" : item.nomeImagem,
						"tagImagem": item.tagImagem,
						"idImagem": item.idImagem,
						"statusImg": item.statusImg == "1" ? "Ativo":"Inativo" ,
						"imgAtiva": item.statusImg == "1" ? true:false,
					}); 
				});
				render['template'] = render_imagens ;
				render['data'] = secao_imagens ;

				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( secao_imagens.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_imagens ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
					content_table_imagens.html(appolo.util.mustache_render_template( render['template'], render['data'] )) ;
				}else{
						var imagens_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							imagens_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_imagens.find( 'tbody.page-' + i ).length ) ) {
								table_imagens.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_imagens.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_imagens_per_page[ i ] = table_imagens.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									imagens_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_imagens_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], imagens_per_page[ i ] )
								) ;
						}
					}
					appolo.gui.pagination.mount() ;
					appolo.configs.set_functions_pos_ajax() ;


				// content_table_imagens.html(appolo.util.mustache_render_template( render['template'], render['data'] )) 
				// content_table_imagens.show();

				appolo.configs.set_functions_pos_ajax() ;


			});
		},
		galeria_imagem_search: function (){
			var that = this,
			secao_imagens = '' ,
			galeria_imagem_sections = $( that.galeria_imagem_sections ),
			table_imagens = galeria_imagem_sections.find( '.table-imagens' ),
			aux = table_imagens.find( 'tbody' ),
			content_table_imagens = table_imagens.find( 'tbody.active' ),
			data_limit_per_page = table_imagens.attr( 'data-limit-per-page' ),
			content_table_imagens_per_page = new Array(), sn=0,
			tag_img = $('#tag_img').val(),
			descricao_img = $('#descricao_img').val(),
			name_img = $('#name_img').val(),
			section = $('#section').val(),
			render = { "template": {}, "data": {} };
			aux.html("")
			content_table_imagens.html( appolo.util.mustache_render_template( render_sections_imagens_loading));
			content_table_imagens.show();
			random =  "?buster"+Math.random();
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_imagens,
				data:  {tag_img: tag_img, descricao_img: descricao_img, name_img: name_img, section: section},
				dataType: 'json'
			}).done(function( resultado ){	
				secao_imagens = { "items": [] } ;					
				$.each( resultado, function( i, item ) {
					 secao_imagens.items.push( {
					 	"descricaoImagem": item.descricaoImagem,
						"dtUploadImagem": item.dtUploadImagem,
						"caminhoImagem" : item.caminhoImagem+random,
						"caminhoImagemNoBuster" : item.caminhoImagem,						
						"nomeImagem" : item.nomeImagem,
						"tagImagem": item.tagImagem,
						"idImagem": item.idImagem,
						"statusImg": item.statusImg == "1" ? "Ativo":"Inativo" ,
					}); 
				});
				render['template'] = render_imagens ;
				render['data'] = secao_imagens ;
				
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( secao_imagens.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_imagens ;

				if( ! ( appolo.gui.pagination.pages > 1 ) ){
					content_table_imagens.html(appolo.util.mustache_render_template( render['template'], render['data'] )) ;
				}else{
						var imagens_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							imagens_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_imagens.find( 'tbody.page-' + i ).length ) ) {
								table_imagens.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_imagens.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_imagens_per_page[ i ] = table_imagens.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									imagens_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_imagens_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], imagens_per_page[ i ] )
								) ;
						}
					}

					appolo.gui.pagination.first_page() ;								
					appolo.configs.set_functions_pos_ajax() ;

				
				// content_table_imagens.html(appolo.util.mustache_render_template( render['template'], render['data'] )) 
				// content_table_imagens.show();

				appolo.configs.set_functions_pos_ajax() ;


			});
		},
		showImage: function (obj){
			$("a[rel^='prettyPhoto']").prettyPhoto();
			$.prettyPhoto.open(obj.src, obj.title, obj.alt);
			return false;
		}		
	},	
	usuarios: {
		usuarios_content_sections: null,
		form_grid_usuarios: 'grid_usuarios',
		currently_open_type_modal: null,
		init: function (){
			var that = this;
			usuarios_content_sections = $( that.usuarios_content_sections ),
			modal_new_User = usuarios_content_sections.find( '.modal' ),
			table_usuarios = usuarios_content_sections.find( '.table-usuarios' ),
			content_table_usuarios = table_usuarios.find( 'tbody.active' ),
			data_limit_per_page = table_usuarios.attr( 'data-limit-per-page' ),
			currently_open_type_modal = that.currently_open_type_modal,
			content_table_usuarios_per_page = new Array(), sn = 0,			
			render = { "template": {}, "data": {} }
			usuarios_items = '' ;
			content_table_usuarios.html( appolo.util.mustache_render_template( render_sections_usuarios_loading));
			content_table_usuarios.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_admin_usuarios,
				dataType: 'json'
			}).done(function( usuarios ){			
				usuarios_items = { "items": [] } ;	
				$.each( usuarios, function( i, usuarios ) {

					 usuarios_items.items.push( {
						"nomePessoa": usuarios.nomepessoa,
						"cpfPessoa": usuarios.cpfpessoa,
						"nomeusuario": usuarios.nomeusuario,
						"datacriacao": usuarios.datacriacao,
						"status": usuarios.Status,
						"idusuario": usuarios.idusuario
					}); 
				});
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( usuarios_items.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_usuarios ;
				render['template'] = render_usuarios_grid ;
				render['data'] = usuarios_items ;

				content_table_usuarios.find( 'img' ).fadeOut( that.default_time_loading ) ;
				content_table_usuarios.find( 'tr.loading' ).remove() ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
					content_table_usuarios.append(
						appolo.util.mustache_render_template( render['template'], render['data'] )
						) ;
				}else{
						var usuarios_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							usuarios_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_usuarios.find( 'tbody.page-' + i ).length ) ) {
								table_usuarios.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_usuarios.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_usuarios_per_page[ i ] = table_usuarios.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									usuarios_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_usuarios_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], usuarios_per_page[ i ] )
								) ;

						}
					}
					
					appolo.gui.pagination.mount() ;

					appolo.configs.set_functions_pos_ajax() ;

				}) ;

			
		},

		usuarios_search: function (){
			var that = this,
			usuarios_content_sections = $( that.usuarios_content_sections ),
			table_usuarios = usuarios_content_sections.find( '.table-usuarios' ),
			content_table_usuarios = table_usuarios.find( 'tbody.active' ),
			data_limit_per_page = table_usuarios.attr( 'data-limit-per-page' ),
			currently_open_type_modal = that.currently_open_type_modal,
			content_table_usuarios_per_page = new Array(), sn = 0,			
			render = { "template": {}, "data": {} },
			nome_Pessoa = $('#nome_Pessoa').val(),	
			nome_Usuario = $('#nome_Usuario').val(),
			cdStatus = $('#cdStatus_Busca').val(),		
			render = { "template": {}, "data": {} }
			$( table_usuarios.find('tbody') ).each(function(){
				if( ! $( this ).hasClass( 'active' ) ){
					$( this ).html('') ;
				}
			}) ;
			usuarios_items = '' ;
			content_table_usuarios.html( appolo.util.mustache_render_template( render_sections_usuarios_loading));
			content_table_usuarios.show();
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_admin_usuarios,
				data:  {nome_Pessoa: nome_Pessoa, cdStatus: cdStatus, nome_Usuario: nome_Usuario},
				dataType: 'json'
			}).done(function( usuarios ){	
				
				usuarios_items = { "items": [] } ;	
				$.each( usuarios, function( i, usuarios ) {

					 usuarios_items.items.push( {
						"nomePessoa": usuarios.nomepessoa,
						"cpfPessoa": usuarios.cpfpessoa,
						"nomeusuario": usuarios.nomeusuario,
						"datacriacao": usuarios.datacriacao,
						"status": usuarios.Status,
						"idusuario": usuarios.idusuario
					}); 
				});
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( usuarios_items.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_usuarios ;
				render['template'] = render_usuarios_grid ;
				render['data'] = usuarios_items ;

				content_table_usuarios.find( 'img' ).fadeOut( that.default_time_loading ) ;
				content_table_usuarios.find( 'tr.loading' ).remove() ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
					content_table_usuarios.append(
						appolo.util.mustache_render_template( render['template'], render['data'] )
						) ;
				}else{
						var usuarios_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							usuarios_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_usuarios.find( 'tbody.page-' + i ).length ) ) {
								table_usuarios.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_usuarios.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_usuarios_per_page[ i ] = table_usuarios.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									usuarios_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_usuarios_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], usuarios_per_page[ i ] )
								) ;

						}
					}
					
					appolo.gui.pagination.first_page() ;

					appolo.configs.set_functions_pos_ajax() ;

				}) ;

			
		},
		usuarios_edit_acessos: function (){
			
			var that = this,
			usuarios_edit_content_sections = $( that.usuarios_edit_content_sections ),
			usuarios_edit_acessos_table = usuarios_edit_content_sections.find( '.table-user_acessos' );
			idUsuario = $('#idUsuario').val();	
			acessos_items = '' ;
			render = { "template": {}, "data": {} };
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_acesso_acao,
				data:  {idUsuario: idUsuario},
				dataType: 'json'
			}).done(function( resultados ){
				acessos_items = { "modulos": [] } ;					
				$.each( resultados, function( i, itemsAux ) {
					acessos_items.modulos.push( {						
						"nomeModulo": itemsAux.nomeModulo,						
						"idModulo": itemsAux.idModulo,
						"checkModulo": itemsAux.checkModulo,
						"listaAcao": itemsAux.listaAcao,
						"numberActions": itemsAux.numberActions
					});
				});	
				render['template'] = render_usuarios_edit_acessos ;
				render['data'] = acessos_items ;
				usuarios_edit_acessos_table.append(appolo.util.mustache_render_template( render['template'], render['data'] ));
				usuarios_edit_acessos_table.show();	
				if(!$('#mantemAcessoPadrao').is(":checked")){
					$('.table_acessos').slideDown();	
				}
				appolo.configs.set_functions_pos_ajax() ;					
			}) ;
			
		},
		usuarios_edit: function (){
			var that = this,
			usuarios_edit_content_sections = $( that.usuarios_edit_content_sections ),
			cdCpf = $('#cdCpf').val(),	
			mantemAcessoPadrao = "",
			usuarios_items = '' ;
			
			
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_admin_usuarios,
				data:  {cdCpf : cdCpf},
				dataType: 'json'
			}).done(function( usuarios ){	
				
				$.each( usuarios, function( i, usuarios ) {
					 $('#user_description').val(usuarios.nomeusuario),
					 $('#idCargo').val(usuarios.idcargo),
					 $('#idUsuario').val(usuarios.idusuario),
					 mantemAcessoPadrao = usuarios.mantemAcessoPadrao
				});
				
				if(mantemAcessoPadrao=="1"){
					$('#mantemAcessoPadrao').prop('checked', true);
				}else{
					$('#mantemAcessoPadrao').prop('checked', false);
					
				}
				that.usuarios_edit_acessos();
				$(".usuarios_edit").slideDown(); 
				$(".loading").slideUp();
				
			});	
			
		}
	},	
	funcionarios: {
		funcionarios_content_sections: null,
		funcionarios_search_bar: null,
		form_grid_funcionarios: 'grid_funcionarios',
		currently_open_type_modal: null,

		init: function (){
			var that = this,
			funcionarios_search_bar = $( that.funcionarios_search_bar ),
			funcionarios_content_sections = $( that.funcionarios_content_sections ),
			table_funcionarios = funcionarios_content_sections.find( '.table-funcionarios' ),
			content_table_funcionarios = table_funcionarios.find( 'tbody.active' ),
			data_limit_per_page = table_funcionarios.attr( 'data-limit-per-page' ),
			
			currently_open_type_modal = that.currently_open_type_modal,
			content_table_funcionarios_per_page = new Array(), sn = 0,
			content_select_cargo = funcionarios_search_bar.find('.cargo-select');
			cdSexo = nome = "",
			cdStatus = cdCargo = "null",
			render = { "template": {}, "data": {} }			
			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_area,
					data:  {nome: nome, cdStatus: cdStatus, cdCargo: cdCargo, cdSexo: cdSexo},
					dataType: 'json'
			}).done(function( lista_resultado ){									
				funcionarios_edit_lista = { "items": [] } ;	
				$.each( lista_resultado, function( i, area ) {
					funcionarios_edit_lista.items.push( {							
							"idCargo": area.idCargo,
							"descricaoCargo": area.descricaoCargo,							
						});
				});

				render['template'] = render_funcionarios_search_area ;
				render['data'] = funcionarios_edit_lista ;
				content_select_cargo.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				content_select_cargo.show();
			});



			content_table_funcionarios.html( appolo.util.mustache_render_template( render_sections_funcionarios_loading));
			content_table_funcionarios.show();

			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_funcionarios,
					data:  {nome: nome, cdStatus: cdStatus, cdCargo: cdCargo, cdSexo: cdSexo},
					dataType: 'json'
			}).done(function( lista_resultado ){	
				
				funcionarios_lista = { "items": [] } ;	
				$.each( lista_resultado, function( i, pessoa ) {
					section_dataCriacao_min = appolo.util.mount_date_min ( pessoa.dtNascimento ) ;
					section_dataCriacao_full = appolo.util.mount_date_full_w_feira( pessoa.dtNascimento ) ;
					funcionarios_lista.items.push( {
							"nome": pessoa.nomePessoa,
							"section_dataCriacao_min": section_dataCriacao_min,
							"section_dataCriacao_full": section_dataCriacao_full,
							"cpf": pessoa.cpfPessoa,
							"sexo": pessoa.sexo,
							"cargo": pessoa.descricaoCargo,
							"status": pessoa.DescricaoStatus
						});
				});
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( funcionarios_lista.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_funcionarios ;
				render['template'] = render_funcionarios_grid ;
				render['data'] = funcionarios_lista ;
				content_table_funcionarios.find( 'img' ).fadeOut( that.default_time_loading ) ;
				content_table_funcionarios.find( 'tr.loading' ).remove() ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
						content_table_funcionarios.append(
							appolo.util.mustache_render_template( render['template'], render['data'] )
						) ;
					}else{
						var funcionarios_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							funcionarios_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_funcionarios.find( 'tbody.page-' + i ).length ) ) {
								table_funcionarios.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_funcionarios.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_funcionarios_per_page[ i ] = table_funcionarios.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									funcionarios_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_funcionarios_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], funcionarios_per_page[ i ] )
							) ;

						}
					}
					appolo.gui.pagination.mount() ;
					appolo.configs.set_functions_pos_ajax() ;
			}) ;
		},

		funcionarios_search: function (){

			var that = this,
			funcionarios_search_bar = $( that.funcionarios_search_bar ),
			funcionarios_content_sections = $( that.funcionarios_content_sections ),
			table_funcionarios = funcionarios_content_sections.find( '.table-funcionarios' ),
			content_table_funcionarios = table_funcionarios.find( 'tbody.active' ),
			data_limit_per_page = table_funcionarios.attr( 'data-limit-per-page' ),
			
			currently_open_type_modal = that.currently_open_type_modal,
			content_table_funcionarios_per_page = new Array(), sn = 0,
			content_select_cargo = funcionarios_search_bar.find('.cargo-select');
			nome = $('#nome_Busca').val(),	
			cdCargo = $('#cdCargo_Busca').val(),
			cdStatus = $('#cdStatus_Busca').val(),	
			cdSexo = $('#cdSexo_Busca').val(),			
			render = { "template": {}, "data": {} }
			$( table_funcionarios.find('tbody') ).each(function(){
				if( ! $( this ).hasClass( 'active' ) ){
					$( this ).html('') ;
				}
			}) ;
			// content_table_funcionarios.html("");
			content_table_funcionarios.html( appolo.util.mustache_render_template( render_sections_funcionarios_loading ) );
			content_table_funcionarios.show();
			if(cdStatus == ""){
				cdStatus = "null";
			}
			if(cdCargo == ""){
				cdCargo = "null";
			}
			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_funcionarios,
					data:  {nome: nome, cdStatus: cdStatus, cdCargo: cdCargo, cdSexo: cdSexo},
					dataType: 'json'
			}).done(function( lista_resultado ){	
				
				funcionarios_lista = { "items": [] } ;	
				$.each( lista_resultado, function( i, pessoa ) {

					funcionarios_lista.items.push( {
							"nome": pessoa.nomePessoa,
							"dtNascimento": pessoa.dtNascimento,
							"cpf": pessoa.cpfPessoa,
							"sexo": pessoa.sexo,
							"cargo": pessoa.descricaoCargo,
							"status": pessoa.DescricaoStatus
						});
				});
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( funcionarios_lista.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_funcionarios ;
				render['template'] = render_funcionarios_grid ;
				render['data'] = funcionarios_lista ;
				content_table_funcionarios.find( 'img' ).fadeOut( that.default_time_loading ) ;
				content_table_funcionarios.find( 'tr.loading' ).remove() ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
						content_table_funcionarios.append(
							appolo.util.mustache_render_template( render['template'], render['data'] )
						) ;
					}else{
						var funcionarios_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							funcionarios_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_funcionarios.find( 'tbody.page-' + i ).length ) ) {
								table_funcionarios.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_funcionarios.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_funcionarios_per_page[ i ] = table_funcionarios.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									funcionarios_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_funcionarios_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], funcionarios_per_page[ i ] )
							) ;

						}
					}
					appolo.gui.pagination.first_page() ;
					appolo.configs.set_functions_pos_ajax() ;
					content_table_funcionarios.show();

			}) ;
		},
		funcionarios_new: function (){
			var that = this,
			funcionarios_new_content_sections = $( that.funcionarios_new_content_sections ),
			select_funcionarios = funcionarios_new_content_sections.find( '.div-cargo-select' ),
			content_select_funcionarios = select_funcionarios.find('.cargo-select');
			render = { "template": {}, "data": {} }
			funcionarios_new_items = '' ;
			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_area,
					dataType: 'json'
			}).done(function( lista_resultado ){	
				
				funcionarios_new_lista = { "items": [] } ;	
				$.each( lista_resultado, function( i, area ) {

					funcionarios_new_lista.items.push( {							
							"idCargo": area.idCargo,
							"descricaoCargo": area.descricaoCargo
						});
				});
				render['template'] = render_funcionarios_new_grid ;
				render['data'] = funcionarios_new_lista ;
				content_select_funcionarios.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
				content_select_funcionarios.show();							
			}) ;
		},

			funcionarios_edit: function (){
			$(".content-funcionarios_edit").hide();	
			var that = this,
			funcionarios_edit_content_sections = $( that.funcionarios_edit_content_sections ),
			select_funcionarios = funcionarios_edit_content_sections.find( '.div-cargo-select' ),
			content_select_funcionarios = select_funcionarios.find('.cargo-select'),
			idCargo = dtNasc = sexo = cdStatus = "",
			cdCpf = $('#cdCpf').val();
			render = { "template": {}, "data": {} }
			funcionarios_edit_items = '' ;
			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_contato_pessoa,
					data:  {cdCpf: cdCpf},
					dataType: 'json'
			}).done(function( lista_resultado ){					
				funcionarios_edit_lista = { "items": [] } ;	
				$.each( lista_resultado, function( i, area ) {
					$('#contato').val(area.contatoPessoa);
				});
			});	
			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_funcionarios,
					data:  {cdCpf: cdCpf},
					dataType: 'json'
			}).done(function( lista_resultado ){					
				funcionarios_lista = { "items": [] } ;	
				$.each( lista_resultado, function( i, pessoa ) {										
					sexo = pessoa.sexo;	
					dtNasc = pessoa.dtNascimento.substring(0, 10);
					cdStatus = pessoa.statusPessoa;
					idCargo = pessoa.idCargo;
					$('#dtNascimento').val(dtNasc);
					$('#nome').val(pessoa.nomePessoa);
				})
				$("#sexo"+sexo+"").prop("checked",true);
				$("#status"+cdStatus+"").prop("checked",true);
				$(".loading").hide();
				$(".content-funcionarios_edit").fadeIn();		
			});	
			var title = document.title;
			if  (!title.match("^Alterar Dados Pessoais")){
				$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_area,
					dataType: 'json'
				}).done(function( lista_resultado ){					
					funcionarios_edit_lista = { "items": [] } ;	
					$.each( lista_resultado, function( i, area ) {
						funcionarios_edit_lista.items.push( {
								"idCargo": area.idCargo,
								"descricaoCargo": area.descricaoCargo,
							});
					});
					render['template'] = render_funcionarios_edit_grid ;
					render['data'] = funcionarios_edit_lista ;
					content_select_funcionarios.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
					content_select_funcionarios.show();		
					$("#cargo").find("option[value="+idCargo+"]").attr("selected",true);
				}) ;
			}			
			
		},
	},

	//area
	area: {
		area_content_sections: null,
		area_edit_content_sections: null,
		form_grid_area: 'grid_area',
		currently_open_type_modal: null,

		init: function(){
			var that = this,
			area_content_sections = $( that.area_content_sections ),
			table_areas = area_content_sections.find( '.table-areas' ),
			content_table_areas = table_areas.find( 'tbody.active' ),
			data_limit_per_page = table_areas.attr( 'data-limit-per-page' ),
			currently_open_type_modal = that.currently_open_type_modal,
			content_table_areas_per_page = new Array(), sn = 0,			
			render = { "template": {}, "data": {} }
			areas_items = '' ;
			content_table_areas.html( appolo.util.mustache_render_template( render_sections_area_loading));
			content_table_areas.show();
			$.ajax({
					type: "POST", 
					url: appolo.configs.select_admin_area,
					dataType: 'json'
			}).done(function( areas ){

				areas_items = { "items": [] } ;	
				$.each( areas, function( i, area ) {

					areas_items.items.push( {
							"idCargo": area.idCargo,
							"descricaoCargo": area.descricaoCargo
						});
				});
				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( areas_items.items.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_areas ;
				render['template'] = render_area_grid ;
				render['data'] = areas_items ;
				content_table_areas.find( 'img' ).fadeOut( that.default_time_loading ) ;
				content_table_areas.find( 'tr.loading' ).remove() ;
				if( ! ( appolo.gui.pagination.pages > 1 ) ){
						content_table_areas.append(
							appolo.util.mustache_render_template( render['template'], render['data'] )
						) ;
					}else{
						var areas_per_page = new Array() ; //items per page

						for ( var i = 1 ; i <= appolo.gui.pagination.pages ; i++ ) {
							areas_per_page[ i ] = { "items": [] } ;
							if( ( i != 1 ) && ( ! table_areas.find( 'tbody.page-' + i ).length ) ) {
								table_areas.append( '<tbody class="page page-' + i + '"></tbody>' );
							}else{
								table_areas.find( 'tbody.page-' + i ).html( '' ) ;
							}

							content_table_areas_per_page[ i ] = table_areas.find( 'tbody.page-' + i ) ;

							for ( var j = 0 ; j < data_limit_per_page ; j++ ) {
								if ( typeof render['data'].items[ sn ] != 'undefined'){
									areas_per_page[ i ].items[ j ] = render['data'].items[ sn ] ;
								}
								sn++ ;
							}

							content_table_areas_per_page[ i ].append(
								appolo.util.mustache_render_template( render['template'], areas_per_page[ i ] )
							) ;

						}
					}
					
					appolo.gui.pagination.mount() ;

					appolo.configs.set_functions_pos_ajax() ;

			}) ;
				
		},

		area_edit: function(){
			var that = this,
			area_edit_content_sections = $( that.area_edit_content_sections ),
			table_areas = area_edit_content_sections.find( '.table-areas' ),
			content_table_areas = table_areas.find( 'tbody.active' ),
			render = { "template": {}, "data": {} },
			form_grid_area= 'grid_area',
			cargoId = $('#idCargo').val();			
			areas_items = '' ;
			$.ajax({
				type: "POST", 
				url: appolo.configs.select_modulo_acao,
				data:  {cargoId: cargoId},
				dataType: 'json'
			}).done(function( resultados ){
				areas_items = { "modulos": [] } ;					
				$.each( resultados, function( i, itemsAux ) {
					areas_items.modulos.push( {						
						"nomeModulo": itemsAux.nomeModulo,						
						"idModulo": itemsAux.idModulo,
						"checkModulo": itemsAux.checkModulo,
						"listaAcao": itemsAux.listaAcao,
						"numberActions": itemsAux.numberActions
					});
				});	
				render['template'] = render_area_grid ;
				render['data'] = areas_items ;
				content_table_areas.append(appolo.util.mustache_render_template( render['template'], render['data'] ));
				content_table_areas.show();								
				appolo.configs.set_functions_pos_ajax() ;

			}) ;
			$(".loading").hide();
			$(".form_edit_area").fadeIn();	

		}	
	},
	pages: {

		pages_content_sections: null,
		currently_open_section: null,
		currently_open_type_modal: null,
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
				$( '.section-gap > .title').html( '<span class="glyphicon glyphicon-th a-icon"></span>' ) ;
			}) ;

		},

		get_parent_pages_section_breadcrumb: function( section, news ){
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

				if( ! ( news == 'news' ) ){
					that.temporary_sections.push( { "title": sections_parent[0]['nomeSecao'], "slug": section, "class": ( ( sections_parent[0]['secaoHidden'] == 1 ) ? ' access-hidden' : '' ), "active": ( ( section == that.currently_open_section ) ? true : false ), "link": ( appolo.configs.pages_sections_url + section ) } ) ;

					if ( sections_parent[0]["idSecaoPai"] != 0 ){
						that.get_parent_pages_section_breadcrumb( sections_parent[0]["idSecaoPai"] ) ;
					}
				}else{
					that.temporary_sections.push( { "title": sections_parent[0]['nomeSecao'], "slug": section, "class": ( ( sections_parent[0]['secaoHidden'] == 1 ) ? ' access-hidden' : '' ), "active": true, "link": ( appolo.configs.news_new_url + section ) } ) ;
					return false ;
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

			//bug news *breadcrumb*
			if( section == 'news' ) {
				section_pages_parent = { "sections": [] } ; //array

				section_pages_parent.sections.push( {
					"idSecao": null,
					"nomeSecao": "Seções"
				} ) ;

				where.prepend( appolo.util.mustache_render_template( render_sections_pages_head, section_pages_parent ) ) ;

				return false ;
			}

			//if NOT bug:
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

		init: function(){
			var that = this,
			pages_content_sections = $( that.pages_content_sections ),
			table_sections = pages_content_sections.find( '.table-sections' ),
			content_table_sections = table_sections.find( 'tbody.active' ),
			content_table_sections_back_section = table_sections.find( 'tbody.back-section' ),
			data_limit_per_page = table_sections.attr( 'data-limit-per-page' ),
			currently_open_section = that.currently_open_section,
			currently_open_type_modal = that.currently_open_type_modal,
			order = that.order,
			by = that.by,
			first_one = true,
			division_sections_pages = that.division_sections_pages,
			render = { "template": {}, "data": {} }, sn = 0, live_count = section_dataCriacao = section_dataCriacao_min = section_dataCriacao_full = section_datahoraPublicacao = section_datahoraPublicacao_min = section_datahoraPublicacao_full = section_pages_parent = section_pages = '', content_table_sections_per_page = new Array() ;

			//render loading
			content_table_sections.html( appolo.util.mustache_render_template( render_sections_pages_loading ) ) ;

			//activing menu li from model
			$( '.navbar-nav li' ).removeClass( 'active' ) ;
			$( '.navbar-nav .paginas' ).addClass( 'active' ) ;

			$.ajax({
				dataType: 'json',
				url: appolo.configs.select_pages_sections + ( ( currently_open_section != null ) ? ( currently_open_section ) : "0" ) + ( '?order=' + order + '&by=' + by )
				}).done(function( sections ){

				//Array
				if ( Array.isArray( appolo.configs.nav[ appolo.configs.nav.length - 1 ] ) ) { appolo.configs.nav.pop() ; }

				//if there is a opened section
				if ( currently_open_section ){
					appolo.util.change_status_nav( 'sections', 0, false ) ;
					appolo.configs.pages.temporary_sections = new Array() ;
					appolo.configs.nav.push( { "title": "<img src=\"/images/icon-loading.gif\" alt=\"Carregando...\" class=\"breadcrumb-loading\">", "slug": "loading", "active": false, "link": "" } ) ;
					that.get_parent_pages_section_breadcrumb( currently_open_section ) ;
					appolo.configs.nav.push( appolo.configs.pages.temporary_sections ) ;
					that.get_parent_pages_section_back( currently_open_section, content_table_sections_back_section ) ; //back section
				}

				//show loading in breadcrumb
				appolo.gui.mount_breadcrumb() ;

				//declare variable
				section_pages = { "sections": [] } ;

				$.each( sections, function( i, section ) {
					if( ! section.idPagina ){ //it its NOT a true page
						

						section_datahoraCriacao = new Date ( section.dataCriacao ) ;
						section_datahoraCriacao_min = appolo.util.mount_date_min ( section_datahoraCriacao ) ;
						section_datahoraCriacao_full = appolo.util.mount_date_full_w_feira( section_datahoraCriacao ) ;
						if( section_datahoraCriacao_min != null && section_datahoraCriacao_min != '' ){
							section_datahoraCriacao_modified = new Date( section_datahoraCriacao ) ;
							section_datahoraCriacao_full = section_datahoraCriacao_full + ' ás ' + ( section_datahoraCriacao_modified.getHours() ) + ':' + section_datahoraCriacao_modified.getMinutes() ;
						}

						section_pages.sections.push( {
							"id_item": section.idSecao,
							"icon_item": "folder-close",
							"type": "sections",
							"url_prefix": appolo.configs.pages_sections_url,
							"name_item": section.nomeSecao,
							"desc_item": section.descricaoSecao,
							"created": ( ( section.idSecao == appolo.configs.section_created ) ? "yes" : "" ),
							"updated": ( ( section.idSecao == appolo.configs.section_updated ) ? "yes" : "" ),
							"section_dataCriacao_min": section_datahoraCriacao_min,
							"section_dataCriacao_full": section_datahoraCriacao_full,
							"addclass": [
								{ "class": ( ( section.secaoHidden == 1 ) ? 'non-visible' : '' ) },
								{ "class": ( ( section.descricaoSecao != '' ) ? 'plusinfo' : '' ) }
							]
						 } ) ;
					}else if( section.idPagina ){ //if its a true page
						if( ! first_one ){
							division_sections_pages = "" ;
						}

						section_datahoraCriacao = new Date ( section.datahoraCriacao ) ;
						section_datahoraCriacao_min = appolo.util.mount_date_min ( section_datahoraCriacao ) ;
						section_datahoraCriacao_full = appolo.util.mount_date_full_w_feira( section_datahoraCriacao ) ;
						if( section_datahoraCriacao_min != null && section_datahoraCriacao_min != '' ){
							section_datahoraCriacao_modified = new Date( section_datahoraCriacao ) ;
							section_datahoraCriacao_full = section_datahoraCriacao_full + ' ás ' + ( parseInt( section_datahoraCriacao_modified.getHours() ) ) + ':' + section_datahoraCriacao_modified.getMinutes() ;
						}

						section_datahoraPublicacao = new Date ( section.datahoraPublicacao ) ;
						section_datahoraPublicacao_min = ( section.datahoraPublicacao ) ? appolo.util.mount_date_min ( section_datahoraPublicacao ) : "" ;
						section_datahoraPublicacao_full = ( section.datahoraPublicacao ) ? appolo.util.mount_date_full_w_feira( section_datahoraPublicacao ) : "" ;
						if( section_datahoraPublicacao_min != null && section_datahoraPublicacao_min != '' ){
							section_datahoraPublicacao_modified = new Date( section_datahoraPublicacao ) ;
							section_datahoraPublicacao_full = section_datahoraPublicacao_full + ' ás ' + ( section_datahoraPublicacao_modified.getHours() ) + ':' + section_datahoraPublicacao_modified.getMinutes() ;
						}

						section_pages.sections.push( {
							"id_item": section.idPagina,
							"icon_item": "file",
							"type": "pages",
							"url_prefix": appolo.configs.pages_page_url,
							"name_item": section.nomePagina,
							"desc_item": section.descricaoPagina,
							"created": ( ( section.idPagina == appolo.configs.page_created ) ? "yes" : "" ),
							"updated": ( ( section.idPagina == appolo.configs.page_updated ) ? "yes" : "" ),
							"canceled": ( ( section.idPagina == appolo.configs.page_canceled ) ? "yes" : "" ),
							"error": ( ( section.idPagina == appolo.configs.page_error ) ? "yes" : "" ),
							"section_dataCriacao_min": section_datahoraCriacao_min,
							"section_dataCriacao_full": section_datahoraCriacao_full,
							"section_dataPublicacao_min": section_datahoraPublicacao_min,
							"section_dataPublicacao_full": section_datahoraPublicacao_full,
							"division_sections_pages": division_sections_pages,
							"creator": section.nicename,
							"status": ( ( section.status == 0 ) ? appolo.configs.status_free : appolo.configs.status_open ),
							"addclass": [
								{ "class": ( ( section.paginaHidden == 1 ) ? 'non-visible' : '' ) },
								{ "class": ( ( section.descricaoPagina != '' ) ? 'plusinfo' : '' ) }
							]
						} ) ;

						first_one = false ;
					}

				}) ;


				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( section_pages.sections.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_sections ;

				that.set_parent_pages_section( currently_open_section, appolo.gui.pagination.pages ) ;

				render['template'] = render_sections_pages ;
				render['data'] = section_pages ;

				if( sections.length == 0 ){ //if theres is no result, render a page with "none"
					render['template'] = ( ( currently_open_section != null ) ? render_sections_pages_none : render_sections_pages_none_no_page_selected ) ;
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
					appolo.configs.section_updated = '' ;
					appolo.configs.page_updated = '' ;
					appolo.configs.page_canceled = '' ;
					appolo.configs.page_error = '' ;

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

					appolo.gui.form_set_checks_grid( that.form_grid_pages_sections, appolo.configs.delete_pages_sections, '.check', 'Tem certeza que deseja deletar ?', '.del-checks', '.view-checks' ) ;

					appolo.configs.set_functions_pos_ajax() ;

				}, that.default_time_loading ) ;

			}).error( function(){
				appolo.gui.render_warn_message( appolo.gui.render_message( "danger", true, appolo.gui.message_error_loading_sections, "animated fadeInRight" ) ) ;
			} ) ;

		},

		page: {

			currently_section_parent: null,
			content_form_page: '.content-form-page',
			form_grid_pages_sections: 'grid_page',
			default_time_loading: 500,
			a_icon_page: ' <span class="glyphicon glyphicon-file a-icon"></span>',
			a_icon_page_form: ' <span class="glyphicon glyphicon-list-alt a-icon"></span>',
			a_icon_page_tmpl: ' <span class="glyphicon glyphicon-indent-right a-icon"></span>',
			main_form: '.main-form > #inject',
			main_form_form: 'form[name=main-form_form]',
			textarea_coding: '.code-editing',
			default_time_loading: 150,
			control_group_form_page: '.control-group-form-page',
			just_took_out: false,
			just_scrolled_out: false,
			just_inverted: false,
			i_organize_group: 0,
			begin: true,
			can: true,
			form_code: '.form-code',
			save_item: {},

			set_form_properties: function( form, form_not_null ){
				var that = this ;

				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Cuidado, você está editando a página!</strong></p>' ) ;
				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Seção</strong>: ' + that.currently_section_parent_name + '</p>' ) ;
				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Campos obrigatórios</strong>: ' + ( ( form_not_null.length > 0 ) ? ( form_not_null.length + ' <span class="glyphicon glyphicon-flash not-null-icon"></span>' ) : 'Nenhum' ) + ' </p>' ) ;
				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Última publicação</strong>: ' + ( ( that.datetimePublicacao != '' ) ? appolo.util.mount_date_full_w_feira( that.datetimePublicacao ) : ' (nenhuma)' ) + '</p>' ) ;
				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Último usuário</strong>: ' + ( ( that.last_user_nicename != '' ) ? that.last_user_nicename : ' -' ) + '</p>' ) ;
				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Pré-visualização</strong>: ' + ( ( that.config_preview != '' ) ? ( '<a target="_blank" href="' + appolo.configs.view_staging + that.config_preview + '">' + appolo.configs.view_staging + that.config_preview + '</a>' ) : ' -' ) + '</p>' ) ;
				form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Visualização no ar</strong>: ' + ( ( that.config_preview != '' ) ? ( '<a target="_blank" href="' + appolo.configs.view_prod + that.config_preview + '">' + appolo.configs.view_prod + that.config_preview + '</a>' ) : ' -' ) + '</p>' ) ;
				form.append( '<h2 class="divisor">Administrador</h2>' ) ;
				if( appolo.configs.pages.page.can_view_admin ){
					form.append( '<p><span class="glyphicon glyphicon-arrow-right a-icon"></span><strong>Conteúdo - Valores & Campos [JSON]</strong>: ' + ( ( that.config_data != '' ) ? ( '<a target="_blank" href="' + appolo.configs.pages.page.view_content + that.config_data + '">' + appolo.configs.pages.page.view_content + that.config_data + '</a>' ) : ' -' ) + '</p>' ) ;
				}
				form.css( 'display', 'inline-block' ) ;
			},

			form_mount_field: function( object_field, this_type, parent_group, parent_name, group_name, main_form ){
				var that = this, code = '', object_field = $( object_field ),				/* BUG RADIO VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV */
				notnull = ( typeof $( object_field ).attr( 'notnull' ) != 'undefined' ), select_type = $( object_field ).attr( 'type' ) ;

				name = $( object_field ).attr( 'name' ),
				name_self = ( ( typeof $( object_field ).attr( 'title' ) != 'undefined' ) ? $( object_field ).attr( 'title' ) : $( object_field ).attr( 'name' ) ),
				check_same_name = $( parent_group.find( ' > *[name=' + name + ']' ) ) ;

				if( ( name == '' ) || ( name == 'undefined' ) ){
					return appolo.gui.set_error_page( [ 'Campo do grupo "<i>' + group_name + '</i>" não tem um nome definido.' ], this_type, main_form ) ;
				}

				if( check_same_name.length > 1 ){
					return appolo.gui.set_error_page( [ 'Existem dois campos com o mesmo nome "<i>' + name + '</i>".' ], this_type, main_form ) ;
				}

				if( ! $( $( object_field ).find( 'input, textarea, select'  ) ).length ){
					return appolo.gui.set_error_page( [ 'Nenhum campo em "<i>' + name_self + '</i>" definido.' ], this_type, main_form ) ;
				}

				label = ( ( $( $( object_field ).find( 'label' ) ).length ? ( $( $( object_field ).find( 'label' ) ).html() ) : name ) ) ;
				hint = 	( ( $( $( object_field ).find( 'hint'  ) ).length ? ( '<span class="glyphicon glyphicon-question-sign"></span>' + $( $( object_field ).find( 'hint'  ) ).html() ) : '' ) ) ;
				input = ( ( $( $( object_field ).find( 'input'  ) ).length ? ( $( $( object_field ).find( 'input' ) ) ) : false ) ) ;

				if( !input ){
					return appolo.gui.set_error_page( [ 'Input não definido para o "<i>' + label + '</i>".' ], this_type, main_form ) ;
				}

				//code
				code += '<div class="control-group ' + select_type + '">' ;
					code += '<label class="control-label ' + ( ( notnull ) ? 'not-null' : '' ) + '">' + label + '</label>' ;

					code += '<div class="controls">' ;
						switch( $( object_field ).attr( 'type' ) ){
							case 'text':
								code += '<input id="' + name + '-' + parent_name + '-0" name="' + name + '-' + parent_name + '-0" data-realname="' + name + '"' ;
									if( typeof input.attr( 'max' ) != 'undefined' && input.attr( 'max' ) != '0' && input.attr( 'max' ) != '' ){
										code += ' maxlength="' + input.attr( 'max' ) + '" ' ;
									}
									code += ' type="text" ' ;
									code += ' placeholder="' + ( ( typeof input.attr( 'title' ) != 'undefined' ) ? input.attr( 'title' ) : 'Preencha o campo' ) + '" ' ;
									code += ' class="form-control" ' ;
								code += ' >' ;
							break ;
							case 'number':
								code += '<input id="' + name + '-' + parent_name + '-0" name="' + name + '-' + parent_name + '-0" data-realname="' + name + '"' ;
									if( typeof input.attr( 'min' ) != 'undefined' && input.attr( 'min' ) != '0' && input.attr( 'min' ) != '' ){
										code += ' min="' + input.attr( 'min' ) + '" ' ;
									}
									if( typeof input.attr( 'max' ) != 'undefined' && input.attr( 'max' ) != '0' && input.attr( 'max' ) != '' ){
										code += ' max="' + input.attr( 'max' ) + '" ' ;
									}
									code += ' type="number" ' ;
									code += ' placeholder="' + ( ( typeof input.attr( 'title' ) != 'undefined' ) ? input.attr( 'title' ) : 'Preencha o campo' ) + '" ' ;
									code += ' class="form-control" ' ;
								code += ' >' ;
							break ;
							case 'textarea':
								code += '<textarea id="' + name + '-' + parent_name + '-0" name="' + name + '-' + parent_name + '-0" data-realname="' + name + '"' ;
									if( typeof input.attr( 'max' ) != 'undefined' && input.attr( 'max' ) != '0' && input.attr( 'max' ) != '' ){
										code += ' maxlength="' + input.attr( 'max' ) + '" ' ;
									}
									if( typeof input.attr( 'rows' ) != 'undefined' && input.attr( 'rows' ) != '0' && input.attr( 'rows' ) != '' ){
										code += ' rows="' + input.attr( 'rows' ) + '" ' ;
									}
									code += ' placeholder="' + ( ( typeof input.attr( 'title' ) != 'undefined' ) ? input.attr( 'title' ) : 'Preencha o campo' ) + '" ' ;
									code += ' class="form-control" ' ;
								code += ' >' + '</textarea>' ;
							break ;
							case 'radio':
								if( $( $( object_field ).find( 'input'  ) ).length < 2 ){
									return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" deve ter mais de um valor.' ], this_type, main_form ) ;
								}
								input_value_radio = $( $( object_field ).find( 'input' ) ) ;
								for( i = 0; i < input_value_radio.length; i ++){
									if( typeof $( input_value_radio[ i ] ).attr( 'value' ) == 'undefined' ){
										return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" está faltando um valor.' ], this_type, main_form ) ;
									}
									code += '<label class="radio-inline">' ;
										code += '<input id="' + name + '-' + parent_name + '-0" name="' + name + '-' + parent_name + '-0" value="' + $( input_value_radio[ i ] ).attr( 'value' ) + '" data-realname="' + name + '"' ;
											code += ' type="radio" ' ;
											code += ' class="form-control" ' ;
											if( typeof $( input_value_radio[ i ] ).attr( 'checked' ) != 'undefined' ){
												code += ' checked ' ;
												code += ' data-check-it-by-default="true" ' ;
											}
											code += ' title="' + ( ( typeof $( input_value_radio[ i ] ).attr( 'title' ) != 'undefined' ) ? $( input_value_radio[ i ] ).attr( 'title' ) : 'Preencha o campo' ) + '" ' ;
										code += ' >' + ( ( typeof $( input_value_radio[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( input_value_radio[ i ] ).attr( 'title' ) ) : $( input_value_radio[ i ] ).attr( 'value' ) ) ;
									code += '</label>' ;
								}
							break ;
							case 'checkbox':
								if( $( $( object_field ).find( 'input'  ) ).length < 2 ){
									return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" deve ter mais de um valor.' ], this_type, main_form ) ;
								}
								input_value_check = $( $( object_field ).find( 'input' ) ) ;
								for( i = 0; i < input_value_check.length; i ++){
									if( typeof $( input_value_check[ i ] ).attr( 'value' ) == 'undefined' ){
										return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" está faltando um valor.' ], this_type, main_form ) ;
									}
									code += '<label class="checkbox-inline">' ;
										code += '<input id="' + name + '-' + parent_name + '-0" name="' + name + '-' + parent_name + '-0" value="' + $( input_value_check[ i ] ).attr( 'value' ) + '" data-realname="' + name + '"' ;
											code += ' type="checkbox" ' ;
											code += ' class="form-control" ' ;
											if( typeof $( input_value_check[ i ] ).attr( 'checked' ) != 'undefined' ){
												code += ' checked ' ;
												code += ' data-check-it-by-default="true" ' ;
											}
											code += ' title="' + ( ( typeof $( input_value_check[ i ] ).attr( 'title' ) != 'undefined' ) ? $( input_value_check[ i ] ).attr( 'title' ) : 'Preencha o campo' ) + '" ' ;
										code += ' >' + ( ( typeof $( input_value_check[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( input_value_check[ i ] ).attr( 'title' ) ) : $( input_value_check[ i ] ).attr( 'value' ) ) ;
									code += '</label>' ;
								}
							break ;
							case 'select':
								if( $( $( object_field ).find( 'input'  ) ).length < 2 ){
									return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" deve ter ao menos dois valores.' ], this_type, main_form ) ;
								}
								input_value_select = $( $( object_field ).find( 'input' ) ) ;
								code += '<select id="' + name + '-' + parent_name + '-0" name="' + name + '-' + parent_name + '-0" class="form-control" data-realname="' + name + '">' ;
									if( ! notnull ){ code += '<option value=""></option>' ; }
									for( i = 0; i < input_value_select.length; i ++){
										if( typeof $( input_value_select[ i ] ).attr( 'value' ) == 'undefined' ){
											return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" está faltando um valor.' ], this_type, main_form ) ;
										}
										code += '<option value="' + $( input_value_select[ i ] ).attr( 'value' ) + '"' ;
										if( typeof $( input_value_select[ i ] ).attr( 'checked' ) != 'undefined' || typeof $( input_value_select[ i ] ).attr( 'selected' ) != 'undefined' ){
											code += ' selected ' ;
										}
										code += ' >' ;
											code += ( ( typeof $( input_value_select[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( input_value_select[ i ] ).attr( 'title' ) ) : $( input_value_select[ i ] ).attr( 'value' ) ) ;
										code += ' </option>' ;
									}
								code += '</select>' ;
							break ;
							default:
								return appolo.gui.set_error_page( [ 'Campo "<i>' + label + '</i>" não tem tipo correto.' ], this_type, main_form ) ;
							break ;
						}

						code += '<p class="help-block">' + hint + '</p>' ;
					code += '</div>' ;
				code += '</div>' ;

				
				return code ;
			},

			form_mount_group: function( object_group, this_type, main_form, item ){
				var that = this, code = '', elements_objects = [], current_item = max = min = 0 ;

				if( ! object_group.length ){
					return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
				}

				for( var i = 0; i < object_group.length; i ++ ){
					name = $( object_group[ i ] ).attr( 'name' ),
					name_self = ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? $( object_group[ i ] ).attr( 'title' ) : $( object_group[ i ] ).attr( 'name' ) ),
					check_same_name = $( $( that.form_code ).find( ' group[name=' + name + ']' ) ),
					check_same_name_all = $( $( $( that.content_form_page ).find( that.form_code ) ).find( ' > group[name=' + name + ']' ) ) ;

					//repetidor
					max = ( typeof $( object_group[ i ] ).attr( 'max' ) != 'undefined' ) ? $( object_group[ i ] ).attr( 'max' ) : false ;
					min = ( typeof $( object_group[ i ] ).attr( 'min' ) != 'undefined' ) ? $( object_group[ i ] ).attr( 'min' ) : false ;
					if( item == 0 && ( typeof $( object_group[ i ] ).attr( 'repeat' ) != 'undefined' || max || min ) ){
						return appolo.gui.set_error_page( [ 'Grupo "pai" de nome "<i>' + name_self + '</i>" não pode ser repetidor.' ], this_type, main_form ) ;
					}
					if( typeof $( object_group[ i ] ).attr( 'repeat' ) != 'undefined' && ( ! max || ! min ) ){
						return appolo.gui.set_error_page( [ 'Grupo "<i>' + name_self + '</i>" é repetidor e necessita de um valor máximo e mínimo definidos.' ], this_type, main_form ) ;
					}else if( ( typeof $( object_group[ i ] ).attr( 'repeat' ) == 'undefined' ) && ( max || min ) ){
						appolo.gui.set_warning_page( [ 'Grupo "<i>' + name_self + '</i>" tem limites definidos mas não possui a tag "<i>repeat</i>" definida.' ], this_type, main_form ) ;
						max = min = false ;
					}

					if( parseInt( min ) <= 0 ){
						return appolo.gui.set_error_page( [ 'Grupo "<i>' + name_self + '</i>" possui o valor mínimo igual a zero. Atualmente isto não é possível. :(', 'Estamos trabalhando para que ele possa ficar ali !' ], this_type, main_form ) ;
					}

					if( parseInt( max ) <= 0 ){
						return appolo.gui.set_error_page( [ 'Grupo "<i>' + name_self + '</i>" não pode ter um valor máximo menor ou igual a zero.' ], this_type, main_form ) ;
					}

					if( parseInt( min ) > parseInt( max ) ){
						return appolo.gui.set_error_page( [ 'Grupo "<i>' + name_self + '</i>" possui o valor mínimo maior do que o valor máximo.' ], this_type, main_form ) ;
					}

					if( ( name == '' ) || ( typeof name == 'undefined' ) ){
						return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
					}

					if( check_same_name.length > 1 || check_same_name_all.length > 1 ){
						return appolo.gui.set_error_page( [ 'Existem dois grupos com o mesmo nome "<i>' + name + '</i>".' ], this_type, main_form ) ;
					}

					//mount fieldset
					code += '<fieldset class="group ' + name + '" name="' + name + '" data-item="0" data-max="' + max + '" data-min="' + min + '" id="' + name + '" id="' + ( ( typeof $( object_group[ i ] ).attr( 'id' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'id' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '" data-realname="' + name + '">' ;

					code += '<legend>' + name_self + ' ' + ( ( $( object_group[ i ] ).attr( 'repeat' ) != 'undefined' && max && min ) ? ( '<span class="legend-order">(' + ( ( min == 0 ) ? 0 : 1 ) + ')</span>' ) : '' ) + '</legend>' ;

					//control fieldsets
					if( $( object_group[ i ] ).attr( 'repeat' ) != 'undefined' && max && min ){
						code += '<div class="btn-group btn-group-justified control-group-form-page" id="control-' + name + '" data-item="0">' ;

							code += '<div class="btn-group">' ;
								code += '<button href="#" class="btn btn-default btn-add-group disabled" type="button" id="' + name + '"><span class="glyphicon glyphicon-plus"></span></button>' ;
							code += '</div>' ;

							code += '<div class="btn-group">' ;
								code += '<button href="#" class="btn btn-default btn-rmv-group disabled" type="button" id="' + name + '"><span class="glyphicon glyphicon-minus"></span></button>' ;
							code += '</div>' ;

							code += '<div class="btn-group">' ;
								code += '<button href="#" class="btn btn-default btn-up-group disabled" type="button" id="' + name + '"><span class="glyphicon glyphicon-arrow-up"></span></button>' ;
							code += '</div>' ;

							code += '<div class="btn-group">' ;
								code += '<button href="#" class="btn btn-default btn-down-group disabled" type="button" id="' + name + '"><span class="glyphicon glyphicon-arrow-down"></span></button>' ;
							code += '</div>' ;

						code += '</div>' ;
					}

					elements_objects[ item ] = $( object_group[ i ] ).find( ' > group, > field' ) ;

					//getting layers [ LAYERS ERROR ]
					aux_verify_groups_child = $( object_group[ i ] ).find( ' group > group > group ' ) ;
					if( aux_verify_groups_child.length > 0 ){
						/*REVIEW REVIEW REVIEW REVIEW REVIEW AFTER-TCC*/
						return appolo.gui.set_error_page( [ 'Atualmente, não é possível definir uma terceira camada como para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>".', '<b>Dica</b>: retire o grupo "<i>' + ( ( typeof aux_verify_groups_child.attr( 'title' ) != 'undefined' ) ? ( aux_verify_groups_child.attr( 'title' ) ) : ( aux_verify_groups_child.attr( 'name' ) ) ) + '</i>". Estamos trabalhando para que ele possa ficar ali !' ], this_type, main_form ) ;
					}
					
					if( item == 0 ){ current_item = 0 ; } //current_item ) ;
					
					//nothing inside
					if( ! elements_objects[ item ].length ){
						return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
					}else{
						while( current_item < elements_objects[ item ].length ){

							var object = $( $( elements_objects[ item ][ current_item ] ) )[ 0 ] ;

							if( $( object )[ 0 ].localName == 'group' ){
								code += that.form_mount_group( $( object ), this_type, main_form, ( item + 1 ) ) ;
							}

							if( $( object )[ 0 ].localName == 'field' ){
								code += that.form_mount_field( $( object ), this_type, $( object_group[ i ] ), $( object_group[ i ] ).attr( 'name' ), ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ), main_form ) ;	
							}

							current_item ++ ;
						}
					}

					code += '</fieldset>' ;
				}

				return code ;
			},

			//old but it maybe works
			form_mount_page: function( fieldsets, obj, item ){
				var that = this, elements_objects = [], mount_obj = require = aux = newobjs = {}, current_item = 0, jsonStr = '' ;

				

				for (var i = 0; i < fieldsets.length; i ++ ) {

					elements_objects[ item ] = $( fieldsets[ i ] ).find( ' > fieldset, > .text input' ) ;

					if( item == 0 ){ current_item = 0 ; }

					

					require = {} ;

					while( current_item < elements_objects[ item ].length ){

						var object = $( $( elements_objects[ item ][ current_item ] ) )[ 0 ], name_object = ( $( $( object )[ 0 ] ).data( 'realname' ) ) ;

						//CASE FIELDSET
						if( $( object )[ 0 ].localName == 'fieldset' ){

							newobjs = that.form_mount_page( $( object ), require[ name_object ], ( item + 1 ) ) ;
							//newobjs.values.push( 'TESTE' ) ;

							if( item == 0 ){
								require[ name_object ] = newobjs ;
							}else{
								jsonStr = '{"'+name_object+'":' + JSON.stringify( newobjs ) + '}';
								aux = JSON.parse( jsonStr ) ;
							}

							if( $( fieldsets[ i ] ).data( 'realname' ) == 'group_child' ){
								console.log( 'TESTE: ',  jsonStr ) ;
							}
						}

						//CASE INPUT
						if( $( object )[ 0 ].localName == 'input' ){

							input_value = $( $( object )[ 0 ] ).val() ;

							

							//alert( name_object ) ;
							//jsonStr = '{"'+name_object+'":"' + input_value + '""}';
							aux[ name_object ] = input_value ;
						}

						current_item ++ ;
					}

					if( item == 0 ){
						mount_obj[ $( fieldsets[ i ] ).data( 'realname' ) ] = require ;
					}
				}

				if( item == 0 ) {
					return mount_obj ;
				}else{
					return aux ;
				}
			},

			increase_time: 10,

			set_concat_data: function( control, item, set_in ){
				var that = this,
				content_form_page = $( that.content_form_page ),
				main_form = $( content_form_page.find( that.main_form ) ),
				control_parent = control, parent_count = this_child = 0 ;

				setTimeout( function(){
					$.each( item, function( name, item ){
						parent_name = name ;
						parent_item = item ;
						parent_count++ ;

						if( isNaN( appolo.configs.pages.page.save_item[ control_parent.data( 'realname' ) ] ) ){
							appolo.configs.pages.page.save_item[ control_parent.data( 'realname' ) ] = 0 ;
						}else{
							appolo.configs.pages.page.save_item[ control_parent.data( 'realname' ) ]++ ;
						}

						$.each( item, function( name, item ){
							this_name = name ;
							this_item = item ;
							this_child++ ;

							if( ! ( typeof this_item == 'object' ) ){

								if( typeof control_parent.parent().data( 'realname' ) != 'undefined' ){
									set_parent_name = control_parent.parent().data( 'realname' ) ;
									set_parent = $( main_form.find( ' fieldset[data-realname=' + set_parent_name + '][data-item=' + set_in + ']' ) ) ;
									set_child = $( set_parent.find( ' > fieldset[data-realname=' + control_parent.data( 'realname' ) + '][data-item=' + ( parent_count - 1 ) + ']' ) ) ;
									
									$( set_child.find( ' > .control-group *[data-realname=' + this_name + ']' ) ).val( this_item ) ;
								}else{
									$( control_parent.find( ' > .control-group *[data-realname=' + this_name + ']' ) ).val( this_item ) ;
								}

							}else{

								control_parent_aux = $( control_parent.find( ' > fieldset[data-realname=' + this_name + '][data-item=' + ( parent_count - 1 ) + ']' ) ) ;

								//fix it (the order)
								if( typeof control_parent.data('realname') != 'undefined' ){ /*fix*/
									control_parent_aux = $( control_parent.find( ' > fieldset[data-realname=' + this_name + '][data-item=' + ( set_in ) + ']' ) ) ;
								}

								set_parent_name = control_parent_aux.parent().data( 'realname' ) ;
								set_parent = $( main_form.find( ' fieldset[data-realname=' + set_parent_name + '][data-item=' + ( parent_count - 1 ) + ']' ) ) ;
								set_child = $( set_parent.find( ' > fieldset[data-realname=' + control_parent_aux.data( 'realname' ) + '][data-item=' + set_in + ']' ) ) ;

								var tmp_min = ( ( typeof set_child.data('min') != 'undefined' ) ? set_child.data('min') : 1 ) ;

								if( Object.keys(item).length > 1 ){
										for( i = tmp_min; i < Object.keys(item).length; i ++ ){
											if( tmp_min ) {
												$( set_child.find( ' > .control-group-form-page .btn-add-group' ) ).trigger( 'click' ) ;
											}else{
												setTimeout( function(){
													$( set_child.find( ' > .control-group-form-page .btn-add-group' ) ).trigger( 'click' ) ;
													that.increase_time+= 5 ;
												}, 5 ) ;
											}
										}
								}else{
									if( Object.keys(item).length == 1 && tmp_min == 0 ){
										/*do not put min in 0*/
										//$( set_child.find( ' > .control-group-form-page .btn-add-group' ) ).trigger( 'click' ) ;
									}
								}

								that.set_concat_data( control_parent_aux, this_item, ( parent_count - 1 ) ) ;
							}
						} ) ;
					} ) ;
				that.increase_time+= 10 ;
				}, 10 ) ;
			},

			set_data_from_content: function( data ){
				var that = this, pages = appolo.configs.pages,
				content_form_page = $( that.content_form_page ),
				main_form = $( content_form_page.find( that.main_form ) ),
				data_form = data ;

				$('.overlay').css( 'height', $( window ).height() ) ;
				$('.overlay').show() ;
				$('.warningmsg-form').show() ;
				$('.warningmsg-form').css( 'top', ( $( window ).height() / 2 ) ) ;
				$('.warningmsg-form').css( 'left', ( ( $( window ).width() / 2 ) - 150 ) ) ;

				$.each( data_form, function( name, item ){
					$control = $( main_form.find( ' > fieldset[data-realname=' + name + ']' ) ) ;
					that.set_concat_data( $control, item, 0 ) ;
					appolo.configs.pages.page.save_item[ name ] = 0 ;
				} ) ;

				/*MAX THRE GROUPS !!!!!*/ //<-------- DONT THINK TOO MUCH [REVIEW REVIEW REVIEW REVIEW AFTER-TCC]

				setTimeout( function(){
					setTimeout( function(){
						$( window ).scrollTop( 0 ) ;
						$('.overlay').remove() ;
						$('.warningmsg-form').remove() ;
					}, that.increase_time ) ;
				}, 2000 ) ;
			},

			get_data_from_form: function( form, type ){
				var that = this, pages = appolo.configs.pages,
				content_form_page = $( that.content_form_page ),
				main_form = $( content_form_page.find( that.main_form ) ),
				page = main_form.serializeField() ;

				//set items form
				appolo.items_form = 0 ;

				//console
				console.log( page ) ;

				//hidden fields
				main_form.append( '<input type="hidden" name="page-document" id="page-document" class="page-document" value="' + appolo.treat.html_quotes( JSON.stringify( page ) ) + '">' ) ;
				main_form.append( '<input type="hidden" name="page-type" id="page-type" class="page-type" value="' + type + '">' ) ;


			},

			render_form: function(){
				var that = this, pages = appolo.configs.pages,
				content_form_page = $( that.content_form_page ),
				this_type = 'form',
				main_form = $( content_form_page.find( that.main_form ) ),
				main_form_form = $( content_form_page.find( that.main_form_form ) ),
				form_code = $( content_form_page.find( that.form_code ) ),
				groups = code = '', breakpoint = false,
				elements = '', i = 0 ;

				if( main_form.length && form_code.length ){

					//hide main form
					main_form.hide() ;

					//get configs

						//group
						groups = $( form_code.find( ' > group' ) ) ;
						code += that.form_mount_group( groups, this_type, main_form, 0 ) ;
						if( that.can == false ){ return false ; }
						
						//write main on main form
						$( main_form.parent() ).addClass( 'ok' ) ; /*set its ok*/

						//form group
						main_form.html( code ) ;
						appolo.configs.set_functions_pos_ajax() ;
						if( appolo.configs.pages.page.only_view ) {
							$( main_form.find( 'input, textarea, select' ) ).each( function(){
								$( this ).attr( 'disabled', 'disabled' ) ;
								$( this ).addClass( 'disabled' ) ;
								$( this ).css( 'color', '#A0A0A0' ) ;
							}) ;

							//msg in use
							appolo.gui.render_warn_message( appolo.gui.render_message( "danger", true, "<b>Atenção:</b> Este formulário está sendo editado por outra pessoa. Volte mais tarde.", "animated fadeInRight" ) ) ;
						}

						//set data to da group
						if( typeof appolo.configs.pages.page.data_form != 'undefined' && appolo.configs.pages.page.data_form != "" ){
							that.set_data_from_content( appolo.configs.pages.page.data_form ) ;
						}

						$( "button[type=submit]", main_form_form ).click(function() {
						    $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
						    $(this).attr("clicked", "true");
						});

						main_form_form.submit( function(){

							//verify later about validate forms
							/*if( main_form_form.find( '.not-null' ).length ){ //not null
								breakpoint = appolo.util.treat_not_null( main_form_form, breakpoint ) ;
							}
							//breakpoint
							if( breakpoint ){
								breakpoint = false ;
								return false ;
							}*/

							that.get_data_from_form( $( this ), $( 'button[type=submit][clicked=true]', this ).val() ) ;

							return true ;
						}) ;

					//FINISH->get configs

					//show main form
					main_form.slideDown( that.default_time_loading ) ;

					//properties
					that.set_form_properties( $( main_form.parent().find( '#form-properties' ) ), $( main_form.find( '.not-null' ) ) ) ;
					//FINISH->properties

					//set button function
					$( that.control_group_form_page ).each( function( i ) {
						appolo.gui.set_control_form( $( this ) ) ;
					}) ;

				}else{
					return appolo.gui.set_error_page( [ 'Erro desconhecido.', 'Contate os administradores.' ], this_type, main_form ) ;

				}
			},

			config_editing_form_or_tmpl: function(){
				var that = this, textarea_coding = $( that.textarea_coding ), editing = $( textarea_coding.find( '#editing' ) ), type = editing.attr( 'type' ), textarea = document.getElementById( 'editing' ) ;

				//focus on editing area (textarea)
				editing.focus() ;

				if( type == 'form' ) {
					var myCodeMirror = CodeMirror.fromTextArea( textarea, {
						lineNumbers: true,
						autofocus: true,
						dragDrop: true,
						mode:  "htmlmixed"
					} ) ;
				}else if( type == 'tmpl' ) {
					CodeMirror.defineMode("mustache", function(config, parserConfig) {
						var mustacheOverlay = {
							token: function(stream, state) {
								var ch;
								if (stream.match("{{")) {
									while ((ch = stream.next()) != null)
										if (ch == "}" && stream.next() == "}") {
											stream.eat("}");
											return "mustache";
										}
									}
									while (stream.next() != null && !stream.match("{{", false)) {}
										return null;
								}
							};
							return CodeMirror.overlayMode(CodeMirror.getMode(config, parserConfig.backdrop || "text/html"), mustacheOverlay);
						});
					var editor = CodeMirror.fromTextArea(document.getElementById("editing"), {mode: "mustache", lineNumbers: true, autofocus: true});
				}
			},

			adjust: function(){
				var that = this, pages = appolo.configs.pages, currently_section_parent = that.currently_section_parent ;

				//breadcrumb

				appolo.util.change_status_nav( 'sections', 0, false ) ;
				pages.temporary_sections = new Array() ;
				appolo.configs.nav.push( { "title": "<img src=\"/images/icon-loading.gif\" alt=\"Carregando...\" class=\"breadcrumb-loading\">", "slug": "loading", "active": false, "link": "" } ) ;
				appolo.configs.pages.get_parent_pages_section_breadcrumb( currently_section_parent ) ;
				appolo.configs.nav.push( pages.temporary_sections ) ;

				//set between quotes "loading"
				setTimeout( function(){
					if( that.editing_something == 'form' || that.editing_something == 'tmpl' ){
						appolo.configs.nav.push( { "title":  ( that.currently_open_page_name + '<span class="inv">(Não visível)</span>' ), "slug": appolo.treat.encode_path( that.currently_open_page_name ), "active": false, "link": ( appolo.configs.pages_page_url + appolo.configs.pages.page.currently_open_page ), "class": "go-back-sections" } ) ;
						appolo.configs.nav.push( { "title":  ( ( ( that.editing_something == 'form' ) ? that.a_icon_page_form : that.a_icon_page_tmpl ) + ( ( that.editing_something == 'form' ) ? 'Formulário ' : 'Template ' ) + '<span class="inv">(Não visível)</span>' ), "slug": appolo.treat.encode_path( that.currently_open_page_name ), "active": true, "link": "" } ) ;
					}else{
						appolo.configs.nav.push( { "title":  ( that.a_icon_page + that.currently_open_page_name + '<span class="inv">(Não visível)</span>' ), "slug": appolo.treat.encode_path( that.currently_open_page_name ), "active": true, "link": "" } ) ;
					}
					
				
					//show loading in breadcrumb
					appolo.gui.mount_breadcrumb() ;
				}, that.default_time_loading ) ;

				//configs # general
				if( ! that.error_config_form ){
					setTimeout( function(){
						if( ! that.editing_something ){
							that.render_form() ;
						}else{
							that.config_editing_form_or_tmpl() ;
							appolo.configs.set_functions_pos_ajax() ;
						}
					}, pages.default_time_loading ) ;
				}
			},

			init: function(){
				var that = this,
				page = appolo.configs.pages.currently_open_page ;

				that.adjust() ;
			}

		}


	},

	//news
	news: {
		
		news_content_sections: null,
		currently_open_section: null,
		currently_open_type_modal: null,
		currently_open_page: null,
		back_section: null,
		form_grid_pages_sections: 'grid_news_sections',
		temporary_sections: new Array(),
		default_time_loading: 500,
		round: 0,
		count_round: 0,

		init: function(){
			var that = this,
			news_content_sections = $( that.news_content_sections ),
			table_sections = news_content_sections.find( '.table-sections' ),
			content_table_sections = table_sections.find( 'tbody.active' ),
			content_table_sections_back_section = table_sections.find( 'tbody.back-section' ),
			data_limit_per_page = table_sections.attr( 'data-limit-per-page' ),
			currently_open_section = that.currently_open_section,
			currently_open_type_modal = that.currently_open_type_modal,
			order = that.order,
			by = that.by,
			first_one = true,
			division_sections_pages = that.division_sections_pages,
			render = { "template": {}, "data": {} }, sn = 0, live_count = section_dataCriacao = section_dataCriacao_min = section_dataCriacao_full = section_datahoraPublicacao = section_datahoraPublicacao_min = section_datahoraPublicacao_full = section_pages_parent = section_pages = '', content_table_sections_per_page = new Array() ;

			//fix ROW AREA WARN
			/*if( $( $( '.row.area-warn' ).find( '> .alert' ) ).length > 0 ){
				$( '.content-sections' ).css( 'margin', '15px' ) ;
			}*/

			//render loading
			content_table_sections.html( appolo.util.mustache_render_template( render_sections_pages_loading ) ) ;

			//activing menu li from model
			$( '.navbar-nav li' ).removeClass( 'active' ) ;
			$( '.navbar-nav .paginas' ).addClass( 'active' ) ;

			console.log( appolo.configs.select_news_sections + ( ( currently_open_section != null ) ? ( currently_open_section ) : "0" ) + ( '?order=' + order + '&by=' + by ) ) ;

			$.ajax({
				dataType: 'json',
				url: appolo.configs.select_news_sections + ( ( currently_open_section != null ) ? ( currently_open_section ) : "0" ) + ( '?order=' + order + '&by=' + by )
				}).done(function( sections ){

				//Array
				if ( Array.isArray( appolo.configs.nav[ appolo.configs.nav.length - 1 ] ) ) { appolo.configs.nav.pop() ; }

				//if there is a opened section
				if ( currently_open_section ){
					appolo.util.change_status_nav( 'sections', 0, false ) ;
					appolo.configs.pages.temporary_sections = new Array() ;
					//appolo.configs.nav.push( { "title": "<img src=\"/images/icon-loading.gif\" alt=\"Carregando...\" class=\"breadcrumb-loading\">", "slug": "loading", "active": false, "link": "" } ) ;
					appolo.configs.pages.get_parent_pages_section_breadcrumb( currently_open_section, 'news' ) ;
					appolo.configs.nav.push( appolo.configs.pages.temporary_sections ) ;
					appolo.configs.pages.get_parent_pages_section_back( 'news', content_table_sections_back_section ) ; //back section
				}

				//show loading in breadcrumb
				appolo.gui.mount_breadcrumb() ;

				//declare variable
				section_pages = { "sections": [] } ;

				$.each( sections, function( i, section ) {
					if( ! section.idPublicacao ){ //it its NOT a true page

						section_datahoraCriacao = new Date ( section.dataCriacao ) ;
						section_datahoraCriacao_min = appolo.util.mount_date_min ( section_datahoraCriacao ) ;
						section_datahoraCriacao_full = appolo.util.mount_date_full_w_feira( section_datahoraCriacao ) ;
						if( section_datahoraCriacao_min != null && section_datahoraCriacao_min != '' ){
							section_datahoraCriacao_modified = new Date( section_datahoraCriacao ) ;
							section_datahoraCriacao_full = section_datahoraCriacao_full + ' ás ' + ( section_datahoraCriacao_modified.getHours() ) + ':' + section_datahoraCriacao_modified.getMinutes() ;
						}

						section_pages.sections.push( {
							"id_item": section.idSecao,
							"icon_item": "folder-close",
							"type": "sections",
							"url_prefix": appolo.configs.news_new_url,
							"name_item": section.nomeSecao,
							"desc_item": section.descricaoSecao,
							"created": ( ( section.idSecao == appolo.configs.section_created ) ? "yes" : "" ),
							"updated": ( ( section.idSecao == appolo.configs.section_updated ) ? "yes" : "" ),
							"section_dataCriacao_min": section_datahoraCriacao_min,
							"section_dataCriacao_full": section_datahoraCriacao_full,
							"addclass": [
								{ "class": ( ( section.secaoHidden == 1 ) ? 'non-visible' : '' ) },
								{ "class": ( ( section.descricaoSecao != '' ) ? 'plusinfo' : '' ) }
							]
						 } ) ;
					}else if( section.idPublicacao ){ //it its a true page

						section_datahoraCriacao = new Date ( section.dtHoraCriacao ) ;
						section_datahoraCriacao_min = appolo.util.mount_date_min ( section_datahoraCriacao ) ;
						section_datahoraCriacao_full = appolo.util.mount_date_full_w_feira( section_datahoraCriacao ) ;
						if( section_datahoraCriacao_min != null && section_datahoraCriacao_min != '' ){
							section_datahoraCriacao_modified = new Date( section_datahoraCriacao ) ;
							section_datahoraCriacao_full = section_datahoraCriacao_full + ' ás ' + ( section_datahoraCriacao_modified.getHours() ) + ':' + section_datahoraCriacao_modified.getMinutes() ;
						}

						section_datahoraAlteracao = new Date ( section.datahoraAlteracao ) ;
						section_datahoraAlteracao_min = ( section.datahoraAlteracao ) ? appolo.util.mount_date_min ( section_datahoraAlteracao ) : "" ;
						section_datahoraAlteracao_full = ( section.datahoraAlteracao ) ? appolo.util.mount_date_full_w_feira( section_datahoraAlteracao ) : "" ;
						if( section_datahoraAlteracao_min != null && section_datahoraAlteracao_min != '' ){
							section_datahoraAlteracao_modified = new Date( section_datahoraAlteracao ) ;
							section_datahoraAlteracao_full = section_datahoraAlteracao_full + ' ás ' + ( section_datahoraAlteracao_modified.getHours() ) + ':' + section_datahoraAlteracao_modified.getMinutes() ;
						}

						type_label = 'default' ;
						status_text = 'Aguardando' ;
						if( section.status_text == 'INS' ){
							type_label = 'default' ;
							status_text = 'Nova' ;
						}else if( section.status_text == 'ALT' ){
							type_label = 'default' ;
							status_text = 'Aguardando' ;
						}else if( section.status_text == 'APR' ){
							type_label = 'info' ;
							status_text = 'Aprovado' ;
						}else if( section.status_text == 'PEN' ){
							type_label = 'warning' ;
							status_text = 'Pendente' ;
						}else if( section.status_text == 'PUB' ){
							type_label = 'success' ;
							status_text = 'Publicado' ;
						}else if( section.status_text == 'REP' ){
							type_label = 'danger' ;
							status_text = 'Reprovado' ;
						}

						section_pages.sections.push( {
							"id_item": section.idPublicacao,
							"icon_item": "align-left",
							"type": "news",
							"news": "news",
							"status_text": status_text,
							"type_label": type_label,
							"url_prefix": appolo.configs.news_new_url + currently_open_section + '/set/',
							"name_item": section.tituloPublicacao,
							"desc_item": section.textoPublicacao,
							"created": ( ( section.idPublicacao == appolo.configs.news_created ) ? "yes" : "" ),
							"updated": ( ( section.idPublicacao == appolo.configs.news_updated ) ? "yes" : "" ),
							"canceled": ( ( section.idPublicacao == appolo.configs.news_canceled ) ? "yes" : "" ),
							"error": ( ( section.idPublicacao == appolo.configs.news_error ) ? "yes" : "" ),
							"section_dataCriacao_min": section_datahoraCriacao_min,
							"section_dataCriacao_full": section_datahoraCriacao_full,
							"section_dataPublicacao_min": section_datahoraAlteracao_min,
							"section_dataPublicacao_full": section_datahoraAlteracao_full,
							"creator": section.nicename,
							"addclass": [
								{ "class": ( ( section.secaoHidden == 1 ) ? 'non-visible' : '' ) },
								{ "class": ( ( section.descricaoSecao != '' ) ? 'plusinfo' : '' ) }
							]
						 } ) ;
					}

				}) ;


				appolo.gui.pagination.limit = data_limit_per_page ;
				appolo.gui.pagination.pages = Math.ceil( section_pages.sections.length / data_limit_per_page ) ;
				appolo.gui.pagination.grid = table_sections ;

				appolo.configs.pages.set_parent_pages_section( currently_open_section, appolo.gui.pagination.pages ) ;

				render['template'] = render_sections_pages ;
				render['data'] = section_pages ;

				if( sections.length == 0 ){ //if theres is no result, render a page with "none"
					render['template'] = ( ( currently_open_section != null ) ? render_sections_pages_none : render_sections_pages_none_no_page_selected ) ;
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
					appolo.configs.section_updated = '' ;
					appolo.configs.page_updated = '' ;
					appolo.configs.page_canceled = '' ;
					appolo.configs.page_error = '' ;

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

					appolo.gui.form_set_checks_grid( that.form_grid_pages_sections, appolo.configs.delete_pages_sections, '.check', 'Tem certeza que deseja deletar ?', '.del-checks', '.view-checks' ) ;

					appolo.configs.set_functions_pos_ajax() ;

				}, that.default_time_loading ) ;

			}).error( function(){
				appolo.gui.render_warn_message( appolo.gui.render_message( "danger", true, appolo.gui.message_error_loading_sections, "animated fadeInRight" ) ) ;
			} ) ;

		},

		set: {

			editable: 0,

			init: function(){
				var that = this,
				currently_open_section = that.currently_open_section, html_text = $( '#body_text' ), see_html = $( '.see_html' ) ;

				appolo.util.change_status_nav( 'sections', 0, false ) ;
				appolo.configs.pages.temporary_sections = new Array() ;
				appolo.configs.nav.push( { "title": that.currently_section_parent_name, "slug": "loading", "active": false, "link": appolo.configs.news_new_url + currently_open_section } ) ;
				if( ! $( 'body' ).hasClass( 'tmpl' ) ){
					appolo.configs.nav.push( { "title": ( ( ! $( 'body' ).hasClass('tmpl') ) ? '<span class="glyphicon glyphicon-align-left a-icon"></span>' : '' ) + that.currently_open_page_name, "slug": "loading", "active": ( ( ! $( 'body' ).hasClass('tmpl') ) ? true : false ), "link": appolo.configs.news_new_url + currently_open_section + '/set/' + that.currently_open_new } ) ;
				}
				if( $( 'body' ).hasClass( 'tmpl' ) ){
					appolo.configs.nav.push( { "title": '<span class="glyphicon glyphicon-indent-right a-icon"></span>' + 'Template', "slug": "loading", "active": true, "link": ( appolo.configs.news_new_url ) } ) ;
					appolo.configs.pages.page.config_editing_form_or_tmpl() ;
				}
				//appolo.configs.pages.get_parent_pages_section_breadcrumb( currently_open_section, 'news' ) ;
				appolo.configs.nav.push( appolo.configs.pages.temporary_sections ) ;

				//html text
				if((html_text.length>0) && (html_text.length<2)){

					html_text.focus(function(){
						$( '.box_view' ).removeClass( 'hidden' ) ;
						//$( '.box_view' ).fadeIn() ;
						if(that.editable==0){
							corpo = new nicEditor({fullPanel : true}).panelInstance('body_text',{hasPanel : true});


							if ($('.nicEdit-main').length>0){
								$('.nicEdit-main').focus() ;
							}
						}
					}) ;

					$('.nicEdit-main').blur( function(){
						$( '#body_text' ).html( $( this ).html() ) ;
					}) ;


					if(see_html.length>0){
						see_html.each(function(value) {
							$(this).click(function(){
								if(that.editable==0){
									if (html_text.length>0){
										if( typeof corpo != 'undefined' ){
											corpo.removeInstance('body_text') ;
										}

										that.editable = 1 ;
										html_text.focus() ;
									}
								}else if(that.editable==1){
									that.editable = 0 ;
								}
							});
						});
					}

				}


				//buttons [[SET]]
				$( '.btn-save-news' ).click( function(){
					$('.box_view button').click() ;
					$( 'form[name=main-new]' ).attr( 'action', '/crud/new_save/' + currently_open_section + '?action=save' ) ;
					$( 'form[name=main-new]' ).submit() ;

					return false ;
				}) ;

				$( '.btn-view-news' ).click( function(){
					$('.box_view button').click() ;
					$( 'form[name=main-new]' ).attr( 'action', '/crud/new_save/' + currently_open_section + '?action=view' ) ;
					$( 'form[name=main-new]' ).submit() ;

					return false ;
				}) ;

				$( '.btn-publish-news' ).click( function(){
					$('.box_view button').click() ;
					$( 'form[name=main-new]' ).attr( 'action', '/crud/new_save/' + currently_open_section + '?action=publish' ) ;
					$( 'form[name=main-new]' ).submit() ;

					return false ;
				}) ;

				//input focus
				$( '#titulo-item-0' ).focus() ;

			}

		}

	},

	//show modal passing an id
	show_modal: function ( modal ){
		var that = this,
		controls = '.controls', control_group = fields = json_configs = patt_example = occurred_error = "", aux_verify_modals = true, breakpoint = false, lock = 0 ;

		if( $( '#' + modal ).length > 0 ){

			$( '.modal' ).each( function(){

				if ( ( ! ( $( this ).css( 'display' ) == 'none' ) && ( ! ( $( this ).hasClass( modal ) ) ) ) ) {
					aux_verify_modals = false ;
				}
			} ) ;

			if ( aux_verify_modals ) {

				//this modal (if exists)
				this_modal = $( '#' + modal ) ;

				//modal new section - pages
				if ( modal == 'section' ){
					$( '#section' ).on( 'show.bs.modal' , function () { //on show

						//reset form
						appolo.gui.reset_form_on_container( this_modal ) ;

						//set modal title
						appolo.gui.set_modal_title_type( this_modal, appolo.configs.currently_open_type_modal, "f", "seção" ) ;

						//configs: pages, news & images
						appolo.gui.section_pages_news_images( this_modal ) ;

						//keyup register val(name)
						patt_example = new RegExp( ( appolo.configs.pages.default_filename ), 'g' ) ;
						appolo.gui.set_modal_key_up_files( this_modal, '#section_name', '.file-ext', patt_example ) ;

						//news config
						$( '.set-areas .set-news input[type=checkbox]' ).unbind() ;
						$( '.set-areas .set-news input[type=checkbox]' ).change( function(){
							if( $( '.set-areas .set-news input[type=checkbox]' ).prop( 'checked' ) ){
								if( ! $( '.area-set-news' ).is(':animated') ){
									$( '.area-set-news' ).slideDown( 200 ) ;
								}
							}else{
								if( ! $( '.area-set-news' ).is(':animated') ){
									$( '.area-set-news' ).slideUp( 200 ) ;
								}
							}
						} );

						//case edit (before send):
						if( appolo.configs.currently_open_type_modal == 'edit' ){

							//if there isnt any content
							if( typeof appolo.configs.currently_selected_item_grid == 'undefined' || appolo.configs.currently_selected_item_grid == 0 ){
								appolo.gui.close_modal( this_modal ) ;
								return false ;
							}

							//remove class hidden for deleting button
							$( $( this_modal ).find( '.btn-del-file' ) ).removeClass( 'hidden' ) ;

							//set a "loading" on the modal
							appolo.gui.set_modal_loading( this_modal, true ) ;

							//load dbs data and config json
							fields = appolo.util.set_fields_via_db( this_modal, appolo.configs.currently_selected_item_grid, appolo.configs.select_section_url, 3 ) ;
							json_configs = appolo.configs.load_json_config( this_modal, appolo.configs.currently_selected_item_grid, modal, 3 ) ;

							//set fields on the inputs [ TRIGGER! ]
							this_modal.on( 'data-received', function( event, fields ){
								//active all
								$( this_modal.find( 'input, textarea' ) ).removeProp( 'disabled' ) ; //<<--

								//se não houver resultado
								if( ! fields.length ){
									appolo.gui.close_modal( this_modal ) ;
								}else{

									//for each item ( section [ ONLY ONE IS SELECTED ] )
									$.each( fields, function( i, section ) {

										//hidden
										$( $( this_modal ).find( 'input[data-receive=idSecao]' ) ).val( appolo.treat.html_entity_decode( section.idSecao ) ) ;

										//inputs
										$( $( this_modal ).find( 'input[data-receive=nomeSecao]' ) ).val( appolo.treat.html_entity_decode( section.nomeSecao ) ) ;
										$( $( this_modal ).find( 'textarea[data-receive=descricaoSecao]' ) ).val( appolo.treat.html_entity_decode( section.descricaoSecao ) ) ;
										if( section.caminhoFisico != null ){
											$( $( this_modal ).find( 'input[data-receive=caminhoFisico]' ) ).val( appolo.treat.html_entity_decode( section.caminhoFisico ) ) ;
										}

										//nv
										if( section.secaoHidden == 1 ){
											$( $( this_modal ).find( '.nv input[type=checkbox]' ) ).prop( 'checked', true ) ;
										}

										//to begin checking
										$( $( this_modal ).find( '.set-areas input[type=checkbox]' ) ).prop( 'checked', false ) ;
										switch( section.tpSecao ){
											case '1':
												$( $( this_modal ).find( '.set-pages input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
											case '2':
												$( $( this_modal ).find( '.set-news input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
											case '3':
												$( $( this_modal ).find( '.set-imgs input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
											case '4':
												$( $( this_modal ).find( '.set-pages input[type=checkbox]' ) ).prop( 'checked', true ) ;
												$( $( this_modal ).find( '.set-news input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
											case '5':
												$( $( this_modal ).find( '.set-pages input[type=checkbox]' ) ).prop( 'checked', true ) ;
												$( $( this_modal ).find( '.set-imgs input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
											case '6':
												$( $( this_modal ).find( '.set-news input[type=checkbox]' ) ).prop( 'checked', true ) ;
												$( $( this_modal ).find( '.set-imgs input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
											case '7':
												$( $( this_modal ).find( '.set-pages input[type=checkbox]' ) ).prop( 'checked', true ) ;
												$( $( this_modal ).find( '.set-news input[type=checkbox]' ) ).prop( 'checked', true ) ;
												$( $( this_modal ).find( '.set-imgs input[type=checkbox]' ) ).prop( 'checked', true ) ;
											break;
										}
									} ) ;
	

									//check set-news if its ok
									if( $( '.set-areas .set-news input[type=checkbox]' ).prop( 'checked' ) ){
										$( '.area-set-news' ).slideDown( 200 ) ;
									}

									//force keyup at the file ext
									$( this_modal.find( '.controls #section_name' ) ).trigger( 'keyup' ) ;

								}

							} );

							this_modal.on( 'configs-received', function( event, configs ){
								if( typeof configs.error != 'undefined' ){
									occurred_error = configs.error ;
									return false ;
								}

								if( typeof configs.tmpls.file.length != 'undefined' ){
									$( $( this_modal ).find( 'input[data-receive=tmpl]' ) ).val( appolo.treat.html_entity_decode( configs.tmpls.file ) ) ;
								}
							} ) ;
						}

						//force trigger
						$( this_modal.find( '.controls #section_name' ) ).trigger( 'keyup' ) ;

						//->submit form
						$( this_modal.find( 'form' ) ).submit(function(){ //on submit
							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes

								//not null
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null( this_modal, breakpoint ) ;
								}

								//set areas
								if( ! ( ( $( $( '.set-areas' ).find( 'input[type=checkbox]' )[0] ).prop('checked') ) || ( $( $( '.set-areas' ).find( 'input[type=checkbox]' )[1] ).prop('checked') ) || ( $( $( '.set-areas' ).find( 'input[type=checkbox]' )[2] ).prop('checked') ) ) ){
									alert( 'Selecione ao menos uma área para a seção!' ) ;
									breakpoint = true ;
								}

								//check extensions
								if( ! breakpoint ){
									breakpoint = appolo.util.check_ext_file( [
										[ $( this_modal.find( 'input[name=configfile]' ) ), appolo.gui.default_ext_config ],
										[ $( this_modal.find( 'input[name=tmplfile]' ) ), appolo.gui.default_ext_tmpl ]
									] ) ;	
								}

								//active/desactive button
								if( breakpoint || lock != 0 ){ /*if there's an error*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}

							//->/validacoes

							//form's data
							data = $( this ).serialize() ;

							//->new
							if ( appolo.configs.currently_open_type_modal == 'new' ){
								$.ajax({
									type: "POST", /*update insert_section*/
									url: appolo.configs.insert_section + ( ( appolo.configs.pages.currently_open_section ) ? appolo.configs.pages.currently_open_section : "0" ),
									data: data
								}).done(function( id ){
									if( $( 'body' ).hasClass( 'pages' ) ){
										appolo.configs.pages.init() ;
									}else if( $( 'body' ).hasClass( 'news' ) ){
										appolo.configs.news.init() ;
									}
									this_modal.modal( 'hide' ) ;
									appolo.configs.section_created = id ;
									appolo.gui.render_warn_message( appolo.gui.render_message( "success", true, "Seção criada com sucesso !", "animated fadeInRight" ) ) ;
								}) ;
							}
							//->/new

							//->edit
							if ( appolo.configs.currently_open_type_modal == 'edit' ){
								$.ajax({
									type: "POST", /*update section_properties*/
									url: appolo.configs.section_properties + ( ( appolo.configs.currently_selected_item_grid ) ? appolo.configs.currently_selected_item_grid : "0" ),
									data: data
								}).done(function( id ){
									if( $( 'body' ).hasClass( 'pages' ) ){
										appolo.configs.pages.init() ;
									}else if( $( 'body' ).hasClass( 'news' ) ){
										appolo.configs.news.init() ;
									}
									this_modal.modal( 'hide' ) ;
									appolo.configs.section_updated = id ;
									appolo.gui.render_warn_message( appolo.gui.render_message( "info", true, "Seção editada com sucesso !", "animated fadeInRight" ) ) ;
								}) ;
							}
							//->/edit

							return false ;
						}) ;
						//->/submit form

					}).on( 'shown.bs.modal' , function () { //on shown

						//case edit (before send):
						if( appolo.configs.currently_open_type_modal == 'edit' ){
							//set a "loading" on the modal
							appolo.gui.set_modal_loading( this_modal, false ) ;

							//if an error occurred
							if( occurred_error != '' ){
								if( occurred_error == "404" ){
									$( $( $( this_modal ).find( 'input[data-receive=caminhoFisico]' ) ).parent().parent() ).addClass( 'has-error' ) ;
									$( '.icon-xml-error, .xml-error' ).show() ;
								}
							}
						}

						//set focus first field
						appolo.gui.set_focus_first_field( '#section_name' ) ;

					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;

						history.pushState( '', document.title, window.location.pathname ) ;

						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
						breakpoint = false ;
						$( '#section' ).unbind() ;
					}) ;
				}





				//----------------------------------------------------------------\\





				//modal page - pages
				if ( modal == 'page' ){
					$('#page').on('show.bs.modal', function () { //on show


						//reset form
						appolo.gui.reset_form_on_container( this_modal ) ;

						//set modal title
						appolo.gui.set_modal_title_type( this_modal, appolo.configs.currently_open_type_modal, "f", "página" ) ;
						
						//keyup register val(name)
						patt_example = new RegExp( ( appolo.configs.pages.default_filename ), 'g' ) ;
						appolo.gui.set_modal_key_up_files( this_modal, '#page_name', '.file-ext', patt_example ) ;

						//case edit (before send):
						if( appolo.configs.currently_open_type_modal == 'edit' ){

							//if there isnt any content
							if( typeof appolo.configs.currently_selected_item_grid == 'undefined' || appolo.configs.currently_selected_item_grid == 0 ){
								appolo.gui.close_modal( this_modal ) ;
								return false ;
							}

							//remove class hidden for deleting button
							$( $( this_modal ).find( '.btn-del-file' ) ).removeClass( 'hidden' ) ;

							//remove class hidden for editing button
							$( $( this_modal ).find( '.btn-edit-file' ) ).removeClass( 'hidden' ) ;

							$( $( $( this_modal ).find( '.btn-edit-file' ) ).find( 'a' ) ).each( function(){
								$( this ).unbind() ;
								$( this ).attr( 'data-item', appolo.configs.currently_selected_item_grid ) ;
								$( this ).click( function(){
									if( $( this ).data( 'type' ) == 'form' ){
										location.href = ( appolo.configs.page_create_form ).replace( /-id-/g, appolo.configs.currently_selected_item_grid ) ;
									}else if( $( this ).data( 'type' ) == 'tmpl' ){
										location.href = ( appolo.configs.page_create_tmpl ).replace( /-id-/g, appolo.configs.currently_selected_item_grid ) ;
									}
									return false ;
								}) ;
							}) ;

							//load dbs data and config json
							fields = appolo.util.set_fields_via_db( this_modal, appolo.configs.currently_selected_item_grid, appolo.configs.select_page_url, 3 ) ;
							json_configs = appolo.configs.load_json_config( this_modal, appolo.configs.currently_selected_item_grid, modal, 3 ) ;

							//set fields on the inputs [ TRIGGER! ]
							this_modal.on( 'data-received', function( event, fields ){
								//se não houver resultado
								if( ! fields.length ){
									appolo.gui.close_modal( this_modal ) ;
								}else{

									//for each item ( page [ ONLY ONE IS SELECTED ] )
									$.each( fields, function( i, page ) {


										//hidden
										$( $( this_modal ).find( 'input[data-receive=idPagina]' ) ).val( appolo.treat.html_entity_decode( page.idPagina ) ) ;

										//inputs
										$( $( this_modal ).find( 'input[data-receive=nomePagina]' ) ).val( appolo.treat.html_entity_decode( page.nomePagina ) ) ;
										$( $( this_modal ).find( 'textarea[data-receive=descricaoPagina]' ) ).val( appolo.treat.html_entity_decode( page.descricaoPagina ) ) ;
										$( $( this_modal ).find( 'input[data-receive=caminhoXmlPagina]' ) ).val( appolo.treat.html_entity_decode( page.caminhoXmlPagina ) ) ;

										//nv
										if( page.paginaHidden == 1 ){
											$( $( this_modal ).find( '.nv input[type=checkbox]' ) ).prop( 'checked', true ) ;
										}

									} );

									//force keyup at the file ext
									$( this_modal.find( '.controls #page_name' ) ).trigger( 'keyup' ) ;
								}

							} ) ;

							this_modal.on( 'configs-received', function( event, configs ){
								if( typeof configs.error != 'undefined' ){
									occurred_error = configs.error ;
									return false ;
								}

								if( typeof configs.data.length != 'undefined' ){
									$( $( this_modal ).find( 'input[data-receive=data]' ) ).val( appolo.treat.html_entity_decode( configs.data ) ) ;
								}
								if( typeof configs.form.length != 'undefined' ){
									$( $( this_modal ).find( 'input[data-receive=form]' ) ).val( appolo.treat.html_entity_decode( configs.form ) ) ;
								}
								if( typeof configs.tmpls.file.length != 'undefined' ){
									$( $( this_modal ).find( 'input[data-receive=tmpl]' ) ).val( appolo.treat.html_entity_decode( configs.tmpls.file ) ) ;
								}

								//preview - length
								if( typeof configs.preview.length != 'undefined' ){
									$( $( this_modal ).find( 'input[data-receive=preview]' ) ).val( appolo.treat.html_entity_decode( configs.preview ) ) ;
								}

								$.each( configs.tmpls.tmpl.outs, function( i, out ) {

									//staging - length
									if( typeof out.staging.length != 'undefined' ){
										$( $( this_modal ).find( 'input[data-receive=staging]' ) ).val( appolo.treat.html_entity_decode( out.staging ) ) ;
									}

									//live - length
									if( typeof out.live.length != 'undefined' ){
										$( $( this_modal ).find( 'input[data-receive=live]' ) ).val( appolo.treat.html_entity_decode( out.live ) ) ;
									}
								} ) ;

							} ) ;

						}

						//force trigger
						$( this_modal.find( '.controls #page_name' ) ).trigger( 'keyup' ) ;

						//->submit form
						$( this_modal.find( 'form' ) ).submit(function(){ //on submit
							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes

								//not null
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null( this_modal, breakpoint ) ;
								}

								//check extensions
								breakpoint = appolo.util.check_ext_file( [
									[ $( this_modal.find( 'input[name=configfile]' ) ), appolo.gui.default_ext_config ],
									[ $( this_modal.find( 'input[name=datafile]' ) ), appolo.gui.default_ext_data ],
									[ $( this_modal.find( 'input[name=formfile]' ) ), appolo.gui.default_ext_form ],
									[ $( this_modal.find( 'input[name=tmplfile]' ) ), appolo.gui.default_ext_tmpl ]
								] ) ;

								//active/desactive button
								if( breakpoint || lock != 0 ){ /*if there's an error*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}

							//->/validacoes

							//form's data
							data = $( this ).serialize() ;

							//->new
							if ( appolo.configs.currently_open_type_modal == 'new' ){
								$.ajax({
									type: "POST", /*update insert_page*/
									url: appolo.configs.insert_page + appolo.configs.pages.currently_open_section,
									data: data
								}).done(function( id ){
									appolo.configs.pages.init() ;
									this_modal.modal( 'hide' ) ;
									appolo.configs.page_created = id ;
									appolo.gui.render_warn_message( appolo.gui.render_message( "success", true, "Página criada com sucesso !", "animated fadeInRight" ) ) ;
								}) ;
							}
							//->/new

							//->edit
							if ( appolo.configs.currently_open_type_modal == 'edit' ){
								$.ajax({
									type: "POST", /*update page_properties*/
									url: appolo.configs.page_properties + ( ( appolo.configs.currently_selected_item_grid ) ? appolo.configs.currently_selected_item_grid : "0" ),
									data: data
								}).done(function( id ){
									appolo.configs.pages.init() ;
									this_modal.modal( 'hide' ) ;
									appolo.configs.page_updated = id ;
									appolo.gui.render_warn_message( appolo.gui.render_message( "info", true, "Página editada com sucesso !", "animated fadeInRight" ) ) ;
								}) ;
							}
							//->/edit

							return false ;
						}) ;
						//->/submit form

					}).on( 'shown.bs.modal' , function () { //on shown

						//case edit (before send):
						if( appolo.configs.currently_open_type_modal == 'edit' ){
							//set a "loading" on the modal
							appolo.gui.set_modal_loading( this_modal, false ) ;

							//if an error occurred
							if( occurred_error != '' ){
								if( occurred_error == "404" ){
									$( $( $( this_modal ).find( 'input[data-receive=caminhoXmlPagina]' ) ).parent().parent() ).addClass( 'has-error' ) ;
									$( '.icon-xml-error, .xml-error' ).show() ;
								}
							}
						}

						//set focus first field
						appolo.gui.set_focus_first_field( '#page_name' ) ;

					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;

						history.pushState( '', document.title, window.location.pathname ) ;

						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

						$( '#page' ).unbind() ;
					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
						breakpoint = false ;
					}) ;
				}



				//----------------------------------------------------------------\\



				//modal area - area
				if ( modal == 'area' ){
					$( '#area' ).on( 'show.bs.modal' , function () { //on show
						//reset form
						appolo.gui.reset_form_on_container( this_modal ) ;

						//set modal title
						appolo.gui.set_modal_title_type( this_modal, appolo.configs.currently_open_type_modal, "m", "Cargo" ) ;

						$( this_modal.find( 'form' ) ).submit(function(){ //on submit
							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null_unique( this_modal, breakpoint ) ;
								}
								if( this_modal.find( '.minlength' ).length ){ //not null
									breakpoint = appolo.util.treat_min_length( this_modal, breakpoint ) ;
								}
								//active/desactive button
								if( breakpoint || lock != 0 ){ /*if there's an error*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}
							//->/validacoes
							//form's data
							data = $( this ).serialize() ;
							//->new
							if ( appolo.configs.currently_open_type_modal == 'new' ){
								$.ajax({
									type: "POST", /*update insert_area*/
									url: appolo.configs.new_admin_area,
									data: data
								}).done(function( id ){
									appolo.configs.area.init() ;
									appolo.configs.id_created = id ;
									this_modal.modal( 'hide' ) ;
									appolo.gui.render_warn_message( appolo.gui.render_message( "success", true, "Cargo cadastrado com sucesso ! Por favor edite as permissões do cargo cadastrado", "animated fadeInRight" ) ) ;
								}) ;
							}
							//->/new
							return false ;
						}) ;


					}).on( 'shown.bs.modal' , function () { //on shown

						//case edit (before send):
						if( appolo.configs.currently_open_type_modal == 'edit' ){
							//set a "loading" on the modal
							appolo.gui.set_modal_loading( this_modal, false ) ;
						}

						//set focus first field
						appolo.gui.set_focus_first_field( '#area_description' ) ;

					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;
						this_modal.find('.has-error').removeClass( 'has-error' ) ;
						this_modal.find('.error_input').text( "" ) ;
						history.pushState( '', document.title, window.location.pathname ) ;

						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

					$( '#area' ).unbind() ;
					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
						breakpoint = false ;
					}) ;

						
				}

				if ( modal == 'user' ){
					$( '#user' ).on( 'show.bs.modal' , function () { //on show
						//reset form
						appolo.gui.reset_form_on_container( this_modal ) ;

						//set modal title
						appolo.gui.set_modal_title_type( this_modal, appolo.configs.currently_open_type_modal, "m", "Usuário" ) ;

						modal = $( '#user' ),
						modal_new_User = modal.find( '.select_new_User' ),
						render = { "template": {}, "data": {} };
						this_modal.find("button").attr("disabled", "disabled")
						funcionarios_items = '' ;
						$.ajax({
							type: "POST", 
							url: appolo.configs.select_admin_funcionarios_NoUser,
							dataType: 'json'
						}).done(function( funcionariosNoUser ){				
							funcionarios_items = { "items": [] } ;	
							$.each( funcionariosNoUser, function( i, funcionariosNoUser ){

								 funcionarios_items.items.push({
									"nomePessoa": funcionariosNoUser.nomePessoa,
									"cpfPessoa": funcionariosNoUser.cpfPessoa,
								}); 
								

							});
						this_modal.find( 'button' ).removeAttr( 'disabled' ) ;
						render['template'] = render_funcionarios_search_area ;
						render['data'] = funcionarios_items ;
						modal_new_User.html(appolo.util.mustache_render_template( render['template'], render['data'] ));
						modal_new_User.show();
						});
						$( this_modal.find( 'form' ) ).submit(function(){ //on submit
							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null_unique( this_modal, breakpoint ) ;
								}
								if(!breakpoint && this_modal.find( '.minlength' ).length){// min length
								 	breakpoint = appolo.util.treat_min_length( this_modal, breakpoint ) ;
								}
								if(!breakpoint ){// senha
									status_senha = this_modal.find('.output').text();
									if(status_senha=="Fraca" || status_senha=="Média" || status_senha=="..."){
										input_senha = this_modal.find('.password');
										message =this_modal.find( '.senha_error' );
										message.text("");
										message.append("Senha muito fraca");
										input_senha.parent().addClass( 'has-error' ) ;
										input_senha.focus()
										input_senha.change(function(){
											input_senha.parent().removeClass( 'has-error' ) ;
											message.text("");
										});
										breakpoint = true;
									}
								}	
								//active/desactive button
								if( breakpoint || lock != 0 ){ /*if there's an error*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}
							//->/validacoes
							//form's data
							data = $( this ).serialize() ;

							//->new
							if ( appolo.configs.currently_open_type_modal == 'new' ){

								$.ajax({
									type: "POST",
									url: appolo.configs.new_admin_user,
									data: data
								}).done(function( id ){									
									if(id!="error"){
										appolo.configs.usuarios.init() ;
										appolo.configs.id_created = id ;
										this_modal.modal( 'hide' ) ;
										appolo.gui.render_warn_message( appolo.gui.render_message( "success", true, "Usuário Cadastrado com sucesso, para personalizar seu acesso ou alterar sua senha por favor clique em alterar", "animated fadeInRight" ) ) ;
									}
									else{
										this_modal.modal( 'hide' ) ;
										location.reload();
									}
									
								}) ;
							}
							//->/new
							return false ;
						}) ;


					}).on('shown.bs.modal', function () { //on shown

						//first input focus
						appolo.gui.set_focus_first_field( '#user_description' ) ;

					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;
						this_modal.find('.has-error').removeClass( 'has-error' ) ;
						this_modal.find('.error_input').text( "" ) ;
						history.pushState( '', document.title, window.location.pathname ) ;

						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

					$( '#user' ).unbind() ;
					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
						breakpoint = false ;
					}) ;

						
				}
				//modal image - image
				if ( modal == 'image_new' ){
					
					$( '#image_new' ).on( 'show.bs.modal' , function () { //on show

						//reset form
						appolo.gui.reset_form_on_container( this_modal ) ;
						//set modal title
						appolo.gui.set_modal_title_type( this_modal, appolo.configs.currently_open_type_modal, "f", "Nova Imagem" ) ;
						this_modal.find( '.send-form' ).html( "Confirmar" ) ;
						var find = ' ', re = new RegExp(find, 'g');
						aux = path+idSite+"_"+nomeSite+"/"+section+"/";
						aux2 = path+idSite+"_"+nomeSite+"/"+section;
						aux3 = /images.appolo/+idSite+"_"+nomeSite+"/"+section+"/";
						this_modal.find( '#images_path' ).val(aux.replace(re, '_'));
						this_modal.find( '#path' ).val(aux3.replace(re, '_'));
						this_modal.find( '#folder' ).val(aux2.replace(re, '_'));
						$("#input-id").fileinput({'showRemove':false, 'showCaption':true, 'showUpload':false, 'previewFileType':'image', 'initialPreviewCount':0, 'allowedFileExtensions':['jpg', 'gif', 'png', 'jpeg']});

						$('#input-id').on('fileloaded', function(event, file, previewId, index) {
							control_group = this_modal.find(".kv-fileinput-caption").parent();
							control_group.removeClass( 'has-error' ) ;
							aux = control_group.parent().parent().find('.error_input');
							aux.text("");
						});
						$( this_modal.find( 'form' ) ).submit(function(){ //on submit

							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null_unique( this_modal, breakpoint ) ;
								}
								if( this_modal.find( '.minlength' ).length ){ //not null
									breakpoint = appolo.util.treat_min_length( this_modal, breakpoint ) ;
								}
								if( !breakpoint ){
									if($("#input-id").val()==""){
										control_group = $(".kv-fileinput-caption").parent();
										control_group.addClass( 'has-error' ) ;
										message = control_group.parent().parent().find('.error_input');
										message.text("");
										message.append("Favor Carregar a Imagem");
										breakpoint = true;
									}
								}
								//active/desactive button
								if( breakpoint || lock != 0 ){ /*if there's an error*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}
							//->/validacoes
							return true ;
						}) ;
					}).on( 'shown.bs.modal' , function () { //on shown
						this_modal.find( '#image_name' ).focus();
						if( appolo.configs.currently_open_type_modal == 'nova' ){
							//set a "loading" on the modal
							appolo.gui.set_modal_loading( this_modal, false ) ;
						}
					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;
						appolo.gui.reset_form_on_container( this_modal ) ;
						history.pushState( '', document.title, window.location.pathname ) ;
						this_modal.find('.has-error').removeClass( 'has-error' ) ;
						this_modal.find('.error_input').text( "" ) ;
						history.pushState( '', document.title, window.location.pathname ) ;

						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

					$( '#image' ).unbind() ;
					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
						breakpoint = false ;
					}) ;
				}

				if ( modal == 'image_update' ){
					
					$( '#image_update' ).on( 'show.bs.modal' , function () { //on show

						//reset form
						appolo.gui.reset_form_on_container( this_modal ) ;
						//set modal title
						appolo.gui.set_modal_title_type( this_modal, appolo.configs.currently_open_type_modal, "f", "Alterar Imagem" ) ;
						this_modal.find("button").attr("disabled", "disabled")
						$("#input-id_up").fileinput({'showRemove':false, 'showCaption':true, 'showUpload':false, 'previewFileType':'image', 'initialPreviewCount':0, 'allowedFileExtensions':['jpg', 'gif', 'png', 'jpeg']});
						this_modal.find(".btn-file").addClass("disabled");
						this_modal.find( '.send-form' ).html( "Confirmar" ) ;
						url = window.location.href;
						aux = url.split("-")
						idImagem = aux.pop()						
						this_modal.find( '#idImg' ).val(idImagem);
						random = "?buster"+Math.random();
						this_modal.find( '#trocaImg' ).val("0");
						// alert(idImagem);

						$.ajax({
							type: "POST", 
							url: appolo.configs.select_imagens,
							data:  {idImagem: idImagem},
							dataType: 'json'
						}).done(function( resultado ){			
						console.log(resultado);							
							this_modal.find( '#image_name_up' ).val(resultado[0].nomeImagem);
							this_modal.find( '#image_name_up' ).val(resultado[0].nomeImagem);
							this_modal.find( '#image_description_up' ).val(resultado[0].descricaoImagem);
							this_modal.find( '#images_tag_up' ).val(resultado[0].tagImagem);
							this_modal.find( '#images_path_up' ).val(path.replace("/images.appolo/", resultado[0].caminhoImagem));
							this_modal.find("button").removeAttr("disabled")
							this_modal.find( '#folder' ).val(resultado[0].caminhoImagem);
							cdStatus = resultado[0].statusImg;
							$('#input-id_up').fileinput('refresh',{'initialPreview':"<img src='"+resultado[0].caminhoImagem+random+"' caption='"+this_modal.find( '#image_name_up' ).val()+"' class='file-preview-image'>", 'initialCaption':this_modal.find( '#image_name_up' ).val(),'showRemove':false, 'showCaption':true, 'showUpload':false, 'previewFileType':'image', 'allowedFileExtensions':['jpg', 'gif', 'png', 'jpeg']});
							$('#input-id_up').fileinput('reset');
							$("#status"+cdStatus+"").prop("checked",true);

						});

						$('#input-id_up').on('fileloaded', function(event, file, previewId, index) {
							control_group = this_modal.find(".kv-fileinput-caption").parent();
							control_group.removeClass( 'has-error' ) ;
							aux = control_group.parent().parent().find('.error_input');
							aux.text("");
							this_modal.find( '#trocaImg' ).val("1");

						});
						$( this_modal.find( 'form' ) ).submit(function(){ //on submit
							$( this_modal.find( '.send-form' ) ).attr( 'disabled', 'disabled' ) ;
							//->validacoes
								if( this_modal.find( '.not-null' ).length ){ //not null
									breakpoint = appolo.util.treat_not_null_unique( this_modal, breakpoint ) ;
								}
								if( this_modal.find( '.minlength' ).length ){ //not null
									breakpoint = appolo.util.treat_min_length( this_modal, breakpoint ) ;
								}
								if( !breakpoint ){															

									if(this_modal.find(".file-caption-name").html()=="" ){
										control_group = $(".kv-fileinput-caption").parent();
										control_group.addClass( 'has-error' ) ;
										message = control_group.parent().parent().find('.error_input');
										message.text("");
										message.append("Favor Carregar a Imagem");
										breakpoint = true;
									}
								}
								//active/desactive button
								if( breakpoint || lock != 0 ){ /*if there's an error*/
									$( this_modal.find( '.send-form' ) ).removeAttr( 'disabled' ) ;
									breakpoint = false ;
									return false ;
								}
							//->/validacoes
							return true ;
						}) ;
					}).on( 'shown.bs.modal' , function () { //on shown
						this_modal.find( '#image_description_up' ).focus();
						if( appolo.configs.currently_open_type_modal == 'edit' ){
							//set a "loading" on the modal
							appolo.gui.set_modal_loading( this_modal, false ) ;
						}
					}).on( 'hide.bs.modal' , function () { //on hide
						lock = 1 ;
						$('#input-id_up').fileinput('clear');
						appolo.gui.reset_form_on_container( this_modal ) ;
						history.pushState( '', document.title, window.location.pathname ) ;
						this_modal.find('.has-error').removeClass( 'has-error' ) ;
						this_modal.find( '#trocaImg' ).val("0");
						this_modal.find('.error_input').text( "" ) ;
						if( that.currently_page != 1 && location.hash == '' ){
							appolo.util.set_hash( '#p-' + appolo.configs.currently_page ) ;
						}

					$( '#image' ).unbind() ;
					}).on( 'hidden.bs.modal' , function() { //on hidden
						lock = 0 ;
						breakpoint = false ;
					}) ;
				}


				//show modal
				this_modal.modal( 'show' )

			}

		}

	},

	//login function
	login: function(){
		//doing yet..
		$( '#chaveContratante' ).focus() ;
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

	//load json config
	load_json_config: function( modal, id, where, set_warn ){
		var that = this ;
		$.ajax({
			type: "GET", /*update insert_section*/
			url: appolo.gui.xml_to_json + '?id=' + id + '&where=' + where
		}).done( function( configs ){
			modal.triggerHandler( 'configs-received', [ configs ] );
		} ).error( function(){
			appolo.gui.render_warn_message( appolo.gui.render_message( "warning", true, "Erro ao carregar o conteúdo.", "animated fadeInRight" ) ) ;
		} ) ;
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

		//campos not null
		if ( $( 'label.not-null' ).length ) {
			$( 'label.not-null' ).each(function(){
				if( ! $( $( this ).find( '.not-null-icon' ) ).length ){
					$( this ).attr( 'data-toggle', 'tooltip' ) ;
					$( this ).attr( 'data-placement', 'right' ) ;
					$( this ).attr( 'data-original-title', 'Campo obrigatório.' ) ;
					if ( ! $( this ).hasClass( 'plusinfo' ) ){
						$( this ).addClass( 'plusinfo' ) ;	
					}
					$( this ).append( ' <span class="glyphicon glyphicon-flash a-icon not-null-icon"></span>' ) ;
				}
			}) ;
		}

		//select check when click on the row
		if( $( 'tbody > tr' ).length ){

			$( 'tbody > tr' ).each(function( item ){
				$( this ).find( 'a, span' ).click(function( e ){
					e.stopPropagation() ;
				}) ;
				$( this ).add( $( this ).find( 'input[type=checkbox]' ).parent() ).click(function(){
					$( this ).find( 'input[type=checkbox]' ).click() ;
				}) ;

				$( this ).add( $( this ).find( 'input[type=radio]' ).parent() ).click(function(){
					$( this ).parent().find('input[type=radio]').each(function () {
						// $( this ).attr( 'checked', false ) ;
						// $( this ).removeProp('checked');
						$( this ).prop("checked", false);
					});
					// $( $( this ).find( 'input[type=radio]' )).attr( 'checked', true ) ;	
					$( $( this ).find( 'input[type=radio]' )).prop( 'checked', true ) ;	
				}) ;
			}) ;
		}

		//btn go back
		if( $( '.go-back' ).length ){
			$( '.go-back' ).unbind() ;
			$( '.go-back' ).click( function(){
				if( ! confirm( 'Tem certeza que deseja voltas e cancelas as alterações ?') ){
					return false ;
				}
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
				appolo.configs.currently_open_type_modal = split_modal[1] ;
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
			return false ;
		});

		//resize dashboard and others
		$( window ).resize(function(){
			that.w_wi = $( window ).width() ;
			that.w_he = $( window ).height() ;
		}) ;

		//class no-link
		if ( $( 'a[href=#]').length ) {
			$( 'a[href=#]').click(function(){
				return false ;
			}) ;
		}

		//monit-date
		if( $( '.monit-date' ).length ){
			$( '.monit-date' ).html( appolo.util.mount_date_full_w_feira( $( '.monit-date' ).html() ) ) ;
		}

		//refresh button (iphone)
		if ( $( 'a.refresh').length ) {
			$( 'a.refresh').click(function(){
				location.href = location.href ;
			}) ;
		}

		//open_preview
		if( typeof appolo.configs.pages.page.open_preview != 'undefined' ){
			window.open( appolo.configs.pages.page.open_preview ) ;
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

			/*general*/
			$( '.navbar-nav > li:first-child' ).toggleClass( 'active' ) ;

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

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .paginas' ).addClass( 'active' ) ;
			}
			
			/*pages*/
			if ( $('body.page').length ) {
				that.nav.push( { "title": "Páginas", "slug": "pages", "active": false, "link": that.pages_url } ) ;
				that.nav.push( { "title": "Seções", "slug": "sections", "active": true, "link": that.pages_sections_url } ) ;
				that.pages.page.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .paginas' ).addClass( 'active' ) ;
			}

			/*relatorios*/
			if ( $('body.relatorios').length ) {
				that.nav.pop();
				that.nav.push( { "title": "Relatorios", "slug": "pages", "active": true, "link": "" } ) ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .reports' ).addClass( 'active' ) ;
			}

			/*admin*/
			if ( $('body.admin').length ) {
				that.nav.pop();
				that.nav.push( { "title": "Administração", "slug": "pages", "active": true, "link": "" } ) ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			/*area*/
			if ( $('body.area').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Cargos", "slug": "area", "active": true, "link": "" }) ;
				that.area.area_content_sections = that.area_content_sections ;
				that.area.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			/*funcionarios*/
			if ( $('body.funcionarios').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Funcionários", "slug": "funcionarios", "active": true, "link": that.funcionarios_url }) ;
				that.funcionarios.funcionarios_content_sections = that.funcionarios_content_sections ;
				that.funcionarios.funcionarios_search_bar = that.funcionarios_search_bar ;
				that.funcionarios.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			if ( $('body.funcionarios_new').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Funcionários", "slug": "funcionarios_new", "active": false, "link": "/admin/funcionarios/" }) ;
				that.nav.push( { "title": "Novo Funcionário", "slug": "funcionarios_new", "active": true, "link": "" }) ;
				that.funcionarios.funcionarios_new_content_sections = that.funcionarios_new_content_sections ;
				that.funcionarios.funcionarios_new() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			if ( $('body.funcionarios_edit').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Funcionários", "slug": "funcionarios_new", "active": false, "link": "/admin/funcionarios/" }) ;
				that.nav.push( { "title": "Alterar Funcionário", "slug": "funcionarios_new", "active": true, "link": "" }) ;
				that.funcionarios.funcionarios_edit_content_sections = that.funcionarios_edit_content_sections ;
				that.funcionarios.funcionarios_edit() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			/*usuarios*/
			if ( $('body.usuarios').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Usuários", "slug": "usuarios", "active": true, "link": "admin/usuarios/"}) ;
				that.usuarios.usuarios_content_sections = that.usuarios_content_sections ;
				that.usuarios.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}
			if ( $('body.usuario_alterar').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Usuários", "slug": "usuarios", "active": false, "link": "/admin/usuarios" }) ;
				that.nav.push( { "title": "Alterar Usuário", "slug": "usuarios", "active": true, "link": "" }) ;
				that.usuarios.usuarios_edit_content_sections = that.usuarios_edit_content_sections ;
				that.usuarios.usuarios_edit() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			/*area_edit*/
			if ( $('body.area_edit').length ) {
				that.nav.push( { "title": "Administração", "slug": "area", "active": false, "link": "/admin" }) ;
				that.nav.push( { "title": "Cargos", "slug": "area", "active": false, "link": "/admin/area" }) ;
				that.nav.push( { "title": "Alterar Cargo", "slug": "area_edit", "active": true, "link": "" }) ;
				that.area.area_edit_content_sections = that.area_edit_content_sections ;
				that.area.area_edit() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .admin' ).addClass( 'active' ) ;
			}

			/*imagens*/
			if ( $('body.imagens').length ) {
				that.nav.push( { "title": "Imagens", "slug": "imagens", "active": true, "link": that.area_url }) ;
				that.imagens.imagens_content_sections = that.imagens_content_sections ;
				that.imagens.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .images' ).addClass( 'active' ) ;
			}
			/*imagens*/
			if ( $('body.galeria_imagem').length ) {
				that.nav.push( { "title": "Imagens", "slug": "imagens", "active": false, "link": "/images/" }) ;
				that.nav.push( { "title": "Galeria de Imagens", "slug": "galeria_imagem", "active": true, "link": that.area_url }) ;
				that.imagens.galeria_imagem_sections = that.galeria_imagem_sections ;
				that.imagens.galeria_imagem() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .images' ).addClass( 'active' ) ;
			}
			
			/*news*/
			if ( $('body.news').length ) {
				that.nav.push( { "title": "Notícias", "slug": "sections", "active": false, "link": that.news_url } ) ;
				that.nav.push( { "title": "Seções", "slug": "sections", "active": true, "link": that.news_new_url } ) ;
				that.news.news_content_sections = that.news_content_sections ;
				that.news.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .noticias' ).addClass( 'active' ) ;
			}
			
			/*pages*/
			if ( $('body.new').length ) {
				that.nav.push( { "title": "Notícias", "slug": "sections", "active": false, "link": that.news_url } ) ;
				that.nav.push( { "title": "Seções", "slug": "sections", "active": false, "link": that.news_new_url } ) ;
				that.news.set.init() ;

				//fix menu sel:
				//activing menu li from model
				$( '.navbar-nav li' ).removeClass( 'active' ) ;
				$( '.navbar-nav .noticias' ).addClass( 'active' ) ;
			}

			/*urls*/
			if ( $( 'body.urls').length ) {
				that.urls() ;
			}

			/*login*/
			if ( $( 'body.login').length ) {
				that.login() ;
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

	//get html translation table
	get_html_translation_table: function(table, quote_style) {

	var entities = {},
	hash_map = {},
	decimal;
	var constMappingTable = {},
	constMappingQuoteStyle = {};
	var useTable = {},
	useQuoteStyle = {};

	// Translate arguments
	constMappingTable[0] = 'HTML_SPECIALCHARS';
	constMappingTable[1] = 'HTML_ENTITIES';
	constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
	constMappingQuoteStyle[2] = 'ENT_COMPAT';
	constMappingQuoteStyle[3] = 'ENT_QUOTES';

	useTable = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
	useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() :
	'ENT_COMPAT';

	if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
		throw new Error('Table: ' + useTable + ' not supported');
	// return false ;
	}

	entities['38'] = '&amp;';
	if (useTable === 'HTML_ENTITIES') {
		entities['160'] = '&nbsp;';
		entities['161'] = '&iexcl;';
		entities['162'] = '&cent;';
		entities['163'] = '&pound;';
		entities['164'] = '&curren;';
		entities['165'] = '&yen;';
		entities['166'] = '&brvbar;';
		entities['167'] = '&sect;';
		entities['168'] = '&uml;';
		entities['169'] = '&copy;';
		entities['170'] = '&ordf;';
		entities['171'] = '&laquo;';
		entities['172'] = '&not;';
		entities['173'] = '&shy;';
		entities['174'] = '&reg;';
		entities['175'] = '&macr;';
		entities['176'] = '&deg;';
		entities['177'] = '&plusmn;';
		entities['178'] = '&sup2;';
		entities['179'] = '&sup3;';
		entities['180'] = '&acute;';
		entities['181'] = '&micro;';
		entities['182'] = '&para;';
		entities['183'] = '&middot;';
		entities['184'] = '&cedil;';
		entities['185'] = '&sup1;';
		entities['186'] = '&ordm;';
		entities['187'] = '&raquo;';
		entities['188'] = '&frac14;';
		entities['189'] = '&frac12;';
		entities['190'] = '&frac34;';
		entities['191'] = '&iquest;';
		entities['192'] = '&Agrave;';
		entities['193'] = '&Aacute;';
		entities['194'] = '&Acirc;';
		entities['195'] = '&Atilde;';
		entities['196'] = '&Auml;';
		entities['197'] = '&Aring;';
		entities['198'] = '&AElig;';
		entities['199'] = '&Ccedil;';
		entities['200'] = '&Egrave;';
		entities['201'] = '&Eacute;';
		entities['202'] = '&Ecirc;';
		entities['203'] = '&Euml;';
		entities['204'] = '&Igrave;';
		entities['205'] = '&Iacute;';
		entities['206'] = '&Icirc;';
		entities['207'] = '&Iuml;';
		entities['208'] = '&ETH;';
		entities['209'] = '&Ntilde;';
		entities['210'] = '&Ograve;';
		entities['211'] = '&Oacute;';
		entities['212'] = '&Ocirc;';
		entities['213'] = '&Otilde;';
		entities['214'] = '&Ouml;';
		entities['215'] = '&times;';
		entities['216'] = '&Oslash;';
		entities['217'] = '&Ugrave;';
		entities['218'] = '&Uacute;';
		entities['219'] = '&Ucirc;';
		entities['220'] = '&Uuml;';
		entities['221'] = '&Yacute;';
		entities['222'] = '&THORN;';
		entities['223'] = '&szlig;';
		entities['224'] = '&agrave;';
		entities['225'] = '&aacute;';
		entities['226'] = '&acirc;';
		entities['227'] = '&atilde;';
		entities['228'] = '&auml;';
		entities['229'] = '&aring;';
		entities['230'] = '&aelig;';
		entities['231'] = '&ccedil;';
		entities['232'] = '&egrave;';
		entities['233'] = '&eacute;';
		entities['234'] = '&ecirc;';
		entities['235'] = '&euml;';
		entities['236'] = '&igrave;';
		entities['237'] = '&iacute;';
		entities['238'] = '&icirc;';
		entities['239'] = '&iuml;';
		entities['240'] = '&eth;';
		entities['241'] = '&ntilde;';
		entities['242'] = '&ograve;';
		entities['243'] = '&oacute;';
		entities['244'] = '&ocirc;';
		entities['245'] = '&otilde;';
		entities['246'] = '&ouml;';
		entities['247'] = '&divide;';
		entities['248'] = '&oslash;';
		entities['249'] = '&ugrave;';
		entities['250'] = '&uacute;';
		entities['251'] = '&ucirc;';
		entities['252'] = '&uuml;';
		entities['253'] = '&yacute;';
		entities['254'] = '&thorn;';
		entities['255'] = '&yuml;';
	}

	if (useQuoteStyle !== 'ENT_NOQUOTES') {
		entities['34'] = '&quot;';
	}
	if (useQuoteStyle === 'ENT_QUOTES') {
		entities['39'] = '&#39;';
	}
	entities['60'] = '&lt;';
	entities['62'] = '&gt;';

	// ascii decimals to real symbols
	for (decimal in entities) {
		if (entities.hasOwnProperty(decimal)) {
			hash_map[String.fromCharCode(decimal)] = entities[decimal];
		}
	}

	return hash_map;
	},

	encode_path: function ( text ){
		var that = this,
		varString = new String(text),
		stringAcentos = new String('àâêôûãõáéíóúçüÀÂÊÔÛÃÕÁÉÍÓÚÇÜ\'\" -'),
		stringSemAcento = new String('aaeouaoaeioucuAAEOUAOAEIOUCU  _-'),
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

		return ( text ).toLowerCase() ;
	},

	html_quotes: function( string ){
		return string.replace( /"/g, '\'' ) ;
	},

	html_entity_decode: function(string, quote_style) {
		var hash_map = {},
		symbol = '',
		tmp_str = '',
		entity = '';
		tmp_str = string.toString();

		if (false === (hash_map = appolo.treat.get_html_translation_table('HTML_ENTITIES', quote_style))) {
		return false ;
		}

		// fix &amp; problem
		// http://phpjs.org/functions/get_html_translation_table:416#comment_97660
		delete(hash_map['&']);
		hash_map['&'] = '&amp;';

		for (symbol in hash_map) {
		entity = hash_map[symbol];
		tmp_str = tmp_str.split(entity)
		.join(symbol);
		}
		tmp_str = tmp_str.split('&#039;')
		.join("'");

		return tmp_str;
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
