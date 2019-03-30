import Vue from 'vue'
import Vuex from 'vuex'
import {HTTP} from "../axios";

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        books: [],
        book: {},
        categories: []
    },
    mutations: {
        setLoadedBooksPagination(state, payload) {
            state.books = payload
        },
        setBookData(state, payload) {
            state.book = payload
        },
        setLoadedCategories(state, payload) {
            state.categories = payload
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
                    store.commit('setBookData', response.data)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        loadCategories({commit}) {
            HTTP.get('api/categories')
                .then(response => {
                    let categories = []
                    response.data.data.forEach(function (category) {
                        categories.push({
                            text: category.name,
                            value: category.id
                        })
                    })

                    store.commit('setLoadedCategories', categories)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        loadCategory({commit}, categoryId) {
            HTTP.get('api/category/' + categoryId)
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
            return state.book
        },
        categories(state) {
            return state.categories
        }
    },
})