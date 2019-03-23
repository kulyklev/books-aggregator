<template>
    <b-container class="p-0">
        <b-row>
            <b-col cols="1" sm="2" md="2" lg="2"></b-col>

            <b-col >
                <book-card></book-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import BookCard from "./book-card";
    export default {
        name: "Books",
        components: {BookCard}
    }
</script>

<style scoped>

</style>