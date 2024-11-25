import classnames from 'classnames';

export const getTableSettingsClassNames = ({ hasMinWidthOverflow }) => {
	return classnames({
		'has-min-width-overflow': hasMinWidthOverflow
	});
}
