<?php
$pageTitle = "Charts - Pie Series";
$pageDescription = "ag-Charts is a highly performant charting library with a clean API to effortlessly create beautiful visualizations.";
$pageKeywords = "Javascript Grid Charting";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1>Pie and Doughnut Series</h1>

<p class="lead">
    This section shows how to create pie charts.
</p>

<p>
    Pie series are used for showing how parts relate to the whole, for example if you want to show the
    market share of each competitor.
</p>

<h2>Basic Configuration</h2>

<p>
    To plot a basic pie all we need is an array of values that will determine the angle of each
    pie slice. The total of all values will correspond to the full pie.
</p>

<p>A basic pie series configuration is shown below:</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'pie',
    angleKey: 'value'
}]
SNIPPET
) ?>

<p>
    This results in the chart shown below. Note that <a href="../javascript-charts-tooltips/">tooltips</a> show the
    absolute value of each pie slice.
</p>

<?= chart_example('Basic Pie Chart', 'basic-pie', 'generated') ?>

<h2>Slice Labels</h2>

<p>
    In the example above there's no legend or labels next to pie slices. To show those, the label information must be
    in the <code>data</code>. Additionally, we'll have to provide the <code>labelKey</code>:
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'pie',
    angleKey: 'value',
+   labelKey: 'label'
}]
SNIPPET
, 'diff') ?>

<p>
    Now we get labels, a legend, and the tooltips will also show labels along with the values:
</p>

<?= chart_example('Pie Chart with Labels', 'pie-labels', 'generated') ?>

<p>
    Each individual slice can be toggled on and off via the legend.
</p>

<p>
    You might notice that not all of the slices in the chart above have a label. The reason for this is that certain
    slices can be small, and if there's a cluster of small slices their labels will overlap, resulting
    in a messy chart. To prevent this from happening the series will only show labels for slices with an angle greater
    than a certain value, which by default is set to be <code>20</code> degrees. This value is adjustable via the
    <code>label.minAngle</code> config:
</p>

<?= createSnippet(<<<SNIPPET
label: {
    minAngle: 20
}
SNIPPET
) ?>

<p>
    The label's callout can be configured to have a different <code>length</code>,
    <code>color</code> and <code>strokeWidth</code>, for example:
</p>

<?= createSnippet(<<<SNIPPET
callout: {
    colors: 'red',
    length: 20,
    strokeWidth: 3
}
SNIPPET
) ?>

<p>
    Please check the <a href="#api-reference">API reference</a> below
    to learn more about <code>label</code> and <code>callout</code>, as well as other series
    configuration.
</p>

<h2>Variable Slice Radius</h2>

<p>
    Let's say you have the data for both the market share of mobile operating systems
    and the level of user satisfaction with each OS. We could represent
    the satisfaction level as the radius of a slice using the <code>radiusKey</code> config
    like so:
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'pie',
    labelKey: 'os',
    angleKey: 'share',
    radiusKey: 'satisfaction'
}]
SNIPPET
) ?>

<p>
    A pie chart where slices can have different radii is also known as a <strong>rose chart</strong>.
</p>

<?= chart_example('Slices with Different Radii', 'slice-radius', 'generated') ?>

<h2>Doughnuts</h2>

<p>
    Pie series can be used to create a doughnut chart by using the <code>innerRadiusOffset</code>
    config.
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'pie',
    labelKey: 'os',
    angleKey: 'share',
    innerRadiusOffset: -70
}]
SNIPPET
) ?>

<p>
    The config specifies the offset value from the maximum pie radius which all pie
    slices use by default (the maximum pie series radius is determined automatically by the
    chart depending on the chart's dimensions). <code>-70</code> in the snippet above means
    the inner radius of the series should be 70 pixels smaller than the maximum radius.
</p>

<?= chart_example('Doughnut Chart', 'doughnut-chart', 'generated') ?>

<h2>Multiple Doughnuts</h2>

<p>
    As well as the <code>innerRadiusOffset</code> we can also configure the
    <code>outerRadiusOffset</code>. This gives us the ability to render multiple pie series
    in a single chart without overlapping.
</p>

<?= createSnippet(<<<SNIPPET
series: [
    {
        type: 'pie',
        outerRadiusOffset: 0, // default
        innerRadiusOffset: -40,
        ...
    },
    {
        type: 'pie',
        outerRadiusOffset: -100,
        innerRadiusOffset: -140,
        ...
    }
]
SNIPPET
) ?>

<p>
    In the snippet above we configure the <code>outerRadiusOffset</code> of the second (inner) series
    to be smaller than the <code>innerRadiusOffset</code> of the first (outer) series.
    The difference of <code>60</code> between these offsets will determine the size of the
    gap between the outer and inner series. The difference between <code>outerRadiusOffset</code>
    and <code>innerRadiusOffset</code> for each series will determine the thickness of the rings, which will be
    <code>40</code> for both series in this case.
</p>

<p>
    The example below uses one pie series to plot the market share of each operating system
    and another pie series to plot user satisfaction level with each OS:
</p>

<?= chart_example('Multi-Doughnut Chart', 'multi-doughnut', 'generated') ?>

<h2>API Reference</h2>

<?php createDocumentationFromFile('../javascript-charts-api-explorer/config.json', 'pie', [], ['showSnippets' => true]); ?>

<h2>Next Up</h2>

<p>
    Continue to the next section to learn about <a href="../javascript-charts-histogram-series/">histogram series</a>.
</p>

<?php include '../documentation-main/documentation_footer.php'; ?>
