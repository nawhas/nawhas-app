import axios from 'axios';

const state = {
  tracks: [],
  track: []
};

const getters = {
  tracks(state) {
    return state.tracks;
  },
  track(state) {
    return state.track;
  },
};

const mutations = {
  FETCH_TRACKS(state, payload) {
    state.tracks = payload.data;
  },
  FETCH_TRACK(state, payload) {
    state.track = payload.data;
  },
  STORE_TRACK(state, payload) {
    state.tracks.push(payload.data);
  }
};

const actions = {
  storeTrack({commit}, payload) {
    axios.post(`/v1/reciters/${payload.reciter}/albums/${payload.album}/tracks`, payload.form)
      .then((response) => {
        commit('STORE_TRACK', {
          data: response.data
        });
      });
  },
  updateTrack({commit}, payload) {
    axios.post(`/v1/reciters/${payload.reciter}/albums/${payload.album}/tracks/${payload.track}`, payload.form);
  }
};

export default {
  state,
  mutations,
  actions,
  getters,
  namespaced: true
};
