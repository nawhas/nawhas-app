import axios from 'axios';

const state = {
  reciters: [],
  popularReciters: [],
  reciter: []
};

const getters = {
  reciters(state) {
    return state.reciters;
  },
  popularReciters(state) {
    return state.popularReciters;
  },
  reciter(state) {
    return state.reciter;
  },
};

const mutations = {
  FETCH_RECITERS(state, payload) {
    state.reciters = payload.data;
  },
  FETCH_POPULAR_RECITERS(state, payload) {
    state.popularReciters = payload.data;
  },
  FETCH_RECITER(state, payload) {
    state.reciter = payload.data;
  },
  STORE_RECITER(state, payload) {
    state.reciters.push(payload.data);
  }
};

const actions = {
  fetchReciters({commit}) {
    return new Promise((resolve, reject) => {
      axios.get('/v1/reciters').then((response) => {
        commit('FETCH_RECITERS', {
          data: response.data.data
        });
        resolve();
      }).catch(reject);
    });
  },
  fetchPopularReciters({commit}) {
    axios.get('/v1/popular/reciters')
      .then((response) => {
      commit('FETCH_POPULAR_RECITERS', {
        data: response.data.data
      });
      });
  },
  fetchReciter({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.get(`/v1/reciters/${payload.reciter}`)
        .then((response) => {
          commit('FETCH_RECITER', {
            data: response.data
          });
          resolve();
        }).catch(reject);
    });
  },
  storeReciter({commit}, payload) {
    axios.post('/v1/reciters', payload)
      .then((response) => {
      commit('STORE_RECITER', {
        data: response.data
      });
      });
  },
  updateReciter({commit}, payload) {
    axios.post(`/v1/reciters/${payload.reciter.slug}`, payload.form);
  }
};

export default {
  state,
  mutations,
  actions,
  getters,
  namespaced: true
};
