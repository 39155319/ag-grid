<?php
$pageTitle = "ag-Grid Examples: Datagrid and D3 Graphs Integration";
$pageDescription = "ag-Grid is a feature-rich datagrid available in Free or Enterprise versions. We don't offer charting out of the box but have built and example of integrating with the popular d3 charting library.";
$pageKeywords = "ag-grid d3 d3.js sparkline examples";
$pageGroup = "thirdparty";
include '../documentation-main/documentation_header.php';
?>

    <h1>Third-Party Charting</h1>

    <p class="lead">
        This section goes through examples of integrating the grid with <a href="https://d3js.org/">D3</a>
        (for charting outside of the grid) and
        <a href="https://omnipotent.net/jquery.sparkline/">Sparklines</a> (for charting inside the grid).
    </p>

    <note>
        This section pre-dates <a href="../javascript-grid-charts-integrated-overview/">Integrated Charts</a>.
        It is our plan to add support to our charting library to achieve the below, but for now we will leave these examples using D3 and Sparklines.
    </note>

    <h2>External Graphs using D3</h2>

    <p>D3 is a powerful Graphing Library. In this example we provide an example that displays a simple ag-Grid table of stock
    data that when clicked on provides a simple time-series chart of the corresponding data. Multiple rows (or stocks) can be
    selected to provide a comparison between stocks.</p>

<?= grid_example('External Graphs using D3', 'stocks-master-detail', 'vanilla', ['enterprise' => true, 'exampleHeight' => 820]) ?>

    <h2>Inline Graphs using jQuery Sparklines</h2>

    <p>jQuery Sparklines is a great library that offers small but rich graphs - ideal for use within ag-Grid.</p>

    <p>In this example we demonstrate the following:</p>

    <ul class="content">
        <li>Close Trend: Inline summary trend graph. If clicked on the full time-series
        will be displayed below.</li>
        <li>Average Volume: The average volume per year in a Bar Graph.</li>
        <li>Target Expenditure: Illustrates how a graph can be used withing a cell editor. If double clicked (or enter
            pressed) a popup editor in the form of a Pie Chart will be shown - when a segment is clicked on the value
            will be saved down to the grid.</li>
        <li>Expenditure: Expenditure shown in a Pie Chart.</li>
    </ul>

    <?= grid_example('Inline Graphs', 'inline-graphs', 'vanilla', ['enterprise' => true, 'exampleHeight' => 850, 'extras' => ['lodash', 'd3', 'jquery', 'sparkline']]) ?>


<?php include '../documentation-main/documentation_footer.php'; ?>
