<template>
    <div>
        <b-card :img-src="book.offers[0].image" img-alt="Card image" img-left class="mb-3" :title="book.name">
            <b-container>
                <b-row>
                    <b-col>
                        <div class="price-range">
                            <span>{{ minPrice }}</span>&nbsp-&nbsp;<span>{{ maxPrice }}</span>&nbsp;грн
                        </div>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col lg="12" xl="8">
                        <b-row>
                            <b-col class="pr-0" md="5" lg="3" xl="4">
                                <span>Видавництво:</span>
                            </b-col>
                            <b-col class="p-0" md="7" lg="9" xl="8">
                                {{ book.publisher }}
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="pr-0" md="5" lg="3" xl="4">
                                <span>Автор:</span>
                            </b-col>
                            <b-col class="p-0" md="7" lg="9" xl="8">
                                {{ book.author }}
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="pr-0" md="5" lg="3" xl="4">
                                <span>Рік:</span>
                            </b-col>
                            <b-col class="p-0" md="7" lg="9" xl="8">
                                {{ book.publishing_year }}
                            </b-col>
                        </b-row>
                        <router-link :to="bookPage">Перешлянути пропозиції</router-link>
                    </b-col>

                    <b-col class="d-none d-xl-block" xl="4">
                        <b-row
                                v-for="offer in book.offers"
                                :key="offer.id"
                        >
                            <b-col>
                                <a :href="offer.link">{{ offer.dealer }}</a>
                            </b-col>

                            <b-col>
                                <a :href="offer.link">{{ offer.price }}</a>&nbsp;{{ offer.currency }}
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </b-container>
        </b-card>
    </div>
</template>

<script>
    export default {
        name: "book-card",
        props: [
            'id',
            'book'
        ],
        data() {
            return {
            }
        },
        computed: {
            bookPage() {
                return 'book/' + this.book.id
            },
            minPrice() {
                return this.calcMinPrice()
            },
            maxPrice() {
                return this.calcMaxPrice()
            }
        },
        methods:{
            calcMinPrice() {
                return Math.min(...this.book.offers.map(offer => parseFloat(offer.price)))
            },

            calcMaxPrice() {
                return Math.max(...this.book.offers.map(offer => parseFloat(offer.price)))
            }
        },
    }
</script>

<style scoped>

</style>