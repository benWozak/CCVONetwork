<template>
    <div class="network">
        <div class="main">
            <header class="title">
                <h1>Organizational Social Network Analysis</h1>
                <el-button class="button" @click="goToMyNetwork">Your Network</el-button>
                <network-menu>
                    <template  v-slot:block>
                        <span class="menu-title">Zoom</span>
                        <el-slider 
                            :step="10" 
                            @input="handleZoom($event)" 
                            v-model="zoom"
                            @change="secureNodePlacement">
                        </el-slider>
                    </template>
                </network-menu>
            </header>

            <!-- @mousedown="startDrag" @mousemove="drag($event)" @mouseup="stopDrag" @wheel="handleZoom($event)" -->
            <div id="network-container">
                <d3-network ref='net'
                    :net-nodes="nodes"
                    :net-links="links"
                    :options="options"
                    :selection="{nodes: selected, links: linksSelected}"
                    @node-click="nodeClick"
                />
            </div>
        </div>

    </div>
</template>

<script>
import D3Network from 'vue-d3-network'
import NetworkMenu from '../components/NetworkMenu'

export default {
    name: "network",
    components: {
        D3Network,
        NetworkMenu,
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
            organizations: [],
        }
    },
    created() {
        axios.get('api/connections')
        .then(response => {
            this.connections = response.data.data;
        });
        axios.get('api/organizations?has_connections=true')
        .then(response => {
            this.organizations = response.data.data
        });
    },
    mounted() {
        window.scrollTo(1200, 1500);
        this.$nextTick(() => {
            setTimeout(() => {
                this.secureNodePlacement(); 
            }, 5000)
        })
    },
    computed:{

        nodes() {
            let nodes = [];
                for(let i = 0; i < this.organizations.length; i++) {
                    switch(this.organizations[i].subsector.id) {
                        case 1: // Environment
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--light-blue)'
                            })
                            
                            break;
                        case 2: //social services
                             nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--blue)'
                            })
                            break;
                        case 3: //housing
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--olive)'
                            })
                            break;
                        case 4: 
                        case 21: // Art & culture
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--light-green)'
                            })
                            break;
                        case 5: // business
                        case 14:
                             nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--slate-gray)'
                            })
                            break;
                        case 6: // Individual
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--dark-teal)'
                            })
                            break;
                        case 7: // health
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--pink)'
                            })
                            break;
                        case 8: // development
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--dark-pink)'
                            })
                            break;
                        case 9: // education
                        case 17:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--purple)'
                            })
                            break;
                        case 10: //sports
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--red)'
                            })
                            break;
                        case 12: // law
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--orange)'
                            })
                            break;
                        case 13: // government
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--yellow)'
                            })
                            break;
                        case 15: // religion
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--tan)'
                            })
                            break;
                        case 16: // fundraising and volunteer
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--brown)'
                            })
                            break;
                        case 19: //international
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--green)'
                            })
                            break;
                        default: 
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                            })
                            break;
                    }
                    
                }
                return nodes;
        },

        links() {
            let links = [];
                    for(let i = 0; i < this.connections.length; i++) {
        
                    links.push({
                        sid: this.connections[i].host_id,
                        tid: this.connections[i].contact_id,
                    })
                /**
                 * if host_id === contact_id
                 *
                 * add
                 *
                 * _svgAttrs: {"stroke-width":4,opacity:1},name: "Mutual"
                 */
                }
                return links;
        },

        options(){
            return{
                canvas: false,
                //force: 2200,
                force: this.force,
                //size: { w: window.innerWidth - 20, h: window.innerHeight - 10 },
                size: { w: 4000, h: 4000 },
                offset: { x: this.networkX, y: this.networkY },
                fontSize: this.fontSize,
                nodeSize: this.nodeSize,
                nodeLabels: true,
                linkLabels: true,
            }
        },
    },
    methods: {
        nodeClick(event, node) {
            this.pinNode(node)
        },
        goToMyNetwork() {
            this.$router.push("/mynetwork");
        },
        handleZoom($event) {
            this.freeNodePlacement();
            this.fontSize = this.zoom / 1.5;
            this.nodeSize = this.zoom / 1.5;
            this.force = this.zoom * 300;
        },
        secureNodePlacement() {
            for(let i = 0; i < this.nodes.length; i++) {
                this.nodes[i].pinned = true;
                this.nodes[i].fx = this.nodes[i].x
                this.nodes[i].fy = this.nodes[i].y
            }
        },
        freeNodePlacement() {
            for(let i = 0; i < this.nodes.length; i++) {
                this.nodes[i].pinned = false;
                this.nodes[i].fx = null;
                this.nodes[i].fy = null;
            }
        },
        selection () {
            return {
                nodes: this.selected,
                links: this.linksSelected
            }
        },
        pinNode (node) {
            node.pinned = true
            node.fx = node.x
            node.fy = node.y
            this.nodes[node.index] = node
        },
        startDrag($event) {
            // this.startX = $event.offsetX;
            this.dragging = true;
        },
        drag($event) {
            if(this.dragging) {
                this.networkX = $event.offsetX - (window.innerWidth / 2);
                this.networkY = $event.offsetY - ( window.innerHeight / 2);
            }
        },
        stopDrag() {
            this.dragging = false;
        },
    }
};
</script>

<style lang="scss">
@import "~styles/colors";

.title {
    width: 100%;
    position: fixed;
    
}
.menu-title {
    margin-top: 10px;
    margin-bottom: 10px;
    color: #1aad8d;
    font-weight: 800;
    font-size: 16
}
// #network-container {
//     cursor: grab;
// }
// #network-container:active {
//     cursor: grabbing
// }
.main h1{
    color: #1aad8d !important;
}

</style>
