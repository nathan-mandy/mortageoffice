import classnames from 'classnames';

import { tableAttributes } from './attributes';
import { TableSettingsControl } from './control';
import { getTableSettingsClassNames } from './helpers';

const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;

const BLOCK_NAME = 'core/table';

addFilter(
	'blocks.registerBlockType',
	'tableSettings.attributes',
	(settings, name) => {
		if (name !== BLOCK_NAME) {
			return settings;
		}

		return {
			...settings,
			attributes: {
				...settings.attributes,
				...tableAttributes,
			},
		};
	}
);

addFilter(
	'editor.BlockEdit',
	'headingSettings.control',
	createHigherOrderComponent((BlockEdit) => (props) => {
		if (props.name !== BLOCK_NAME) {
			return <BlockEdit {...props} />;
		}

		return (
			<>
				<BlockEdit {...props} />
				<InspectorControls>
					<TableSettingsControl {...props} />
				</InspectorControls>
			</>
		);
	}, 'withTableSettingsControl')
);


addFilter(
	'editor.BlockListBlock',
	'headingSettings.editorBlock',
	createHigherOrderComponent((BlockListBlock) => (props) => {
		if (props.name !== BLOCK_NAME) {
			return <BlockListBlock {...props} />;
		}

		const blockListProps = {
			...props,
			className: classnames(
				props.className,
				getTableSettingsClassNames(props.attributes)
			),
		};

		return <BlockListBlock {...blockListProps} />;
	})
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'headingSettings.className',
	(props, blockType, attributes) => {
		if (blockType.name !== BLOCK_NAME) {
			return props;
		}

		return {
			...props,
			className: classnames(
				props.className,
				getTableSettingsClassNames(attributes)
			),
		};
	}
);
