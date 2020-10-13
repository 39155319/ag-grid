<?php
$pageTitle = "Updating Columns";
$pageDescription = "Columns can be change by the grid, eg column width. This stateful parts of the column can be modified.";
$pageKeywords = "Javascript Grid Column State";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1>Column State</h1>

<p class="lead">
    <a href="../javascript-grid-column-definitions/">Column Definitions</a> contain both stateful and non-stateful
    attributes. Stateful attributes can have their values changed by the grid (eg Column sort can be changed
    by the user clicking on the column header).
    Non-stateful attributes do not change from what is set in the Column Definition (eg once the Header
    Name is set as part of a Column Definition, it typically does not change).
</p>

<p>
    The full list of stateful attributes of Columns are as follows:
</p>

<ul class="content">
    <li>Width</li>
    <li>Flex</li>
    <li>Pinned</li>
    <li>Sort</li>
    <li>Hide</li>
    <li>AggFunc</li>
    <li>Row Group</li>
    <li>Pivot</li>
    <li>Column Order</li>
</ul>

<p>
    This section details how such state items can be changed.
</p>

<h2 id="save-and-apply">Save and Apply State</h2>

<p>
    There are two API methods provided for getting and setting Column State.
    <code>columnApi.getColumnState()</code> gets the current column state and
    <code>columnApi.applyColumnState()</code> sets the column state.
</p>

<?= createSnippet(<<<SNIPPET
// save the columns state
let savedState = columnApi.getColumnState();

// restore the column state
columnApi.applyColumnsState({ state: savedState });
SNIPPET
) ?>

<p>
    The example below demonstrates saving and restoring column state. Try the following:
</p>
<ol class="content">
    <li>Click 'Save State' to save the Column State.</li>
    <li>Change some column state e.g. resize columns, move columns around, apply column sorting or row grouping etc.</li>
    <li>Click 'Restore State' and the columns state is set back to where it was when you clicked 'Save State'.</li>
    <li>Click 'Reset State' and the state will go back to what was defined in the Column Definitions.</li>
</ol>

<?= grid_example('Save and Apply State', 'save-apply-state', 'generated', ['enterprise' => true]) ?>

<h2>Column State Interface</h2>

<p>
    The structure of a Column State is as follows:
</p>

<?= createSnippet(<<<SNIPPET

// Getting Column State
function getColumnState(): ColumnState[]

interface ColumnState {
    colId?: string; // ID of the column
    width?: number; // width of column in pixels
    flex?: number; // column's flex if flex is set
    hide?: boolean; // true if column is hidden
    sort?: string; // sort applied to the columns
    sortIndex?: number; // the order of the sort, if sorting by many columns
    aggFunc?: string | IAggFunc; // the aggregation function applied
    pivot?: boolean; // true if pivot active
    pivotIndex?: number; // the order of the pivot, if pivoting by many columns
    pinned?: string | 'left' | 'right'; // set if column is pinned
    rowGroup?: boolean; // true if row group active
    rowGroupIndex?: number | null; // the order of the row group, if row grouping by many columns
}

// Applying Column State
function applyColumnState(params: ApplyColumnStateParams): boolean

interface ApplyColumnStateParams {
    state?: ColumnState[]; // the state from getColumnState
    applyOrder?: boolean; // whether column order should be applied
    defaultState?: ColumnState; // state to apply to columns where state is missing for those columns
}
SNIPPET
) ?>

<h2>Partial State</h2>

<p>
    It is possible to focus on particular columns and / or particular attributes when getting and / or
    applying Column State. This allows fine grained control over the Column State, e.g. setting what Columns
    are Pinned, without impacting any other state attribute.
</p>

<h3>Applying Partial State</h3>

<p>
    When applying column state, in cases where some state attributes or columns are missing from the Column State,
    the following rules apply:
</p>

<ul class="content">
    <li>
        If a Column State is missing attributes, or attributes are provided as <code>undefined</code>,
        then those missing / undefined attributes are not updated. For example if a Column has a
        Column State with just <code>pinned</code>, then Pinned is applied to that Column but other
        attributes, such as Sort, are left intact.
    </li>
    <li>
        When state is applied and there are additional Columns in the grid that do not appear in the provided
        state, then the <code>params.defaultState</code> is applied to those additional Columns.
    </li>
    <li>
        If <code>params.defaultState</code> is not provided, then any additional Columns in the grid will not
        be updated.
    </li>
</ul>

<p>
    Combining these rules together leaves for flexible fine grained state control. Take the following code
    snippets as examples:
</p>

<?= createSnippet(<<<SNIPPET

// Sort Athlete column ascending
columnApi.applyColumnState({
    state: [
        {
            colId: 'athlete',
            sort: 'asc'
        }
    ]
});

// Sort Athlete column ascending and clear sort on all other columns
columnApi.applyColumnState({
    state: [
        {
            colId: 'athlete',
            sort: 'asc'
        }
    ],
    defaultState: {
        // important to say 'null' as undefined means 'do nothing'
        sort: null
    }
});

// Clear sorting on all columns, leave all other attributes untouched
columnApi.applyColumnState({
    defaultState: {
        // important to say 'null' as undefined means 'do nothing'
        sort: null
    }
});

// Clear sorting, row group, pivot and pinned on all columns,
// leave all other attributes untouched
columnApi.applyColumnState({
    defaultState: {
        // important to say 'null' as undefined means 'do nothing'
        sort: null,
        rowGroup: null,
        pivot: null,
        pinned: null
    }
});

// Order columns, but do nothing else
columnApi.applyColumnState({
    state: [
        { colId: 'athlete' },
        { colId: 'country' },
        { colId: 'age' },
        { colId: 'sport' }
    ],
    applyOrder: true
});

SNIPPET
) ?>

<p>
    The example below shows some fine grained access to Column State.
</p>

<?= grid_example('Fine Grained State', 'fine-grained-state', 'mixed', ['enterprise' => true]) ?>

<h3>Saving Partial State</h3>

<p>
    Using the techniques above, it is possible to save and restore a subset of the parameters in the state.
    The example below demonstrates this by selectively saving and restoring a) sort state and
    b) column visibility and order state.
</p>

<p>
    Note than when saving and restoring Sort state, other state attributes (width, row group, column order etc)
    are not impacted.
</p>

<p>
    Likewise when saving and restoring visibility and order, only visibility and order will be impacted when
    re-applying the state.
</p>

<?= grid_example('Selective State', 'selective-state', 'generated', ['enterprise' => true]) ?>

<h2>Considerations</h2>

<p>
    There are a few items to note on specific state attributes. They are as follows:
</p>

<h3>Null vs Undefined</h3>

<p>
    For all state attributes, <code>undefined</code> means <i>"do not apply this attribute"</i>
    and <code>null</code> means <i>"clear this attribute"</i>.
</p>

<p>
    For example setting <code>sort=null</code> will clear sort on a column whereas setting
    <code>sort=undefined</code> will leave whatever sort, if any, that is currently present.
</p>

<p>
    The only exception is with regards to Column width. For width, both <code>undefined</code>
    and <code>null</code> will skip the attribute. This is because Width is mandatory - there
    is no such things as a Column with no width.
</p>

<h3>Width and Flex</h3>

<p>
    When Flex is active on a Column, the grid ignores the <code>width</code> attribute when setting the Width.
</p>

<p>
    When <code>getColumnState()</code> is called, both <code>width</code> and <code>flex</code> are returned.
    When <code>applyColumnState()</code> is called, if <code>flex</code> is present then <code>width</code> is
    ignored.
</p>

<p>
    If you want to restore a Column's width to the exact same pixel width as specified in the Column State,
    set <code>flex=null</code> for that Column's state to turn Flex off.
</p>

<h3>Row Group and Pivot</h3>

<p>
    There are two attributes representing both Row Group and Pivot. First using the boolean attributes
    <code>rowGroup</code> and <code>pivot</code> and then secondly using the index attributes <code>rowGroupIndex</code>
    and <code>pivotIndex</code>.
</p>

<p>
    When <code>getColumnState()</code> is called, all of <code>rowGroup</code>, <code>pivot</code>,
    <code>rowGroupIndex</code> and <code>pivotIndex</code> are returned. When
    <code>applyColumnState()</code> is called, preference is given to the index variants. For example
    if both <code>rowGroup</code> and <code>rowGroupIndex</code> are present, <code>rowGroupIndex</code>
    is applied.
</p>

<h2>Column Events</h2>

<p>
    Column Events will get raised when applying Column State as these events would
    normally get raised. For example <code>columnPinned</code> event will get raised if applying
    the state results in a column getting pinned or unpinned.
</p>

<p>
    The example below demonstrates events getting raised based on Column State changes.
    The example logs event information to the console, so best open the example in
    a new tab and observe the dev console.
</p>

<?= grid_example('Column Events', 'column-events', 'generated', ['enterprise' => true]) ?>

<p>
    To suppress events raised when invoking <code>applyColumnState()</code>
    set the grid property <code>suppressColumnStateEvents=true</code>.
</p>

<p>
    The example below is similar to the example above, except no events are
    raised when the state is changed via the buttons.
</p>

<?= grid_example('Suppress Events', 'suppress-events', 'generated', ['enterprise' => true]) ?>

<h2>Column Group State</h2>

<p>
    Column Group State is concerned with the state of Column Groups. There is only one state attribute for Column Groups,
    which is whether the group is open or closed.
</p>

<p>
    To get the state of Column Groups use the API method <code>columnApi.getColumnGroupState()</code>. To
    set the Column Group state use the API method <code>columnApi.setColumnGroupState(state)</code>.
</p>

<p>
    The example below demonstrates getting and setting Column Group State. Note the following:
</p>

<ul class="content">
    <li>Clicking 'Save State' will save the opened / closed state of column groups.</li>
    <li>Clicking 'Restore State' will restore the previously saved state.</li>
    <li>
        Clicking 'Reset State' will reset the column state to match the Column Definitions,
        i.e. all Column Groups will be closed.
    </li>
</ul>

<?= grid_example('Column Group State', 'column-group-state', 'generated', ['enterprise' => true]) ?>


<?php include '../documentation-main/documentation_footer.php';?>
