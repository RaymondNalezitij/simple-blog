export const state = () => ({
    auth: null
});

export const getters = {
    get(state) {
        return state.auth;
    }
}

export const actions = {

}

export const mutations = {
    set(state, user) {
        state.auth = user;
    }
}
