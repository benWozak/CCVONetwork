<template>
    <div class="home">
        <header class="header">
            <el-card>
                <img alt="KRD logo" src="../assets/krd-logo.png" class="logo" style="width: 86px;"/>
                <h1>Organizational Social Network App</h1>
                <img alt="CCVO logo" src="../assets/ccvo-logo.png" class="logo-right" style="width: 86px;"/> 
            </el-card>
        </header>
        <div class="container">
            <h2>Welcome to CCVO’s member network builder!</h2>
            <p style="line-spacing: 1.1em;">
                <b>Have you ever wondered what your network looks like?</b>
                <br><br>We are working to find out! This sector-level Social Network Analysis will
                    not only let you visualize Calgary's non-profit network in a fun way, but will help us learn about some of its
                    key attributes. Where is there existing density, and where could new connections be helpful?
                    Where does information flow freely, and where are there bottlenecks? What are some key
                    leverage points for sector-level action?
            </p>
            <p style="line-spacing: 1.1em;">
                Have a look below - answer some questions about <i>your</i> connections and see where you land in Calgary's network at the end.
            </p>

            <p style="line-spacing: 1.1em;">
                    Please enter organizational names only 
                    (except for individual members, where your name is your "organization").
            </p>
            
            <p>
                <i>With questions about this survey or app, please get in touch with 
                    <a style="color: orange;" href="mailto:roman@hellokrd.net">Roman @ KRD</a> or 
                    <a style="color: orange;" href="mailto:dsilver@calgarycvo.org">Dana @ CCVO</a>
                </i>.
            </p><p></p>

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
    position: relative !important;
    top: 0px !important;
}
.header .logo {
    float: left;
    margin: -6px 0 12px 25px;
}

.header .logo-right {
    float: right;
    margin-right: 10px;
}

h1 {
  color: #1aad8d;
  width: 80%;
  margin: auto;
  float: left;
  padding-top: 20px;
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
