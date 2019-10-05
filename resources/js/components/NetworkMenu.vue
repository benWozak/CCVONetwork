<template>
    <div class="menu-card-container">
            <el-button class="menu-button" v-show="!opened"  @click="toggle">Menu</el-button>
            <transition name="toggle">
                <el-card class="menu-card" v-show="opened">
                    <div slot="header" class="clearfix">
                        <el-button style="float: left; padding: 3px 0; color: #1aad8d; font-size: 2rem;" type="text" icon="el-icon-s-home" @click="goToHome"></el-button>
                        <span class="menu-title">Menu</span>
                        <el-button style="float: right; padding: 3px 0; color: #1aad8d; font-weight:1000" type="text" @click="hide">X</el-button>
                    </div>
                    <slot name="block">
                        <!-- Zoom -->
                    </slot>
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
</template>
<script>
export default {
    data() {
        return {
            opened: false,

        }
    },
    methods: {
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
    }

}
</script>

<style lang="scss" scoped>
.toggle-enter-active {
    transition: 1s ease;
}
.toggle-leave-active {
    transition: 1s ease;
}
.toggle-enter, .toggle-leave-to {
    transform: translateX(-100%);
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