<template>
    <div>
        <b-card img-src="https://placekitten.com/300/300" img-alt="Card image" img-left class="mb-3" :title="book.name">
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
                        <router-link to="/book/1">Go to book</router-link>
                    </b-col>

                    <b-col>
                        <div>
                            від
                            <span>100</span>
                            до
                            <span>200</span>
                            грн
                        </div>

                        <b-row
                                v-for="offer in book.offers"
                                :key="offer.id"
                        >
                            <b-col>
                                <a href="#">{{ offer.dealer }}</a>
                            </b-col>

                            <b-col>
                                <a href="#">{{ offer.price }}</a>
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
        }

    }
</script>

<style scoped>

</style>