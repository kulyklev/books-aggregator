<template>
    <highcharts
            :options="chartOptions"
    >

    </highcharts>
</template>

<script>
    import {Chart} from 'highcharts-vue'

    export default {
        name: "price-chart",
        components: {
            highcharts: Chart
        },
        data() {
            return {
                chartOptions: {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Динаміка зміни ціна'
                    },
                    subtitle: {
                        text: 'Source: WorldClimate.com'
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: 'Цiна, грн.'
                        }
                    },
                    tooltip: {
                        shared: true,
                        crosshairs: true
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        },
                    },
                    series: [{
                        name: 'Tokyo',
                        data: [
                            {x: (new Date("2019-03-21T15:14:53.000000Z")).getTime(), y: 12},
                            {x: (new Date("2019-03-22T15:14:53.000000Z")).getTime(), y: 13},
                            {x: (new Date("2019-03-23T15:14:53.000000Z")).getTime(), y: 14},
                            {x: (new Date("2019-03-24T15:14:53.000000Z")).getTime(), y: 10},
                            {x: (new Date("2019-03-25T15:14:53.000000Z")).getTime(), y: 16},
                            ]
                    }, {
                        name: 'London',
                        data: [
                            {x: (new Date("2019-03-21T15:14:53.000000Z")).getTime(), y: 2},
                            {x: (new Date("2019-03-22T15:14:53.000000Z")).getTime(), y: 3},
                            {x: (new Date("2019-03-23T15:14:53.000000Z")).getTime(), y: 4},
                            {x: (new Date("2019-03-24T15:14:53.000000Z")).getTime(), y: 1},
                            {x: (new Date("2019-03-25T15:14:53.000000Z")).getTime(), y: 6},
                        ]
                    }]
                }
            }
        }
    }
</script>

<style scoped>

</style>