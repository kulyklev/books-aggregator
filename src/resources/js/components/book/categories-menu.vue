<template>
    <b-form-group label="Plain stacked checkboxes">
        <b-form-checkbox-group
                v-model="selected"
                :options="categories"
                plain
                stacked
        ></b-form-checkbox-group>
    </b-form-group>
</template>

<script>
    export default {
        name: "categories-menu",
        data() {
            return {
                selected: [], // Must be an array reference!
                options: [
                    { text: 'Orange', value: 'orange' },
                    { text: 'Apple', value: 'apple' },
                    { text: 'Pineapple', value: 'pineapple' },
                    { text: 'Grape', value: 'grape' }
                ]
            }
        },
        computed: {
            categories(){
                return this.$store.getters.categories
            }
        },
        mounted() {
            this.$store.dispatch('loadCategories')
        }
    }
</script>

<style scoped>

</style>