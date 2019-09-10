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
            :rules="{ required: true, message: 'Please enter the name of your Organization', trigger: 'blur' }"
            label-width="240px" @submit.native.prevent>
                <el-form-item  label="Your Organization" prop="organization_name">
                    <el-autocomplete
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
                    <el-button type="primary" class="button" @click="addOrganization">Next</el-button>
                    <el-button @click="resetForm">Cancel</el-button>
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
                <el-form-item v-for="(connection, index) in awareness.connections" :key="index" :label="'Connection' + (index + 1)" >
                    <el-autocomplete
                        v-model="connection.name" @keyup.enter.native="$event.target.nextElementSibling.focus()"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <div class="clearfix">
                    <el-form-item class="footer">
                        <el-button type="primary" class="button" @click="setAware">Next</el-button>
                        <el-button @click="resetForm">Cancel</el-button>
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
                <el-form-item v-for="(connection, index) in shared.connections" :key="index" :label="'Connection' + (index + 1)" >
                    <el-autocomplete
                        v-model="connection.name" @keyup.enter.native="$event.target.nextElementSibling.focus()"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <div class="clearfix">
                    <el-form-item class="footer">
                        <el-button type="primary" class="button" @click="setShared">Next</el-button>
                        <el-button @click="resetForm">Cancel</el-button>
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
                <el-form-item v-for="(connection, index) in partners.connections" :key="index" :label="'Connection' + (index + 1)" >
                    <el-autocomplete
                        v-model="connection.name" @keyup.enter.native="$event.target.nextElementSibling.focus()"
                        :trigger-on-focus="false"
                        :fetch-suggestions="getOrganizations">
                    </el-autocomplete>
                </el-form-item>

                <div class="clearfix">
                    <el-form-item class="footer">
                        <el-button type="primary" class="button" @click="setPartners">Next</el-button>
                        <el-button @click="resetForm">Cancel</el-button>
                    </el-form-item>
                </div>
        </el-form>

        <el-form v-if="active === 4"
            label-width="240px"
            @submit.native.prevent>
            <div class="text-container">Thank you for taking the time to fill out this Survey. Now lets see how your connections line up with other organizations!</div>
                <!-- <el-form-item>
                    <label for="" class="custom-label">Would you like to be entered to win an individual ticket to CCVO's annual Connections conference on April 22, 2020?</label>
                    <div>Click <a href="https://www.hellokrd.net/">here</a> to enter</p>
                </el-form-item> -->

            <div class="clearfix">
                <el-form-item class="footer">
                    <span class="margin-right">
                        <el-button type="primary" class="button" @click="onSubmit()" @submit.prevent="onSubmit()">Submit</el-button>
                    </span>

                    <el-button @click="resetForm">Cancel</el-button>
                </el-form-item>
            </div>

        </el-form>
    </el-card>
</template>

<script>
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
                {id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},
            ]
        },
        shared: {
            connections: [
                {id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},
            ]
        },
        partners: {
            connections: [
                {id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},{id: 0, name:''},
            ]
        },
        connections: [],
        join_raffle: false,
      }
    },
    computed: {
        nodes: {
            get() { return this.$store.state.nodes },
        },
        links: {
            get() { return this.$store.state.links },
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
            this.nextId++;

            this.active = 1;
        },
        setAware() {
            for(let i = 0; i < this.awareness.connections.length; i++) {

                if(this.awareness.connections[i].name === '') {
                    this.awareness.connections.splice(i, 1);
                } else {
                    this.awareness.connections[i].id = this.nextId;
                    this.nextId++;

                    this.nodes.push({
                        id: this.awareness.connections[i].id,
                        name: this.awareness.connections[i].name,
                        connection_type: 'awareness'
                    })

                    this.links.push({
                        sid: this.organization.id,
                        tid: this.awareness.connections[i].id
                    })
                }

            }
            this.active = 2;
        },
        setShared() {
             for(let i = 0; i < this.shared.connections.length; i++) {

                if(this.shared.connections[i].name === '') {
                    this.shared.connections.splice(i, 1);
                } else {
                    for(let j = 0; j < this.nodes.length; j++) {
                        if(this.shared.connections[i].name.toUpperCase() === this.nodes[j].name.toUpperCase()) {
                            this.shared.connections[i].id = this.nodes[j].id;
                            this.links.push({
                                sid: this.organization.id,
                                tid: this.shared.connections[i].id,
                            })
                            this.shared.connections.splice(i, 1);
                        }
                    }
                    this.shared.connections[i].id = this.nextId;
                    this.nextId++;

                    this.nodes.push({
                        id: this.shared.connections[i].id,
                        name: this.shared.connections[i].name,
                        connection_type: 'shared knowledge'
                    })

                    this.links.push({
                        sid: this.organization.id,
                        tid: this.shared.connections[i].id,
                    })
                }

            }
            this.active = 3;
        },
        setPartners() {
            for(let i = 0; i < this.partners.connections.length; i++) {

                if(this.partners.connections[i].name === '') {
                    this.partners.connections.splice(i, 1);
                } else {
                    for(let j = 0; j < this.nodes.length; j++) {
                        if(this.partners.connections[i].name.toUpperCase() === this.nodes[j].name.toUpperCase()) {
                            this.partners.connections[i].id = this.nodes[j].id;
                            this.links.push({
                                sid: this.organization.id,
                                tid: this.partners.connections[i].id,
                            })
                            this.partners.connections.splice(i, 1);
                        }
                    }
                    this.partners.connections[i].id = this.nextId;
                    this.nextId++;

                    this.nodes.push({
                        id: this.partners.connections[i].id,
                        name: this.partners.connections[i].name,
                        connection_type: 'partnership'
                    })

                    this.links.push({
                        sid: this.organization.id,
                        tid: this.partners.connections[i].id,
                    })
                }

            }
            this.active = 4;
        },

        /**
         * Check to see if Connection already exists, if so,
         * establish link, then remove it from connections list
         */
        checkExistingNodes(){
            for(let i = 0; i < this.nodes.length; i++) {
                for(let j = 0; j < this.connections.length; j++) {
                    if(this.nodes[i].organization_name.toUpperCase() === this.connections[j].organization_name.toUpperCase()) {
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

        addConnections() {
            for(let i = 1; i < this.nodes.length; i++) {
                this.connections.push({
                    organization_name: this.nodes[i].name,
                    connection_type: this.nodes[i].connection_type,
                })
            }
        },

        /**
         * Submits data to the backend
         */
        onSubmit() {

            this.addConnections();

            axios.post('/api/connections', {
                organization_name: this.organization.organization_name,
                is_member: this.organization.is_member,
                connections: this.connections
            });

            this.resetForm();
            this.$router.push("/network");
            this.$message({
                showClose: true,
                message: 'New Connection Established',
                type: 'success'
            });
        },
        resetForm() {

            this.organization.id = this.nextId++;
            this.organization.organization_name = '';
            this.connections = []
            this.active = 0;
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
    created() {
        // this.setIdValues();
    }
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
    .button {
        background-color: #1aad8d;
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
    .el-autocomplete {
        width: 400px !important;
    }
</style>
