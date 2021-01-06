var columnDefs = [
    { field: "athlete" },
    { field: "age", width: 100 },
    { field: "country", sort: 'asc' },
    { field: "year" },
    { field: "date" },
    { field: "sport" },
    { field: "gold" },
    { field: "silver" },
    { field: "bronze" },
    { field: "total" }
];

var gridOptions = {
    columnDefs: columnDefs,
    defaultColDef: {
        width: 170,
        sortable: true
    },
    postSort: function(rowNodes) {
        // here we put Ireland rows on top while preserving the sort order

        function isIreland(node) {
            return node.data.country === "Ireland";
        }

        function move(toIndex, fromIndex) {
            rowNodes.splice(toIndex, 0, rowNodes.splice(fromIndex, 1)[0]);
        }

        var nextInsertPos = 0;
        for (var i = 0; i < rowNodes.length; i++) {
            if (isIreland(rowNodes[i])) {
                move(nextInsertPos, i);
                nextInsertPos++;
            }
        }
    }
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
