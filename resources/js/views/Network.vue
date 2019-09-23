<template>
    <div class="network">
        <div class="main">
            <header class="header">
                <el-card >
                    <h1>Organizational Social Network Analysis</h1>
                    <div class="raffle-container">
                        Would you like to be entered to win an individual ticket to CCVO's annual Connections conference on April 22, 2020?
                        <br><br><el-button class="button" onclick=" window.open('https://www.hellokrd.net/', '_blank'); return false;">Enter Here!</el-button>
                    </div>
                </el-card>
            </header>
            <!--  @mousedown="startDrag" @mousemove="drag($event)" @mouseup="stopDrag" -->
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
                        <span>Menu</span>
                        <el-button style="float: right; padding: 3px 0" type="text" @click="hide">Close</el-button>
                    </div>
                    <div class="block">
                        <span class="title">Zoom</span>
                        <el-slider :step="10" @input="handleZoom" v-model="zoom"></el-slider>
                    </div>
                    <div class="block">
                        <span class="title">Sub-Sector Legend</span>
                        <ul>
                            <li>
                                <div class="circle" style="background-color: var(--light-blue);" /> <span>Environment & Animal Welfare</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--blue);" /> <span>Social Services</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--olive);" /> <span>Housing</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--light-green);" /> <span>Arts & Culture</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--green);" /> <span>Business & Professional</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--slate-gray);" /> <span>Individual</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--light-teal);" /> <span>Health</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--dark-teal);" /> <span>Development</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--pink);" /> <span>Education & Research</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--dark-pink);" /> <span>Sports & Recreation</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--purple);" /> <span>Law & Advocacy</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--light-purple);" /> <span>Government</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--orange);" /> <span>Faith & Religion</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--yellow);" /> <span>Fundraising & Volunteerism</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--tan);" /> <span>Student</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--brown);" /> <span>International</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: var(--red);" /> <span>Nonprofit</span>
                            </li>
                            <li>
                                <div class="circle" style="background-color: #DCFAF3;" /> <span>Other/Unknown</span>
                            </li>
                        </ul>
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
            zoom: 50,
            fontSize: 25,
            nodeSize: 25,
            force: 5000,
            networkX: 0,
            networkY: 0,
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
    computed:{

        nodes() {
            let nodes = [];
                for(let i = 0; i < this.organizations.length; i++) {
                    switch(this.organizations[i].subsector.id) {
                        case 1: 
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--light-blue)'
                            })
                            
                            break;
                        case 2:
                             nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--blue)'
                            })
                            break;
                        case 3:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--olive)'
                            })
                            break;
                        case 4:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--light-green)'
                            })
                            break;
                        case 21:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--green)'
                            })
                            break;
                        case 5:
                             nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--slate-gray)'
                            })
                            break;
                        case 14:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--light-teal)'
                            })
                            break;
                        case 6:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--dark-teal)'
                            })
                            break;
                        case 7:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--pink)'
                            })
                            break;
                        case 8:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--dark-pink)'
                            })
                            break;
                        case 9:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--purple)'
                            })
                            break;
                        case 10:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--light-purple)'
                            })
                            break;
                        case 12:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--orange)'
                            })
                            break;
                        case 13:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--yellow)'
                            })
                            break;
                        case 15:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--tan)'
                            })
                            break;
                        case 16:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--brown)'
                            })
                            break;
                        case 17:
                            nodes.push({
                                id: this.organizations[i].id,
                                name: this.organizations[i].organization_name,
                                _color: 'var(--red)'
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
                force: this.force,
                size: { w: (window.innerWidth * 1.5), h: (window.innerHeight * 1.5)},
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
        toggle() {
            this.opened = true;
            this.divWidth = 350;
        },
        hide() {
            this.opened = false
        },
        handleZoom(value) {
            this.fontSize = this.zoom / 1.5;
            this.nodeSize = this.zoom / 1.5;
            this.force = this.zoom * 300;
        },
        // startDrag() {
        //     this.dragging = true;
        // },
        // drag($event) {
        //     if(this.dragging) {
        //         // var CTM = svg.getScreenCTM();

        //         this.networkX = $event.offsetX;
        //         this.networkY = $event.offsetY;
        //     }

        //     // return this.networkX, this.networkY;
        // },
        // stopDrag() {
        //     this.dragging = false;
        // },

        // NOT CURRENTLY BEING USED
        // getMousePosition($event) {
        //     
        //     return {
        //         x: ($event.clientX - CTM.e) / CTM.a
        //         y: ($event.clientY - CTM.f) / CTM.d
        //     };
        // }
    }
};
</script>

<style lang="scss">
@import "~styles/colors";

.header {
    width: 100%;
    position: relative;
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
    top: 50px !important;
    left: 40px;
}

.menu-button {
    color: white;
    background-color: #1aad8d;
}

.menu-card {
    width: 480px;
}

.circle {
    height: 15px;
    width: 15px;
    display: inline-block;
    border-radius: 50%;
    // padding: 10px;
    // margin-left: 30px;
}
ul {
    list-style-type: none;
}
</style>
