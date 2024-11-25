const { __ } = wp.i18n;

const { PanelBody, ToggleControl } = wp.components;

export const TableSettingsControl = (props) => {
	const { hasMinWidthOverflow } = props.attributes;

	return (
		<PanelBody
			className={'skeletor-inspector-control'}
			title={__('Extra Table Settings')}
		>
			<ToggleControl
				label={__("Has Min-Width & Overflow")}
				checked={hasMinWidthOverflow}
				onChange={(hasMinWidthOverflow) => props.setAttributes({ hasMinWidthOverflow }) }
				help={__("Force the table to display with a minimum width that matches the base content-width and with an overflow scroll. This will allow the table to maintain horizontal display on smaller screens.")}
			/>
		</PanelBody>
	);
};

