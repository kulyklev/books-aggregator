<template>
    <b-container>
        <b-row>
            <b-col cols="1" sm="2" md="2" lg="2">

            </b-col>

            <b-col class="p-0">
                <b-card>
                    <h1>{{ book.name }}</h1>

                    <b-row>
                        <b-col cols="1" sm="2" md="3" lg="3">
                            <b-card-img
                                    src="https://www.bookclub.ua/images/db/goods/49568_83765.jpg"
                                    width="5em"
                                    height="auto"
                            />
                        </b-col>

                        <b-col>
                            <b-row>
                                от
                                <span>100</span>
                                до
                                <span>200</span>
                            </b-row>

                            <b-row>
                                <b-col md="4" lg="3">Оригінальна назва</b-col>
                                <b-col>{{ book.original_name }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Автор</b-col>
                                <b-col>{{ book.author }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">ISBN</b-col>
                                <b-col>{{ book.isbn }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Мова</b-col>
                                <b-col>{{ book.language }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Мова оригіналу</b-col>
                                <b-col>{{ book.original_language }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Сторінок</b-col>
                                <b-col>{{ book.paperback }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Формат</b-col>
                                <b-col>{{ book.product_dimensions }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Видавництво</b-col>
                                <b-col>{{ book.publisher }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Рік видання</b-col>
                                <b-col>{{ book.publishing_year }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Категорія</b-col>
                                <b-col>{{ book.category }}</b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4" lg="3">Вага</b-col>
                                <b-col>{{ book.weight }}</b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                </b-card>

                <b-card class="mt-2">
                    <h3>offers</h3>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: "Book",

        props: ['id'],
        mounted() {
            this.$store.dispatch('loadBookData', this.id)
        },
        computed: {
            book() {
                return this.$store.getters.book
            }
        }
    }
</script>

<style scoped>

</style>