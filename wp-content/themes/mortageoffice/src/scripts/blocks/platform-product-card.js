const { registerBlockType } = wp.blocks;
const { RichText, MediaUpload, InspectorControls, ColorPalette } = wp.blockEditor;
const { PanelBody, Button } = wp.components;

registerBlockType('card-block/main', {
    title: 'Platform Product Card',
    icon: 'products',
    category: 'common',

    attributes: {
        title: { type: 'string', source: 'html', selector: '.card-heading', default: '' },
        heading: { type: 'string', source: 'html', selector: '.card-title', default: '' },
        body: { type: 'string', source: 'html', selector: '.hover-content p', default: '' },
        imageAlt: { type: 'string', attribute: 'alt', selector: '.card_image', default: '' },
        imageUrl: { type: 'string', attribute: 'src', selector: '.card_image', default: '' },
        secondImageAlt: { type: 'string', attribute: 'alt', selector: '.card_second_image', default: '' },
        secondImageUrl: { type: 'string', attribute: 'src', selector: '.card_second_image', default: '' },
        buttonText: { type: 'string', source: 'html', selector: '.wp-block-button__link', default: '' },
        backgroundColor: { type: 'string', default: '#ffffff' },
    },

    edit({ attributes, setAttributes }) {
        const {
            title,
            heading,
            body,
            imageAlt,
            imageUrl,
            secondImageAlt,
            secondImageUrl,
            buttonText,
            backgroundColor,
        } = attributes;

        const onImageSelect = (image) => setAttributes({ imageUrl: image.url, imageAlt: image.alt });
        const onSecondImageSelect = (image) =>
            setAttributes({ secondImageUrl: image.url, secondImageAlt: image.alt });

        return (
            <div>
                <InspectorControls>
                    <PanelBody title="Background Color" initialOpen={true}>
                        <ColorPalette
                            value={backgroundColor}
                            onChange={(color) => setAttributes({ backgroundColor: color })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div
                    className="product-card-container"
                    style={{ backgroundColor: backgroundColor }}
                >
                    <div className="product-icon-heading">
                        <MediaUpload
                            onSelect={onImageSelect}
                            allowedTypes={['image']}
                            render={({ open }) => (
                                <Button className="button" onClick={open}>
                                    {!imageUrl ? 'Upload Image' : <img className="card_image" src={imageUrl} alt={imageAlt} />}
                                </Button>
                            )}
                        />
                        <RichText
                            tagName="h4"
                            placeholder="Enter Title"
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                            className="card-heading"
                        />
                    </div>

                    <div className="product-second-image">
                        <RichText
                            tagName="h2"
                            placeholder="Enter Heading"
                            value={heading}
                            onChange={(value) => setAttributes({ heading: value })}
                            className="card-title"
                        />
                        <MediaUpload
                            onSelect={onSecondImageSelect}
                            allowedTypes={['image']}
                            render={({ open }) => (
                                <Button className="button" onClick={open}>
                                    {!secondImageUrl ? 'Upload Second Image' : <img className="card_second_image" src={secondImageUrl} alt={secondImageAlt} />}
                                </Button>
                            )}
                        />
                    </div>

                    <div className="hover-content">
                        <RichText
                            tagName="p"
                            placeholder="Enter Card Text"
                            value={body}
                            onChange={(value) => setAttributes({ body: value })}
                        />
                        <div className="wp-block-button">
                            <RichText
                                tagName="a"
                                placeholder="Enter Button Text"
                                value={buttonText}
                                onChange={(value) => setAttributes({ buttonText: value })}
                                className="wp-block-button__link"
                            />
                        </div>
                    </div>
                </div>
            </div>
        );
    },

    save({ attributes }) {
        const {
            title,
            heading,
            body,
            imageAlt,
            imageUrl,
            secondImageAlt,
            secondImageUrl,
            buttonText,
            backgroundColor,
        } = attributes;

        return (
            <div
                className="product-card-container"
                style={{ backgroundColor: backgroundColor }}
            >
                <div className="product-icon-heading">
                    {imageUrl && <img className="card_image" src={imageUrl} alt={imageAlt} />}
                    <RichText.Content tagName="h4" value={title} className="card-heading" />
                </div>

                <div className="product-second-image">
                    <RichText.Content tagName="h2" value={heading} className="card-title" />
                    {secondImageUrl && <img className="card_second_image" src={secondImageUrl} alt={secondImageAlt} />}
                </div>

                <div className="hover-content">
                    {body && <RichText.Content tagName="p" value={body} />}
                    {buttonText && (
                        <div className="wp-block-button">
                            <RichText.Content tagName="a" value={buttonText} className="wp-block-button__link" />
                        </div>
                    )}
                </div>
            </div>
        );
    },
});
