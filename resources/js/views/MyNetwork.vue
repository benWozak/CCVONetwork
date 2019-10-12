<template>
  <div>
    <header class="header">
      <Navbar />
    </header>

    <network-menu>
      <template v-slot:block>
        <span class="menu-title">Zoom</span>
        <el-slider
          :step="10"
          @input="handleZoom($event)"
          v-model="zoom"
          @change="secureNodePlacement"
        ></el-slider>
      </template>
    </network-menu>

    <div id="network-container">
      <d3-network
        ref="net"
        :net-nodes="nodes"
        :net-links="links"
        :options="options"
        :selection="{nodes: selected, links: linksSelected}"
        @node-click="nodeClick"
      />
    </div>
  </div>
</template>

<script>
import D3Network from "vue-d3-network";
import NetworkMenu from "../components/NetworkMenu";
import Navbar from "../components/Navbar";

export default {
  name: "mynetwork",
  components: {
    D3Network,
    NetworkMenu,
    Navbar
  },
  data() {
    return {
      renderComponent: true,
      dragging: false,
      zoom: 20,
      fontSize: 25,
      nodeSize: 35,
      force: 5000,
      networkX: 0,
      networkY: 0,
      center: true,
      selected: {},
      linksSelected: {},
      connections: [],
      organizations: []
    };
  },
  created() {
    // this.raffle();

    axios.get(`api/organizations/${this.organizationId}/network`)
      .then(response => {
        // console.log(this.organizationId);
        this.organizations = response.data.data.organizations;
        this.connections = response.data.data.connections;
        // console.log(response.data.data);
      }).catch(error => {
        if (error) {
          console.log(error);
        }
      });
  },
  mounted() {
    // window.scrollTo(2000, 2000);
    this.$nextTick(() => {
      setTimeout(() => { 
        this.secureNodePlacement();
      }, 4000);
    });
  },
  methods: {
    // raffle() {
    //   this.$notify.info({
    //     title: "CCVO's annual Connections conference",
    //     dangerouslyUseHTMLString: true,
    //     message:
    //       "Thanks for participating! To be entered to win an individual ticket to CCVO's annual Connections conference on April 22, 2020, <a href='https://www.hellokrd.net/' target='_blank'>Click Here</a> (link opens in new window).",
    //     duration: 0
    //   });
    // },
    nodeClick(event, node) {
      this.pinNode(node);
    },
    handleZoom($event) {
      this.freeNodePlacement();
      this.fontSize = this.zoom / 1.5;
      this.nodeSize = this.zoom / 1.5;
      this.force = this.zoom * 300;
    },
    secureNodePlacement() {
      for (let i = 0; i < this.nodes.length; i++) {
        this.nodes[i].pinned = true;
        this.nodes[i].fx = this.nodes[i].x;
        this.nodes[i].fy = this.nodes[i].y;
      }
    },
    freeNodePlacement() {
      for (let i = 0; i < this.nodes.length; i++) {
        this.nodes[i].pinned = false;
        this.nodes[i].fx = null;
        this.nodes[i].fy = null;
      }
    },
    selection() {
      return {
        nodes: this.selected,
        links: this.linksSelected
      };
    },
    pinNode(node) {
      node.pinned = true;
      node.fx = node.x;
      node.fy = node.y;
      this.nodes[node.index] = node;
    }
  },
  computed: {
    organizationId: {
      get() {
        return this.$store.state.currentId;
      }
    },

    nodes() {
      // console.log(this.organizations);
      let nodes = [];
      for (let i = 0; i < this.organizations.length; i++) {
        switch (this.organizations[i].subsector_id) {
          case 1: // Environment
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--light-blue)"
            });

            break;
          case 2: //social services
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--blue)"
            });
            break;
          case 3: //housing
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--olive)"
            });
            break;
          case 4:
          case 21: // Art & culture
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--light-green)"
            });
            break;
          case 5: // business
          case 14:
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--slate-gray)"
            });
            break;
          case 6: // Individual
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--dark-teal)"
            });
            break;
          case 7: // health
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--pink)"
            });
            break;
          case 8: // development
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--dark-pink)"
            });
            break;
          case 9: // education
          case 17:
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--purple)"
            });
            break;
          case 10: //sports
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--red)"
            });
            break;
          case 12: // law
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--orange)"
            });
            break;
          case 13: // government
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--yellow)"
            });
            break;
          case 15: // religion
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--tan)"
            });
            break;
          case 16: // fundraising and volunteer
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--brown)"
            });
            break;
          case 19: //international
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name,
              _color: "var(--green)"
            });
            break;
          default:
            nodes.push({
              id: this.organizations[i].id,
              name: this.organizations[i].name
            });
            break;
        }
      }
      return nodes;
    },

    links() {
      // console.log(this.connections)
      let links = [];
      for (let i = 0; i < this.connections.length; i++) {
        links.push({
          sid: this.connections[i].host_id,
          tid: this.connections[i].contact_id
        });
      }
      return links;
    },

    options() {
      return {
        canvas: false,
        //force: 2200,
        force: this.force,
        size: { w: window.innerWidth, h: window.innerHeight },
        // size: { w: 1600, h: 900 },
        offset: { x: this.networkX, y: this.networkY },
        fontSize: this.fontSize,
        nodeSize: this.nodeSize,
        nodeLabels: true,
        linkLabels: true
      };
    }
  }
};
</script>

<style lang="scss" scoped>
@import "~styles/colors";

.header {
  width: 100%;
  height: 60px;
  position: fixed;
  background-color: white;
}

.menu-title {
  margin-top: 10px;
  margin-bottom: 10px;
  color: #1aad8d;
  font-weight: 800;
  font-size: 16;
}
.main h1 {
  color: #1aad8d !important;
}
</style>