var columnDefs = [
    { field: 'athlete', width: 150 },
    { field: 'country', width: 150 },
    { field: 'year', width: 100 },
    { field: 'gold', width: 100, cellRenderer: 'medalCellRenderer' },
    { field: 'silver', width: 100, cellRenderer: 'medalCellRenderer' },
    { field: 'bronze', width: 100, cellRenderer: 'medalCellRenderer' },
    { field: 'total', width: 100 }
];

var gridOptions = {
    columnDefs: columnDefs,
    components: {
        'medalCellRenderer': MedalCellRenderer
    },
    defaultColDef: {
        editable: true,
        sortable: true,
        flex: 1,
        minWidth: 100,
        filter: true,
        resizable: true
    }
};

// cell renderer class
function MedalCellRenderer() { }

// init method gets the details of the cell to be renderer
MedalCellRenderer.prototype.init = function(params) {
    this.params = params;
    this.eGui = document.createElement('span');
    var text = '';
    // one star for each medal
    for (var i = 0; i < params.value; i++) {
        text += '#';
    }
    this.eGui.innerHTML = text;
};

MedalCellRenderer.prototype.getGui = function() {
    return this.eGui;
};

MedalCellRenderer.prototype.medalUserFunction = function() {
    console.log('user function called for medal column: row = ' + this.params.rowIndex
        + ', column = ' + this.params.column.getId());
};

function onCallGold() {
    console.log('=========> calling all gold');
    // pass in list of columns, here it's gold only
    var params = { columns: ['gold'] };
    var instances = gridOptions.api.getCellRendererInstances(params);
    instances.forEach(function(instance) {
        instance.medalUserFunction();
    });
}

function onFirstRowGold() {
    console.log('=========> calling gold row one');
    // pass in one column and one row to identify one cell
    var firstRowNode = gridOptions.api.getDisplayedRowAtIndex(0);
    var params = { columns: ['gold'], rowNodes: [firstRowNode] };

    var instances = gridOptions.api.getCellRendererInstances(params);
    instances.forEach(function(instance) {
        instance.medalUserFunction();
    });
}

function onCallAllCells() {
    console.log('=========> calling everything');
    // no params, goes through all rows and columns where cell renderer exists
    var instances = gridOptions.api.getCellRendererInstances();
    instances.forEach(function(instance) {
        instance.medalUserFunction();
    });
}

// setup the grid after the page has finished loading
document.addEventListener('DOMContentLoaded', function() {
    var gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);

    agGrid.simpleHttpRequest({ url: 'https://www.ag-grid.com/example-assets/olympic-winners.json' })
        .then(function(data) {
            gridOptions.api.setRowData(data);
        });
});
