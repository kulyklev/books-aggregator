import Vue from 'vue'
import Router from 'vue-router'
import Books from '../components/book/Books'
import Book from '../components/book/Book'
import Categories from '../components/category/Categories'
import AddCategoryLink from '../components/category/AddCategoryLink'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'Books',
            component: Books
        },
        {
            path: '/book/:id',
            name: 'Book',
            props: true,
            component: Book
        },
        {
            path: '/categories',
            name: 'Categories',
            props: true,
            component: Categories
        },
        {
            path: '/categories/new-link',
            name: 'AddCategoryLink',
            props: true,
            component: AddCategoryLink
        },
    ],
    // mode: 'history'
})