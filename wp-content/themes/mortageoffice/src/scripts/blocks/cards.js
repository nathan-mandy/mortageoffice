const { RichText, MediaUpload, PlainText } = wp.editor;
const { registerBlockType } = wp.blocks;
const { Button } = wp.components;

registerBlockType('card-block/main', {
    title: 'Platform Product Card',
    icon: 'products',
    category: 'common',

    attributes: {
        title: {
            source: 'text',
            selector: '.card_title',
        },
        heading: {
            source: 'text',
            selector: '.card_heading',
        },
        body: {
            type: 'array',
            source: 'children',
            selector: '.card_body',
        },
        imageAlt: {
            attribute: 'alt',
            selector: '.card_image',
        },
        imageUrl: {
            attribute: 'src',
            selector: '.card_image',
        },
        secondImageAlt: {
            attribute: 'alt',
            selector: '.card_second_image',
        },
        secondImageUrl: {
            attribute: 'src',
            selector: '.card_second_image',
        },
        buttonText: {
            type: 'string',
            source: 'text',
            selector: '.card_button',
        },
    },

    edit({ attributes, className, setAttributes }) {
        const getImageButton = (openEvent, imageUrl) => {
            if (imageUrl) {
                return <img src={imageUrl} onClick={openEvent} className="image" />;
            } else {
                return (
                    <div className="button-container">
                        <Button onClick={openEvent} className="button button-large">
                            Upload image
                        </Button>
                    </div>
                );
            }
        };

        return (
            <div className="product-card-container">
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
                        className="card-heading"
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
                />

                <div className="product-second-image">
                    <MediaUpload
                        onSelect={(media) =>
                            setAttributes({ secondImageAlt: media.alt, secondImageUrl: media.url })
                        }
                        type="image"
                        render={({ open }) => getImageButton(open, attributes.secondImageUrl)}
                    />
                </div>
                <PlainText
                    onChange={(content) => setAttributes({ buttonText: content })}
                    value={attributes.buttonText}
                    placeholder="Button Text"
                    className="card-button-text"
                />
            </div>
        );
    },

    save({ attributes }) {
        const cardImage = (src, alt, className) => {
            if (!src) return null;

            if (alt) {
                return <img className={className} src={src} alt={alt} />;
            }
            return <img className={className} src={src} alt="" aria-hidden="true" />;
        };

        return (
            <div className="product-card-container">
                <div className="product-icon-heading">
                    {cardImage(attributes.imageUrl, attributes.imageAlt, 'card_image')}
                    <h4 className="card-heading">{attributes.title}</h4>
                    <h2 className="card-title">{attributes.heading}</h2>
                    {attributes.body}
                </div>
                <div className="product-second-image">
                    {cardImage(attributes.secondImageUrl, attributes.secondImageAlt, 'card_second_image')}
                </div>
                <div className="card-button">
                    <button className="card_button">{attributes.buttonText}</button>
                </div>
            </div>
        );
    },
});
