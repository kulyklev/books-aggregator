<template>
    <div>
        this is book page #{{ this.id }}
    </div>
</template>

<script>
    export default {
        name: "Book",

        props: [
            'id'
        ],
    }
</script>

<style scoped>

</style>