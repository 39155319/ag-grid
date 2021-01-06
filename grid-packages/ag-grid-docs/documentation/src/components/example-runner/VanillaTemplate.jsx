import React from 'react';
import ReactDOMServer from 'react-dom/server';
import ExampleStyle from './ExampleStyle';
import Extras from './Extras';
import { localPrefix, agGridVersion, agChartsVersion } from './consts';
import { getCssFilePaths, isDevelopment, isUsingPublishedPackages } from './helpers';
import Scripts from './Scripts';
import Styles from './Styles';

const VanillaTemplate = ({ library, appLocation, options, scriptFiles, styleFiles, indexFragment }) =>
    <html lang="en">
        <head>
            <title>JavaScript example</title>
            <ExampleStyle />
            <VanillaStyles library={library} files={styleFiles} />
            <Extras options={options} />
        </head>
        <VanillaBody
            library={library}
            appLocation={appLocation}
            options={options}
            scriptFiles={scriptFiles}
            indexFragment={indexFragment} />
    </html>;

// we have to use this function to avoid a wrapping div around the fragment
const VanillaBody = ({ library, appLocation, options, scriptFiles, indexFragment }) => {
    let scriptPath;

    if (library === 'charts') {
        scriptPath = isUsingPublishedPackages() ?
            `https://unpkg.com/ag-charts-community@${agChartsVersion}/dist/ag-charts-community.min.js` :
            `${localPrefix}/ag-charts-community/dist/ag-charts-community.js`;
    } else {
        if (options.enterprise) {
            scriptPath = isUsingPublishedPackages() ?
                `https://unpkg.com/@ag-grid-enterprise/all-modules@${agGridVersion}/dist/ag-grid-enterprise.min.js` :
                `${localPrefix}/@ag-grid-enterprise/all-modules/dist/ag-grid-enterprise.js`;
        } else {
            scriptPath = isUsingPublishedPackages() ?
                `https://unpkg.com/@ag-grid-community/all-modules@${agGridVersion}/dist/ag-grid-community.min.js` :
                `${localPrefix}/@ag-grid-community/all-modules/dist/ag-grid-community.js`;
        }
    }

    const bodySuffix = ReactDOMServer.renderToStaticMarkup(
        <>
            <script dangerouslySetInnerHTML={{ __html: `var __basePath = '${appLocation}';` }}></script>
            <script src={scriptPath}></script>
            <Scripts files={scriptFiles} />
        </>
    );

    return <body dangerouslySetInnerHTML={{ __html: `${indexFragment}\n${bodySuffix}` }}></body>;
};

const VanillaStyles = ({ library, files }) => {
    if (!isDevelopment() || library !== 'grid') { return <Styles files={files} />; }

    const cssPaths = getCssFilePaths();

    return <Styles files={[...cssPaths, ...files]} />;
};

export default VanillaTemplate;