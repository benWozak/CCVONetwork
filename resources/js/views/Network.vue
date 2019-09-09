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
        .then((response) => {
            this.connections = response.data 
        });
        axios.get('api/organizations')
        .then((response) => {
            this.organizations = response.data  
        });
    },
    computed:{
        
        nodes: {
            get() {
                return this.nodesDisplay();
            }
        },

        links: { 
           get() {
               return this.linksDisplay();
           }
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
            for(let i = 0; i < this.organizations.length; i++) {
                this.nodes.push({
                    id: this.organizations.id,
                    name: this.organizations.organization_name
                })
            }
        },
        linksDisplay(){
            for(let i = 0; i < this.connections.length; i++) {
                this.links.push({
                    sid: this.connections.host_id,
                    tid: this.connections.contact_id
                })
            }
        },
        
    }
};
</script>

<style lang="scss" scoped>

</style>