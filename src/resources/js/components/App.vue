<template>
    <b-container>
        <b-navbar class="mb-2" toggleable="sm" type="dark" variant="primary" fixed="top">
            <b-navbar-brand href="#">Books Aggregator</b-navbar-brand>

            <b-navbar-toggle target="nav_collapse" />

            <b-collapse is-nav id="nav_collapse">
                <b-nav-form @submit="searchBook" class="w-50">
                    <b-form-input v-model="searchPhrase" class="mr-sm-2 w-50" type="text" placeholder="Search" />
                    <b-button variant="success" class="my-2 ml-2 my-sm-0" type="submit">Search</b-button>
                </b-nav-form>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <!--<b-nav-item-dropdown right>
                        &lt;!&ndash; Using button-content slot &ndash;&gt;
                        <template slot="button-content"><em>User</em></template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Signout</b-dropdown-item>
                    </b-nav-item-dropdown>-->
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <router-view></router-view>
    </b-container>
</template>

<script>
    export default {
        data() {
            return {
                searchPhrase: ''
            }
        },
        mounted() {

        },
        methods: {
            searchBook() {
                this.$store.dispatch('searchBook', this.searchPhrase)
            }
        }

    }
</script>
