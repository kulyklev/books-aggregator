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
        props: ['offers'],
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
                    series: []
                }
            }
        },
        methods: {
            prepareChartData() {
                let res = [];

                this.offers.forEach(function (offer) {
                    let offerObj = {}
                    offerObj.name = offer.dealer
                    offerObj.data = []

                    offer.prices.forEach(function (price) {
                        let point = {}

                        point.x = new Date(price.date).getTime()
                        point.y = parseFloat(price.price)
                        offerObj.data.push(point)
                    })
                    res.push(offerObj)
                })
                console.log(res)
                this.chartOptions.series = res
            }
        },
        watch: {
            offers: 'prepareChartData'
        }
    }
</script>

<style scoped>

</style>