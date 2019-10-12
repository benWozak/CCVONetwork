<template>
    <div>
        <el-menu 
            router
            :default-active="activeIndex" 
            class="navbar"
            active-text-color="#1aad8d" 
            mode="horizontal"
            @select="handleSelect">
            <el-menu-item route index="/mynetwork" class="navbar-text">Your Network</el-menu-item>
            <el-menu-item route index="/network" class="navbar-text">Greater Network</el-menu-item>
        </el-menu>
      <div class="line"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeIndex: '/mynetwork',
        }
    },
    methods: {
        handleSelect() {
            if(this.activeIndex === '/mynetwork') {
                this.activeIndex = '/network'
            } else {
                this.activeIndex = '/mynetwork'
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.navbar {
  margin-left: 120px;
}

.navbar-text {
    font-size: 18px;
    font-weight: 600;
}

.title-text {
  display: inline-block;
}
</style>