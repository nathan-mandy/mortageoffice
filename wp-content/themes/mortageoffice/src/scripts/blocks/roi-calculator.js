import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

(function () {
    /**
     * Backend: Gutenberg Block Registration
     */
    registerBlockType('custom/roi-calculator', {
        title: 'ROI Calculator',
        icon: 'calculator',
        category: 'widgets',

        attributes: {
            investment: { type: 'number', default: 1000 },
            returnPercentage: { type: 'number', default: 10 },
            performing: { type: 'number', default: 1 },
        },

        edit: ({ attributes, setAttributes }) => {
            const { investment, returnPercentage, performing } = attributes;

            // Function to calculate ROI
            const calculateROI = () => {
                return (investment * returnPercentage) / 100;
            };

            // Function to calculate Non-Performing Value
            const calculatePerforming = () => {
                return (investment * returnPercentage * performing) / 100;
            };

            return (
                <div>
                    <InspectorControls>
                        <PanelBody title="Initial Values">
                            <RangeControl
                                label="Investment Amount"
                                value={investment}
                                onChange={(value) => setAttributes({ investment: value })}
                                min={100}
                                max={10000}
                            />
                            <RangeControl
                                label="Return Percentage"
                                value={returnPercentage}
                                onChange={(value) => setAttributes({ returnPercentage: value })}
                                min={1}
                                max={100}
                            />
                            <RangeControl
                                label="Non-Performing Percentage"
                                value={performing}
                                onChange={(value) => setAttributes({ performing: value })}
                                min={1}
                                max={100}
                            />
                        </PanelBody>
                    </InspectorControls>
                    <div><label>Select number of lorem ipsum dolor set undarspice</label></div>
                    <div className="roi-calculator-container">
                        <div className="roi-slider">
                            <label htmlFor="investment">Investment:</label>
                            <input
                                type="range"
                                id="investment"
                                min="100"
                                max="10000"
                                value={investment}
                                onChange={(e) => setAttributes({ investment: parseFloat(e.target.value) })}
                            />
                            <span>${investment}</span>
                        </div>
                        <div className="roi-slider">
                            <label htmlFor="return-percentage">Return Percentage:</label>
                            <input
                                type="range"
                                id="return-percentage"
                                min="1"
                                max="100"
                                value={returnPercentage}
                                onChange={(e) =>
                                    setAttributes({ returnPercentage: parseFloat(e.target.value) })
                                }
                            />
                            <span>{returnPercentage}%</span>
                        </div>
                        <div className="roi-slider">
                            <label htmlFor="non-perfoming">Non-Performing Percentage:</label>
                            <input
                                type="range"
                                id="non-perfoming"
                                min="1"
                                max="100"
                                value={performing}
                                onChange={(e) =>
                                    setAttributes({ performing: parseFloat(e.target.value) })
                                }
                            />
                            <span>{performing}%</span>
                        </div>
                        <p>
                            ROI: <strong>${calculateROI().toFixed(2)}</strong>
                        </p>
                        <p>
                            Non-Performing: <strong>${calculatePerforming().toFixed(2)}</strong>
                        </p>
                    </div>
                </div>
            );
        },

        save: ({ attributes }) => {
            const { investment, returnPercentage, performing } = attributes;

            return (
                <div
                    className="roi-calculator-container"
                    data-investment={investment}
                    data-return={returnPercentage}
                    data-performing={performing}
                >
                     <div><label>Select number of lorem ipsum dolor set undarspice</label></div>
                    <div className="roi-slider">
                        <label htmlFor="investment">Investment:</label>
                        <input
                            type="range"
                            id="investment"
                            min="100"
                            max="10000"
                            step="100"
                            defaultValue={investment}
                            data-role="investment"
                        />
                        <span id="investment-value">${investment}</span>
                    </div>
                    <div className="roi-slider">
                        <label htmlFor="return-percentage">Return Percentage:</label>
                        <input
                            type="range"
                            id="return-percentage"
                            min="1"
                            max="100"
                            step="1"
                            defaultValue={returnPercentage}
                            data-role="return"
                        />
                        <span id="return-value">{returnPercentage}%</span>
                    </div>
                    <div className="roi-slider">
                        <label htmlFor="non-perfoming">Non-Performing Percentage:</label>
                        <input
                            type="range"
                            id="non-perfoming"
                            min="1"
                            max="100"
                            step="1"
                            defaultValue={performing}
                            data-role="performing"
                        />
                        <span id="performing-value">{performing}%</span>
                    </div>
                    <p>
                        ROI: <span id="roi-value">0</span>
                    </p>
                    <p>
                        Non-Performing: <span id="non-performing-value">0</span>
                    </p>
                </div>
            );
        },
    });

    /**
     * Frontend: Dynamic ROI Calculation
     */
    document.addEventListener('DOMContentLoaded', () => {
        const containers = document.querySelectorAll('.roi-calculator-container');

        containers.forEach((container) => {
            const investmentInput = container.querySelector('[data-role="investment"]');
            const returnInput = container.querySelector('[data-role="return"]');
            const performingInput = container.querySelector('[data-role="performing"]');
            
            const roiValue = container.querySelector('#roi-value');
            const investmentDisplay = container.querySelector('#investment-value');
            const returnDisplay = container.querySelector('#return-value');
            const performingDisplay = container.querySelector('#performing-value');
            const nonPerformingValueDisplay = container.querySelector('#non-performing-value'); // Non-performing display

            // Calculate ROI
            const calculateROI = () => {
                const investment = parseFloat(investmentInput.value);
                const returnPercentage = parseFloat(returnInput.value);
                const roi = (investment * returnPercentage) / 100;
                roiValue.textContent = `$${roi.toFixed(2)}`;
            };

            // Calculate Non-Performing Value
            const calculateNonPerforming = () => {
                const investment = parseFloat(investmentInput.value);
                const returnPercentage = parseFloat(returnInput.value);
                const performing = parseFloat(performingInput.value);
                const nonPerforming = (investment * returnPercentage * performing) / 10000; // Correct calculation
                nonPerformingValueDisplay.textContent = `$${nonPerforming.toFixed(2)}`;
            };

            // Event listeners for the input sliders
            investmentInput.addEventListener('input', () => {
                investmentDisplay.textContent = `$${investmentInput.value}`;
                calculateROI();
                calculateNonPerforming(); // Update non-performing value
            });

            returnInput.addEventListener('input', () => {
                returnDisplay.textContent = `${returnInput.value}%`;
                calculateROI();
                calculateNonPerforming(); // Update non-performing value
            });

            performingInput.addEventListener('input', () => {
                performingDisplay.textContent = `${performingInput.value}%`;
                calculateNonPerforming(); // Update non-performing value
            });

            // Initialize values on page load
            calculateROI();
            calculateNonPerforming(); // Initialize non-performing value
        });
    });
})();
