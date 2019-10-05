import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home";
import MyNetwork from "./views/MyNetwork"
import Network from "./views/Network";
import Form from "./views/Form";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/form",
      name: "form",
      component: Form
    },
    {
      path: "/mynetwork",
      name: "mynetwork",
      component: MyNetwork,
    },
    {
      path: "/network",
      name: "network",
      component: Network,
    }
  ]
});
