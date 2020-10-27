const getters = {
    posts: (state) => {
        return state.posts
    },
    next: (state) => {
        return state.next
    },
    post: (state) => {
        return state.post
    },
    comments: (state) => {
        return state.comments
    },
    nextComment: (state) => {
        return state.nextComment
    },
}

export default getters
