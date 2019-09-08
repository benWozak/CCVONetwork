<template>
    <div class="network">
        <div class="main">
            <d3-network ref='net' 
                :net-nodes="organizations" 
                :net-links="connections" 
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
            linksSelected: {}
        }
    },
    // mounted () {
    //     axios.get('api/connections').then(response => (this.connections = response));
    //     axios.get('api/organizations').then(response => (this.connections = response));
    // },
    computed:{
        
        organizations: { 
            get() { return this.$store.state.organizations } 
        },

        connections: { 
            get() { return this.$store.state.connections } 
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
        // selection() {
        //     return {
        //         nodes: this.selected,
        //         links: this.linksSelected
        //     }
        // },
    },

    methods: {
        // linkClick (event, link) {
        //     if (this.tool === 'killer') {
        //         this.removeLink(link)
        //     } else {
        //         if (this.linksSelected[link.id]) {
        //             this.unSelectLink(link.id)
        //         } else {
        //             this.selectLink(link)
        //         }
        //     }
        //     this.updateSelection()
        // },
        // updateSelection () {
        //     this.showSelection = (Object.keys(this.selected).length | Object.keys(this.linksSelected).length)
        // },
        // clearSelection () {
        //     this.selected = {}
        //     this.linksSelected = {}
        // },
        // selectNodesLinks () {
        //     for (let link of this.links) {
        //         // node is selected
        //         if (this.selected[link.sid] || this.selected[link.tid]) {
        //         this.selectLink(link)
        //         // node is not selected
        //         } else {
        //         this.unSelectLink(link.id)
        //         }
        //     }
        // },
        // selectNode(node) {
        //     this.selected[node.id] = node
        // },
        // selectLink (link) {
        //     this.$set(this.linksSelected, link.id, link)
        // },
        // unSelectNode (nodeId) {
        //     if (this.selected[nodeId]) {
        //         delete (this.selected[nodeId])
        //     }
        //     this.selectNodesLinks()
        // },
        // unSelectLink (linkId) {
        //     if (this.linksSelected[linkId]) {
        //         delete (this.linksSelected[linkId])
        //     }
        // },
        // setShowMenu (show) {
        //     this.showMenu = show
        //     this.showHint = false
        // }
    }
};
</script>

<style lang="scss" scoped>

</style>