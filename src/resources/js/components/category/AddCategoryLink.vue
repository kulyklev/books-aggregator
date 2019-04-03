<template>
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
        <b-form-group
                id="input-group-1"
                label="Посилання:"
                label-for="input-1"
        >
            <b-form-input
                    id="input-1"
                    v-model="form.link"
                    type="url"
                    required
                    placeholder="Введіть посилання"
            ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-2" label="Продавець" label-for="input-2">
            <b-form-select
                    id="input-2"
                    v-model="form.dealer"
                    required
                    :options="dealers"
            ></b-form-select>
        </b-form-group>

        <b-button type="submit" variant="primary">Зберегти</b-button>
        <b-button type="reset" variant="danger">Відмінити</b-button>
    </b-form>
</template>

<script>
    export default {
        name: "AddCategoryLink",
        props: ['categoryId'],
        data() {
            return {
                form: {
                    link: '',
                    dealer: ''
                },
                show: true
            }
        },
        mounted() {
            this.$store.dispatch('loadDealers')
        },
        computed: {
            dealers() {
                return this.$store.getters.dealers
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()
                this.$store.dispatch('saveCategoryLink', {
                    link: this.form.link,
                    dealer: this.form.dealer
                })
                alert(JSON.stringify(this.form.dealer))
                this.$router.push({name: 'Categories'})
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.name = ''
                this.form.food = null
                this.form.checked = []
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
                this.$router.go(-1)
            }
        }
    }
</script>

<style scoped>

</style>