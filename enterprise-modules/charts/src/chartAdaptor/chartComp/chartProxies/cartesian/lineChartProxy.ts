import {AgLineSeriesOptions, CartesianChartOptions, HighlightOptions, LineSeriesOptions} from "@ag-grid-community/core";
import {AgCartesianChartOptions, AgChart, CartesianChart, ChartTheme, LineSeries} from "ag-charts-community";
import {ChartProxyParams, UpdateChartParams} from "../chartProxy";
import {CartesianChartProxy} from "./cartesianChartProxy";
import {isDate} from '../../typeChecker';

export class LineChartProxy extends CartesianChartProxy<LineSeriesOptions> {

    public constructor(params: ChartProxyParams) {
        super(params);

        this.initChartOptions();
        this.recreateChart();
    }

    protected getDefaultOptionsFromTheme(theme: ChartTheme): CartesianChartOptions<LineSeriesOptions> {
        const options = super.getDefaultOptionsFromTheme(theme);

        const seriesDefaults = theme.getConfig<AgLineSeriesOptions>('line.series.line');
        options.seriesDefaults = {
            tooltip: {
                enabled: seriesDefaults.tooltipEnabled,
                renderer: seriesDefaults.tooltipRenderer
            },
            fill: {
                colors: [],
                opacity: 1
            },
            stroke: {
                colors: theme.palette.strokes,
                opacity: seriesDefaults.strokeOpacity,
                width: seriesDefaults.strokeWidth
            },
            marker: {
                enabled: seriesDefaults.marker.enabled,
                shape: seriesDefaults.marker.shape,
                size: seriesDefaults.marker.size,
                strokeWidth: seriesDefaults.marker.strokeWidth
            },
            highlightStyle: seriesDefaults.highlightStyle as HighlightOptions
        } as LineSeriesOptions;

        return options;
    }

    protected createChart(options?: CartesianChartOptions<LineSeriesOptions>): CartesianChart {
        const { grouping, parentElement } = this.chartProxyParams;

        options = options || this.chartOptions;
        const agChartOptions = options as AgCartesianChartOptions;
        agChartOptions.autoSize = true;
        agChartOptions.axes = [{
            type: 'category',
            position: 'bottom',
            ...options.xAxis
        }, {
            type: 'number',
            position: 'left',
            ...options.yAxis
        }];

        return AgChart.create(agChartOptions, parentElement);
    }

    public update(params: UpdateChartParams): void {
        this.chartProxyParams.grouping = params.grouping;

        if (params.fields.length === 0) {
            this.chart.removeAllSeries();
            return;
        }

        const testDatum = params.data[0];
        const testValue = testDatum && testDatum[params.category.id];

        this.updateAxes(isDate(testValue) ? 'time' : 'category');

        const { chart } = this;
        const fieldIds = params.fields.map(f => f.colId);
        const { fills, strokes } = this.getPalette();
        const data = this.transformData(params.data, params.category.id);

        const existingSeriesById = (chart.series as LineSeries[]).reduceRight((map, series, i) => {
            const id = series.yKey;

            if (fieldIds.indexOf(id) === i) {
                map.set(id, series);
            } else {
                chart.removeSeries(series);
            }

            return map;
        }, new Map<string, LineSeries>());

        let previousSeries: LineSeries | undefined = undefined;

        params.fields.forEach((f, index) => {
            let lineSeries = existingSeriesById.get(f.colId);
            const fill = fills[index % fills.length];
            const stroke = strokes[index % strokes.length];

            if (lineSeries) {
                lineSeries.title = f.displayName;
                lineSeries.data = data;
                lineSeries.xKey = params.category.id;
                lineSeries.xName = params.category.name;
                lineSeries.yKey = f.colId;
                lineSeries.yName = f.displayName;
                lineSeries.marker.fill = fill;
                lineSeries.marker.stroke = stroke;
                lineSeries.stroke = fill; // this is deliberate, so that the line colours match the fills of other series
            } else {
                const { seriesDefaults } = this.chartOptions;
                const marker = {
                    ...seriesDefaults.marker,
                    fill,
                    stroke
                } as any;
                if (marker.type) { // deprecated
                    marker.shape = marker.type;
                    delete marker.type;
                }
                const options: any /*InternalLineSeriesOptions*/ = {
                    ...seriesDefaults,
                    type: 'line',
                    title: f.displayName,
                    data,
                    xKey: params.category.id,
                    xName: params.category.name,
                    yKey: f.colId,
                    yName: f.displayName,
                    fill,
                    stroke: fill, // this is deliberate, so that the line colours match the fills of other series
                    fillOpacity: seriesDefaults.fill.opacity,
                    strokeOpacity: seriesDefaults.stroke.opacity,
                    strokeWidth: seriesDefaults.stroke.width,
                    tooltipRenderer: seriesDefaults.tooltip && seriesDefaults.tooltip.enabled && seriesDefaults.tooltip.renderer,
                    marker
                };

                lineSeries = AgChart.createComponent(options, 'line.series');

                chart.addSeriesAfter(lineSeries, previousSeries);
            }

            previousSeries = lineSeries;
        });

        this.updateLabelRotation(params.category.id);
    }

    protected getDefaultOptions(): CartesianChartOptions<LineSeriesOptions> {
        const options = this.getDefaultCartesianChartOptions() as CartesianChartOptions<LineSeriesOptions>;

        options.xAxis.label.rotation = 335;

        options.seriesDefaults = {
            ...options.seriesDefaults,
            stroke: {
                ...options.seriesDefaults.stroke,
                width: 3,
            },
            marker: {
                enabled: true,
                shape: 'circle',
                size: 6,
                strokeWidth: 1,
            },
            tooltip: {
                enabled: true,
            }
        };

        return options;
    }
}