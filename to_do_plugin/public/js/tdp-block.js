( function( blocks, element, editor ) {
    var el = element.createElement;
    var RichText = editor.RichText;

    blocks.registerBlockType( 'tdp/tdp-block', {
        title: 'TDP Block',
        icon: 'smiley',
        category: 'common',
        attributes: {
            content: {
                default:'[tpd_latest_five]'
            },
        },
        edit: function( props ) {
            var content = props.attributes.content;

            function onChangeContent( newContent ) {
                props.setAttributes( { content: newContent } );
            }

            return el(
                RichText,
                {
                    tagName: 'p',
                    className: props.className,
                    onChange: onChangeContent,
                    value: content,
                }
            );
        },
        save: function( props ) {
            return el( RichText.Content, {
                tagName: 'p',
                value: props.attributes.content,
            } );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.editor );