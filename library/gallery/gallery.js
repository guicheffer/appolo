/**
 * Gallery jQuery plugin v1.0
 * http://folha.com
 * Copyright 2012, Folha de S.Paulo 
 * Author: afelix
 * Library: jQuery 1.7.2
 * 
 * Ultilizado para incorporar uma galeria no corpo de uma matéria
 *
 * Date: Tue Jul 10 2012 18:44:08 GMT-0300
 */
$.fn.gallery = function ( options ) {
	var base = this , 
	options = options || false ;

	base.$el = $( base ) ;
	base.el = base ;

    base.options = {
    	elem: null ,

    	collection: [] ,

    	re: /^http\:\/\/fotografia\.folha\.uol\.com\.br\/galerias\/([0-9]+)\-(.*)/ ,

    	speed: 200 ,

		index: 0 ,

		locked: false ,

		total: 0 ,

		gallery: {} ,

		position: 0 ,

		counter: 0 ,

    	// Carousel
    	carousel: {
    		elem: null ,

    		display: 6 ,
	
			width: 90 ,
			
			step: 6 ,
			
			index: 0 ,
			
			speed: 500 ,
			
			locked: false ,

			start: 0
    	}
    } ;

    base.init = function () {
    	base.options = $.extend( {} , base.options , options ) ;

    	if ( base.check_url() ) {
    		var op = base.options ;

    		base.mount( function() {
    			base.get_position() ;
				base.change( op.position ) ;

				// Imagem
				var image = $( "div.image img" , op.elem ) ;
				image.load( function () {
					$( this ).animate( { opacity: 1 } , op.speed  ) ;
				} ) ;

				// Anterior
				$( "div.image a.control.prev_img" , op.elem ).click( base.prev ) ;
				// Próxima
				$( "div.image a.control.next_img" , op.elem ).click( base.next ) ;

				// Thumbs
				var thumbs = $( "div.pagination ul > li" , op.elem ) ;
				thumbs.click( function ( e ) {
					e.preventDefault() ;
					var that = $( this ) , i = thumbs.index( that ) ; 
					base.change( i ) ;

    				thumbs.find( "a" ).filter( ".selected" ).removeClass( "selected" ) ;
					thumbs.eq(i).find( "a" ).addClass( "selected" ) ;
				} ) ;
    		} ) ;
    	}
    } ;

    // Verifica se url casa com uma url da fotografia
    base.check_url = function () {
    	var op = base.options ;
    	op.gallery.url = base.$el.find( "a" ).attr( "href" ) ;

    	if ( op.re.test( op.gallery.url ) ) {
    		op.gallery.fragments = op.gallery.url.split( "#" ) ;
			op.gallery.id = op.gallery.fragments[0].split( "/" )[4].split( "-" )[0] ;

			return true ;
    	}

    	return false ;
    } ;

    base.mount = function ( callback ) { 
    	var op = base.options ;

    	op.carousel.elem = $( "<ul/>" ).wrap( '<div class="articleGallery" data-id="' + op.gallery.id + '" />' )

    	$.getJSON( op.gallery.fragments[0] + ".jsonp?callback=?" , function ( data ) {
    		// Monta as thumbs
    		base.carousel.mount( data ) ;

    		// Container da foto
    		op.carousel.elem.parent().parent().after( '<div class="image"> \
    			<div class="credit"></div> \
    			<a href="javascript:void(0)" class="control prev_img">Anterior</a> \
    			<a href="javascript:void(0)" class="control next_img">Próxima</a> \
    			<img src=""></div> \
    			<div class="legend"></div>' ) ;

    		base.$el.remove() ;

    		op.elem = $( 'div.articleGallery[data-id=' +  op.gallery.id + ']' ) ;

    		if ( typeof callback === "function" ) {
    			callback() ;
    		}
    	} ) ;
    } ;

    // Verifica se foi passado uma foto específica
    base.get_position = function () {
    	var op = base.options ;

    	if ( typeof op.gallery.fragments[1] != "undefined" ) {
			var idx = op.gallery.fragments[1].split( "-" )[1] ;

			for ( var i = 0 , len = op.collection.length ; i < len ; i++ ) {
				if ( idx == op.collection[i].id ) {
					op.position = i ;
				}
			}
		}
    } ;

    base.prev = function () {
    	base.change( base.options.index - 1 ) ;
    } ;

    base.next = function () {
    	base.change( base.options.index + 1 ) ;
    } ;

    base.change = function ( i ) { 
    	var op = base.options ;

    	if ( !op.locked ) {
    		op.locked = true ;
    		var total = op.total - 1 ;
    		i = ( i < 0 ) ? total : ( ( i > total ) ? 0 : i ) ;

    		op.index = i ;    		

			var thumbs = $( "div.pagination ul > li" , op.elem ) ;
    		thumbs.find( "a" ).filter( ".selected" ).removeClass( "selected" ) ;
			thumbs.eq(i).find( "a" ).addClass( "selected" ) ;

    		$( "div.legend" , op.elem ).html( decodeURIComponent( op.collection[i].legend ) ) ;
			$( "div.credit" , op.elem ).html(  op.collection[i].credit ) ;

    		$( "div.image img" , op.elem ).animate( { opacity: 0 } , op.speed , function() {
    			$( this ).attr( { src: op.collection[i].href } ) ;

    			// Carousel
				base.carousel.init( i ) ;

				// Omniture
				base.omniture( { 
					url: op.gallery.url , 
					id: op.collection[i].id , 
					counter: op.counter++  
				} ) ;


    			op.locked = false ;
    		} ) ;

    	}
    } ;

    // Contabiliza cada foto para Omniture
    base.omniture = function ( data ) {
    	if ( typeof photoEmbedOmniture == "function" ) {
			if ( data.counter > 0 ) { 
				photoEmbedOmniture( data.url , data.id ) ;
			}
		}
    } ;

    // Carousel
    base.carousel = {} ;

    base.carousel.init = function ( i ) {
    	var op = base.options ,
    	prev = $( "#thumbnails > a.prev" , op.elem ) ,
    	next = $( "#thumbnails > a.next" , op.elem ) ;

    	if ( ( op.total - 1 ) < op.carousel.display ) {
    		prev.remove() ;
    		next.remove() ;
    		return ;
    	}

    	prev.click( base.carousel.prev ) ;
    	next.click( base.carousel.next ) ;

    	base.carousel.change( i ) ;
    } ;

    // Monta as thumbs
    base.carousel.mount = function ( data ) {
    	var op = base.options , items = [] ;

		$.each( data.images , function ( i , item ) {
			items.push( '<li><a href="' + item.image_gallery + '"><img src="' + item.image_medium + '"></a></li>') ;
			op.collection.push( { 
				id: item.idx ,
				href: item.image_gallery ,
				legend: encodeURIComponent( item.legend.replace( /<a.*.<\/a>/gi , "" ) ) ,
				credit: item.credit_javascript
			} ) ;
		} ) ;

		op.total = items.length ;

		op.carousel.elem.html( items.join( "" ) ) ;
		op.carousel.elem.wrap( '<div id="thumbnails"/>' ).parent()
			.append( '<a href="javascript:void(0)" class="control prev">Anterior</a> \
				<a href="javascript:void(0)" class="control next">Próxima</a>' ).parent()
			.prepend( '<h4 class="title">' + data.gallery.title + '</h4> \
				<a href="' + data.gallery.url + '" class="full"><span class="icon foto"></span> &nbsp;Ver em tamanho maior »</a>' )
			.insertAfter( base.$el ) ;

		op.carousel.elem.wrap( '<div class="pagination" />' ) ;
    } ;

    base.carousel.prev = function () {
    	base.carousel.scroll( base.options.carousel.index - base.options.carousel.step ) ;
    } ;

    base.carousel.next = function () {
    	base.carousel.scroll( base.options.carousel.index + base.options.carousel.step ) ;
    } ;

    base.carousel.change = function ( i ) {
    	var op = base.options ;

    	if ( i === 0 ) {
			base.carousel.scroll( i ) ;
		} else if ( i == op.total ) {
			base.carousel.scroll( op.total - op.carousel.step ) ;
		} else if ( i < op.carousel.index ) {
			base.carousel.prev() ;
		} else if ( i > ( op.carousel.index + op.carousel.step - 1 ) ) {
			if ( i == ( op.total - 1 ) ) {
				base.options.carousel.index++ ;
			}
			base.carousel.next() ;
		}
    } ;

    base.carousel.scroll = function ( i ) { 
    	var op = base.options ;

    	if ( !op.carousel.locked ) {
			op.carousel.locked = true ;

			if ( i >= ( op.total - op.carousel.step ) ) {
				i = op.total - op.carousel.step ;	
			} else if ( i < 0 || i > op.total ) {
				i = 0 ;
			}

			op.carousel.index = i ;

			if ( op.carousel.elem !== null ) {
				var value = ( i * op.carousel.width * -1 ) + "px" ;

				$( op.carousel.elem , op.elem ).animate( { left: value } , op.carousel.speed , function () {
					op.carousel.locked = false ;
				} ) ;
			}
    	}
    } ;

	// Inicialização
    base.init() ;
} ;