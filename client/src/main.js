import Vue from 'vue'
import './plugins/axios'
import api from '@/api/'
import App from './App.vue'
import store from './store'
import router from './router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.config.productionTip = false
Vue.use(api)
Vue.use(ElementUI)
new Vue({
  store,
  router,
  created() {
    
   this.$api.common.getSearchHotWord().catch(function(error){
    console.log(error)
   });
  
  },
  render: h => h(App)
}).$mount('#app')
