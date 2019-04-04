import Vue from 'vue'
import './plugins/axios'
import api from '@/api/'
import App from './App.vue'
import store from './store'
import router from './router'

Vue.config.productionTip = false
Vue.use(api)
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
