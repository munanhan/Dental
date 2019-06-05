import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./registerServiceWorker";

// element ui
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

//远程api
import api from './api';
Vue.use(api);

//添加dialog移动
import dialogDrag from './components/dialogDrag'
Vue.use(dialogDrag);

//使用菜单权限
import permission from './components/permission';
Vue.use(permission);

//图表
import VCharts from 'v-charts'
Vue.use(VCharts)

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
