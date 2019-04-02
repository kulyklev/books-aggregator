import Vue from 'vue'
import Vuex from 'vuex'
import {HTTP} from "../axios";

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        books: [],
        book: {},
        categoryNames: [],
        categoriesData: []
    },
    mutations: {
        setLoadedBooksPagination(state, payload) {
            state.books = payload
        },
        setBookData(state, payload) {
            state.book = payload
        },
        setLoadedCategoryNames(state, payload) {
            state.categoryNames = payload
        },
        setLoadedCategoriesData(state, payload) {
            state.categoriesData = payload
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
        loadCategoryNames({commit}) {
            HTTP.get('api/categories')
                .then(response => {
                    let categories = []
                    response.data.data.forEach(function (category) {
                        categories.push({
                            text: category.name,
                            value: category.id
                        })
                    })

                    store.commit('setLoadedCategoryNames', categories)
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
        },
        loadCategoriesData({commit}) {
            HTTP.get('api/categories')
                .then(response => {
                    store.commit('setLoadedCategoriesData', response.data.data)
                })
        },
        saveCategory({commit}, categoryName) {
            let formData = new FormData()
            formData.set('name', categoryName)

            HTTP.post('api/categories', formData)
                .then(response => {
                    store.dispatch('loadCategoriesData')
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
        categoryNames(state) {
            return state.categoryNames
        },
        categoriesData(state) {
                return state.categoriesData
        }
    },
})