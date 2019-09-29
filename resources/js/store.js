import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    nextId: 0,
    nodes: [], // for individual organizaitions and their connections
    links: [], // for individual organizaitions and their connections
    organizations: [], // for full network of organizaitions and connections
    connections: [] // for full network of organizaitions and connections
  },
  mutations: {
    ADD_NODE: (state, node) => {
      state.nodes.push(node);
    },

    ADD_LINK: (state, link) => {
      state.links.push(link);
    }
  },
  actions: {
    getConnections() {
      axios.get('api/connections').then(response => (this.connections = response));
    },
    getOrganizations() {
      axios.get('api/organizations').then(response => (this.connections = response));
    },
  }
});
