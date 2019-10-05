<template>
    <div>
        <header class="title">
            <h1>Your Organizational Network</h1>
            <el-button>info</el-button>

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
    </div>
</template>

<script>
import D3Network from 'vue-d3-network'
import NetworkMenu from '../components/NetworkMenu'

export default {
    name: "mynetwork",
    components: {
        D3Network,
        NetworkMenu
    },
    data() {
        return {

        }
    },
    created() {
        this.raffle();
        axios.get('api/connections')
        .then(response => {
            this.connections = response.data.data;
        });
        axios.get('api/organizations?has_connections=true')
        .then(response => {
            this.organizations = response.data.data
        });
    },
    methods: {
        raffle() {
            this.$notify.info({
                title: "CCVO's annual Connections conference",
                dangerouslyUseHTMLString: true,
                message: "Thanks for participating! To be entered to win an individual ticket to CCVO's annual Connections conference on April 22, 2020, <a href='https://www.hellokrd.net/' target='_blank'>Click Here</a> (link opens in new window).",
                duration: 0
            });
        },
        nodeClick(event, node) {
            this.pinNode(node)
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
    }
}
</script>

<style lang="scss" scoped>
@import "~styles/colors";

.title {
    width: 100%;
    position: fixed;
    
}
.raffle-container {
    width: 40%;
    margin: 0 auto;
}

.toggle-enter-active {
    transition: 1s ease;
}
.toggle-leave-active {
    transition: 1s ease;
}
.toggle-enter, .toggle-leave-to {
    transform: translateX(-100%);
}
.main h1{
    color: #1aad8d !important;
}
.text {
    font-size: 14px;
}
.item {
    margin-bottom: 18px;
}
.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both
}
.menu-card-container {
    position: fixed !important;
    top: 0;
    left: 0;
}
.menu-card-container .menu-button {
    float: left !important;
    position: fixed;
    top: 25px !important;
    left: 40px;
}
.menu-button {
    color: white;
    background-color: #1aad8d;
}
.menu-button:hover {
    color: #1aad8d;
    background-color: #D5F0EA;
}
.menu-card {
    width: 380px;
}
.menu-title {
    margin-top: 10px;
    margin-bottom: 10px;
    color: #1aad8d;
    font-weight: 800;
    font-size: 16
}
.circle {
    height: 15px;
    width: 15px;
    display: inline-block;
    border-radius: 50%;
}
.legend-text {
    float: left !important;
}
</style>