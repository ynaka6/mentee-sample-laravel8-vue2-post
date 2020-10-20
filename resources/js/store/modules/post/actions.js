import axios from 'axios'

const actions = {
    fetchPosts: async ({ commit, state }, { hashtag = null, reset = false }) => {
        if (reset) {
            commit('SET_POSTS', [])
            commit('SET_NEXT', null)
        }
        const params = { hashtag, maxId: state.next }
        const response = await axios.get('/api/posts', { params })
        commit('PUSH_POSTS', response.data.posts)
        commit('SET_NEXT', response.data.next)
    },
    fetchPost: async ({ state }, { id }) => {
        let post = state.posts.find(p => p.id === id)
        if (!post) {
            const response = await axios.get(`/api/post/${id}`)
            post = response.data
        }
        return post
    },
    createPost: async ({ commit }, formData) => {
        return await axios
            .post('/api/post', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
            .then((response) => {
                commit('PREPEND_POSTS', [response.data])
            })
    },
    deletePost: async ({ commit }, { id }) => {
        await axios.delete(`/api/post/${id}`)
        commit('REMOVE_POST', id)
    },
}

export default actions
