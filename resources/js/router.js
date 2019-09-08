import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import Network from "./views/Network.vue";
import Form from "./views/Form.vue";

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
      // route level code-splitting
      // this generates a separate chunk (from.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      // component: () =>
      //   import(/* webpackChunkName: "from" */ "./views/Form.vue")
    },
    {
      path: "/network",
      name: "network",
      component: Network
    }
  ]
});
