<template>
    <b-container>
        <b-navbar class="mb-2" toggleable="lg" type="dark" variant="primary">
            <b-navbar-brand href="#">Books Aggregator</b-navbar-brand>

            <b-navbar-toggle target="nav_collapse" />

            <b-collapse is-nav id="nav_collapse">
                <b-nav-form class="w-75">
                    <b-form-input class="mr-sm-2 w-75" type="text" placeholder="Search" />
                    <b-button variant="outline-success" class="my-2 my-sm-0" type="submit">Search</b-button>
                </b-nav-form>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <!-- Using button-content slot -->
                        <template slot="button-content"><em>User</em></template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Signout</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <router-view></router-view>
    </b-container>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
