<template>
  <div class="about">
    <div class="container">
        <div class="aside">
            <UserForm/>
        </div>

        <div class="main">
            <Visual :connect="connections"/>
        </div>
    </div>
  </div>
</template>

<script>
import Visual from "@/components/Visual.vue";
import UserForm from '@/components/AddNode.vue'

export default {
  name: "form",
  components: {
    Visual,
    UserForm
  },
  data: () => {
      return {
          connections: [],
      }
  }
};
</script>

<style lang="scss" scoped>
h1,a{
  color: #1aad8d;
  text-decoration: none;
}

.container {
    display: flex;
    flex-direction: row;
}
.main {
    margin: auto;
}
</style>