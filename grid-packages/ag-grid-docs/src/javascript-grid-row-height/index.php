<?php
$pageTitle = "Row Height: Styling & Appearance Feature of our Datagrid";
$pageDescription = "Core feature of ag-Grid supporting Angular, React, Javascript and more. One such feature is Row Height. Rows can have different Row Height. You can even change the row height dynamically at run time. Version 24.1.0 is available for download now, take it for a free two month trial.";
$pageKeywords = "ag-Grid ag grid javascript Row Height";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1>Row Height</h1>

<p>
    By default, the grid will display rows with a height of <code>25px</code>. You can change this for each row
    individually to give each row a different height.
</p>

<note>
    You cannot use variable row height when using <a href="../javascript-grid-viewport/">Viewport Row Model</a>.
    This is because this row model needs to work out the position of rows that are not loaded and hence needs to
    assume the row height is fixed.
</note>

<h2><code>rowHeight</code> Property</h2>

<p>
    To change the row height for the whole grid, set the property <code>rowHeight</code> to a positive number.
    For example, to set the height to 50px, do the following:
</p>

<?= createSnippet('gridOptions.rowHeight = 50;') ?>

<p>
    Changing the property will set a new row height for all rows, including pinned rows top and bottom.
</p>

<h2><code>getRowHeight</code> Callback</h2>

<p>
    To change the row height so that each row can have a different height,
    implement the <code>getRowHeight()</code> callback. For example, to set the height
    to 50px for all non-pinned rows and 25px for pinned rows, do the following:
</p>

<?= createSnippet(<<<SNIPPET
gridOptions.getRowHeight = function(params) {
    return params.node.group ? 50 : 20;
}
SNIPPET
) ?>

<p>
    The params object passed to the callback has the following values:
</p>

<ul class="content">
    <li><b>node:</b> The <a href="../javascript-grid-row-node/">rowNode</a> in question.</li>
    <li><b>data:</b> The data for the row.</li>
    <li><b>api:</b> The <a href="../javascript-grid-api/">grid API</a>.</li>
    <li><b>context:</b> The <a href="../javascript-grid-context/">grid context</a>.</li>
</ul>

<p>
    The example below shows dynamic row height, specifying a different row height for each row.
    It uses the <code>getRowHeight()</code> callback to achieve this.
</p>

<?= grid_example('Row Height Simple', 'row-height-simple', 'generated', ['modules' => true]) ?>

<h2>Text Wrapping</h2>

<p>
    If you want text to wrap inside cells rather than truncating, add the flag <code>wrapText=true</code> to
    the Column Definition.
</p>
<p>
    The example below has <code>wrapText=true</code> set on the <strong>Latin Text</strong> column.
    Behind the scenes, this results in the CSS property <code>white-space: normal</code>
    being applied to the cell, which causes the text to wrap.
</p>

<?= grid_example('Row Height Complex', 'row-height-complex', 'generated', ['modules' => true]) ?>

<note>
    If you are providing a custom <a href="../javascript-grid-cell-rendering-components/">Cell Renderer Component</a>,
    you can implement text wrapping in the custom component in your own way. The property <code>wrapText</code>
    is intended to be used when you are not using a custom Cell Renderer.
</note>

<h2>Auto Row Height</h2>

<p>
    It is possible to set the row height based on the contents of the cells.
    To do this, set <code>autoHeight=true</code> on each column where
    height should be calculated from. For example, if one column is showing
    description text over multiple lines, then you may choose to select only
    that column to determine the line height.
</p>

<p>
    <code>autoHeight</code> is typically used with <code>wrapText</code>.
    If <code>wrapText</code> is not set, and no custom
    <a href="../javascript-grid-cell-rendering-components/">Cell Renderer Component</a>
    is used, then the cell will display all it's contents on one line. This is probably not
    the intention if using Auto Row Height.
</p>

<p>
    If multiple columns are marked with <code>autoHeight=true</code> then the
    height of the largest column is used.
</p>

<p>
    The height is calculated once when the data is first given to the grid.
    If the data changes, or the width of a column changes, then you may require the
    grid to calculate the height again by calling <code>api.resetRowHeights()</code>.
</p>

<p>
    The example below shows auto height in action. The following can be noted:
</p>
<ul>
    <li>
        All columns have <code>wrapText=true</code> and <code>autoHeight=true</code>,
        so the height of each row is such that it fits all contents from all columns.
    </li>
    <li>
        The example listens for the grid event <code>onColumnResized</code>.
        When a column is resized, the grid re-calculates the row heights after
        the resize is finished.
    </li>
    <li>
        The example listens for the grid event <code>onColumnVisible</code>.
        When a column is shown or hidden, the grid re-calculates the row heights after
        the resize is finished.
    </li>
</ul>

<!-- this example uses a timeout to set data - the runner doesn't currently support this sort of thing -->
<?= grid_example('Auto Row Height', 'auto-row-height', 'generated', ['enterprise' => true, 'modules' => true]) ?>

<h3>Lazy Height Calculation</h3>

<p>
    Auto height works by the grid creating an off-screen (not visible to the user)
    temporary row with all the
    auto height columns rendered into it. The grid then measures the height of the
    temporary row. Because DOM interaction is required for each row this can be an
    intensive process. For this reason the grid only calculates the height of the
    row when it is needed - e.g. rows not yet visible due to vertical scrolling do not
    have their heights calculated, similarly child rows of groups where the group
    is not open do not have their heights calculated until the group is opened and
    the child rows are visible.
</p>

<p>
    Because the heights of rows are changing as you scroll rows into view, the vertical scrollbar
    and the row positions change as the grid is scrolling vertically. This leads to the following
    behaviours:
</p>
<ul>
    <li>
        The vertical scroll range (how much you can scroll over) will change dynamically to
        fit the rows. If scrolling by dragging the scroll thumb with the mouse, the scroll thumb
        will not follow the mouse. It will either lag behind or jump ahead, depending on whether
        the row height calculations are increasing or decreasing the vertical scroll range.
    </li>
    <li>
        If scrolling up and showing rows for the first time (e.g. the user jumps to the bottom scroll
        position and then starts slowly scrolling up), then the row positions will jump as the
        rows coming into view at the top will get resized and the new height will impact the position
        of all rows beneath it. For example if the row gets resized to be 10 pixels taller, rows
        below it will get pushed down by 10 rows. If scrolling down this isn't observed as rows below
        are not in view.
    </li>
</ul>
<p>
    The above are results of Lazy Height Calculation. It is not possible to avoid these effects.
</p>

<h3>Auto Height Performance Consideration</h3>

<p>
    Because auto-height is a DOM intensive operation, consideration should be given for
    when and how to use it. Only apply auto-height to columns where it makes sense. For example, if you have
    many columns that do not require a variable height, then do not set them to auto-height.
</p>

<h2>Changing Row Height</h2>

<p>
    Setting the row height is done once for each row. Once set, the grid will not ask you
    for the row height again. You can change the row height after it is initially set
    using a combination of <code>api.resetRowHeights()</code>, <code>rowNode.setRowHeight()</code> and
    <code>api.onRowHeightChanged()</code>.
</p>

<h3><code>api.resetRowHeights()</code></h3>

<p>
    Call this API to have the grid clear all the row
    heights and work them all out again from scratch - if you provide a <code>getRowHeight()</code>
    callback, it will be called again for each row. The grid will then resize and
    reposition all rows again. This is the shotgun approach.
</p>

<h3><code>rowNode.setRowHeight(height)</code> and <code>api.onRowHeightChanged()</code></h3>

<p>
    You can call <code>rowNode.setRowHeight(height)</code> directly
    on the rowNode to set its height. The grid will resize the row but will NOT
    reposition the rows (i.e. if you make a row shorter, a space will appear between
    it and the next row - the next row will not be moved up). When you have set the
    row height (potentially on many rows) you need to call <code>api.onRowHeightChanged()</code>
    to tell the grid to reposition the rows. It is intended that you can call
    <code>rowNode.setRowHeight(height)</code> many times and then call <code>api.onRowHeightChanged()</code>
    once at the end.
</p>

<p>
    When calling <code>rowNode.setRowHeight(height)</code>, you can either pass in a new height
    or <code>null</code> or <code>undefined</code>. If you pass a height, that height will be used for the row.
    If you pass in <code>null</code> or <code>undefined</code>, the grid will then calculate the row height in the
    usual way, either using the provided <code>rowHeight</code> property or <code>getRowHeight()</code>
    callback.
</p>

<h3 id="example-changing-row-height">Example Changing Row Height</h3>

<p>The example below changes the row height in the different ways described above.</p>

<ul class="content">
    <li><b>Top Level Groups:</b> The row height for the groups is changed by calling <code>api.resetRowHeights()</code>.
    This gets the grid to call <code>gridOptions.getRowHeight()</code> again for each row.</li>
    <li><b>Swimming Leaf Rows:</b> Same technique is used here as above. You will need to expand
    a group with swimming (e.g. United States) and the grid works out all row heights again.</li>
    <li><b>Russia Leaf Rows:</b> The row height is set directly on the <code>rowNode</code>, and then the grid
    is told to reposition all rows again by calling <code>api.onRowHeightChanged()</code>.</li>
</ul>

<p>Note that this example uses ag-Grid Enterprise as it uses grouping. Setting the row
height is an ag-Grid free feature, we just demonstrate it against groups and normal
rows below.</p>

<?= grid_example('Changing Row Height', 'row-height-change', 'generated', ['enterprise' => true, 'exampleHeight' => 590, 'modules' => ['clientside', 'rowgrouping', 'menu', 'columnpanel']]) ?>

<h2>Height for Pinned Rows</h2>

<p>
    Row height for pinned rows works exactly as for normal rows with one difference: it
    is not possible to dynamically change the height once set. However this is easily solved
    by just setting the pinned row data again which resets the row heights. Setting the
    data again is not a problem for pinned rows as it doesn't impact scroll position, filtering,
    sorting or group open / closed positions as it would with normal rows if the data was reset.
</p>

<?php include '../documentation-main/documentation_footer.php';?>
