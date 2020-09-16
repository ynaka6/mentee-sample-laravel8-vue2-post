const getters = {
    user: (state) => {
        return state.user
    },
    loggedIn: (state) => {
        return null !== state.user
    },
}

export default getters
