const mutations = {
    SET_POSTS: (state, posts) => {
        state.posts = posts
    },
    PUSH_POSTS: (state, posts) => {
        state.posts.push(...posts)
    },
    PREPEND_POSTS: (state, posts) => {
        state.posts = [...posts, ...state.posts]
    },
    SET_NEXT: (state, next) => {
        state.next = next
    },
    SET_POST: (state, post) => {
        state.post = post
    },
    REMOVE_POST: (state, id) => {
        state.posts = state.posts.filter((p) => p.id !== id)
    },
}

export default mutations
