import React, { Component } from 'react';
import { AgGridReact } from '@ag-grid-community/react';
import { AllCommunityModules } from '@ag-grid-community/all-modules';

import '@ag-grid-community/all-modules/dist/styles/ag-grid.css';
import '@ag-grid-community/all-modules/dist/styles/ag-theme-alpine.css';

export default class extends Component {
    constructor(props) {
        super(props);

        this.athleteVisible = true;
        this.ageVisible = true;
        this.countryVisible = true;
        this.rowData = null;
        this.bottomData = [
            {
                athlete: 'Total',
                age: '15 - 61',
                country: 'Ireland',
                year: '2020',
                date: '26/11/1970',
                sport: 'Synchronised Riding',
                gold: 55,
                silver: 65,
                bronze: 12
            }
        ];

        this.state = this.createState();
    }

    createState() {
        const topOptions = {
            alignedGrids: [],
            defaultColDef: {
                editable: true,
                sortable: true,
                resizable: true,
                filter: true,
                flex: 1,
                minWidth: 100
            },
            suppressHorizontalScroll: true
        };
        const bottomOptions = {
            alignedGrids: [],
            defaultColDef: {
                editable: true,
                sortable: true,
                resizable: true,
                filter: true,
                flex: 1,
                minWidth: 100
            }
        };

        topOptions.alignedGrids.push(bottomOptions);
        bottomOptions.alignedGrids.push(topOptions);

        return {
            topOptions,
            bottomOptions,
            columnDefs: [
                { field: 'athlete', width: 200, hide: !this.athleteVisible },
                { field: 'age', width: 150, hide: !this.ageVisible },
                { field: 'country', width: 150, hide: !this.countryVisible },
                { field: 'year', width: 120 },
                { field: 'date', width: 150 },
                { field: 'sport', width: 150 }
            ],
            bottomData: this.bottomData,
            rowData: this.rowData
        };
    }

    onGridReady(params) {
        this.topGrid = params;
        var httpRequest = new XMLHttpRequest();
        httpRequest.open('GET', 'https://www.ag-grid.com/example-assets/olympic-winners.json');
        httpRequest.send();
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var httpResult = JSON.parse(httpRequest.responseText);
                this.rowData = httpResult;
                this.setState(this.createState.bind(this));
            }
        }.bind(this);
    }

    onFirstDataRendered() {
        this.topGrid.columnApi.autoSizeAllColumns();
    }

    render() {
        return (
            <div style={{ display: 'flex', flexDirection: 'column', height: '100%' }} className="ag-theme-alpine">
                <div style={{ flex: '1 1 auto' }} >
                    <AgGridReact rowData={this.state.rowData}
                        gridOptions={this.state.topOptions}
                        columnDefs={this.state.columnDefs}
                        onGridReady={this.onGridReady.bind(this)}
                        onFirstDataRendered={this.onFirstDataRendered.bind(this)}
                        modules={AllCommunityModules} />
                </div>

                <div style={{ flex: 'none', height: '60px' }}>
                    <AgGridReact
                        rowData={this.state.bottomData}
                        gridOptions={this.state.bottomOptions}
                        columnDefs={this.state.columnDefs}
                        headerHeight="0"
                        modules={AllCommunityModules}
                        rowStyle={{ fontWeight: 'bold' }}
                    />
                </div>
            </div>
        );
    }
}
