<?php
$pageTitle = "Charts - Histogram Series";
$pageDescription = "ag-Charts is a highly performant charting library with a clean API to effortlessly create beautiful visualizations.";
$pageKeywords = "Javascript Grid Charting";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1>Histogram Series</h1>

<p class="lead">
    Histograms show the frequency distribution of continuous data. They are a good choice for when the data is larger
    than could be plotted on a bar chart and can be used to find underlying trends in continuous data.
</p>

<h2>Simple Histogram</h2>

<p>
    Histograms require at least one numeric attribute in the data to be specified using the
    <code>xKey</code> property. Data will be distributed into bins according to the <code>xKey</code> values.
</p>

<p>
    The simplest configuration for a Histogram Series is shown below:
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'histogram'
    xKey: 'age'
}]
SNIPPET
) ?>

<?= chart_example('Simple Histogram', 'simple', 'generated'); ?>

<h2>Bin Count</h2>

<p>
    By default the histogram will split the x domain of the data into around ten
    regular-width bins, although the exact number generated will vary so that the
    chart can find round values for the bin boundaries. This is similar to how giving
    a number of ticks to an axis does not guarantee that exact number of ticks.

    The number of bins to aim for can be overridden by setting the <code>binCount</code>
    property on a histogram series.
</p>

<p>
    Given enough data, charts with more bins are able to more precisely illustrate
    underlying trends, but are also more sensitive to random noise.
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'histogram'
    xKey: 'age',
    binCount: 20
}]
SNIPPET
) ?>

<?= chart_example('Larger Bin Count', 'larger-bin-count', 'generated'); ?>

<h2>Irregular Intervals</h2>

<p>
    Rather than specify the number of bins, for cases where you know exactly which bins
    you wish to split your x-axis values into, it is possible to explicitly give the
    start and end values for each bin.

    This is given using the <code>bins</code> property, and the value should be an array
    of arrays where each inner array contains the start and end value of a bin.

    In the example below, the data from the race is split into irregular age categories.
</p>

<p>
    For histogram charts with irregular bins it is usual for the area of the bar,
    rather than its height, to visually represent the value of each bin.

    In this way the shape of the underlying curve is maintained over irregular intervals.

    The <code>areaPlot</code> property should be set to <code>true</code>
    to enable this mode.
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'histogram'
    xKey: 'age',
    areaPlot: true,
    bins: [[16, 18], [18, 21], [21, 25], [25, 40]]
}]
SNIPPET
) ?>

<p>
    Note that if you give the <code>bins</code> property you should not also give
    <code>binCount</code>, but if both are present <code>bins</code> takes precedence.
</p>

<?= chart_example('Irregular Intervals', 'irregular-intervals', 'generated'); ?>

<h2>XY Histogram</h2>

<p>
    The histograms shown above all contain a single <code>xKey</code> with its frequency plotted on the y axis.
    However it is sometimes useful to visualise an <code>xKey</code> and <code>yKey</code> using a Histogram.
</p>

<p>
    When using XY Histograms it is also useful to control how bins are aggregated using the <code>aggregation</code>
    series property. The following sections compare the <code>sum</code> and <code>mean</code> aggregation functions.
</p>

<h3>Summing Bins</h3>

<p>
    This is used to show the summing of one column or attribute for each of the bins. When a <code>yKey</code> is given,
    the default behaviour is to plot a total of the <code>yKey</code> values. The kind of aggregation to use is
    controlled by the <code>series.aggregation</code> property.
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'histogram'
    xKey: 'age',
    yKey: 'winnings',
    aggregation: 'sum'
}]
SNIPPET
) ?>

<?= chart_example('XY Histogram with Sum Aggregation', 'sum-histogram', 'generated'); ?>

<h3>Mean Bins</h3>

<p>
    Showing frequencies or summing up the y-values isn't always the best way to show your data.

    For data that is not evenly distributed in x, but is relatively uniform in y, a sum plot xy histogram
    will tend to be dominated by the populations of the x-bins.

    In the above example you may notice that
    the prize money distribution very closely follows the age distribution, so that while potentially
    useful, the chart does not reveal any new trends in the data.

    In many cases, plotting the mean of a bin on the y-axis better illustrates an underlying trend in the data:
</p>

<?= createSnippet(<<<SNIPPET
series: [{
    type: 'histogram'
    xKey: 'age',
    yKey: 'time',
    yName: 'Average Time',
    aggregation: 'total'
}]
SNIPPET
) ?>

<?= chart_example('XY Histogram with Mean Aggregation', 'mean-histogram', 'generated'); ?>

<h2>API Reference</h2>

<?php createDocumentationFromFile('../javascript-charts-api-explorer/config.json', 'histogram', [], ['showSnippets' => true]) ?>

<h2>Next Up</h2>

<p>
    Continue to the next section to learn about <a href="../javascript-charts-layout/">layout</a>.
</p>

<?php include '../documentation-main/documentation_footer.php'; ?>
