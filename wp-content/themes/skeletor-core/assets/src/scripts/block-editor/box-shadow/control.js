import { PanelBody, SelectControl } from '@wordpress/components';
import { applyFilters } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';

export const BoxShadowControl = (props) => {
	const { boxShadow } = props.attributes;

	const boxShadowOptions = applyFilters('skeletor.boxShadowOptions', [
		{ label: __('Soft'), value: 'soft' },
		{ label: __('Hard'), value: 'hard' },
	]);

	return (
		<PanelBody
			className={'skeletor-inspector-control'}
			title={__('Box Shadow')}
			initialOpen={false}
		>
			<SelectControl
				value={boxShadow}
				options={[
					{ label: 'None', value: '' },
					...boxShadowOptions
				]}
				onChange={(boxShadow) => props.setAttributes({ boxShadow })}
			/>
		</PanelBody>
	);
};
