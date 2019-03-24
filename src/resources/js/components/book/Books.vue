<template>
    <b-container class="p-0">
        <b-row>
            <b-col cols="1" sm="2" md="2" lg="2"></b-col>

            <b-col>
                <book-card
                        v-for="book in books.data"
                        :key="book.id"
                        :book="book"
                ></book-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import BookCard from "./book-card";

    export default {
        name: "Books",
        components: {BookCard},
        computed: {
            books() {
                return this.$store.getters.books
            }
        },
        created() {
            this.$store.dispatch('loadBooksPagination')
        }
    }
</script>

<style scoped>

</style>