( function( $ ) {
	/**
     * Admin notice
     */
    function admin_notice( response ) {
      var div = $( '<div />' );
      var p = $( '<p />' );
      var span = $( '<span />' );
      var screen_reader = $( '<span />' );
      var button = $( '<button />' );
      div.attr( 'id', 'admin-notice' );
      div.addClass( 'updated notice notice-success is-dismissible' );
      button.attr( 'id', 'admmin-notice-button' );
      button.addClass( 'notice-dismiss' );
      screen_reader.addClass( 'screen-reader-text' );

      div.append( p );
      p.append( span );
      p.text( response );
      div.append( button );
      button.append( screen_reader );

      div.insertAfter( '#wpbody-content .wrap .wp-header-end' );

      $( '#admmin-notice-button' ).click( function() {
        $( '#admin-notice' ).remove();
      } );
    }

    admin_notice( 'This is the admin notice.' );
} )( jQuery );	