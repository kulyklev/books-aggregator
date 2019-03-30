<template>
    <b-form-group label="Plain stacked checkboxes">
        <b-form-radio-group
                id="categories-radio-group"
                v-model="selected"
                :options="categories"
                name="categories"
        ></b-form-radio-group>
    </b-form-group>
</template>

<script>
    export default {
        name: "categories-menu",
        data() {
            return {
                selected: null,
            }
        },
        computed: {
            categories(){
                return this.$store.getters.categories
            }
        },
        methods: {
            getCategory() {
                this.$store.dispatch('loadCategory', this.selected)
            }
        },
        mounted() {
            this.$store.dispatch('loadCategories')
        },
        watch: {
            selected: 'getCategory'
        }
    }
</script>

<style scoped>

</style>