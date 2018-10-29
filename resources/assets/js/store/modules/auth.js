import router from '../../routes'

const state = {
  token: null,
  user: null,
};

const mutations = {
  LOGIN(state, {token}) {
    state.token = token;
  },
  LOGOUT(state) {
    state.token = null;
  },
  FETCH_USER_SUCCESS(state, {user}) {
    state.user = user;
  },
};

const actions = {
  redirectToLogin() {
    const url = null;
    window.location.replace(url);
  },
  redirectToSignup() {
    const url = null;
    window.location.replace(url);
  },
  login({commit, dispatch}) {
    const token = null;
    const expiration = null;

    // setAccessToken(token, expiration);
    commit('LOGIN', {token});
    dispatch('fetchUser').then(() => {
      router.push('/');
    });
  },
  logout({commit}) {
    client.post('logout').then(() => {
      clearAccessToken();
      commit('LOGOUT');
      router.push('/');
    });
  },
  fetchUser({commit, state}) {
    return new Promise((resolve) => {
      if (!state.token) {
        resolve();
        return;
      }

      client.get('v1/user').then((response) => {
        commit('FETCH_USER_SUCCESS', { user: response.data });
        resolve();
      }).catch(() => {
        clearAccessToken();
        commit('LOGOUT');
        resolve();
      });
    });
  },
};

const getters = {
  authenticated(state) {
    return !!state.token;
  },
  isAdmin(state) {
    return state.user && state.user.role === 'admin';
  },
  userRole(state) {
    if (state.user) {
      return state.user.role;
    }
    return null;
  }
};

export default {
  state,
  mutations,
  actions,
  getters,
  namespaced: true
};
