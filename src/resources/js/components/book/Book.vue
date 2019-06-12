<template>
    <b-container class="container-align">
        <b-row>
            <b-col class="p-0">
                <b-card>
                    <h1>{{ book.name }}</h1>

                    <b-row>
                        <b-col cols="8" sm="8" md="3" lg="3">
                            <b-card-img
                                    :src="imageLink"
                                    width="5em"
                                    height="auto"
                            />
                        </b-col>

                        <b-col>
                            <b-row>
                                <b-col class="price-range">
                                    Ціна:&nbsp;<span>{{ minPrice }}</span>&nbsp-&nbsp;<span>{{ maxPrice }}</span>&nbsp;грн
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Оригінальна назва</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.original_name }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Автор</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.author }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">ISBN</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.isbn }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Мова</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.language }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Мова оригіналу</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.original_language }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Сторінок</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.paperback }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Формат</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.product_dimensions }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Видавництво</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.publisher }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Рік видання</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.publishing_year }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Категорія</b-col>
                                <b-col class="pl-0 pl-sm-0"> {{ book.category }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col class="pr-0 pr-sm-0" cols="5" sm="5" md="4" lg="3">Вага</b-col>
                                <b-col class="pl-0 pl-sm-0">{{ book.weight }}</b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                </b-card>

                <b-card class="mt-2">
                    <b-list-group>
                        <h3>Купити книгу</h3>
                        <book-offer
                                v-for="offer in book.offers"
                                :key="offer.id"
                                :offer="offer"
                        ></book-offer>
                    </b-list-group>
                </b-card>

                <b-card class="mt-2">
                    <price-chart
                            :offers="book.offers"
                    ></price-chart>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import BookOffer from './book-offer'
    import PriceChart from './price-chart'
    import CategoriesMenu from "./categories-menu"

    export default {
        name: "Book",
        components: {
            BookOffer,
            PriceChart,
            CategoriesMenu
        },
        props: ['id'],
        data() {
            return {
                minPrice: null,
                maxPrice: null,
                imageLink: ''

            }
        },
        mounted() {
            this.$store.dispatch('loadBookData', this.id).then(() => {
                this.imageLink = this.$store.getters.book.offers[0].image
            })
        },
        computed: {
            book() {
                return this.$store.getters.book
            },
        },
        methods:{
            updateMinMaxPrices() {
                this.minPrice = this.calcMinPrice()
                this.maxPrice = this.calcMaxPrice()
            },

            calcMinPrice() {
                return Math.min(...this.book.offers.map(offer => parseFloat(offer.price)))
            },

            calcMaxPrice() {
                return Math.max(...this.book.offers.map(offer => parseFloat(offer.price)))
            }
        },
        watch: {
            book: 'updateMinMaxPrices'
        }
    }
</script>

<style scoped>

</style>