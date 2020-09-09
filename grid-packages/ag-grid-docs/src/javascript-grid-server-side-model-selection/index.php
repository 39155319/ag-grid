<?php
$pageTitle = "Server-Side Row Model - Row Selection";
$pageDescription = "ag-Grid is a feature-rich datagrid available in Free or Enterprise versions. There are four available Row Models, the Server-Side Row Model is arguably the most powerful giving the ultimate 'big data' user experience. Users navigate through very large data sets using a mixture of server-side grouping and aggregation while using infinite scrolling to bring the data back in blocks to the client.";
$pageKeywords = "ag-Grid Server-Side Row Model";
$pageGroup = "row_models";
include '../documentation-main/documentation_header.php';
?>

<h1 class="heading-enterprise">Server-Side Row Selection</h1>

<p class="lead">
    Selecting rows and groups in the Server-Side Row Model is supported.
    Just set the property <code>rowSelection</code> to either <code>'single'</code>
    or <code>'multiple'</code> as with any other row model.
</p>

<h2>Example: Click Selection</h2>

<p>
    The example below shows both simple 'click' selection as well as multiple 'shift-click' selections. Selecting groups
    is not allowed as clicking on groups is reserved for opening and closing the groups.
</p>

<ul class="content">
    <li><b>Single 'Click' Selection</b> - when you click on a leaf level row, the row is selected.</li>
    <li><b>Multiple 'Shift-Click' Selections</b> - select a leaf row (single click) and then 'shift-click' another leaf
        row within the same group to select all rows between that range.</li>
</ul>

<?= grid_example('Click Selection', 'click-selection', 'generated', ['enterprise' => true, 'exampleHeight' => 590, 'extras' => ['alasql'], 'modules' => ['serverside', 'rowgrouping']]) ?>

<note>
    Performing multiple row selections using 'shift-click' has the following restrictions:
    <ul class="content">
        <li>Only works across rows that share the same parent.</li>
        <li>Only works for rows that are loaded (e.g. a large range selection may span rows that are not loaded).</li>
    </ul>
</note>

<h2>Example: Checkbox Selection</h2>

<p>
    Below shows another example using checkbox selection. The example shows checkboxes on the groups and a regular
    column. This is for comparison in the example only. Normal applications generally have the checkbox on one column
    or the groups.
</p>

<ul class="content">
    <li>
        Checkbox selection on the group column allowing selection of any row.
    </li>
    <li>
        Checkbox selection on the group sport column. Selection is restricted to leaf-level rows only
        via <code>gridOptions.isRowSelectable(rowNode)</code> callback.

    </li>
</ul>

<?= grid_example('Checkbox Example', 'checkbox', 'generated', ['enterprise' => true, 'exampleHeight' => 590, 'extras' => ['alasql'], 'modules' => ['serverside', 'rowgrouping']]) ?>

<h2>Providing Node IDs</h2>

<p>
    Providing node IDs is optional. If you provide your own node IDs
    (using the <code>getRowNodeId()</code> callback)
    then you must make sure that the rows have unique IDs across your entire data
    set. This means all the groups and all leaf-level nodes must have unique
    IDs, even if the leaves are not part of the same group. This is because
    the grid uses node IDs internally and requires them to be unique.
</p>

<p>
    If you do not provide node IDs, the grid will generate the IDs for you,
    and will make sure they are unique.
</p>

<h2>Selecting Group Nodes</h2>

<p>
    Group nodes can be selected along with non-group nodes.
</p>

<p>
    It is not possible to select all items in a group by selecting the group.
    When NOT using the Server-Side Row Model (e.g. if using the default Client-side Row Model)
    it is possible to do this by setting <code>groupSelectsChildren=true</code>.
    This is not possible in the Server-Side Row Model because the children for
    a group may not be loaded into the grid. Without all the children loaded,
    it is not possible to select them all.
</p>
<p>
    If you want selecting a group to also select children, this is something you will
    need to implement within the application as it will require selecting rows
    that are not yet loaded into the grid, probably not even loaded into the client.
</p>

<h2>Next Up</h2>

<p>
    Continue to the next section to learn about setting <a href="../javascript-grid-server-side-model-row-height/">Row Height</a>
    using the Server-Side Row Model.
</p>

<?php include '../documentation-main/documentation_footer.php';?>
