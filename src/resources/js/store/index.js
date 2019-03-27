import Vue from 'vue'
import Vuex from 'vuex'
import {HTTP} from "../axios";

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        books: [],
        book: {}
    },
    mutations: {
        setLoadedBooksPagination(state, payload) {
            state.books = payload
        },
        setBookData(state, payload) {
            state.book = payload
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
        },
        updateBooksPagination({commit}, page) {
            HTTP.get('api/books', {
                params: {
                    page: page
                }
            })
                .then(response => {
                    store.commit('setLoadedBooksPagination', response.data)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        loadBookData({commit}, bookId) {
            HTTP.get('api/books/' + bookId)
                .then(response => {
                    console.log(response.data)
                    store.commit('setBookData', response.data)
                    console.log(store.state.book)
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
            return state.book
        }
    },
})