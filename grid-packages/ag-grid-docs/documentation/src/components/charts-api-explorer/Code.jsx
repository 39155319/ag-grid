import React from 'react';
import { formatJson } from './utils.jsx';
import { CodeSnippet } from './CodeSnippet.jsx';
import styles from './Code.module.scss';

export const Code = ({ framework, options }) => {
    const codeMap = {
        javascript: VanillaCode,
        angular: AngularCode,
        react: ReactCode,
        vue: VueCode
    };

    const FrameworkCode = codeMap[framework];

    return <div className={styles['code']}>
        {FrameworkCode && <FrameworkCode options={options} />}
    </div>;
};

const VanillaCode = ({ options }) => {
    const lines = [];
    const extractLines = (prefix, object) => {
        if (Array.isArray(object) && ['chart.axes', 'chart.series'].indexOf(prefix) < 0) {
            // arrays should be specified in their entirety
            lines.push(`${prefix} = ${formatJson(object)};`);
            return;
        }

        Object.keys(object).forEach(key => {
            const value = object[key];

            if (typeof value === 'object') {
                extractLines(Array.isArray(object) ? `${prefix}[${key}]` : `${prefix}.${key}`, value);
            } else if (value != null) {
                lines.push(`${prefix}.${key} = ${formatJson(value)};`);
            }
        });
    };

    extractLines('chart', options);

    if (lines.length > 0) {
        lines.unshift('\n// update existing chart');
    }

    lines.unshift('// create new chart', `chart = AgChart.create(${formatJson(options)});`);

    return <CodeSnippet lines={lines} />;
};

const ReactCode = ({ options }) => <CodeSnippet lines={[`const options = ${formatJson(options)};`, '', '<AgChartsReact options={options} />']} language='jsx' />;

const AngularCode = ({ options }) => <React.Fragment>
    <CodeSnippet lines={[`const options = ${formatJson(options)};`]} />
    <CodeSnippet lines={['<ag-charts-angular [options]="options">', '</ag-charts-angular>']} language='html' />
</React.Fragment>;


const VueCode = ({ options }) => <React.Fragment>
    <CodeSnippet lines={[`const options = ${formatJson(options)};`]} />
    <CodeSnippet lines={['<ag-charts-vue :options="options"></ag-charts-vue>']} language='html' />
</React.Fragment>;
