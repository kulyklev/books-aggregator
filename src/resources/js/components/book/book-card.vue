<template>
    <div>
        <b-card :img-src="book.offers[0].image" img-alt="Card image" img-left class="mb-3" :title="book.name">
            <b-container>
                <b-row>
                    <b-col md="7">
                        <b-row>
                            <b-col md="5">
                                <span>Видавництво:</span>
                            </b-col>
                            <b-col class="p-0">
                                {{ book.publisher }}
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="5">
                                <span>Автор:</span>
                            </b-col>
                            <b-col class="p-0">
                                {{ book.author }}
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="5">
                                <span>Рік:</span>
                            </b-col>
                            <b-col class="p-0">
                                {{ book.publishing_year }}
                            </b-col>
                        </b-row>
                        <router-link :to="bookPage">Перешлянути пропозиції</router-link>
                    </b-col>

                    <b-col>
                        <div>
                            від
                            <span>{{ minPrice }}</span>
                            до
                            <span>{{ maxPrice }}</span>
                            грн
                        </div>

                        <b-row
                                v-for="offer in book.offers"
                                :key="offer.id"
                        >
                            <b-col>
                                <a :href="offer.link">{{ offer.dealer }}</a>
                            </b-col>

                            <b-col>
                                <a :href="offer.link">{{ offer.price }}</a>
                                {{ offer.currency }}
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