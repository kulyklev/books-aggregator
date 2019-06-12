<template>
    <b-container class="container-align">
        <b-row>
            <b-col class="pr-md-1" cols="1" sm="4" md="3" lg="2">
                <categories-menu></categories-menu>
            </b-col>

            <b-col class="pl-md-0" cols="11" sm="8" md="9" lg="10">
                <book-card
                        v-for="book in books.data"
                        :key="book.id"
                        :book="book"
                ></book-card>
            </b-col>
        </b-row>

        <b-row align-h="center">
            <b-pagination-nav
                    align="center"
                    base-url="http://booksaggregator.local/"
                    :number-of-pages="books.meta.last_page"
                    :link-gen="linkGen"
                    first-text="First"
                    prev-text="Prev"
                    next-text="Next"
                    last-text="Last"
                    v-model="books.meta.current_page"
                    @input="updatePagination(books.meta.current_page)"
            />
        </b-row>
    </b-container>
</template>

<script>
    import BookCard from "./book-card";
    import CategoriesMenu from "./categories-menu"

    export default {
        name: "Books",
        components: {
            BookCard,
            CategoriesMenu
        },
        computed: {
            books() {
                return this.$store.getters.books
            }
        },
        mounted() {
            if (this.containsKey(this.$route.query, 'page')) {
                this.$store.dispatch('updateBooksPagination', this.$route.query.page)
            } else {
                this.$store.dispatch('loadBooksPagination')
            }
        },
        methods: {
            linkGen(pageNum) {
                return {
                    path: '/',
                    query: {page: pageNum}
                }
            },
            updatePagination(currentPage) {
                this.$store.dispatch('updateBooksPagination', currentPage)
            },
            containsKey(obj, key ) {
                return Object.keys(obj).includes(key);
            }
        }
    }
</script>

<style scoped>

</style>