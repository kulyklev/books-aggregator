<template>
    <b-list-group deck>
        <b-container>
            <b-row class="pb-3 pt-3">
                <b-col cols="3">Назва категорії</b-col>
                <b-col cols="7">Посилання</b-col>
                <b-col>
                    <b-button v-b-modal.modal-add-category>Додати категорію</b-button>
                </b-col>
            </b-row>
        </b-container>
        <category-card
                v-for="category in categoriesData"
                :key="category.id"
                :categoryData="category"
        >
        </category-card>
        <add-category-modal></add-category-modal>
    </b-list-group>
</template>

<script>
    import CategoryCard from './category-card'
    import AddCategoryModal from './add-category-modal'

    export default {
        name: "categories",
        components: {
            CategoryCard,
            AddCategoryModal
        },
        mounted() {
            this.$store.dispatch('loadCategoriesData')
        },
        computed: {
            categoriesData() {
                return this.$store.getters.categoriesData
            }
        }
    }
</script>

<style scoped>

</style>