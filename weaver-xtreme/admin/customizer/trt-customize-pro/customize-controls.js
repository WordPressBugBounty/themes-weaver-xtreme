( function( api ) {

	// Extends our custom "weaverx-plus-add" section.
	api.sectionConstructor['weaverx-plus-add'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function ( ) {},

		// Always make the section active.
		isContextuallyActive: function ( ) {
			return true;
		}
	} );

} )( wp.customize );

