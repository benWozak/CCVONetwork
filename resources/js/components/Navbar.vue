<template>
    <div>
        <el-menu 
            :default-active="activeIndex" 
            class="navbar"
            active-text-color="#1aad8d" 
            mode="horizontal">
            <el-menu-item index="1" class="navbar-text" @click="routeMyNetwork">Your Network</el-menu-item>
            <el-menu-item index="2" class="navbar-text" @click="routeNetwork">Greater Network</el-menu-item>
        </el-menu>
        <h2 v-if="activeIndex === '1'" class="navbar-title">Your Organizational Network</h2>
        <h2 v-if="activeIndex === '2'" class="navbar-title">Greater Organizational Network</h2>
      <div class="line"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeIndex: '1',
        }
    },
    methods: {
        routeNetwork() {
            this.activeIndex = '2'
            this.$router.replace("/network");
        },
        routeMyNetwork() {
            this.activeIndex = '1'
            this.$router.replace("/mynetwork");
        },
        // handleSelect() {
            // if(this.activeIndex === '/mynetwork') {
            //     this.activeIndex = '/network'
            //     this.$forceUpdate();
            // } else {
            //     this.activeIndex = '/mynetwork'
            //     this.$forceUpdate();
            // }
        // }
    }
}
</script>

<style lang="scss" scoped>
.navbar {
  margin-left: 120px;
}

.navbar-title {
    position: absolute;
    top: 5px;
    left: 45%;
}

.navbar-text {
    font-size: 18px;
    font-weight: 600;
}

.title-text {
  display: inline-block;
}
</style>