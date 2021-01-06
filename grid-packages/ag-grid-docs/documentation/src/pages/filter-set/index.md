---
title: "Set Filter - Overview"
enterprise: true
---

The Set Filter takes inspiration from Excel's AutoFilter and allows filtering on sets of data. It is built on top of the shared functionality that is common across all [Provided Filters](../filter-provided/).

<image-caption src="filter-set/resources/set-filter.png" alt="Set Filter" width="28rem" centered="true"></image-caption>

## Set Filter Sections

The Set Filter is comprised of the following sections:

- **[Mini Filter](../filter-set-mini-filter/)**: used to narrow the values available for selection inside the Filter List.
- **Select All**: used to select / deselect all values shown in the Filter List.
- **[Filter List](../filter-set-filter-list/)**: a list of Set Filter Values which can be selected / deselected to set the filter.
- **Filter Buttons**: Action buttons that can be optionally added to the bottom of the Set Filter.

## Enabling Set Filters

The Set Filter is the default filter used in ag-Grid Enterprise, but it can also be explicitly configured as shown below:

```js
gridOptions: {
    columnDefs: [
        {
            field: 'country',
            filter: true // Set Filter is used by default in Enterprise version
        },
        {
            field: 'year',
            filter: 'agSetColumnFilter' // explicitly configure the Set Filter
        },
    ],
    // other options
}
```


The following example demonstrates how the Set Filter can be enabled. Note the following:

- The **Athlete** column has `filter=true` which defaults to the Set Filter as this example is using ag-Grid Enterprise.
- The **Country** column is explicitly configured to use the Set Filter using `filter='agSetColumnFilter'`.
- All other columns are configured to use the [Number Filter](../filter-number/) using `filter='agNumberColumnFilter'`.
- Filters can be accessed from the [Column Menu](../column-menu/) or by clicking on the filter icon in the [Floating Filters](../floating-filters/).

<grid-example title='Enabling Set Filters' name='enabling-set-filters' type='generated' options='{ "enterprise": true, "exampleHeight": 565, "modules": ["clientside", "setfilter", "menu", "columnpanel"] }'></grid-example>

## Set Filter Parameters

Parameters that are common to all [Provided Filters](../filter-provided/):

<api-documentation source='filter-provided/resources/providedFilters.json' section='filterParams'></api-documentation>


Parameters that are specific to the Set Filter:

<api-documentation source='filter-set/resources/setFilterParams.json' section='filterParams'></api-documentation>

## Next Up


Continue to the next section: [Filter List](../filter-set-filter-list/).
