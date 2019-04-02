<template>
    <b-modal id="modal-add-category"
             centered
             title="Додавання нової категорії"
             @ok="handleOk"
             ref="modal"
    >
        <b-form @submit.stop.prevent="handleSubmit" @reset="onReset" v-if="show">
            <b-form-group
                    id="input-group-category-name"
                    label="Назва категорії"
                    label-for="input-1"
            >
                <b-form-input
                        id="input-1"
                        v-model="form.categoryName"
                        type="email"
                        required
                        placeholder="Введіть назву категорії"
                ></b-form-input>
            </b-form-group>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        name: "add-category-modal",
        data() {
            return {
                form: {
                    categoryName: '',
                },
                show: true
            }
        },
        methods: {
            handleSubmit(evt) {
                this.$nextTick(() => {
                    alert(this.form.categoryName)
                    this.clearCategoryName()
                    // Wrapped in $nextTick to ensure DOM is rendered before closing
                    this.$refs.modal.hide()
                })
            },
            handleOk(evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.form.categoryName) {
                    alert('Please enter your name')
                } else {
                    this.handleSubmit()
                }
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.categoryName = ''

                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            clearCategoryName(){
                this.form.categoryName = ''
            }
        }
    }
</script>

<style scoped>

</style>