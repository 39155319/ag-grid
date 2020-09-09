<?php
$pageTitle = "Tool Panel Component: Enterprise Grade Feature of our Datagrid";
$pageDescription = "ag-Grid is a feature-rich data grid supporting major JavaScript Frameworks. One such feature is Tool Panel. The Tool Panel allows the user to manipulate the list of columns, such as show and hide, or drag columns to group or pivot. Version 20 is available for download now, take it for a free two month trial.";
$pageKeywords = "ag-Grid Tool Panel Component";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1 class="heading-enterprise">Tool Panel Component</h1>

<p class="lead">
    Custom Tool Panel Components can be included into the grid's Side Bar. Implement these when you require
    more Tool Panels to meet your application requirements.
</p>

<p>
    In this section we show the interfaces required to implement a custom Tool Panel Component along with details
    on how to register it with the grid. An example of a custom Tool Panel Component is also provided.
</p>

<h2>Tool Panel Interface</h2>

<p> Implement this interface to provide a custom Tool Panel Components to the grid's Side Bar.</p>

<?= createSnippet(<<<SNIPPET
interface IToolPanel {
    // The init(params) method is called on the tool panel once upon component initialisation.
    init(params: IToolPanelParams): void;

    // Returns the DOM element for this Tool Panel
    getGui(): HTMLElement;

    // Can be left blank if no custom refresh logic is required.
    refresh(): void;
}
SNIPPET
, 'ts') ?>

<?= createSnippet(<<<SNIPPET
interface IToolPanelParams {
    // Grid API
    api: any;

    // Column API
    columnApi: any;
}
SNIPPET
, 'ts') ?>

<h2>Registering Tool Panel Components</h2>

<p>
    Registering a Tool Panel component follows the same approach as any other custom components in the grid. For
    more details see:
    <a href="../javascript-grid-components/#registering-custom-components">Registering Custom Components</a>.
</p>

<p>
    Once the Tool Panel Component is registered with the grid it needs to be included into the Side Bar. The
    following snippet illustrates this:
</p>

<?= createSnippet(<<<SNIPPET
gridOptions: {
    sideBar: {
        toolPanels: [
            {
                id: 'customStats',
                labelDefault: 'Custom Stats',
                labelKey: 'customStats',
                iconKey: 'custom-stats',
                component: 'customStatsToolPanel',
            }
        ]
    },
    components: {
        customStatsToolPanel: CustomStatsComponent
    }

    // other grid properties
}
SNIPPET
) ?>

<p>
    For more details on the configuration properties above, refer to the
    <a href="../javascript-grid-side-bar/#sidebardef-configuration">Side Bar Configuration</a> section.
</p>

<h2>Example: 'Custom Stats' Tool Panel Component</h2>

<p>
    The example below provides a 'Custom Stats' Tool Panel to demonstrates how to create and register a Custom Tool
    Panel Component with the grid and include it the Side Bar:
</p>

<?= grid_example('Custom Stats', 'custom-stats', 'generated', ['enterprise' => true, 'extras' => ['fontawesome'], 'reactFunctional' => true] ) ?>

<?php include '../documentation-main/documentation_footer.php';?>
