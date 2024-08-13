( function( blocks, editor, element ) {
    var el = element.createElement;
    var RichText = editor.RichText;

    blocks.registerBlockType( 'my-cool-shortcodes/my-custom-block', {
        title: 'My Cool Shortcode',
        icon: 'shortcode',
        category: 'widgets',

        edit: function( props ) {
            return el(
                'div',
                { className: props.className },
                el(
                    RichText,
                    {
                        tagName: 'p',
                        placeholder: 'Enter your content...',
                        value: props.attributes.content,
                        onChange: function( newContent ) {
                            props.setAttributes( { content: newContent } );
                        }
                    }
                )
            );
        },

        save: function( props ) {
            return el( RichText.Content, {
                tagName: 'p',
                value: props.attributes.content
            } );
        }
    } );
} )( window.wp.blocks, window.wp.editor, window.wp.element );
