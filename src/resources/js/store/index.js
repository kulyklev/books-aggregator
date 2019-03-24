import Vue from 'vue'
import Vuex from 'vuex'
import {HTTP} from "../axios";

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        books: []
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