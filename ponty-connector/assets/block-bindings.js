( function() {
    var registerBlockBindingsSource = wp.blocks.registerBlockBindingsSource;
    if ( ! registerBlockBindingsSource ) {
        return;
    }

    var fields = [
        { key: '_pnty_organization_name', label: 'Organization Name', type: 'string' },
        { key: '_pnty_location',          label: 'Location',          type: 'string' },
        { key: '_pnty_region',            label: 'Region',            type: 'string' },
        { key: '_pnty_name',              label: 'Contact Name',      type: 'string' },
        { key: '_pnty_user_title',        label: 'Contact Title',     type: 'string' },
        { key: '_pnty_phone',             label: 'Phone',             type: 'string' },
        { key: '_pnty_email',             label: 'Email',             type: 'string' },
        { key: '_pnty_address',           label: 'Address',           type: 'string' },
        { key: '_pnty_withdrawal_date',   label: 'Withdrawal Date',   type: 'string' },
        { key: '_pnty_external_apply_url',label: 'External Apply URL', type: 'string' },
        { key: '_pnty_language',          label: 'Language',          type: 'string' },
        { key: '_pnty_video_url',         label: 'Video URL',         type: 'string' },
        { key: '_pnty_logo',              label: 'Logo',              type: 'string' },
        { key: '_pnty_user_profile_image',label: 'Profile Image',     type: 'string' },
    ];

    var fieldsByKey = {};
    fields.forEach( function( field ) {
        fieldsByKey[ field.key ] = field;
    } );

    registerBlockBindingsSource( {
        name: 'pnty/fields',
        label: 'Ponty Fields',
        getFieldsList: function() {
            return fields.map( function( field ) {
                return {
                    label: field.label,
                    args: { key: field.key },
                    type: field.type,
                };
            } );
        },
        getValues: function( args ) {
            var bindings = args.bindings;
            var select = args.select;
            var context = args.context;
            var values = {};

            var meta = select( 'core/editor' ).getEditedPostAttribute( 'meta' );

            Object.keys( bindings ).forEach( function( attr ) {
                var key = bindings[ attr ].args.key;
                var field = fieldsByKey[ key ];
                if ( meta && meta[ key ] ) {
                    values[ attr ] = meta[ key ];
                } else if ( field ) {
                    values[ attr ] = field.label;
                }
            } );

            return values;
        },
    } );
} )();
