( function( $ ) {

	var WVRXsr = {

		init: function()
		{
			$( 'input[name=wvrx_save]' ).on( 'click', WVRXsr._export );
			$( 'input[name=wvrx_save_all]' ).on( 'click', WVRXsr._exportall );
			$( 'input[name=wvrx_save_todb]' ).on( 'click', WVRXsr._exporttodb );
			$( 'input[name=wvrx_restore]' ).on( 'click', WVRXsr._import );
			$( 'input[name=wvrx_restore_fromdb]' ).on( 'click', WVRXsr._restorefromdb );
			$( 'input[name=wvrx_save_xplus]' ).on( 'click', WVRXsr._exportxplus );
			$( 'input[name=wvrx_select_subtheme]' ).on( 'click', WVRXsr._loadtheme );
			$( 'input[name=wvrx_cust_level_beginner]' ).on( 'click', WVRXsr._levelbeg );
			$( 'input[name=wvrx_cust_level_intermediate]' ).on( 'click', WVRXsr._levelint );
			$( 'input[name=wvrx_cust_level_advanced]' ).on( 'click', WVRXsr._leveladv );
			$( 'input[name=wvrx_cust_interface_what]' ).on( 'click', WVRXsr._interfacewhat );
			$( 'input[name=wvrx_cust_interface_where]' ).on( 'click', WVRXsr._interfacewhere );
		},

		_export: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_save=' + WVRXConfig.exportNonce;
		},

		_exportall: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_save_all=' + WVRXConfig.exportNonce;
		},

		_exporttodb: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_save_todb=' + WVRXConfig.exportNonce;
		},

		_restorefromdb: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_restore_fromdb=' + WVRXConfig.exportNonce;
		},

		_exportxplus: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_save_xplus=' + WVRXConfig.exportNonce;
		},

		_levelbeg: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_cust_level_beginner=' + WVRXConfig.exportNonce;
		},

		_levelint: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_cust_level_intermediate=' + WVRXConfig.exportNonce;
		},

		_leveladv: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_cust_level_advanced=' + WVRXConfig.exportNonce;
		},

		_interfacewhat: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_cust_interface_what=' + WVRXConfig.exportNonce;
		},

		_interfacewhere: function()
		{
			window.location.href = WVRXConfig.customizerURL + '?wvrx_cust_interface_where=' + WVRXConfig.exportNonce;
		},



		_import: function()
		{
			var win			= $( window ),
				body		= $( 'body' ),
				form		= $( '<form class="wvrx-form" method="POST" enctype="multipart/form-data" ></form>' ),
				controls	= $( '.wvrx-settings-restore-controls' ),
				file		= $( 'input[name=wvrx-settings-restore-file]' ),
				message		= $( '.wvrx-uploading' );

			if ( '' == file.val() ) {
				alert( WVRXl10n.emptyImport );
			}
			else {
				win.off( 'beforeunload' );
				body.append( form );
				form.append( controls );
				message.show();
				form.submit();
			}
		},

		_loadtheme: function()
		{
			var win			= $( window ),
				body		= $( 'body' ),
				form		= $( '<form class="wvrx-form-subtheme" method="POST" enctype="multipart/form-data" ></form>' ),
				controls	= $( '.wvrx-settings-load-subtheme' ),
				message		= $( '.wvrx-uploading' );


				win.off( 'beforeunload' );
				body.append( form );
				form.append( controls );
				message.show();
				form.submit();

		}

	};

	$( WVRXsr.init );

})( jQuery );
