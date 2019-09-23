<template>
    <div class="home">
        <header class="header">
            <el-card>
                <img alt="ABCD logo" src="../assets/abcd-logo.png" class="logo" />
                <h1>KRD Consulting Group: Organizational Social Network Analysis</h1>
            </el-card>
        </header>
        <div class="container">
            <h3>Welcome to CCVO’s member network survey!</h3>
            <p>
                Thank you for taking part in this important survey to determine the value of CCVO membership in the community. 
                With your help we’ll be creating a network map – the first of its kind – of the connections among and beyond 
                CCVO members. We’ll ask a couple of introductory questions, and three questions specific to your networks. 
                Please take no more than two minutes per question to note up to ten organizations that come to mind. At the 
                end, be sure to enter your contact info to be entered to win a ticket to CCVO’s 9th annual Connections Conference 
                in April 2020 (a $199 value).
            </p>
            <p>
                Your responses will help us identify new ways to connect CCVO members and increase the value of your membership. 
                Please be assured, your responses are confidential, only the name of your organization will be included in the 
                final network map.
            </p>

            <p>With thanks,</p>
            <h4>Roman Katsnelson</h4>
            <h4>KRD Consulting Group</h4>

            <p>Questions about this survey? Please contact me at roman@hellokrd.net</p>

            <router-link tag="a" to="/form">
                <el-button class="button hero-button">Get Started!</el-button>
            </router-link>
            

        </div>
    </div>
</template>

<script>
import Visual from "@/components/Visual.vue";
import UserForm from '@/components/DataEntry.vue'

export default {
  name: "home",
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
.header {
    background-color: white;
    height: 100px;

}
.header .logo {
    position: absolute;
    top: 5px;
    left: 10px;
    
}
h1 {
  color: #1aad8d;
}
h3, h4, p {
    text-align: left !important;
}
.container {
    margin-top: 50px !important;
    display: flex;
    flex: 11 auto;
    flex-direction: column;
    max-width: 50%;
    margin: auto;
}
.main {
    margin: auto;
}
.hero-button {
    width: 200px;
    height: 50px;
    font-size: 18px;
    font-weight: 400;
}

a {
    text-decoration: none;
    color: white;
}
a:hover {
    color: white;
}
</style>
