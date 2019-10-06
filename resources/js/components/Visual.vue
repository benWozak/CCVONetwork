<template>
    <div class="network">
        <div class="main">
            <d3-network ref='net' 
                :net-nodes="nodes" 
                :net-links="links" 
                :options="options"
                :selection="{nodes: selected, links: linksSelected}"/>
        </div>
    </div>
</template>

<script>
import D3Network from 'vue-d3-network'
import Selection from './Selection.vue'


export default {
    name: "network",
    components: {
        D3Network,
        Selection
        
    },
    data() {
        return {
            nodeSize:25,
            selected: {},
            linksSelected: {}
        }
    },
    computed:{
        
        nodes: { 
            get() { return this.$store.state.nodes } 
        },

        links: { 
            get() { return this.$store.state.links } 
        },

        options(){
            return{
                canvas: false,
                force: 4000,
                size:{ w:800, h:800},
                fontSize: 20,
                nodeSize: this.nodeSize,
                nodeLabels: true,
                linkLabels:true,
            }
        },
        selection() {
            return {
                nodes: this.selected,
                links: this.linksSelected
            }
        },
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
@import "~vue-d3-network/dist/vue-d3-network.css";
    .selected {
        border-color: red;
    }
      

</style>
