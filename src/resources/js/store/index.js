import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        books: [
            {id: 1, name: 'Book 1', publisher: 'Publisher 1', author: 'Mark T.', year: 2001, offers: [
                    {
                        id: 1,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "99.90",
                        currency: "UAH"
                    },
                    {
                        id: 2,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "100",
                        currency: "UAH"
                    },

                ]},
            {id: 2, name: 'Book 2', publisher: 'Publisher 2', author: 'Mark T.', year: 2003, offers: [
                    {
                        id: 3,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "99.90",
                        currency: "UAH"
                    },
                    {
                        id: 4,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "100",
                        currency: "UAH"
                    },

                ]},
            {id: 3, name: 'Book 3', publisher: 'Publisher 3', author: 'Mark T.', year: 2002, offers: [
                    {
                        id: 5,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "99.90",
                        currency: "UAH"
                    },
                    {
                        id: 6,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "100",
                        currency: "UAH"
                    },

                ]},
            {id: 4, name: 'Book 4', publisher: 'Publisher 4', author: 'Mark T.', year: 2011, offers: [
                    {
                        id: 7,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "99.90",
                        currency: "UAH"
                    },
                    {
                        id: 8,
                        dealer: "bookclub.ua",
                        link: "https://www.bookclub.ua/catalog/books/pop/product.html?id=48765",
                        image: "full/a7d08d8023a354d8f38bddaa40acb0f07e533d04.jpg",
                        price: "100",
                        currency: "UAH"
                    },

                ]},
        ]
    },
    mutations: {},
    actions: {},
    getters: {
        books(state) {
            return state.books
        },
        book(state) {
            return (bookId) => {
                return state.books.find((book) => {
                    return book.id == bookId
                })
            }
        }
    },
})