export default {

    namespaced: true,

    state: {
        auth: localStorage.getItem('auth')
    },

    actions: {

        create ({state}, token) {
            state.auth = token;
            localStorage.setItem('auth', token);
        },

        destroy ({state}) {
            state.auth = null;
            localStorage.removeItem('auth');
        }

    }

}