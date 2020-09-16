import axios from 'axios'

const actions = {
    register: async ({ commit }, register) => {
        return axios.post('/api/register', register).then((response) => {
            const user = response.data || null
            commit('SET_USER', user)
            return user
        })
    },
    login: async ({ commit }, login) => {
        return axios.post('/api/login', login).then((response) => {
            const user = response.data || null
            commit('SET_USER', user)
            return user
        })
    },
    logout: async ({ commit }) => {
        return axios.delete('/api/logout').then(() => {
            commit('RESET_USER')
        })
    },
    setUser: async ({ commit }, user) => {
        commit('SET_USER', user)
    },
    resetUser: async ({ commit }) => {
        commit('RESET_USER')
    },
}

export default actions
