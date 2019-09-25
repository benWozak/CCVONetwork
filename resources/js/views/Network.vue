<template>
    <div class="network">
        <div class="main">
            <header class="title">
                <h1>Organizational Social Network Analysis</h1>
            </header>

            <!-- @mousedown="startDrag" @mousemove="drag($event)" @mouseup="stopDrag" @wheel="handleZoom($event)" -->
            <div id="network-container">
                <d3-network ref='net'
                    :net-nodes="nodes"
                    :net-links="links"
                    :options="options"
                />
            </div>
        </div>

        <div class="menu-card-container">
            <el-button class="menu-button" v-show="!opened"  @click="toggle">Menu</el-button>
            <transition name="toggle">
                <el-card class="menu-card" v-show="opened">
                    <div slot="header" class="clearfix">
                        <el-button style="float: left; padding: 3px 0; color: #1aad8d; font-size: 2rem;" type="text" icon="el-icon-s-home" @click="goToHome"></el-button>
                        <span class="menu-title">Menu</span>
                        <el-button style="float: right; padding: 3px 0; color: #1aad8d; font-weight:1000" type="text" @click="hide">X</el-button>
                    </div>
                    <div class="block">
                        <span class="menu-title">Zoom</span>
                        <el-slider :step="10" @input="handleZoom($event)" v-model="zoom"></el-slider>
                    </div>
                    <div class="block">
                        <span class="menu-title">Sub-Sector Legend</span>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--light-blue);" /></el-col>
                            <el-col :span="16"><span class="legend-text"> Environment & Animal Welfare</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--blue);" /> </el-col>
                            <el-col :span="16"><span class="legend-text">Social Services</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--olive);" /> </el-col>
                            <el-col :span="16"><span class="legend-text">Housing</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--light-green);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Arts & Culture</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--slate-gray);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Business & Professional</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--dark-teal);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Individual</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--pink);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Health</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--dark-pink);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Development</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--purple);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Education & Research</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--red);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Sports & Recreation</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--orange);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Law & Advocacy</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--yellow);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Government</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--tan);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Faith & Religion</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--brown);" /></el-col>
                            <el-col :span="16"><span class="legend-text">Fundraising & Volunteerism</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: var(--green);" /></el-col>
                            <el-col :span="16"><span class="legend-text">International</span></el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="4"><div class="circle" style="background-color: #DCFAF3;" /> </el-col>
                            <el-col :span="16"><span class="legend-text">Other/Unknown</span></el-col>
                        </el-row>
                    </div>
                </el-card>
            </transition>
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
        // Selection

    },
    data() {
        return {
            opened: false,
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
                force: 2200,
                //force: this.force,
                //size: { w: window.innerWidth - 20, h: window.innerHeight - 10 },
                size: { w: 5000, h: 5000 },
                offset: { x: this.networkX, y: this.networkY },
                fontSize: this.fontSize,
                nodeSize: this.nodeSize,
                nodeLabels: true,
                linkLabels: true,
                // forces: {
                //     Center: true,
                //     X: 0,
                //     Y: 0,
                //     ManyBody: false,
                //     Link: false,
                // },
            }
        },
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
        toggle() {
            this.opened = true;
            this.divWidth = 350;
        },
        hide() {
            this.opened = false
        },
        goToHome() {
            window.location.pathname = '/';
        },
        handleZoom($event) {
            this.fontSize = this.zoom / 1.5;
            this.nodeSize = this.zoom / 1.5;
            this.force = this.zoom * 300;
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
        }

    }
};
</script>

<style lang="scss">
@import "~styles/colors";

.title {
    width: 100%;
    position: fixed;
    
}
.raffle-container {
    width: 40%;
    margin: 0 auto;
}

#network-container {
    cursor: grab;
}
#network-container:active {
    cursor: grabbing
}

.toggle-enter-active {
    transition: 1s ease;
}
.toggle-leave-active {
    transition: 1s ease;
}
.toggle-enter, .toggle-leave-to {
    transform: translateX(-100%);
    /* opacity: 0; */
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
    // padding: 10px;
    // margin-left: 30px;
}
.legend-text {
    float: left !important;
}

</style>
