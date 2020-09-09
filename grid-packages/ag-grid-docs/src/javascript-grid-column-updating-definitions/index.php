<?php
$pageTitle = "Updating Columns";
$pageDescription = "Columns can be change by the grid, eg column width. This stateful parts of the column can be modified.";
$pageKeywords = "Javascript Grid Column State";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1>Updating Column Definitions</h1>

<p class="lead">
    The section <a href="../javascript-grid-column-definitions/">Column Definitions</a> explained how to
    configure columns. It is possible to change the configuration of the Columns after they are initially set.
    This section goes through how to update Column Definitions.
</p>

<h2 id="adding-removing-columns">Adding & Removing Columns</h2>

<p>
    It is possible to add and remove columns by updating the list of Column Definitions provided to the grid.
</p>

<p>
    When new columns are set, the grid will compare with current columns and work
    out which columns are old (to be removed), new (new columns created) or kept.
</p>

<p>
    The example below demonstrates adding and removing columns from a grid. Note the following:
</p>

<ul>
    <li>
        Selecting the buttons to toggle between including or excluding the medal columns.
    </li>
</ul>

<?= grid_example('Add & Remove Columns', 'add-remove-columns', 'mixed', ['modules' => true, 'reactFunctional' => true]) ?>

<p>
    In the example above, note that any state applied to any column (eg sort, filter, width, column position) will
    be kept if the column still exists after the new definitions are applied. For example try the following:
</p>
<ul>
    <li>Resize Country column. Note changing columns doesn't impact its width.</li>
    <li>Move Country column. Note changing columns doesn't impact its position.</li>
    <li>Sort Country column. Note changing columns doesn't impact its sort.</li>
</ul>

<h2 id="changing-column-definition">Updating Column Definitions</h2>

<p>
    All properties of a column definition can be updated. For example if you want to change the Header Name
    of a column, you update the <code>headerName</code> on the Column Definition and then set the list of
    Column Definitions into the grid again.
</p>

<p>
    It is not possible to update the Column Definition of just one column in isolation. Only a new set of
    Column Definitions can be applied.
</p>

<p>
    The example below demonstrates updating column definitions to change how columns are configured.
    Note the following:
</p>

<ul>
    <li>All Columns are provided with just the <code>field</code> attribute set on the Column Definition.</li>
    <li>
        'Set Header Names' and 'Remove Header Names' sets and then subsequently removes the <code>headerName</code>
        attribute on all Columns.
    </li>
    <li>
        'Set Value Formatter' and 'Remove Value Formatter' sets and then subsequently removes the
        <code>valueFormatter</code> attribute on all Columns.
    </li>
    <li>
        Headers refresh whenever new columns are set. However cells do not refresh, thus a call to
        <code>api.refreshCells({force: true})</code> is required. The refresh is forced so cells will
        be refreshed even though the underlying value for that cell hasn't changed.
    </li>
    <li>
        Note that any resizing, reordering, sorting etc of the Columns is kept intact between updates to the
        Column Definitions.
    </li>
</ul>

<?= grid_example('Updating Column Definition', 'update-column-definition', 'mixed', ['modules' => true, 'reactFunctional' => true]) ?>

<h2 id="changing-column-state">Changing Column State</h2>

<p>
    Parts of the Column Definitions represent Column State. Column State is stateful information and represents
    changing values of the grid.
</p>

<p>
    All stateful attributes of Column Definitions are as follows:
</p>

<?php
    function addItemToTable($key, $defaultKey, $desc) {
        echo("<tr><td><code>$key</code></td><td><code>$defaultKey</code></td><td>$desc</td></tr>");
    }
?>

<table class="table properties">
    <tr>
        <th>Stateful Attribute</th>
        <th>Initial Attribute</th>
        <th>Description</th>
    </tr>
    <?=addItemToTable('width','initialWidth','Width of the column.')?>
    <?=addItemToTable('flex','initialFlex','The flex value for setting this columns width.')?>
    <?=addItemToTable('hide','initialHide','Whether this column should be hidden.')?>
    <?=addItemToTable('pinned','initialPinned','Whether this column should be pinned.')?>
    <?=addItemToTable('sort','initialSort','The sort to apply to this column.')?>
    <?=addItemToTable('sortIndex','initialSortIndex','The order to apply sorting, if multi column sorting.')?>
    <?=addItemToTable('rowGroup','initialRowGroup','Whether this column should be a row group.')?>
    <?=addItemToTable('rowGroupIndex','initialRowGroupIndex','Whether this column should be a row group and in what order.')?>
    <?=addItemToTable('pivot','initialPivot','If this column should be a pivot.')?>
    <?=addItemToTable('pivotIndex','initialPivotIndex','Whether this column should be a pivot and in what order.')?>
    <?=addItemToTable('aggFunc','initialAggFunc','The function to aggregate this column by if row grouping or pivoting.')?>
</table>

<note>
    <p>
        If you are interested in changing Column State only and not the other parts of the column definitions,
        then consider working with the <a href="../javascript-grid-column-state/">Column State</a> API instead.
    </p>
    <p>
        Column State is provided as part of Column Definitions to enable these properties to be reactive. Some
        developers wish to update Column Definitions and expect the grid to respond. Other developers may find
        this non-intuitive and will prefer interacting with <a href="../javascript-grid-column-state/">Column State</a>
        direction.
    </p>
</note>

<p>
    The <b>Initial Attribute</b> will be used only when the
    <b>Column is Created</b> only. The <b>Stateful Attribute</b> will be used when the <b>Column
    is Created or Updated</b>.
</p>

<?= createSnippet(<<<SNIPPET
// using initial values, get applied when Column is created
myInitialValuesColDef = {
    field: 'country',
    initialWidth: 200,
    initialPinned: 'left'
}

// using stateful values, get applied when Column is created or updated
myStatefulColDef = {
    field: 'country',
    width: 200,
    pinned: 'left'
}
SNIPPET
) ?>

<p>
    The example below shows Column Definitions using <b>initial attributes</b>. Note the following:
</p>
<ul>
    <li>
        The <code>initialWidth</code>, <code>initialSort</code> and <code>initialPinned</code>
        is applied only when the columns are created.
    </li>
    <li>
        If you update the width, sort or pinned of a column by interacting with the grid's UI
        and then hit 'Set Columns with Initials', the columns state will not change.
    </li>
    <li>
        Removing the columns first and then setting them again will use the initial values again.
    </li>
</ul>
<?= grid_example('Updating Column Initials', 'changing-default', 'mixed', ['modules' => true, 'reactFunctional' => true]) ?>

<br/>
<p>
    The following example shows Column Definitions using <b>stateful attributes</b>. Note the following:
</p>
<ul>
    <li>
        The <code>width</code>, <code>sort</code> and <code>pinned</code>
        stateful attributes are applied whenever Column Definitions are set.
    </li>
    <li>
        If you update the width, sort or pinned of a column by interacting with the grid's UI
        and then hit 'Set Columns with State', the columns state will change and the changes made via the UI will be lost.
    </li>
    <li>
        Note the <code>defaultColDef</code> is used to remove state. For example <code>sort=null</code>
        is set so that any sorting the user might of done on another column is cleared down. Otherwise
        the grid would see the <code>sort</code> attribute as <code>undefined</code> which means
        the state should not be changed.
    </li>
</ul>

<?= grid_example('Updating Column State', 'changing-state', 'mixed', ['modules' => true, 'reactFunctional' => true]) ?>

<h2>Null vs Undefined</h2>

<p>
    When a stateful attribute is set to <code>undefined</code> the grid ignores the attribute.
</p>

<p>
    When a stateful attribute is set to <code>null</code> the grid clears the attribute.
</p>

<p>
    For example the setting <code>pinned=null</code> will clear pinning on a column whereas
    <code>pinned=undefined</code> means the grid will leave pinned state as it is for that column.
</p>

<p>
    If you don't want to upset any column state (e.g. if you don't want to undo any change the user
    has made to the columns via the grid's UI, such as applying a sort by clicking on a header,
    or dragging a column's width) then do not set the state attributes as by default they will
    be <code>undefined</code>.
</p>

<h2 id="applying-column-order">Applying Column Order</h2>

<p>
    When Column Definitions are provided for existing Columns, the order of the Columns inside the grid
    is not changed to match the order of the newly provided Column Definitions. This is by design so
    that any reordering of the columns a user does to the grid is not lost when the Column Definitions
    get updated.
</p>

<p>
    If the desired behaviour is that Columns should be ordered to match the new set of Column Definitions,
    then set the grid property <code>applyColumnDefOrder=true</code>.
</p>

<p>
    The example below demonstrates applying the Column Definitions order to the grid Columns after
    new Column Definitions are set. Both buttons Medals First and Medals Last set the same Columns but
    in a different order.
</p>

<?= grid_example('Column Definition Order', 'col-def-order', 'mixed', ['modules' => true, 'reactFunctional' => true]) ?>

<h2 id="matching-columns">Matching Columns</h2>

<p>
    When a new Column Definition is passed to the grid, the grid needs to work out if it's an update
    of a Column or a new Column.
</p>
<p>
    Most of the time the <code>field</code> attribute to match the Column.
    However <code>field</code> is both an optional and non-unique attribute,
    e.g. a <code>valueGetter</code> could be used instead of field, or two columns
    could share the same field.
</p>

<p>
    Given the <code>field</code> is not a unique identifier, the grid uses the following rules
    to match columns:
</p>
<ol>
    <li>If <code>colId</code> provided, match using <code>colId</code></li>
    <li>Otherwise if <code>field</code> provided, match using <code>field</code></li>
    <li>Otherwise match using object equality on Column Definition instance</li>
</ol>

<p>
    In other words, to have the grid correctly match Columns make sure each Column has either a
    <code>field</code> or <code>colId</code>.
</p>

<p>
    The example below demonstrates the different matching strategies. Note the following:
</p>

<ul>
    <li>
        All columns, with the exception of Country, are matched correctly. This means
        any column width, sort, position etc will be kept between changes to the columns.
        Country will have its state reset, as it will be treated as a new column each time.
    </li>
    <li>
        Athlete column is matched by object equality as the same column definition instance
        is provided to the grid each time.
    </li>
    <li>
        Age column is matched by <code>colId</code>. The <code>colId</code> is needed as the
        column has no <code>field</code> attribute.
    </li>
    <li>
        All other columns except Country are matched using the <code>field</code> attribute.
    </li>
    <li>
        Country column is not matched as it's a different object instance and has not <code>colId</code>
        or <code>field</code> attributes.
    </li>
</ul>

<?= grid_example('Matching Columns', 'matching-columns', 'mixed', ['modules' => true, 'reactFunctional' => true]) ?>

<h2>Column Events</h2>

<p>
    Column Events will get raised when setting new Column Definitions that update the current Columns.
    For example <code>columnPinned</code> event will get raised if applying the state results in a column getting
    pinned or unpinned.
</p>

<p>
    The example below demonstrates events getting raised based on Column Definition changes.
    The example logs event information to the console, so best open the example in
    a new tab and observe the dev console.
</p>

<?= grid_example('Column Events', 'column-events', 'mixed', ['enterprise' => true, 'reactFunctional' => true]) ?>

<p>
    To suppress events raised when invoking <code>applyColumnState()</code>
    set the grid property <code>suppressColumnStateEvents=true</code>.
</p>

<h2>Refreshing Headers</h2>

<p>
    If you are creating your own <a href="../javascript-grid-header-rendering/">Header Components</a> then
    you will need to be aware of how Header Components are refreshed.
</p>

<p>
    All Header Components that still exist after the new Column Definitions are applied (in other words, the
    Column still exists after the update, it was not removed) will have its <code>refresh</code> method
    called.
</p>

<p>
    It is up to the Header Component to update based on any changes it may find in the Column Definition.
</p>

<p>
    The example below demonstrates refreshing of the headers. Note the following:
</p>
<ul>
    <li>
        Each column is configured to use a custom Header Component.
    </li>
    <li>
        The Header Component logs to the console
        when its methods <code>init</code>, <code>refresh</code> and <code>destroy</code> are called.
    </li>
    <li>
        Toggling between 'Upper Header Names' and 'Lower Header Names' causes the Header Component to refresh.
        The Header Component refreshes itself and returns <code>true</code>.
    </li>
    <li>
        Toggling between 'Filter On' and 'Filter Off' causes the Header Component to refresh.
        The Header Component returns <code>false</code> which results in the component getting destroyed and recreated.
    </li>
    <li>
        Toggling between 'Resize On' and 'Resize Off' causes the Header Component to refresh.
        However there is no change to the Header Component as it doesn't depend on resize - the resize UI
        is provided by the grid.
    </li>
</ul>

<?= grid_example('Refresh Headers', 'refresh-headers', 'mixed', ['reactFunctional' => true]) ?>

<h2>Column Definition Retrieval</h2>

<p>There will be times where you'll want to retrieve the current Column Definition in order to perhaps persist them,
    or perhaps retrieve, alter and then re-apply the modified columns.</p>

<p>The current column definitions can be retrieved with <code>getColumnDefs</code>:</p>

<?= createSnippet(<<<SNIPPET
gridOptions.api.getColumnDefs();
SNIPPET
) ?>

<?php include '../documentation-main/documentation_footer.php';?>
