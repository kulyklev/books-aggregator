<template>
    <b-form-group label="Plain stacked checkboxes">
        <b-form-radio-group
                id="categories-radio-group"
                v-model="selected"
                :options="categoryNames"
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
            categoryNames(){
                return this.$store.getters.categoryNames
            }
        },
        methods: {
            getCategory() {
                this.$store.dispatch('loadCategory', this.selected)
            }
        },
        mounted() {
            this.$store.dispatch('loadCategoryNames')
        },
        watch: {
            selected: 'getCategory'
        }
    }
</script>

<style scoped>

</style>