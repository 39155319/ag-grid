var gridOptions = {
    columnDefs: [
        {
            headerName: 'Participant',
            children: [
                { field: "athlete" },
                { field: "age" }
            ]
        },
        {
            headerName: 'Details',
            children: [
                { field: "country" },
                { field: "year" },
                { field: "date" },
                { field: "sport" }
            ]
        }
    ],
    defaultColDef: {
        flex: 1,
        resizable: true
    },
    columnHoverHighlight: true
};

// setup the grid after the page has finished loading
document.addEventListener('DOMContentLoaded', function() {
    var gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);

    agGrid.simpleHttpRequest({ url: 'https://www.ag-grid.com/example-assets/olympic-winners.json' })
        .then(function(data) {
            gridOptions.api.setRowData(data);
        });
});
