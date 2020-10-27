const mutations = {
    SET_POSTS: (state, posts) => {
        state.posts = posts
    },
    SET_COMMENTS: (state, comments) => {
        state.comments = comments
    },
    PUSH_POSTS: (state, posts) => {
        state.posts.push(...posts)
    },
    PUSH_COMMENTS: (state, comments) => {
        state.comments.push(...comments)
    },
    PREPEND_POSTS: (state, posts) => {
        state.posts = [...posts, ...state.posts]
    },
    PREPEND_COMMENTS: (state, comments) => {
        state.comments = [...comments, ...state.comments]
    },
    SET_NEXT: (state, next) => {
        state.next = next
    },
    SET_NEXT_COMMENT: (state, next) => {
        state.nextComment = next
    },
    SET_POST: (state, post) => {
        state.post = post
    },
    REMOVE_POST: (state, id) => {
        state.posts = state.posts.filter((p) => p.id !== id)
    },
}

export default mutations
