import { getLocalUser } from "./../../helpers/auth"
const user = getLocalUser();

const state = {
  currentUser: user,
  isLoggedIn: !!user,
  loading: null,
  auth_error: null,
  /*
  token: getAccessToken(),
  user: null,
  */
};

const getters = {
  isLoading(state) {
    return state.loading;
  },
  isLoggedIn(state) {
    return state.isLoggedIn;
  },
  currentUser(state) {
    return state.currentUser;
  },
  authError(state) {
    return state.auth_error;
  },
  /*
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
   */
};

const mutations = {
  login(state) {
    state.loading = true;
    state.auth_error = null;
  },
  loginSuccess(state, payload) {
    state.auth_error = null;
    state.isLoggedIn = true;
    state.loading = false;
    state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});
    localStorage.setItem('user', JSON.stringify(state.currentUser));
  },
  loginFailed(state, payload) {
    state.auth_error = null;
    state.loading = false;
    state.auth_error = payload.error;
    state.isLoggedIn = null;
  },
  logout(state) {
    state.loading = true;
    localStorage.removeItem('user');
    state.isLoggedIn = null;
    state.currentUser = null;
    state.loading = false;
  }
  /*
  LOGIN(state, {token}) {
    state.token = token;
  },
  LOGOUT(state) {
    state.token = null;
  },
  FETCH_USER_SUCCESS(state, {user}) {
    state.user = user;
  },
  */
};

const actions = {
  fetchUser({commit, state}) {
    return null;
  },
  login(context) {
    context.commit('login');
  }
  /*
  redirectToLogin() {
    const url = getLoginUrl();
    window.location.replace(url);
  },
  redirectToSignup() {
    const url = getSignupUrl();
    window.location.replace(url);
  },
  login({commit, dispatch}) {
    const token = getParameterByName('access_token');
    const expiration = getParameterByName('expires_in');

    setAccessToken(token, expiration);
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
  */
};

export default {
  state,
  mutations,
  actions,
  getters,
  namespaced: true
};
