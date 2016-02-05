jQuery( function( $ ) {

	//----------------------------------------
	// The magic
	//----------------------------------------

	$( 'form' ).submit( function() {
		var _this = $( this );
		var url   = _this.attr( 'action' );
		var data  = _this.serializeArray();
		var btn   = _this.find( 'button[type="submit"]' );
		var modal = $( '#modalResponse' );

		if ( $( '#ag_wysiwyg_editor' ).length && typeof tinyMCE !== 'undefined' ) {
			data.push( { 
				name: 'fields[ag_wysiwyg_editor]', 
				value: tinyMCE.get( 'ag_wysiwyg_editor' ).getContent() 
			} );
		}

		btn.prop( { 'disabled' : true } );

		$.ajax( {
		    url: url,
		    method: 'PUT',
		    beforeSend: function ( xhr ) {
		        xhr.setRequestHeader( 'X-WP-Nonce', WP_API_Settings.nonce );
		    },
		    data: data,
		    dataType: 'json',
		} ).always( function ( data ) {
			btn.removeProp( 'disabled' );
			modal.find( '.modal-body' ).html( '<pre>' + JSON.stringify( data, null, "\t" ) + '</pre>' );
			modal.modal( 'show' );
		} );

		return false;
	} );

	//----------------------------------------
	// TAB: Content
	//----------------------------------------

	// TYPE: Image
	//----------------------------------------

	var mediaImage;

	$( '#acf-image-thumb' ).click( function() {
		var _this = $( this );

		if ( ! $.isFunction( wp.media ) ) {
			return;
		}

		if ( mediaImage ) {
			mediaImage.open();
			return;
		}

		mediaImage = wp.media( {
			library: {
				type: 'image'
			},
			multiple : false
		} );

		mediaImage.on( 'select', function() {
			var image = mediaImage.state().get( 'selection' ).first().toJSON();
			$( '.media-modal-close' ).trigger( 'click' );
			$( '#acf-image' ).val( image.id );
			_this.find( 'img' ).remove();
			$( '<img src="' + image.url + '" width="171">' ).insertAfter( _this.find( 'span' ) );
		} );

		mediaImage.open();

		return false;
	} );

	// TYPE: File URL
	//----------------------------------------
	
	var mediaFileUrl;

	$( '#acf-file-url-btn' ).click( function() {
		var removeBtn = $( '#acf-file-url-remove-btn' );
		
		if ( ! $.isFunction( wp.media ) ) {
			return;
		}

		if ( mediaFileUrl ) {
			mediaFileUrl.open();
			return;
		}

		mediaFileUrl = wp.media( { 
			multiple: false 
		} );

		mediaFileUrl.on( 'select', function() {
			var file = mediaFileUrl.state().get( 'selection' ).first().toJSON();
			$( '.media-modal-close' ).trigger( 'click' );
			$( '#acf-file-url-id' ).val( file.id );
			$( '#acf-file-url' ).val( file.url );
			removeBtn.removeClass( 'hide' );
		} );

		mediaFileUrl.open();

		return false;
	} );

	$( '#acf-file-url-remove-btn' ).click( function() {
		$( this ).addClass( 'hide' );		
		$( '#acf-file-url-id' ).val( '' );
		$( '#acf-file-url' ).val( '' );

		return false;
	} );

	//----------------------------------------
	// TAB: Choice, Relational
	//----------------------------------------

	// TYPE: Checkbox, Relationship, Taxonomy
	//----------------------------------------

	$( '.check' ).each( function() {
		var name = $( this ).attr( 'name' );

		$( '[name="' + name + '"]').change( function() {
			var _this   = $( this );
			var uncheck = _this.hasClass( 'uncheck' );
			var check   = _this.hasClass( 'check' );

			if ( uncheck ) {
				$( '[name="' + name + '[]"]').removeAttr( 'checked' );
				_this.attr( 'checked', 'checked' );
			} else if( check ) {
				$( '[name="' + name + '[]"]').attr( 'checked', 'checked' );
				$( '[name="' + name + '"]').removeAttr( 'checked' );
			}
		} );

		$( '[name="' + name + '[]"]').change( function() {
			if ( $( '[name="' + name + '[]"]:checked').length ) {
				$( '[name="' + name + '"]').removeAttr( 'checked' );
			} else {
				$( '[name="' + name + '"]').attr( 'checked', 'checked' );
			}
		} );
	} );

	//----------------------------------------
	// TAB: jQuery
	//----------------------------------------

	// TYPE: Date Picker
	//----------------------------------------

	if ( $.isFunction( $( '.datepicker' ).datepicker ) ) {
		$( '.datepicker' ).datepicker( {
			format: 'yyyy-mm-dd',
			autoclose: true
		} );		
	}

	// TYPE: Color Picker
	//----------------------------------------

	if ( $.isFunction( $( '.color-picker' ).colorpicker ) ) {
		$( '.color-picker' ).colorpicker().on( 'changeColor', function( ev ) {
			$( ev.currentTarget ).css( { 
				'background-color': ev.color.toHex() 
			} );
		} );
	}

	// TYPE: Google Map
	//----------------------------------------

	$( '.google-map' ).each( function() {
		var _this     = $( this );
		var searchFld = _this.find( '.google-map-search' );
		var latFld    = _this.find( '.google-map-lat' );
		var lngFld    = _this.find( '.google-map-lng' );
		var lat       = _this.data( 'lat' );
		var lng       = _this.data( 'lng' );
		var LatLng    = { lat : -22.932917, lng : -43.176016 };
		
		if ( lat && lng ) {
			LatLng = { lat : lat, lng : lng };
		}
		
		var map = new google.maps.Map( _this.find( '.map' )[0], {
			zoom 	  : 15,
			center 	  : new google.maps.LatLng( LatLng.lat, LatLng.lng ),
			mapTypeId : google.maps.MapTypeId.ROADMAP
		} );
		
		var geocoder = new google.maps.Geocoder();
		var autocomplete = new google.maps.places.Autocomplete( searchFld[0] );
		
		autocomplete.map = map;
		autocomplete.bindTo( 'bounds', map );
		
		map.marker = new google.maps.Marker({
			position 	: LatLng,
			draggable	: true,
			raiseOnDrag	: true,
			map			: map
		});

		google.maps.event.addListener(autocomplete, 'place_changed', function( e ) {
			var place   = this.getPlace();

			if ( place.geometry ) {
				var lat     = place.geometry.location.lat();
				var lng     = place.geometry.location.lng();
				var latlng  = new google.maps.LatLng( lat, lng );

				map.marker.setPosition( latlng );
				map.marker.setVisible( true );
				map.marker.setAnimation( google.maps.Animation.DROP );
				map.setCenter( latlng );

				latFld.val( lat );
				lngFld.val( lng );
			}
		} );

		google.maps.event.addListener( map.marker, 'dragend', function() {
			var position = map.marker.getPosition();
			var lat      = position.lat();
			var lng      = position.lng();
			var latlng = new google.maps.LatLng( lat, lng );
			
			map.marker.setAnimation( google.maps.Animation.DROP );
			map.setCenter( latlng );

			geocoder.geocode( { 'latLng' : latlng }, function( results, status ) {
				if( status == google.maps.GeocoderStatus.OK && results.length ) {
					searchFld.val( results[0].formatted_address );
					latFld.val( lat );
					lngFld.val( lng );
				}
			} );
		} );
		
		$( '[href="#cnt-jquery"]' ).on( 'shown.bs.tab', function() {
			var center = map.getCenter();
			google.maps.event.trigger( map, 'resize' );
			map.setCenter( center );
		} );

	} );


	//----------------------------------------
	// TAB: Repeater
	//----------------------------------------

	// TYPE: Repeater
	//----------------------------------------

	var verifyItemsRepeater = function() {
		var removeRow = $( '.repeater .remove-row' );
		if ( $( '.repeater > .item' ).length == 1 ) {
			removeRow.hide();
		} else {
			removeRow.show();
		}
	};

	verifyItemsRepeater();

	$( '.repeater > .add-row' ).click( function() {
		var clone = $( '.repeater > .item:last' ).clone();
		clone.find( 'input' ).val( '' );
		$( clone ).insertBefore( $( this ) );
		var newIndex = $( '.repeater > .item' ).length - 1;

		$( '.repeater > .item:last [name]' ).attr( 'name', function( index, name ) {
			return name.replace( /\d+/g, newIndex );
		} );

		verifyItemsRepeater();
		return false;
	} );

	$( document ).on( 'click', '.repeater .remove-row', function() {
		var item = $( '.repeater > .item' );
		if ( item.length == 1 ) {
			item.find( 'input' ).val( '' );
		} else {
			$( this ).closest( '.item' ).remove();
		}
		verifyItemsRepeater();
		return false;
	} );

} );