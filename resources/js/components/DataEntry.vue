<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <h3>Establish Your Network</h3>
        </div>
        <el-steps align-center :active="active" finish-status="success">
            <el-step title="Your Organization"></el-step>
            <el-step title="Awareness"></el-step>
            <el-step title="Shared Knowledge"></el-step>
            <el-step title="Partnerships"></el-step>
            <el-step title="Connect!"></el-step>
        </el-steps>

        <el-form v-if="active === 0"
            ref="organization"
            :model="organization"
            label-width="240px" @submit.native.prevent>
                <el-form-item 
                    class="organization-item" 
                    label="Your Organization" 
                    prop="organization_name"
                    :rules="{ required: true, message: 'Please enter the name of your Organization', trigger: 'blur' }"
                >
                    <el-autocomplete
                        class="organization-input"
                        v-model="organization.organization_name"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <el-form-item label="Is your organization a current or recent CCVO member?" prop="affiliated">
                    <el-radio-group v-model="organization.is_member">
                        <el-radio :label="true">Yes</el-radio>
                        <el-radio :label="false">No</el-radio>
                    </el-radio-group>
                </el-form-item>

            <div class="clearfix">
                <el-form-item class="footer">
                    <el-button class="button" @click="addOrganization">Next</el-button>
                    <el-button class="button-light" @click="resetForm" disabled>Cancel</el-button>
                </el-form-item>
            </div>
        </el-form>

        <el-form v-if="active === 1"
            ref="awareness"
            :model="awareness"
            label-width="240px" @submit.native.prevent>
		<span>
                    Think back over the past three months and consider any nonprofit events
                    or collaboratives you’ve attended. Recall the people you noticed there
                    and those you quickly connected with – such as a brief “Hello” before
                    the event started, or a catch-up during a break.
                </span><br><br>
                <label for="">Please list up to 10 organizations represented by the people you connected with.</label>
                <el-form-item v-for="(connection, index) in awareness.connections" :key="index" :label="'Connection ' + (index + 1)" >
                    <el-autocomplete
                        v-model="connection.organization_name" @keyup.enter.native="$event.target.nextElementSibling.focus()"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <div class="clearfix">
                    <el-form-item class="footer">
                        <el-button class="button" @click="setAware">Next</el-button>
                        <el-button class="button-light" @click="resetForm">Cancel</el-button>
                    </el-form-item>
                </div>
        </el-form>

        <el-form v-if="active === 2"
            ref="shared"
            :model="shared"
            label-width="240px" @submit.native.prevent>
		<span>
                    Think back over the past six months, and consider situations in which you’ve
                    encountered a challenge or concern at work, and needed to “pick someone’s brain”
                    outside of your own organization.
                </span><br><br>
                <label for="">Please list up to 10 organizations represented by the people to whom you reached out.</label>
                <el-form-item v-for="(connection, index) in shared.connections" :key="index" :label="'Connection ' + (index + 1)" >
                    <el-autocomplete
                        v-model="connection.organization_name" @keyup.enter.native="$event.target.nextElementSibling.focus()"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <div class="clearfix">
                    <el-form-item class="footer">
                        <el-button class="button" @click="setShared">Next</el-button>
                        <el-button class="button-light" @click="resetForm">Cancel</el-button>
                    </el-form-item>
                </div>
        </el-form>

        <el-form v-if="active === 3"
            ref="partners"
            :model="partners"
            label-width="240px" @submit.native.prevent>
                <span>
                    Thinking back over the past two years, consider formal partnerships your organization
                    has been involved in for joint funding, shared resources, or any collaborative in which
                    decision-making would be made jointly.
                </span><br><br>
                <label for="">Please list up to 10 organizations involved in these collaborations.</label>
                <el-form-item v-for="(connection, index) in partners.connections" :key="index" :label="'Connection ' + (index + 1)" >
                    <el-autocomplete
                        v-model="connection.organization_name" @keyup.enter.native="$event.target.nextElementSibling.focus()"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <div class="clearfix">
                    <el-form-item class="footer">
                        <el-button class="button" @click="setPartners">Next</el-button>
                        <el-button class="button-light" @click="resetForm">Cancel</el-button>
                    </el-form-item>
                </div>
        </el-form>

        <el-form v-if="active === 4"
            label-width="240px"
            @submit.native.prevent>
            <div class="text-container">Thank you for taking the time to fill out this Survey. Now lets see how your connections line up with other organizations!</div>

            <div class="clearfix">
                <el-form-item class="footer">
                    <span class="margin-right">
                        <el-button class="button" @click="onSubmit()" @submit.prevent="onSubmit()">Submit</el-button>
                    </span>

                    <el-button class="button-light" @click="resetForm">Cancel</el-button>
                </el-form-item>
            </div>

        </el-form>
    </el-card>
</template>

<script>
import store from 'vuex';

export default {
    data() {
      return {
        active: 0,
        nextId: 1,
        organization: {
            id: 0,
            organization_name: '',
            is_member: true,
        },
        awareness: {
            connections: [
                {id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},
            ]
        },
        shared: {
            connections: [
                {id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},
            ]
        },
        partners: {
            connections: [
                {id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},
            ]
        },
        connections: [],
        organizations: [],
        join_raffle: false,
      }
    },
    mounted() {
        axios.get(`/api/organizations`)
            .then( response => {
                this.organizations = response.data.data;
            })
    },
    computed: {
        nodes: {
            get() { return this.$store.state.nodes },
            set() { this.$store.state.nodes = this.nodes }
        },
        links: {
            get() { return this.$store.state.links },
            set() { this.$store.state.links = this.links }
        },
    },
    methods: {
        getOrganizations(search, cb) {
            let results = [];

            axios.get(`/api/organizations?search=${search}`, {
                search
            }).then((response) => {
                results = response.data;

                cb(results.data);
            });
        },

        addOrganization() {
            this.organization.id = this.nextId;

            this.nodes.push({
                id: this.organization.id,
                name: this.organization.organization_name
            })

            axios.post('/api/connections', {
                organization_name: this.organization.organization_name,
                is_member: this.organization.is_member,
                connections: []
            }).then(response => {
                let id = response.data.data.id
                this.$store.commit('SET_CURRENT_ID', id)
            });


            this.nextId++;
            this.active = 1;
        },
        setAware() {
			const awareConnections = this.awareness.connections.filter((connection) => {
				return connection.organization_name != '';
            });

            for(let i = 0; i < awareConnections.length; i++) {
                awareConnections[i].id = this.nextId;
                awareConnections[i].connection_type = 'awareness';

                this.nodes.push({
                    id: awareConnections[i].id,
                    name: awareConnections[i].organization_name
                });

                this.links.push({
                    sid: this.organization.id,
                    tid: awareConnections[i].id
                });

                this.nextId++;
            }

            axios.post('/api/connections', {
                organization_name: this.organization.organization_name,
                is_member: this.organization.is_member,
                connections: awareConnections
            });

            this.active = 2;
        },
        setShared() {
            const sharedConnections = this.shared.connections.filter((connection) => {
				return connection.organization_name != '';
            });
           

			for(let i = 0; i < sharedConnections.length; i++) {
                for(let j = 0; j < this.nodes.length; j++) {
                    if(sharedConnections[i].organization_name.toUpperCase() === 
                        this.nodes[j].name.toUpperCase()) {
                            this.links.push({
                                sid: this.organization.id, tid: this.nodes[j].id
                            })
                            sharedConnections.splice(i, 1)
                    }
                }   
                    sharedConnections[i].id = this.nextId;
                    this.nodes.push({
                        id: sharedConnections[i].id,
                        name: sharedConnections[i].organization_name,
                    });

                    this.links.push({
                        sid: this.organization.id,
                        tid: sharedConnections[i].id,
                    });

                sharedConnections[i].connection_type = 'shared knowledge';
                this.nextId++;
            }

            axios.post('/api/connections', {
                organization_name: this.organization.organization_name,
                is_member: this.organization.is_member,
                connections: sharedConnections
            });

            this.active = 3;
        },
        setPartners() {
    		const partnerConnections = this.partners.connections.filter((connection) => {
				return connection.organization_name != '';
			});


			for(let i = 0; i < partnerConnections.length; i++) {
                for(let j = 0; j < this.nodes.length; j++) {
                    if(partnerConnections[i].organization_name.toUpperCase() === 
                        this.nodes[j].name.toUpperCase()) {
                            this.links.push({
                                sid: this.organization.id, tid: this.nodes[j].id
                            });
                            partnerConnections.splice(i, 1)
                    }
                }
                partnerConnections[i].id = this.nextId;
                partnerConnections[i].connection_type = 'partnership';
				this.nextId++;

                this.nodes.push({
                    id: partnerConnections[i].id,
                    name: partnerConnections[i].organization_name,
                });

                this.links.push({
                    sid: this.organization.id,
                    tid: partnerConnections[i].id,
                })
            }

            axios.post('/api/connections', {
                organization_name: this.organization.organization_name,
                is_member: this.organization.is_member,
                connections: partnerConnections,
            });

            this.active = 4;
        },

        /**
         * Check to see if Connection already exists, if so,
         * establish link, then remove it from connections list
         */
        checkExistingNodes(){
            for(let i = 0; i < this.nodes.length; i++) {
                for(let j = 0; j < this.connections.length; j++) {
                    if(this.nodes[i].name.toUpperCase() === this.connections[j].organization_name.toUpperCase()) {
                        this.links.push({
                            sid: this.organization.id, tid: this.nodes[i].id
                        })
                        this.connections.splice(j, 1)
                    }
                }
            }
        },

        /**
         * Set new nodes for connections that don't yet exist
         * and link them to new organization_name
         */
        addNewNodes() {
            for(let i = 0; i < this.connections.length; i++) {
                this.nodes.push({
                    id: this.connections[i].id,
                    organization_name: this.connections[i].organization_name
                })

                this.links.push({
                    sid: this.organization.id,
                    tid: this.connections[i].id
                })
            }
        },

        /**
         * Submits data to the backend
         */
        onSubmit() {
            // this.addConnections();

			const data = {
                organization_name: this.organization.organization_name,
                is_member: this.organization.is_member,
                connections: this.connections
			};

            axios.post(
				'/api/connections',
				data
			).then((response) => {
				this.connections = response;

                this.resetForm();
                this.$router.push("/mynetwork");
                this.$message({
                    showClose: true,
                    message: 'New Connection Established',
                    type: 'success'
                });

			}).catch((response) => {
				this.connections = response;
			});
        },
        resetForm() {

            this.organization.id = 0;
            this.organization.organization_name = '';
            this.awareness = {
                connections: [
                    {id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},
                ]
            }
            this.shared = {
                connections: [
                    {id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},
                ]
            }
            this.partners = {
                connections: [
                    {id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},{id: 0, organization_name:''},
                ]
            }
            this.$store.commit('CLEAR_NODES')
            this.$store.commit('CLEAR_LINKS')
            this.active = 0;

            this.$forceUpdate();
        },
        /**
         * Data inside this method should be replaced with a fetch of
         * back end generated IDs
         */
        setIdValues() {
            this.organization.id = this.nextId;
            this.nextId++;
        }
    },
}
</script>

<style lang="scss" scoped>
    .text-container{
        max-width: 60%;
        margin: auto;
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .text {
        font-size: 14px;
        font-weight: bold;
    }

    .organization-item .organzation-input {
        position: absolute !important;
    }
    // .el-form-item .el-form-item__content .el-form-item__error {
    //     position: relative !important;
    //     margin-left: 55px !important;
    // }
    

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
    .footer {
        margin-top: 8px;
        position: relative;
        bottom: 0;
        right: 0;
    }
    .box-card {
        width: 780px;
    }
    .inside-box {
        margin: 0 !important;
        padding: 0 !important;
    }
    h3 {
        color: #1aad8d;
    }
    .margin-right {
        margin-right: 12px;
    }
    .button-container {
        display: inline;
    }
    
    .custom-label {
        text-align: right;
        float: left;
        font-size: 14px;
        color: #606266;
        padding: 0 4px 0 0;
    }
    .el-form-item {
        margin-top: 20px;
    }
    .el-autocomplete{
        width: 400px !important;
    }
    .el-form-item .el-form-item__label {
        line-height: 20px !important;
    }
</style>
