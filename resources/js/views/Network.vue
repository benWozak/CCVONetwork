<template>
    <div class="network">
        <div class="main">
            <h1>Organizational Social Network Analysis</h1>
            <div>
                Would you like to be entered to win an individual ticket to CCVO's annual Connections conference on April 22, 2020?
                    <p>Click <a href="https://www.hellokrd.net/">here</a> to enter</p>
            </div>
            <d3-network ref='net'
                :net-nodes="nodes"
                :net-links="links"
                :options="options"
                v-if="renderComponent"/>
        </div>
    </div>
</template>

<script>
import D3Network from 'vue-d3-network'
// import Selection from './Selection.vue'


export default {
    name: "network",
    components: {
        D3Network,
        Selection

    },
    data() {
        return {
            renderComponent: true,
            nodeSize:20,
            selected: {},
            linksSelected: {},
            connections: [],
            organizations: [],
        }
    },
    mounted () {
        axios.get('api/connections')
        .then(response => {
            this.connections = response.data.data;
        });
        axios.get('api/organizations?has_connections=true')
        .then(response => {
            this.organizations = response.data.data;
        });
        this.forceRerender();
    },
    computed:{

        nodes() {
            let nodes = [];
                for(let i = 0; i < this.organizations.length; i++) {
                    nodes.push({
                        id: this.organizations[i].id,
                        name: this.organizations[i].organization_name
                    })
                }
                return nodes;
        },

        links() {
            let links = [];
                    for(let i = 0; i < this.connections.length; i++) {
                    console.log('host: ' + this.connections[i].host_id, 'contact: ' +this.connections[i].contact_id)
                    links.push({
                        sid: this.connections[i].host_id,
                        tid: this.connections[i].contact_id
                    })
                    this.checkLinks();
                }
                return links;
        },

        options(){
            return{
                force: 2000,
                size:{ w:1400, h:1200},
                nodeSize: this.nodeSize,
                nodeLabels: true,
                linkLabels:true,
            }
        },
    },

    methods: {
        forceRerender() {
            this.renderComponent = false;
            
            this.$nextTick().then(() => {
                this.renderComponent = true;
            });
        },
        checkLinks() {
    //       if(this.connections[i].host_id === )
                 
                
    //   _svgAttrs: {"stroke-width":4,opacity:1},name: "Mutual"
                 
        }

    }
};
</script>

<style lang="scss" scoped>

</style>
