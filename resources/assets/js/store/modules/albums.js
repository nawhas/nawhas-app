import axios from 'axios';

const state = {
  albums: [],
  album: []
};

const getters = {
  albums(state) {
    return state.albums;
  },
  album(state) {
    return state.album;
  },
};

const mutations = {
  FETCH_ALBUMS(state, payload) {
    state.albums = payload.data;
  },
  FETCH_ALBUM(state, payload) {
    state.album = payload.data;
  },
  STORE_ALBUM(state, payload) {
    state.albums.push(payload.data);
  }
};

const actions = {
  fetchAlbums({commit}, payload) {
    axios.get(`/v1/reciters/${payload.reciter}/albums`)
      .then((response) => {
        commit('FETCH_ALBUMS', {
          data: response.data
        });
      });
  },
  fetchAlbum({commit}, payload) {
    axios.get(`/v1/reciters/${payload.reciter}/albums/${payload.album}`)
      .then((response) => {
        commit('FETCH_ALBUM', {
          data: response.data
        });
      });
  },
  storeAlbum({commit}, payload) {
    axios.post(`/v1/reciters/${payload.reciter}/albums`, payload.form)
      .then((response) => {
        commit('STORE_ALBUM', {
          data: response.data
        });
      });
  },
  updateAlbum({commit}, payload) {
    axios.post(`/v1/reciters/${payload.reciter.slug}/albums/${payload.album.year}`, payload.form);
  }
};

export default {
  state,
  mutations,
  actions,
  getters,
  namespaced: true
};
