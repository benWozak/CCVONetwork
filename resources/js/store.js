import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    nextId: 0,
    nodes: [], // for individual organizaitions and their connections
    links: [], // for individual organizaitions and their connections
    organizations: [ // for full network of organizaitions and connections
      // {
      //   id: 1,
      //   name: "Gui",
      //   is_member: 1,
      //   info: { subsector: "Marketing" }
      // },
      // {
      //   id: 2,
      //   name: "Rupert",
      //   is_member: 1,
      //   info: { subsector: "Developer" }

      // },
      // {
      //   id: 3,
      //   name: "Ben",
      //   is_member: 1,
      //   info: { subsector: "Developer" }
      // },
      // {
      //   id: 4,
      //   name: "Alanya",
      //   is_member: 1,
      //   info: { subsector: "Communications" }

      // },
      // {
      //   id: 5,
      //   name: "Amanda",
      //   is_member: 1,
      //   info: { subsector: "Accounting" }
      // },
      // {
      //   id: 6,
      //   name: "Little Ben",
      //   is_member: 1,
      //   info: { subsector: "Train Conductor" }

      // },
      // {
      //   id: 7,
      //   name: "Scott",
      //   is_member: 1,
      //   info: { subsector: "Marketing" }
      // },
      // {
      //   id: 8,
      //   name: "Roman",
      //   is_member: 1,
      //   _color: "orange",
      //   subsector: "Master Consultor"
      // },
      // {
      //   id: 9,
      //   name: "Christie",
      //   is_member: 1,
      //   info: { subsector: "Social Work" }
      // },
      // {
      //   id: 10,
      //   name: "Erin",
      //   is_member: 1,
      //   info: { subsector: "Social Work" }
      // }
    ],
    connections: [ // for full network of organizaitions and connections
      // Temporary Test Data
      // { sid: 1, tid: 2 },
      // { sid: 2, tid: 8 },
      // { sid: 3, tid: 4 },
      // { sid: 4, tid: 5 },
      // { sid: 5, tid: 6 },
      // { sid: 7, tid: 8 },
      // { sid: 5, tid: 8 },
      // { sid: 3, tid: 8 },
      // { sid: 7, tid: 9 },
      // { sid: 4, tid: 2 },
      // { sid: 8, tid: 4 },
      // { sid: 3, tid: 2 },
      // { sid: 10, tid: 9 }
      //_svgAttrs:{"stroke-width":8,opacity:1},name: "test" 
    ]
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
    // submitForm({ state }) {
        
      

    //   return request.store();
    // }
  }
});
