import Vue from 'vue'
import App from './App.vue'
import ViewUI from 'view-design'
import 'view-design/dist/styles/iview.css'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.config.productionTip = false
Vue.prototype.$https = axios
Vue.use(ViewUI, VueAxios)

new Vue({
  render: h => h(App),
}).$mount('#app')
