$.fn.mount_group = function( options ){
	var base = this ,
	options = options || false ;

	base.$el = $( base ) ;
	base.el = base ;

	base.options = {
		elem: this ,
		this_type: 'form',
		ads: ''
	} ;

	base.mount_field = function( object_field, this_type, main_form ){
		var that = this, code = '' ;

		//console.log( $( object_field ).attr( 'name' ) ) ;
		code += 'teste' ;
		
		//<div class="control-group">
		//	<label class="control-label not-null" for="section_name">Nome</label>
		//
		//	<div class="controls">
		//		<input id="section_name" name="section_name" maxlength="100" data-receive="nomeSecao" type="text" placeholder="Nome" class="form-control">
		//		<p class="help-block"></p>
		//	</div>
		//</div>

		return code ;
	} ;

	base.mount_group = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		if( ! object_group.length ){
			return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
		}
		for( var i = 0; i < object_group.length; i ++ ){
			name = $( object_group[ i ] ).attr( 'name' ) ;

			if( ( name == '' ) || ( name == 'undefined' ) ){
				return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
			}
			code += '<fieldset class="group" name="' + name + '">' ;

			code += ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( '<legend>' + $( object_group[ i ] ).attr( 'title' ) + '</legend>' ) : '' ) ;

			elements_objects = $( object_group[ i ] ).find( ' > group, > field' ) ;
			
			//nothing inside
			if( ! elements_objects.length ){
				return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
			}else{
				while( j < elements_objects.length ){
					var object = $( $( elements_objects[ j ] ) )[ 0 ] ;

					if( $( object )[ 0 ].localName == 'group' ){
						code += that.mount_group1( $( object ), this_type, main_form ) ;
					}

					if( $( object )[ 0 ].localName == 'field' ){
						code += that.mount_field( $( object ), this_type, main_form ) ;	
					}

					j ++ ;
				}
			}

			code += '</fieldset>' ;
		}

		if( code == 'false' ){ return false ; }
		return code ;
	} ;

	base.mount_group1 = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		if( ! object_group.length ){
			return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
		}
		for( var i = 0; i < object_group.length; i ++ ){
			name = $( object_group[ i ] ).attr( 'name' ) ;

			if( ( name == '' ) || ( name == 'undefined' ) ){
				return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
			}
			code += '<fieldset class="group" name="' + name + '">' ;

			code += ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( '<legend>' + $( object_group[ i ] ).attr( 'title' ) + '</legend>' ) : '' ) ;

			elements_objects = $( object_group[ i ] ).find( ' > group, > field' ) ;
			
			//nothing inside
			if( ! elements_objects.length ){
				return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
			}else{
				while( j < elements_objects.length ){
					var object = $( $( elements_objects[ j ] ) )[ 0 ] ;

					if( $( object )[ 0 ].localName == 'group' ){
						code += that.mount_group2( $( object ), this_type, main_form ) ;
					}

					if( $( object )[ 0 ].localName == 'field' ){
						code += that.mount_field( $( object ), this_type, main_form ) ;	
					}

					j ++ ;
				}
			}

			code += '</fieldset>' ;
		}

		if( code == 'false' ){ return false ; }
		return code ;
	} ;

	base.mount_group2 = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		if( ! object_group.length ){
			return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
		}
		for( var i = 0; i < object_group.length; i ++ ){
			name = $( object_group[ i ] ).attr( 'name' ) ;

			if( ( name == '' ) || ( name == 'undefined' ) ){
				return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
			}
			code += '<fieldset class="group" name="' + name + '">' ;

			code += ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( '<legend>' + $( object_group[ i ] ).attr( 'title' ) + '</legend>' ) : '' ) ;

			elements_objects = $( object_group[ i ] ).find( ' > group, > field' ) ;
			
			//nothing inside
			if( ! elements_objects.length ){
				return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
			}else{
				while( j < elements_objects.length ){
					var object = $( $( elements_objects[ j ] ) )[ 0 ] ;

					if( $( object )[ 0 ].localName == 'group' ){
						code += that.mount_group3( $( object ), this_type, main_form ) ;
					}

					if( $( object )[ 0 ].localName == 'field' ){
						code += that.mount_field( $( object ), this_type, main_form ) ;	
					}

					j ++ ;
				}
			}

			code += '</fieldset>' ;
		}

		if( code == 'false' ){ return false ; }
		return code ;
	} ;

	base.mount_group3 = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		if( ! object_group.length ){
			return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
		}
		for( var i = 0; i < object_group.length; i ++ ){
			name = $( object_group[ i ] ).attr( 'name' ) ;

			if( ( name == '' ) || ( name == 'undefined' ) ){
				return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
			}
			code += '<fieldset class="group" name="' + name + '">' ;

			code += ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( '<legend>' + $( object_group[ i ] ).attr( 'title' ) + '</legend>' ) : '' ) ;

			elements_objects = $( object_group[ i ] ).find( ' > group, > field' ) ;
			
			//nothing inside
			if( ! elements_objects.length ){
				return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
			}else{
				while( j < elements_objects.length ){
					var object = $( $( elements_objects[ j ] ) )[ 0 ] ;

					if( $( object )[ 0 ].localName == 'group' ){
						code += that.mount_group4( $( object ), this_type, main_form ) ;
					}

					if( $( object )[ 0 ].localName == 'field' ){
						code += that.mount_field( $( object ), this_type, main_form ) ;	
					}

					j ++ ;
				}
			}

			code += '</fieldset>' ;
		}

		if( code == 'false' ){ return false ; }
		return code ;
	} ;

	base.mount_group4 = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		if( ! object_group.length ){
			return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
		}
		for( var i = 0; i < object_group.length; i ++ ){
			name = $( object_group[ i ] ).attr( 'name' ) ;

			if( ( name == '' ) || ( name == 'undefined' ) ){
				return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
			}
			code += '<fieldset class="group" name="' + name + '">' ;

			code += ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( '<legend>' + $( object_group[ i ] ).attr( 'title' ) + '</legend>' ) : '' ) ;

			elements_objects = $( object_group[ i ] ).find( ' > group, > field' ) ;
			
			//nothing inside
			if( ! elements_objects.length ){
				return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
			}else{
				while( j < elements_objects.length ){
					var object = $( $( elements_objects[ j ] ) )[ 0 ] ;

					if( $( object )[ 0 ].localName == 'group' ){
						code += that.mount_group5( $( object ), this_type, main_form ) ;
					}

					if( $( object )[ 0 ].localName == 'field' ){
						code += that.mount_field( $( object ), this_type, main_form ) ;	
					}

					j ++ ;
				}
			}

			code += '</fieldset>' ;
		}

		if( code == 'false' ){ return false ; }
		return code ;
	} ;

	base.mount_group5 = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		if( ! object_group.length ){
			return appolo.gui.set_error_page( [ 'Nenhum grupo definido.' ], this_type, main_form ) ;
		}
		for( var i = 0; i < object_group.length; i ++ ){
			name = $( object_group[ i ] ).attr( 'name' ) ;

			if( ( name == '' ) || ( name == 'undefined' ) ){
				return appolo.gui.set_error_page( [ 'Grupo não tem um nome definido.' ], this_type, main_form ) ;
			}
			code += '<fieldset class="group" name="' + name + '">' ;

			code += ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( '<legend>' + $( object_group[ i ] ).attr( 'title' ) + '</legend>' ) : '' ) ;

			elements_objects = $( object_group[ i ] ).find( ' > group, > field' ) ;
			
			//nothing inside
			if( ! elements_objects.length ){
				return appolo.gui.set_error_page( [ 'Nenhum campo para o grupo "<i>' + ( ( typeof $( object_group[ i ] ).attr( 'title' ) != 'undefined' ) ? ( $( object_group[ i ] ).attr( 'title' ) ) : ( $( object_group[ i ] ).attr( 'name' ) ) ) + '</i>" definido.' ], this_type, main_form ) ;
			}else{
				while( j < elements_objects.length ){
					var object = $( $( elements_objects[ j ] ) )[ 0 ] ;

					if( $( object )[ 0 ].localName == 'group' ){
						code += that.mount_group6( $( object ), this_type, main_form ) ;
					}

					if( $( object )[ 0 ].localName == 'field' ){
						code += that.mount_field( $( object ), this_type, main_form ) ;	
					}

					j ++ ;
				}
			}

			code += '</fieldset>' ;
		}

		if( code == 'false' ){ return false ; }
		return code ;
	} ;

	base.mount_group6 = function( object_group, this_type, main_form, aux ){
		var that = this, code = elements_objects = '', j = 0 ;

		alert( 'aetaet' ) ;

		return appolo.gui.set_error_page( [ 'Máximo 5 grupos em um formulário!' ], this_type, main_form ) ;
	} ;

	return base.mount_group( this.options.elem, this.options.this_type, $( '.main-form' ) ) ;
} ;