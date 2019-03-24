import Vue from 'vue'
import Vuex from 'vuex'
import {HTTP} from "../axios";

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
                ]
            },
        ]
    },
    mutations: {
        setLoadedBooksPagination(state, payload) {
            state.books = payload
        }
    },
    actions: {
        loadBooksPagination() {
            HTTP.get('api/books')
                .then(response => {
                    store.commit('setLoadedBooksPagination', response.data)
                })
                .catch(e => {
                    console.log(e)
                })
        }
    },
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