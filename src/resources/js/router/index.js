import Vue from 'vue'
import Router from 'vue-router'
import Books from '../components/book/Books'
import Book from '../components/book/Book'

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
    ],
    // TODO turn on history mode
    // mode: 'history'
})