<template>
    <b-list-group-item>
        <b-container>
            <b-row>
                <b-col cols="3" class="pl-0">{{ categoryData.name }}</b-col>

                <b-col cols="7">
                    <b-row
                            v-for="categoryLink in categoryData.links"
                            :key="categoryLink.id"
                    >
                        {{ categoryLink.url }}
                    </b-row>
                </b-col>

                <b-col align-self="center">
                    <b-row align-h="end">
                        <b-button
                                block
                                variant="outline-primary"
                                :to="{name: 'AddCategoryLink', params:{categoryId: categoryData.id}}"
                        >Додати посилання</b-button>
                    </b-row>
                    <b-row align-h="end" class="pt-2">
                        <b-button block>Редагувати посилання</b-button>
                    </b-row>
                </b-col>
            </b-row>
        </b-container>
    </b-list-group-item>
</template>

<script>
    export default {
        name: "category-card",
        components: {

        },
        props: ['categoryData'],
        data() {
            return {

            }
        }
    }
</script>

<style scoped>

</style>