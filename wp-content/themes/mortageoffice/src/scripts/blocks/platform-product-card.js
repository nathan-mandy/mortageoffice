const { registerBlockType } = wp.blocks;
const { MediaUpload, RichText, PlainText, InspectorControls } = wp.blockEditor;
const { Button, PanelBody, ColorPalette } = wp.components;
const { __ } = wp.i18n;
const { useSelect } = wp.data;

registerBlockType('card-block/main', {
    title: 'Platform Product Card',
    icon: 'products',
    category: 'common',

    attributes: {
        title: {
            type: 'string',
            source: 'text',
            selector: '.card-heading',
        },
        heading: {
            type: 'string',
            source: 'text',
            selector: '.card-title',
        },
        body: {
            type: 'string',
            source: 'html',
            selector: '.hover-content p',
        },
        imageAlt: {
            type: 'string',
            attribute: 'alt',
            selector: '.card_image',
        },
        imageUrl: {
            type: 'string',
            attribute: 'src',
            selector: '.card_image',
        },
        secondImageAlt: {
            type: 'string',
            attribute: 'alt',
            selector: '.card_second_image',
        },
        secondImageUrl: {
            type: 'string',
            attribute: 'src',
            selector: '.card_second_image',
        },
        buttonText: {
            type: 'string',
            source: 'text',
            selector: '.wp-block-button__link',
        },
        backgroundColor: {
            type: 'string',
            default: '', // Default background color
        },
    },

    supports: {
        html: false, // Prevents direct HTML editing to avoid mismatch issues
    },

    edit({ attributes, setAttributes }) {
        // Fetch theme colors dynamically using useSelect
        const colors = useSelect(
            (select) => select('core/block-editor').getSettings().colors,
            []
        );

        const getImageButton = (openEvent, imageUrl) => {
            if (imageUrl) {
                return <img src={imageUrl} onClick={openEvent} className="image" />;
            }
            return (
                <div className="button-container">
                    <Button onClick={openEvent} className="button button-large">
                        Upload image
                    </Button>
                </div>
            );
        };

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Background Settings', 'Mortageoffice')}>
                        <ColorPalette
                            colors={colors}
                            value={attributes.backgroundColor}
                            onChange={(newColor) => setAttributes({ backgroundColor: newColor })}
                        />
                    </PanelBody>
                </InspectorControls>
                <div
                    className="product-card-container"
                    style={{ backgroundColor: attributes.backgroundColor }}
                >
                    <div className="product-icon-heading">
                        <MediaUpload
                            onSelect={(media) =>
                                setAttributes({ imageAlt: media.alt, imageUrl: media.url })
                            }
                            type="image"
                            render={({ open }) => getImageButton(open, attributes.imageUrl)}
                        />
                        <PlainText
                            onChange={(content) => setAttributes({ title: content })}
                            value={attributes.title}
                            placeholder="Your card title"
                            className="card-heading is-style-eyebrow-heading"
                        />
                    </div>
                    <PlainText
                        onChange={(content) => setAttributes({ heading: content })}
                        value={attributes.heading}
                        placeholder="Your card heading"
                        className="card-title"
                    />
                    <RichText
                        onChange={(content) => setAttributes({ body: content })}
                        value={attributes.body}
                        multiline="p"
                        placeholder="Card Text"
                        className="hover-content"
                    />
                    <div className="product-second-image">
                        <MediaUpload
                            onSelect={(media) =>
                                setAttributes({
                                    secondImageAlt: media.alt,
                                    secondImageUrl: media.url,
                                })
                            }
                            type="image"
                            render={({ open }) => getImageButton(open, attributes.secondImageUrl)}
                        />
                    </div>
                    <PlainText
                        onChange={(content) => setAttributes({ buttonText: content })}
                        value={attributes.buttonText}
                        placeholder="Button Text"
                        className="wp-block-button__link"
                    />
                </div>
            </>
        );
    },

    save({ attributes }) {
        return (
            <div
                className="product-card-container"
                style={{ backgroundColor: attributes.backgroundColor }}
            >
                <div className="product-icon-heading">
                    {attributes.imageUrl && (
                        <img
                            className="card_image"
                            src={attributes.imageUrl}
                            alt={attributes.imageAlt || ''}
                        />
                    )}
                    <h4 className="card-heading is-style-eyebrow-heading">{attributes.title}</h4>
                </div>
                <div className="product-second-image">
                    <h2 className="card-title">{attributes.heading}</h2>
                    {attributes.secondImageUrl && (
                        <img
                            className="card_second_image"
                            src={attributes.secondImageUrl}
                            alt={attributes.secondImageAlt || ''}
                        />
                    )}
                </div>
                <div className="hover-content">
                    {attributes.body && (
                        <RichText.Content tagName="p" value={attributes.body} />
                    )}
                    <div className="wp-block-button">
                        <a className="wp-block-button__link">{attributes.buttonText}</a>
                    </div>
                </div>
            </div>
        );
    },
});
