<?php
$pageTitle = "ag-Grid - Enterprise Grade Features: Column Menu";
$pageDescription = "Enterprise feature of ag-Grid supporting Angular, React, Javascript and more. One such feature is Column Menu. The Column Menu drops down from the column header. Use the default options or provide your own. Free and Commercial version available.";
$pageKeywords = "ag-Grid Javascript Grid Column Menu";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1 class="heading-enterprise">Column Menu</h1>

<p class="lead">
    The column menu appears when you click on the menu icon in the column header. For ag-Grid Community,
    only the filter is shown. For ag-Grid Enterprise, a tabbed component containing a 1) Menu, 2) Filter
    and 3) Column Management panel is shown.
</p>

<? enterprise_feature("Column Menu"); ?>

<h2>Showing the Column Menu</h2>

<p>
    The menu will be displayed by default and will be made up of three panels. If you want to change the order or
    what panels are shown, or hide them, you can specify the property <code>menuTabs</code> in the <code>colDef</code>
</p>

<p>
    The property <code>menuTabs</code> is an array of strings. The valid values are: <code>'filterMenuTab'</code>,
    <code>'generalMenuTab'</code> and <code>'columnsMenuTab'</code>.
</p>

<ul class="content">
    <li><code>generalMenuTab</code>: Include in the <code>menuTabs</code> array to show the main panel.</li>
    <li><code>filterMenuTab</code>: Include in the <code>menuTabs</code> array to show the filter panel.</li>
    <li><code>columnsMenuTab</code>: Include in the <code>menuTabs</code> array to show the column selection panel.</li>
</ul>

<p>
    To not show the menu at all, set this property to an empty array<code>[]</code>. In addition, you can set the
    attribute <code>suppressMenu=true</code> to the column definition to not show the menu for a particular column.
</p>

<p>
    The order of the menu tabs shown in the menu will match the order you specify in this array.
</p>

<p>
    If you don't specify a <code>menuTabs</code> for a <code>colDef</code> the default is: <code>['generalMenuTab',
        'filterMenuTab','columnsMenuTab']</code>
</p>

<h2>Customising the General Menu Tab</h2>

<p>
    The main menu panel, by default, will show a set of items. You can adjust which of these items get display, or you
    can start from scratch and provide your own items. To customise the menu, provide the <code>getMainMenuItems()</code>
    callback.
</p>

<p>
    <code>getMainMenuItems()</code> takes the following object as parameters:
</p>

<?= createSnippet(<<<SNIPPET
GetMainMenuItemsParams {
    column: Column, // the column that was clicked
    api: GridApi, // the grid API
    columnApi: ColumnAPI, // the column API
    context: any, // the grid context
    defaultItems: string[] // list of the items that would be displayed by default
}
SNIPPET
, 'ts') ?>

<p>
    The result of <code>getMainMenuItems()</code> should be a list with each item either a) a string
    or b) a MenuItem description. Use 'string' to pick from built in menu items (listed below)
    and use MenuItem descriptions for your own menu items.
</p>

<p>
    A MenuItem description looks as follows (items with question marks are optional):
</p>

<?= createSnippet(<<<SNIPPET
MenuItem {
    name: string, // name of menu item
    disabled?: boolean, // if item should be enabled / disabled
    shortcut?: string, // shortcut (just display text, saying the shortcut here does nothing)
    action?: () => void, // function that gets executed when item is chosen
    checked?: boolean, // set to true to provide a check beside the option
    icon?: HTMLElement | string, // the icon to display, either a DOM element or HTML string
    subMenu?: MenuItemDef[] // if this item is a sub menu, contains a list of menu item definitions
}
SNIPPET
, 'ts') ?>

<h2>Built In Menu Items</h2>

<p>The following is a list of all the default built in menu items with the rules about when they are shown.</p>

<ul class="content">
    <li><code>pinSubMenu</code>: Submenu for pinning. Always shown.</li>
    <li><code>valueAggSubMenu</code>: Submenu for value aggregation. Always shown.</li>
    <li><code>autoSizeThis</code>: Auto-size the current column. Always shown.</li>
    <li><code>autoSizeAll</code>: Auto-size all columns. Always shown.</li>
    <li><code>rowGroup</code>: Group by this column. Only shown if column is not grouped. Note this will appear
        once there is row grouping.
    </li>
    <li><code>rowUnGroup</code>: Un-group by this column. Only shown if column is grouped.</li> Note this will
    appear once there is row grouping.

    <li><code>resetColumns</code>: Reset column details. Always shown.</li>
    <li><code>expandAll</code>: Expand all groups. Only shown if grouping by at least one column.</li>
    <li><code>contractAll</code>: Contract all groups. Only shown if grouping by at least one column.</li>
</ul>

<p>
    Reading the list above it can be understood that the list <code>defaultItems</code> changes on
    different calls to the <code>getMainMenuItems()</code> callback, depending on, for example,
    what columns are current used for grouping.
</p>

<p>
    If you do not provide a <code>getMainMenuItems()</code> callback, then the rules alone decides what gets shown.
    If you do provide a <code>getMainMenuItems()</code>, then the <code>defaultItems</code> will be filled using the
    rules above and you return from the callback whatever you want, using the <code>defaultItems</code> only
    if you want to.
</p>

<h2>Menu Item Separators</h2>

<p>You can add menu item separators as follows:</p>

<?= createSnippet("menuItems.push('separator')") ?>

<?php include './postProcessPopup.php';?>

<h2>Overriding Column Menu Width</h2>

<p>You can override the menu width by overriding the corresponding CSS:</p>

<?= createSnippet(<<<SNIPPET
.ag-set-filter-list {
    width: 500px !important;
}
SNIPPET
, 'css') ?>

<h2>Hiding the Column Menu</h2>

<p>
    Hide the column menu with the grid API <code>hidePopupMenu()</code>, which will hide
    either the <a href="../javascript-grid-context-menu">context menu</a> or the column menu,
    whichever is showing.
</p>

<h2>Example Column Menu</h2>

<p>
    The example below shows the <code>getMainMenuItems()</code> in action. To demonstrate different scenarios,
    the callback returns something different based on the selected column as follows:
</p>

<ul class="content">
    <li>Athlete column appends custom items to the list of built in items.</li>
    <li>Athlete column contains a sub menu.</li>
    <li>Age column provides custom items and adds one built in default item.</li>
    <li>Country column trims down the default items by removing values.</li>
    <li>Date column changes the order of the tabs to <code>['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']</code></li>
    <li>Sport column changes the order of the tabs to <code>['filterMenuTab', 'columnsMenuTab']</code>. Note that the
    <code>'generalMenuTab'</code> is suppressed.
    <li>Gold column changes the order of the tabs to <code>['generalMenuTab', 'gibberishMenuTab']</code>. Note that
    the <code>'filterMenuTab'</code> and <code>'columnsMenuTab'</code> are suppressed. Also there is a warning on the
    console letting the user know that <code>'gibberishMenuTab'</code> is an invalid option and it is ignored</li>
    <li>Silver column hides the menu by suppressing all the menuTabs that can be shown: <code>[]</code>.</li>
    <li>All other columns return the default list.</li>
    <li><code>postProcessPopup</code> is used on the Gold column to reposition the menu 25px lower.</li>
</ul>

<?= grid_example('Column Menu', 'column-menu', 'generated', ['enterprise' => true]) ?>

<h2>Customising the Columns Menu Tab</h2>

<p>
    The behaviour and appearance of the Columns Menu tab can be customised by supplying <code>ColumnsMenuParams</code>
    to the column definition: <code>colDef.columnsMenuParams</code>.
</p>

<p>
    The available properties are shown below:
</p>

<?= createSnippet(<<<SNIPPET
ColumnsMenuParams {
    // to suppress updating the layout of columns as they are rearranged in the grid
    suppressSyncLayoutWithGrid?: boolean,

    // to suppress Column Filter section
    suppressColumnFilter?: boolean,

    // to suppress Select / Un-select all widget
    suppressColumnSelectAll?: boolean,

    // to suppress Expand / Collapse all widget
    suppressColumnExpandAll?: boolean,

    // by default, column groups start expanded. Pass true to default to contracted groups
    contractColumnSelection?: boolean
}
SNIPPET
, 'ts') ?>

<p>
    Note that all of the above properties are initially set to <code>false</code>.
</p>

<p>
    The following example demonstrates all of the above columns menu tab properties. Note the following:
</p>

<ul class="content">
    <li>
        All columns menu tabs have been configured to ignore column moves in the grid by setting
        <code>suppressSyncLayoutWithGrid = true</code> on the default column definition.
    </li>
    <li>
        The <b>Name</b> column doesn't show the top filter section as <code>suppressColumnFilter</code>,
        <code>suppressColumnSelectAll</code> and <code>suppressColumnExpandAll</code> are all set to <code>true</code>.
    </li>
    <li>
        The <b>Age</b> column shows the group columns in a collapsed state as <code>contractColumnSelection</code>
        is set to <code>true</code>.
    </li>
</ul>

<?= grid_example('Customising Columns Menu Tab', 'customising-columns-menu-tab', 'generated', ['enterprise' => true]) ?>

<h2>Popup Parent</h2>

<p>
    Under most scenarios, the menu will fit inside the grid. However if the grid is small and / or the menu
    is very large, then the menu will not fit inside the grid and it will be clipped. This will lead to
    a bad user experience.
</p>

<p>
    To fix this, you should set property <code>popupParent</code> which is explained in the
    <a href="../javascript-grid-context-menu/#popup-parent">popup parent</a> for context menus.
</p>

<?php include '../documentation-main/documentation_footer.php';?>
