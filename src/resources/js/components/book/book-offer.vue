<template>
    <b-list-group-item :href="offer.link">
        <b-row>
            <b-col cols="3">
                <b-img :src="offer.logo" fluid left class="book-offer-image"></b-img>
            </b-col>
            <b-col class="text-right">
                {{ offer.price }} &nbsp; {{ offer.currency }}
            </b-col>
        </b-row>
    </b-list-group-item>
</template>

<script>
    export default {
        name: "book-offer",
        props: ['offer']
    }
</script>

<style scoped>

</style>