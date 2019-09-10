<template>
    <div class="network">
        <div class="main">
            <d3-network ref='net'
                :net-nodes="nodes"
                :net-links="links"
                :options="options"/>
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
            this.organizations = response.data.data
        });
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
                links.push({
                    sid: this.connections[i].host_id,
                    tid: this.connections[i].contact_id
                })
            }

            return links;
        },

        options(){
            return{
                force: 3000,
                size:{ w:600, h:600},
                nodeSize: this.nodeSize,
                nodeLabels: true,
                linkLabels:true,
            }
        },
    },

    methods: {
        nodesDisplay(){

        },
        linksDisplay(){

        },

    }
};
</script>

<style lang="scss" scoped>

</style>
